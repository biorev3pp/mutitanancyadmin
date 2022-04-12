<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdomains extends Model
{
    use HasFactory;
    protected $table = 'subdomains';

    protected $guarded = [];
}
