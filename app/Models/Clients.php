<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class Clients extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->hasMany(Projects::class, 'client_id');
    }
}
