<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movie';

    protected $fillable = [
        'title'
    ];

    public function paths() {
        return $this->hasMany(Path::class);
    }

    public function files() {
        return $this->hasManyThrough(File::class, Path::class);
    }
}
