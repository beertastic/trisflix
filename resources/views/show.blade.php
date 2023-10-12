@include('partials.layout-header')

@include('partials.nav', ['page' => $media])

<div id="page-container">
    Share Slug: {{ session('slug') }}
{{--    @include('components.show-share-file-list')--}}
    @if(count($paths) > 0)
        <h3>{{ ($media == 'tv') ? 'Show: ' . $paths[0]->show->title : 'Movie: ' . $paths[0]->movie->title }}</h3>
        <a href="/sharing/<?= $media ?>/refresh/media/{{ $media_id }}">Refresh file list</a>

        <form method="POST" action="/sharing/link/items/add">
            @if(session('slug'))
                @csrf
                <input type="hidden" name="link_id" value="{{ session('link_id') }}">
                <input type="submit" value="Add selected shows">
            @else
                <a href="/sharing/link/new">CREATE A SHARE</a>
            @endif
            @foreach($paths->SortByDesc('path') as $path)
                <h4>
                    <label for="all_{{ $path->id }}">Folder: {{ $path->path }}</label>
                    <input type="checkbox" id="all_{{ $path->id }}">
                </h4>
                @foreach($path->files->SortByDesc('filename') as $file)
                    <input type="checkbox"@if(($file->link) && (session('link_id') == $file->link['link_id'])) checked @endif value="{{ $file->id }}" name="file_id[]" id="file_id[{{ $file->id }}]" class="all_{{ $path->id }}"> -
                    <label for="file_id[{{ $file->id }}]">
                        @if (pathinfo($file->filename, PATHINFO_EXTENSION) == 'srt')
                            <b><i>(SUBTITLE FILE)</i></b>
                        @endif
                        <a href="/sharing/force/{{ $file->id }}">{{ $file->filename }}</a>
                    </label>
                    <br />
                @endforeach()
            @endforeach()
        </form>
    @else
        <a href="/sharing/<?= $media ?>/refresh/media/{{ $media_id }}">Refresh file list</a>
    @endif
@include('partials.layout-footer')
