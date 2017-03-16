@extends('admin.master')

@section('content')

    <p>
        <a href="{{route('users.index')}}">< Back </a>
    </p>


    <h3>Edit User</h3>

    <hr>
    @if (count($errors) > 0)

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        <hr>

    @endif

    <form action="{{route('users.update',$item->id)}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="">Name : <br>
            <input type="text" value="{{$item->name}}" name="name">
        </label>
        <label for="">Username : <br>
            <input type="text" value="{{$item->username}}" name="username">
        </label>
        <label for="">Email : <br>
            <input type="email" value="{{$item->email}}" name="email">
        </label>
        <label for="">Password : <br>
            <input type="password" name="password">
        </label>
        <label for="">Mobile : <br>
            <input type="text" value="{{$item->mobile}}" name="mobile">
        </label>
        <button class="button button-primary">save</button>
    </form>


@endsection