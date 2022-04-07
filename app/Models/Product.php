<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    // protected $appends = ['image'];

    public function getImageUrlAttribute()
    {
        return $this->image ? url('/uploads/' . $this->image) : "";
    }
}