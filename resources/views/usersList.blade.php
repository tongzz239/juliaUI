@extends('sidebars.adminSidebar')

@section('body')
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" aria-label="Имя получателя" aria-describedby="basic-addon2">
        </div>
    </li>
    @foreach ($users as $user)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $user->email }}
            <button type="button" class="btn btn-secondary">Remove</button>
        </li>
    @endforeach
</ul>
@endsection
