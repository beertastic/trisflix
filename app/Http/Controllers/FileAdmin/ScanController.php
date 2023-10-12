<?php

namespace App\Http\Controllers\FileAdmin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Link;
use App\Models\LinkItem;
use App\Models\Movie;
use App\Models\Path;
use App\Models\TV;
use Illuminate\Http\Request;

class ScanController extends Controller
{

    public function __construct() {
	$this->path_tv = config('access.path_tv');
	$this->path_movies = config('access.path_movies');
    }

    public function deleteLink($link_item_id = null) {
        if ($link_item_id == null) {
            dd('bad link ID');
        }
        $link = Link::find($link_item_id);
        LinkItem::where('link_id', $link->id)->delete();
        $link->delete();
    }

    public function deleteLinkItem($link_id = null) {
        if ($link_id == null) {
            dd('bad link ID');
        }
        LinkItem::find($link_id)->delete();
    }

    public function additems($request)
    {
        $data = [];
        if ($request) {
            $files = $request->all()['file_id'];
            foreach ($files as $file) {
                $link = LinkItem::where('link_id', $request->all()['link_id'])->where('file_id', $file)->first();
                if (!$link) {
                    LinkItem::insert([
                        'link_id' => $request->all()['link_id'],
                        'file_id' => $file
                    ]);
                }
            }
        }
    }

    public function refreshShows()
    {
        $lists = scandir($this->path_tv);
        $lists = array_diff($lists, array(".", "..", "Thumbs.db", "theme.mp3", ".DS_Store", "Desktop_.ini"));

        foreach($lists as $list) {
            $show = TV::where('title', $list)->first();
            if (empty($show) === false) {
                $show->touch();
            } else {
                TV::create([
                    'title' => $list
                ]);
            }
        }

        $shows = TV::all()->pluck('title')->toArray();
        foreach (array_diff($shows, $lists) as $del_show) {
            TV::where('title', $del_show)->delete();
        }
    }

    public function refreshMovies()
    {
        $lists = scandir($this->path_movies);
        $lists = array_diff($lists, array(".", "..", "Thumbs.db", "theme.mp3", ".DS_Store", "Desktop_.ini"));

        foreach($lists as $list) {
            $movie = Movie::where('title', $list)->first();
            if (empty($movie) === false) {
                $movie->touch();
            } else {
                Movie::create([
                    'title' => $list
                ]);
            }
        }

        $movies = Movie::all()->pluck('title')->toArray();
        foreach (array_diff($movies, $lists) as $del_show) {
            Movie::where('title', $del_show)->delete();
        }
    }

    public function indexPath($media_id = null, $media = null)
    {
        if ($media == 'tv') {
            $media_source = TV::find($media_id);
            $path = $this->path_tv;
        } else if ($media == 'movie') {
            $media_source = Movie::find($media_id);
            $path = $this->path_movies;
        }

        if (is_dir($path . '/' . $media_source['title'])) {
            $list = scandir($path . '/' . $media_source['title']);
            $this->scanDir($list, $media_source['id'], $media);
        }
    }

    public function indexFiles($media_id = null, $media = 'tv')
    {
        if ($media_id == null) {
            $media_data = Path::all()->take(100000);
        } else {
            $media_data = Path::where('media_id', $media_id)->where('media', $media)->get();
        }

        $path = ($media == 'tv') ? $this->path_tv : $this->path_movies;

        foreach ($media_data as $md) {
            $make_path = $path . '/' . $md->show->title . '/' . $md->path;

            if (is_readable($make_path)) {
                $list = scandir($make_path);
                $list = array_diff($list, array(".", "..", "Thumbs.db", "theme.mp3", ".DS_Store", "Desktop_.ini"));

                foreach ($list as $sub_dir_file) {
                    $file = File::where('path_id', $md->id)->where('filename', $sub_dir_file)->first();

                    if (empty($file) === false) {
                        $file->touch();
                    } else {
                        File::create([
                            'path_id' => $md->id,
                            'filename' => $sub_dir_file
                        ]);
                    }
                }

                $fileChecker = File::where('path_id', $md->id)->pluck('filename')->toArray();
                foreach (array_diff($fileChecker, $list) as $del_file) {
                    File::where('filename', $del_file)->delete();
                }

            }

        }

    }

    public function indexMovie($media_id = null)
    {
        if ($media_id == null) {
            dd('Mo Movie ID supplies');
        }

        // get movie, scan DIR and add path and file entry
        $movie = Movie::find($media_id);
        if ($movie != null) {
            $path = Path::firstOrCreate ([
                'media_id' => $media_id,
                'media' => 'movie',
                'path' => $movie->title
            ]);

            // check for old and deleted files
            $files = File::where('path_id', $path->id)->get();

            $list = scandir($this->path_movies . '/' . $movie->title);
            $list = array_diff($list, array(".", "..", "Thumbs.db", "theme.mp3", ".DS_Store", "Desktop_.ini"));

            $found_files = [];
            foreach ($list as $sub_dir_file) {

                File::firstOrCreate ([
                    'path_id' => $path->id,
                    'filename' => $sub_dir_file
                ]);

                $found_files[] = $sub_dir_file;

            }

            foreach($files as $file) {
                if (!in_array($file->filename, $found_files)) {
                    File::find($file->id)->delete();
                }
            }

        }

    }


    private function scanDir($list, $media_id, $media) {
        $list = array_diff($list, array(".", "..", "Thumbs.db", "theme.mp3", ".DS_Store", "Desktop_.ini"));
        foreach ($list as $sub_dir_file) {
            $path = Path::where('media_id', $media_id)
                ->where('media', $media)
                ->where('path', $sub_dir_file)
                ->first();
            if (empty($path) === false) {
                $path->touch();
            } else {
                $path = Path::create([
                    'media_id' => $media_id,
                    'media' => $media,
                    'path' => $sub_dir_file
                ]);
            }
        }

        $dataChecker = Path::where('media_id', $media_id)->where('media', $media)->pluck('path')->toArray();
        foreach (array_diff($dataChecker, $list) as $del_file) {
            Path::where('path', $del_file)->delete();
        }

    }


    public function cleanShowList() {
        TV::where('updated_at', '<', now()->subDays(7)->toDateTimeString())->delete();
    }

    public function cleanPathList() {
        Path::where('updated_at', '<', now()->subDays(7)->toDateTimeString())->delete();
    }

    public function cleanFileList() {
        File::where('updated_at', '<', now()->subDays(7)->toDateTimeString())->delete();
    }
}
