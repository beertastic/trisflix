<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileAdmin\ScanController;
use App\Models\Link;
use App\Models\Movie;
use App\Models\Path;
use Illuminate\Http\Request;

class MoviesController extends ScanController
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->method() == 'POST') {
            session(['search_movie' => $request->search_movie]);
        }

        $data['shows'] = Movie::orderBy('title')
            ->where('title','LIKE','%'.session('search_movie').'%')
            ->paginate(20)
            ->withQueryString();
        return view('movies', $data);
    }

    public function listMedia($media_id = null)
    {
        $data['media'] = 'movies';
        $data['media_id'] = $media_id;
        $data['paths'] = Path::where('media_id', $media_id)->where('media', 'movie')->get();
        $data['link'] = Link::where('slug', session('slug'))->first();
        return view('show', $data);
    }

    public function refreshMedia($media_id)
    {
        $this->indexMovie($media_id);
        return redirect()->back();
    }

    public function refreshList()
    {
        $this->refreshMovies();
        return redirect()->back();
    }
}
