<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MinimumQuantity extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'minimum_quantity';
    protected $guarded = [];
    

}
