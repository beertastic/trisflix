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
