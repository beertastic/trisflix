<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasFactory, softDeletes;



    protected $fillable = [
        'owner',
        'slug',
        'expires_at',
        'pass',
    ];

    public function items() {
        return $this->hasMany(LinkItem::class);
    }

    public function file() {
        return $this->hasMany(File::class);
    }
}
