<div>
    @if (count($link->items) > 0)
        <br />FileCount: {{ count($link->items) }} (expires: {{ $link->expires_at }})<br />
        <ol>
            @foreach($link->items as $file)
                @if ($file->file->deleted_at != null)
                    <li> (DL: <b>{{ $file->file->downloads_count }}</b>) <a href="/sharing/link/item/del/{{ $file->id }}">X</a> | {{ $file->file->filename }} Has been upgraded. Please <a href="/sharing/tv/refresh/media/{{ $file->file->path->show->id }}">REFRESH</a> show folder</li>
                @else
                    <li> (DL: <b>{{ $file->file->downloads_count }}</b>) <a href="/sharing/link/item/del/{{ $file->id }}">X</a> | {{ $file->file->filename }}</li>
                @endif
            @endforeach
        </ol>
    @endif
</div>
