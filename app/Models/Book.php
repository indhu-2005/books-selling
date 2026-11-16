<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'author_id',
        'category_id',
        'category_name',
        'price',
        'image',
        'description',
        'condition',
        'isbn',
        'language',
        'publisher',
        'pages',
        'is_exchangeable',
        'exchange_type',
        'featured',
        'rating',
        'seller_name',
        'seller_phone',
        'seller_city',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_exchangeable' => 'boolean',
        'featured' => 'boolean',
        'pages' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authorProfile()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price, 0);
    }
}
