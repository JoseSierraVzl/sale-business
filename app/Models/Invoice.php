<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**@var array<int, string>*/
    protected $fillable = [
        'user_id',
        'sub_total',
        'taxs_total',
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'shopping');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}