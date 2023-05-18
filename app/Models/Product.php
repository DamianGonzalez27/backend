<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'description',
        'store_id',
        'price',
        'url'
    ];
    public $timestamps = false;

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
