<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'image', 'starter_price', 'ending_date'];

    public $timestamps = false;

    public function offer()
    {
        return $this->hasMany(Offer::class, 'foreign_key');
    }
}
