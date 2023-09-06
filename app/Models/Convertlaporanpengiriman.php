<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convertlaporanpengiriman extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $table = "convertlaporanpengirimans";

    use HasFactory;
}
