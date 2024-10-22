<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infraction extends Model
{
    use HasFactory;
    protected $fillable = ['dni','fecha','plate', 'infraccion', 'description'];
}
