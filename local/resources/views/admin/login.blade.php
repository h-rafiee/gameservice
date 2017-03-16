@extends('admin.master')
@section('content')
    <div class="row">
    <div class="three columns">&nbsp;</div>
    <div class="six columns">
    <h2>Administrator Web Panel</h2>
    <hr>
    <form method="post">
            {!! csrf_field() !!}

                <label for="Username">Username</label>
                <input class="u-full-width" name="username" type="text" placeholder="Username" id="Username">

                <label for="Username">Password</label>
                <input class="u-full-width" name="password" type="password" placeholder="Password" id="Password">

                <label for="exampleEmailInput">&nbsp;</label>
                <input class="u-full-width button-primary" type="submit" value="Login">

    </form>

    </div>

    <div class="three columns">&nbsp;</div>
    </div>
@endsection
