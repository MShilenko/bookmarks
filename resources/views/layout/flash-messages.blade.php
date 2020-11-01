@if(session()->has('message'))
	<div class="alert alert-{{ session('type') }} mt-4 col-sm-12">
		{{ session('message') }}
	</div>
@endif