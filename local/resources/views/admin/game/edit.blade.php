@extends('admin.master')

@section('content')

    <p>
        <a href="{{route('games.index')}}">< Back </a>
    </p>


    <h3>Edit Game</h3>

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

    <form action="{{route('games.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="">Category : <br>
            <select name="category_id">
                @foreach($categories as $cat)
                    <option value="{{$cat->id}}" {{($cat->id == $item->category_id)?'selected':''}}>{{$cat->title}}</option>
                @endforeach
            </select>
        </label>
        <label for="">Package name : <br>
            <input type="text" value="{{$item->package_name}}" name="package_name">
        </label>
        <label for="">Title : <br>
            <input type="text" value="{{$item->title}}"  name="title">
        </label>
        <label for="">Logo :<br>
            <input type="file" name="logo">
        </label>
        <img src="{{url("uploads/{$item->logo}")}}" width="200px"><br>
        <button class="button button-primary">save</button>
    </form>


@endsection