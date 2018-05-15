@extends('sidebars.adminSidebar')

@section('body')
<ul class="list-group">
    @foreach ($users as $user)
            <li class="list-group-item justify-content-between align-items-center">
                
                <span class="d-flex">
                <span class="p-2 mr-auto">{{ $user->email }}</span>
                @if ($user->admin == 0)
                    <a class="btn btn-primary p-2" href="/addAdmin/{{ $user->id }}" role="button">Give admin rights</a>
                @elseif ($user->admin == 1)
                    <a class="btn btn-primary p-2" href="/removeAdmin/{{ $user->id }}" role="button">Remove admin rights</a>
                @endif
                    <a class="btn btn-danger p-2" href="/removeUser/{{ $user->id }}" role="button">Remove user</a>
                </span>
            </li>
    @endforeach
</ul>
@endsection





