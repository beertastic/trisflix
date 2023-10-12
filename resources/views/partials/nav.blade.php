<header>
    <div class="nav">
        <ul>
            <li><a @if($page == 'home') class="active"@endif href="/sharing">Home</a></li>
            <li><a @if($page == 'shares') class="active"@endif href="/sharing/shares">Shares</a></li>
            <li><a @if($page == 'tv') class="active"@endif href="/sharing/tv">TV</a></li>
            <li><a @if($page == 'movies') class="active"@endif href="/sharing/movies">Movies</a></li>
        </ul>
    </div>
</header>
