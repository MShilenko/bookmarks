@extends('layout.master')

@section('h1', $bookmark->title)
@section('title', $bookmark->meta->title ?? '')
@section('description', $bookmark->meta->description ?? '')
@section('keywords', $bookmark->meta->keywords ?? '')

@section('content')
  <table class="table table-bordered card-show">
    <tbody>
      <tr>
        <th scope="col col-dark">#</th>
        <td>{{ $bookmark->id }}</td>
      </tr>
      <tr>
        <th scope="col col-dark">Page</th>
        <td><a href="{{ $bookmark->url }}">{{ $bookmark->url }}</a></td>
      </tr>
      <tr>
        <th scope="col col-dark">Favicon</th>
        <td><img src="{{ $bookmark->favicon ?? config('bookmarks.images.default') }}"></td>
      </tr>
      <tr>
        <th scope="col col-dark">Created at</th>
        <td>{{ $bookmark->created_at }}</td>
      </tr>
      <tr>
        <th scope="col col-dark">Meta Title</th>
        <td>{{ $bookmark->meta->title }}</td>
      </tr>
      <tr>
        <th scope="col col-dark">Meta Description</th>
        <td>{{ $bookmark->meta->description }}</td>
      </tr>
      <tr>
        <th scope="col col-dark">Meta Keywords</th>
        <td>{{ $bookmark->meta->keywords }}</td>
      </tr>
      <tr>
        <td colspan="2">@include('bookmarks.forms.destroy', ['bookmark' => $bookmark])</td>
      </tr>
    </tbody>
  </table>
@endsection