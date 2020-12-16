<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $guarded = [];

    protected $fillable = ['name', 'image', 'starter_price', 'ending_date'];

    public $timestamps = false;

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }


}
