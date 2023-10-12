<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    protected $table = 'media_paths';

    protected $fillable = [
        'media',
        'media_id',
        'path'
    ];

    public function files() {
        return $this->hasMany(File::class);
    }

    public function show() {
        return $this->belongsTo(TV::class, 'media_id');
    }

    public function movie() {
        return $this->belongsTo(Movie::class, 'media_id');
    }
}
