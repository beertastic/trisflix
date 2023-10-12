<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileAdmin\ScanController;
use App\Models\Link;
use App\Models\Path;
use App\Models\TV;
use Illuminate\Http\Request;

class TvController extends ScanController
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->method() == 'POST') {
            session(['search_tv' => $request->search_tv]);
        }

        $data['media'] = TV::orderBy('title')
                            ->where('title','LIKE','%'.session('search_tv').'%')
                            ->paginate(20)
                            ->withQueryString();
        return view('tv', $data);
    }

    public function list($slug = null)
    {
        $data = [];
        $data['media'] = TV::orderBy('title')->paginate(20)->withQueryString();
        if ($slug) {
            $share = Link::where('slug', $slug)->first();
            session(['link_id' => $share->id]);
            session(['slug' => $share->slug]);
            $data['link'] = $share;
        }

        return view('tv', $data);
    }

    public function listMedia($media_id = null)
    {
        $data['media'] = 'tv';
        $data['media_id'] = $media_id;
        $data['paths'] = Path::where('media_id', $media_id)->where('media', 'tv')->get();
        $data['link'] = Link::where('slug', session('slug'))->first();
        return view('show', $data);
    }

    public function refreshList()
    {
        $this->refreshShows();
        return redirect()->back();
    }

    public function refreshMedia($media_id)
    {
        $this->indexPath($media_id, 'tv');
        $this->indexFiles($media_id, 'tv');
        return redirect()->back();
    }

}
