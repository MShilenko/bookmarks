<form method="POST" action="{{ route('bookmarks.store') }}" class="form-inline d-flex align-items-start">
  @csrf
  <div class="form-group flex-fill">
    <input name="url" type="text" class="form-control w-100" id="inputUrl" placeholder="Insert link" value="{{ old('url') }}">
  </div>	
  <div class="form-group flex-fill ml-2">
    <input name="password_to_delete" type="password" class="form-control w-100" id="inputPassword" placeholder="Insert delete password" value="{{ old('password_to_delete') }}">
  </div>  
  <button type="submit" class="btn btn-primary ml-2">Add</button>
</form>