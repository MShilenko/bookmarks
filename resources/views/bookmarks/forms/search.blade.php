<form method="get" action="{{ route('bookmarks.search') }}" class="form-inline flex-fill d-flex align-items-start ml-2">
  <div class="form-group flex-fill">
    <input name="find" type="text" class="form-control w-100" id="inputSearch" placeholder="Insert search query" value="{{ old('search') }}">
  </div>	 
  <button type="submit" class="btn btn-light ml-2">Search</button>
</form>