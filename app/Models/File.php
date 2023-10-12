<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'media_files';

    protected $fillable = [
        'filename',
        'path_id'
    ];

    public function path() {
        return $this->belongsTo(Path::class);
    }

    public function show() {
        return $this->hasOneThrough(
            TV::class,
            Path::class,
            'id',
            'id',
            'path_id',
            'media_id');
    }

    public function movie() {
        return $this->hasOneThrough(
            Movie::class,
            Path::class,
            'id',
            'id',
            'path_id',
            'media_id');
    }

    public function link()
    {
        return $this->hasOne(LinkItem::class);
    }

    public function getDownloadsCountAttribute()
    {
//        return $this->hasMany(Download::class);
        return $this->hasMany(Download::class)->count();
    }

}
