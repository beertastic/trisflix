<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileAdmin\ScanController;
use App\Models\Link;
use App\Models\Path;
use App\Models\TV;
use Illuminate\Support\Str;

class PanelController extends ScanController
{
    //// MASTER FUNCTIONS ////
    public function index()
    {
        $data = [];
        $data['recent_t'] = $this->recent_updates('tv');
        $data['recent_m'] = $this->recent_updates('movies');
        return view('home', $data);
    }

    private function recent_updates($source = 'tv')
    {
        if ($source == 'tv') {
            return Path::limit(12)->where('media', 'tv')->orderBy('updated_at', 'desc')->groupBy('media_id')->get();
        } else if ($source == 'movies') {
            return Path::limit(12)->where('media', 'movie')->orderBy('updated_at', 'desc')->groupBy('media_id')->get();
        }
    }
}
