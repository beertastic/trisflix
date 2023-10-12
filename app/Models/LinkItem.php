<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkItem extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'link_id'
    ];

    public function link() {
        return $this->belongsTo(Link::class);
    }

    public function file() {
        return $this->belongsTo(File::class)->withTrashed();
    }
}
