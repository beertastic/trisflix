@include('partials.layout-header')


@include('partials.nav', ['page' => 'shares'])

<a href="/sharing/link/new">CREATE NEW</a>

<ul>
    @foreach($links as $link)
        <li><a href="/sharing/link/del/{{ $link->id }}"> X </a> - <a href="/sharing/tv/list/{{ $link->slug }}">Edit share</a><br />
            <br />Link:
            <br /><b>https://trisflix.com/link/{{ $link->slug }}</b>
            <br />Pass:
            <br /><b>{{ $link->pass }}</b>
            <br />

            @include('components.show-share-file-list')

            <hr />
        </li>
    @endforeach
</ul>

@include('partials.layout-footer')
