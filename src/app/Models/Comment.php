<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'content',
    ];
    //User(投稿者)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Product(商品)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
