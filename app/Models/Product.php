<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'image',
        'user_id',
    ];

    protected $hidden = ["image"];

    protected $appends = ["img_url"];

    public function getImgUrlAttribute(){
        if (empty($this->image)){
            return null;
        }

        return url('/') . Storage::url($this->image);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
