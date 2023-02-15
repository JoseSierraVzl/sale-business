<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    /**@var array<int, string>*/
    protected $fillable = [
        'name',
        'price',
        'tax',
    ];

    protected $casts = [
        'price' => 'float',
        'tax' => 'float',
    ];

    public function shopping()
    {
        return $this->hasMany(Shopping::class);
    }
}