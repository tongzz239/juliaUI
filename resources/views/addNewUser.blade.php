@extends('sidebars.adminSidebar')

@section('body')
<form action="/addNewUser" method="POST" role="form">
	<div class="input-group">
	    <input name="newUserEmail" pattern="[A-Za-z]+\.[A-Za-z]+@ttu\.ee" title="examle: Name.Surname@ttu.ee" required type="text" class="form-control" placeholder="Add new user">
	    <div class="input-group-append">
	        <button class="btn btn-outline-secondary" type="submit">Add</button>
	    </div>
	</div>
	<input name="_token" type="hidden" value="{{ csrf_token() }}" />
</form>



@endsection
