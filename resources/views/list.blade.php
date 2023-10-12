<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TrisFlix</title>
        @livewireStyles
    </head>
    <body>
    @include('components.nav', ['title' => 'Share: ' . session('slug')])

    @include('components.show-share-file-list')

    <hr />
    <a href="/shareman/show/refresh">Refresh show list</a>
    <hr />
        @foreach($shows as $show)
            <br /><a href="{{ url('/shareman/list/show/' . $show->id) }}"> {{ $show->title }} </a>
        @endforeach()
    @livewireScripts
    </body>
</html>
