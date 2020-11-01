@extends('layout.master')

@section('title', 'Add new bookmark')

@section('content')
  <h1>Add new bookmark</h1>

  <div class="col-sm-12">
    @include('layout.errors')

    @include('bookmarks.forms.create')
  </div>  
@endsection