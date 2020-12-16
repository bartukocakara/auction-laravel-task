<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';

    protected $guarded = [];

    protected $fillable = ['user_id', 'product_id', 'amount', 'is_blocked'];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
