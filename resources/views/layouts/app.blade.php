<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>API test</title>

        <style src="{{ mix('/css/app.css') }}"></style>
    </head>
    <body>
        @yield('content')
    </body>
</html>