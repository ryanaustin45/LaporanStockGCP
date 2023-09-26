<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemakun extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $table = "itemakuns";
    use HasFactory;
}
