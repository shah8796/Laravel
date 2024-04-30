<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = 'favourites';
    protected $fillable = ['bookId', 'userId'];
    use HasFactory;
}
