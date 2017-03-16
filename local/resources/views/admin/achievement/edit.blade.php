@extends('admin.master')

@section('content')

    <p>
        <a href="{{url('admin/achievements/game/'.$item->game_id)}}">< Back </a>
    </p>


    <h3>Edit Achievement</h3>

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

    <form action="{{route('achievements.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="">Title : <br>
            <input type="text" value="{{$item->title}}" name="title">
        </label>
        <label for="">Description : <br>
            <textarea name="description">{{$item->description}}</textarea>
        </label>
        <label for="">Logo :<br>
            <input type="file" name="logo">
        </label>
        <img src="{{url("uploads/{$item->logo}")}}" width="200px"><br>
        <button class="button button-primary">save</button>
    </form>


@endsection