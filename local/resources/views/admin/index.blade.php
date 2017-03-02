@extends('admin.master')

@section('content')
    <ul>
        <li><a href="{{url('admin/administrators')}}">{!! trans('admin.administrators') !!}</a></li>
        <li><a href="{{url('admin/users')}}">{!! trans('admin.users') !!}</a></li>
        <li><a href="{{url('admin/applications')}}">{!! trans('admin.applications') !!}</a></li>
        <li><a href="{{url('admin/achievements')}}">{!! trans('admin.achievements') !!}</a></li>
        <li><a href="{{url('admin/logout')}}">{!! trans('global.logout') !!}</a></li>
    </ul>
@endsection