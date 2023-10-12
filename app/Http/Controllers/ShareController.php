<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileAdmin\ScanController;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShareController extends ScanController
{
    public function index()
    {
        $data = [];
        Link::where('expires_at', '<', Carbon::now())->delete();
        $data['links'] = Link::all();
        return view('shares', $data);
    }

    public function nick()
    {



$link=url('https://cdn.weasyl.com/static/media/1d/06/47/1d0647a4e119e2f02c058a8f6efae25e3169adf807ce58acf88051af16f3c52f.png');
header("Content-type: image/png");
$imageContent = file_get_contents($link);
echo $imageContent; 
die();

//        $shares = Link::all();
//        echo rand(100000, 999999) . '<hr />';
//        foreach($shares as $items)
//        {
//            echo '<br />Link ID: ' . $items->id;
//            foreach($items->items as $item) {
//
//                echo '<br />Filename: ' . $item->file->downloads_count;
//                echo '<br />ID: ' . $item->id;
//                echo '<br />link ID: ' . $item->link_id;
//                echo '<br />file ID: ' . $item->file_id;
//                echo '<p />';
//            }
//            echo '<hr /><hr />';
//        }
    }

    public function linkNew()
    {
        $share = Link::create([
            'owner' => 1,
            'slug' => Str::random(20),
            'expires_at' => now()->addDays(14),
            'pass' => Str::random(20)
        ]);
        session(['link_id' => $share->id]);
        session(['slug' => $share->slug]);
        return redirect()->back();
    }

    public function linkDel($link_slug)
    {
        $this->deleteLink($link_slug);
        return redirect()->back();
    }

    public function linkItemDel($link_item_slug)
    {
        $this->deleteLinkItem($link_item_slug);
        return redirect()->back();
    }

    public function linkItemAdd(Request $request)
    {
        $this->additems($request);
        return redirect()->back();
    }
}
