<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TrisFlix</title>
        @livewireStyles
    </head>
    <body>
    <hr />
    <h2>Your Downloads:</h2>
    These expire on {{ $date_end }}
        @foreach($files as $file)
            @if ($file->file->deleted_at != null)
                <br />{{ $file->file->filename }} Has been upgraded or deleted. Please request again
            @else
                <br /><a href="{{ url('/link/' . $slug . '/' . $file->id) }}"> {{ $file->file->filename }} </a>
            @endif
        @endforeach()
    @livewireScripts
    </body>
</html>
