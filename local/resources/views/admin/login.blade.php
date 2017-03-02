@extends('admin.master')
@section('style')
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
@endsection
@section('content')
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3 text-center">
            <img src="https://dl.dropbox.com/s/vfvjwm4z5oxrm6n/lemon.png">
            <h1>Login Administrators</h1>
            <form method="post" class="col-sm-10 col-sm-offset-1">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" placeholder="{!! trans('global.placeholder_username')  !!}" name="username" type="text" autofocus required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="{!! trans('global.placeholder_password') !!}" name="password" type="password" value="" required>
                </div>
                <button class="btn btn-lg btn-success btn-block">{!! trans('global.login') !!}</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@endsection