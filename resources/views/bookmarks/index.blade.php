@extends('layout.master')

{{-- @section('title', $bookmark->meta->title) --}}
{{-- @section('descrption', $bookmark->meta->title) --}}
{{-- @section('keywords', $bookmark->meta->title) --}}

@section('content')
  @foreach ($bookmarks as $bookmark)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
              <p class="card-text"><img src="{{ config('bookmarks.images.folder') }}{{ $bookmark->favicon ?? 'default.svg' }}" alt="{{ $bookmark->title }}"> <a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a></p>
              <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                  <a type="button" href="{{ route('bookmarks.show', ['bookmark' => $bookmark]) }}" class="btn btn-sm btn-outline-secondary">View</a>
                  <a type="button" href="{{ route('bookmarks.edit', ['bookmark' => $bookmark]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
              </div>
              <small class="text-muted">{{ $bookmark->created_at }}</small>
              </div>
          </div>
        </div>
    </div>
  @endforeach

  <div class="col-sm-12">
    {{ $bookmarks->links() }}
  </div>

@endsection