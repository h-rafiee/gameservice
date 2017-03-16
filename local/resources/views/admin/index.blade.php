@extends('admin.master')

@section('content')
<p>
<a href="{{url('admin/logout')}}">Logout</a>
</p>
<h3>
    Admin Panel
</h3>
<hr>
<ul>
    <li><a href="{{url('admin/administrators')}}">Administrators</a></li>
    <li><a href="{{url('admin/categories')}}">Categories</a></li>
    <li><a href="{{url('admin/users')}}">Users</a></li>
    <li><a href="{{url('admin/games')}}">Games</a></li>
</ul>
@endsection