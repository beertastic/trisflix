<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\FileAdmin\ScanController;
use App\Models\TV;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends ScanController
{
    public function sonarr(Request $r) {
        $title = substr($r['series']['path'], strrpos($r['series']['path'], '/') + 1);
        $series = TV::where('title', $title)->first();
        if ($series) {
            $this->indexPath($series->id);
            $this->indexFiles($series->id);

        }
        Log::info('Updated: ' . $r['series']['title']);
    }

    public function radarr(Request $r) {
        $title = $r['movie']['title'] . ' (' . $r['movie']['year'] . ')';
        $movie = Movie::where('title', $title)->first();
        if ($movie) {
            $this->indexMovie($movie->id);
        }
        Log::info('Updated Movie: ' . $r['movie']['title'] );
    }


}
