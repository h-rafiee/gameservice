@extends('admin.master')

@section('content')

    <p>
        <a href="{{url('admin/leaderboards/game/'.$game->id)}}">< Back </a>
    </p>

    <h3>Create Achievement {!! $game->title !!}</h3>
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

    <form action="{{route('leaderboards.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="game_id" value="{{$game->id}}">
        <label for="">Title : <br>
            <input type="text" name="title">
        </label>
        <label for="">Priority : <br>
            <input type="number" min="0" value="0" name="priority">
        </label>
        <label for="">Description : <br>
            <textarea name="description"></textarea>
        </label>
        <label for="">Logo :<br>
            <input type="file" name="logo">
        </label>
        <button class="button button-primary">save</button>
    </form>


@endsection