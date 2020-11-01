<form method="GET" action="{{ route('bookmarks.index') }}" class="form-inline d-flex align-items-center justify-content-end">
  <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">
  <div class="form-group mr-2">
    <select class="form-control form-control-sm" name="sort">
      <option value="created_at" selected="">Date added</option>
      <option value="url">Page url</option>
      <option value="title">Page title</option>
    </select>
  </div>
  <div class="form-group">
    <select class="form-control form-control-sm" name="order">
      <option value="desc" selected="">Descending</option>
      <option value="asc">Ascending</option>
    </select>
  </div>	 
  <button type="submit" class="btn btn-primary ml-2 btn-sm">Sort</button>
</form>

<hr>