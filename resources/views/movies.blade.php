@include('partials.layout-header')

@include('partials.nav', ['page' => 'movies'])

<div id="page-container">

    @if(session('slug'))
        Share Slug: {{ session('slug') }}

        <form method="post" action="/sharing/movies">
            @csrf
            <input type="text" name="search_movie" placeholder="Search part of a title" value="{{ session('search_movie') }}"><br />
            <input type="submit" value="Search">
        </form>

    @else
        Please create or edit a share
    @endif
        {{ $shows->links() }}
        <hr />
        <hr />
        <a href="/sharing/movies/refresh/list">Refresh movie list</a>
        <hr />
        @foreach($shows as $show)
            <br /><a href="{{ url('/sharing/movies/list/media/' . $show->id) }}"> {{ $show->title }} </a>
        @endforeach()
        <hr />
        {{ $shows->links() }}

</div>
@include('partials.layout-footer')
