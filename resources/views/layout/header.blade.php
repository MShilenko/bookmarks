<header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="{{ route('bookmarks.index') }}" class="navbar-brand d-flex align-items-center">
        <strong>@yield('h1', config('app.name'))</strong>
      </a>
      <a href="{{ route('bookmarks.create') }}" class="btn btn-light">Add new bookmark</a>
    </div>
  </div>
</header>