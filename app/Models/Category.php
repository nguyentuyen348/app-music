<?php

namespace App\Models;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $table = 'categories';
    use HasFactory;

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }
}
