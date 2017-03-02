<!DOCTYPE html>
<html lang="fa">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title',trans('admin.header_title'))</title>
     @yield('style')
</head>

<body>
    @yield('content')
    @yield('script')
</body>
</html>