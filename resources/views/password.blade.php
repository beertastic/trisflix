<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TrisFlix</title>
        @livewireStyles
    </head>
    <body>

    <form method="post" action="/link/login/{{ $link->slug }}">
        @csrf
        <input type="password" name="pass">
        <input type="submit">
    </form>

    @livewireScripts
    </body>
</html>
