@include('partials.layout-header')


@include('partials.nav', ['page' => 'home'])

<h3>Recently updated shows</h3>

@foreach($recent_t as $rec_t)
        <?php
        if (!isset($rec_t->show)) {
            echo '<br />An error was found with TV Shows, please inform admin to correct this.';
            continue;
        }
        ?>
        <br /> <a href="https://trisflix.com/sharing/tv/list/media/{{ $rec_t->show->id }}">{{ $rec_t->show->title }}</a>
@endforeach

<h3>Recently updated movies</h3>
@foreach($recent_m as $rec_m)
    <?php
        if (!isset($rec_m->movie)) {
            echo '<br />An error was found with movie: ' . $rec_m->movie->title . ' | ID: ' . $rec_m->movie->id;
            continue;
        }
        ?>
    <br /> <a href="https://trisflix.com/sharing/movies/list/media/{{ $rec_m->movie->id }}">{{ $rec_m->movie->title }}</a>
@endforeach

@include('partials.layout-footer')
