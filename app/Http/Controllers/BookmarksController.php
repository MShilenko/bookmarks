<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Http\Parsers\SimpleDOMParser;
use App\Http\Requests\DestroyBookmark;
use App\Http\Requests\StoreBookmark;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BookmarksController extends Controller
{
    public const FIRST_PAGE = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->query('page') ?? self::FIRST_PAGE;
        $sort = $request->query('sort') ?? 'created_at';
        $order = $request->query('order') ?? 'desc';

        $bookmarks = Cache::tags(["bookmarks", "bookmarks|page|{$page}|sort|{$sort}|order|{$order}"])
            ->remember("bookmarks|page|{$page}|sort|{$sort}|order|{$order}", config('bookmarks.cache.time'), function () use ($sort, $order) {
                $rows = ['id', 'title', 'url', 'favicon', 'created_at'];
                $perPage = config('bookmarks.paginate');
                return Bookmark::select($rows)->orderBy($sort, $order)->paginate($perPage);
            });

        return view('bookmarks.index', compact('bookmarks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bookmarks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreBookmark  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookmark $request)
    {
        $validated = $request->validated();
        $parser = new SimpleDOMParser($validated['url'], [
            'title' => 'h1',
            'meta.title' => 'title',
            'meta.description' => ['meta', 'name.description', 'content'],
            'meta.keywords' => ['meta', 'name.keywords', 'content'],
            'favicon' => ['link', 'rel.shortcut icon', 'href'],
        ]);

        try {
            $data = $parser->getData();
        } catch (\Exception $e) {
            Log::error("{$e->getMessage()} - {$e->getFile()}:{$e->getLine()}");
            flash('An error occurred while loading data.', 'danger');
            return back()->withInput();
        }

        $bookmark = Bookmark::create([
            'title' => $data['title'] ?? $data['meta.title'],
            'url' => $validated['url'],
            'favicon' => $data['favicon'] ? getCorrectUrl($validated['url'], $data['favicon']) : config('bookmarks.images.default'),
            'password_to_delete' => $request['password_to_delete'] ? Hash::make($request['password_to_delete']) : '',
        ]);
        $bookmark->meta()->create([
            'title' => $data['meta.title'],
            'description' => $data['meta.description'],
            'keywords' => $data['meta.keywords'],
        ]);

        return redirect(route('bookmarks.show', ['bookmark' => $bookmark]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        if (!Cache::tags(["bookmark|{$id}"])->has("bookmark|{$id}")) {
            Cache::tags(["bookmark|{$id}"])->put("bookmark|{$id}", Bookmark::findOrFail($id), config('bookmarks.cache.time'));
        }

        $bookmark = Cache::tags(["bookmark|{$id}"])->get("bookmark|{$id}");

        return view('bookmarks.show', compact('bookmark'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  App\Http\Requests\DestroyBookmark  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DestroyBookmark $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::findOrFail($id);
        if (!Hash::check($validated['password_to_delete'], $bookmark->password_to_delete)) {
            flash('Wrong password entered!', 'danger');
            return redirect(route('bookmarks.show', ['bookmark' => $bookmark]));
        }

        $bookmark->delete();
        return redirect(route('bookmarks.index'));
    }
}
