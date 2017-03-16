@extends('admin.master')

@section('content')

    <p>
        <a href="{{route('categories.index')}}">< Back </a>
    </p>

    <h3>Create Category</h3>
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

    <form action="{{route('categories.store')}}" method="post">
        {{csrf_field()}}
        <label for="">Title : <input type="text" name="title"> </label>
        <button class="button button-primary">save</button>
    </form>


@endsection