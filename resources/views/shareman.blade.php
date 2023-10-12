<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TrisFlix</title>
        @livewireStyles
    </head>
    <body>
    @include('components.nav', ['title' => 'Current Shares'])

        <ul>
            @foreach($links as $link)
                <li><a href="shareman/link/delete/{{ $link->id }}"> X </a> - <a href="/shareman/list/{{ $link->slug }}">Edit share</a><br />
                    <br />
                    Link: <b>https://trisflix.com/link/{{ $link->slug }}</b>
                    <br />Pass:
                    <b>{{ $link->pass }}</b>
                    <br />

                    @include('components.show-share-file-list')

                    <hr />
                </li>
            @endforeach
        </ul>

    @livewireScripts
    </body>
</html>
