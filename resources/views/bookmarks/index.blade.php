@extends('layout.master')

@section('content')
  <div class="col-sm-12 sort">
    @include('bookmarks.forms.sort')
  </div>

  @foreach ($bookmarks as $bookmark)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
              <p class="card-text">
                <img src="{{ $bookmark->favicon ?? config('bookmarks.images.default') }}" alt="{{ $bookmark->title }}"> <a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a>
              </p>
              <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                  <a type="button" href="{{ route('bookmarks.show', ['bookmark' => $bookmark]) }}" class="btn btn-sm btn-outline-secondary">View</a>
              </div>
              <small class="text-muted">{{ $bookmark->created_at }}</small>
              </div>
          </div>
        </div>
    </div>
  @endforeach

  <div class="col-sm-12">
    {{ $bookmarks->withQueryString()->links() }}
  </div>

@endsection