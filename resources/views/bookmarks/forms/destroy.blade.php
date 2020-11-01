@include('layout.errors')

<form method="POST" action="{{ route('bookmarks.destroy', ['bookmark' => $bookmark]) }}" class="form-inline d-flex align-items-start">
  @csrf
  @method('DELETE')
  <div class="form-group flex-fill">
    <input name="password_to_delete" type="password" class="form-control w-100" id="inputPassword" placeholder="Insert delete password" value="{{ old('password_to_delete') }}">
  </div>	 
  <button type="submit" class="btn btn-danger ml-2">Delete</button>
</form>