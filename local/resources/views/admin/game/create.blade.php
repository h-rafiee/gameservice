@extends('admin.master')

@section('content')

    <p>
        <a href="{{route('games.index')}}">< Back </a>
    </p>

    <h3>Create Game</h3>
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

    <form action="{{route('games.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <label for="">Category : <br>
            <select name="category_id">
                @foreach($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                @endforeach
            </select>
        </label>
        <label for="">Package name : <br>
            <input type="text" name="package_name">
        </label>
        <label for="">Title : <br>
            <input type="text" name="title">
        </label>
        <label for="">Logo :<br>
            <input type="file" name="logo">
        </label>
        <button class="button button-primary">save</button>
    </form>


@endsection