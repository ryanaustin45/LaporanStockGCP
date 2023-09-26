<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapbiaya extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $table = "rekapbiayas";
    use HasFactory;
}
