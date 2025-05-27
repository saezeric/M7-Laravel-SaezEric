<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    // public $timestamps = false;
    protected $table = 'cards';
    protected $fillable = ['name', 'image_url', 'category_id', 'user_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
