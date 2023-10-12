@include('partials.layout-header')

@include('partials.nav', ['page' => 'tv'])

<div id="page-container">

    @if(session('slug'))
    Share Slug: {{ session('slug') }}
    <form method="post" action="/sharing/tv">
        @csrf
        <input type="text" name="search_tv" placeholder="Search part of a title" value="{{ session('search_tv') }}"><br />
        <input type="submit" value="Search">
    </form>
    @else
        Please create or edit a share
    @endif
    {{ $media->links() }}
    <hr />
        <hr />
        <a href="/sharing/tv/refresh/list">Refresh show list</a>
        <hr />
        @foreach($media as $show)
            <br /><a href="{{ url('/sharing/tv/list/media/' . $show->id) }}"> {{ $show->title }} </a>
        @endforeach()
    <hr />
    {{ $media->links() }}


</div>

@include('partials.layout-footer')
