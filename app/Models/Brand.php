<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected  $primaryKey = 'id';
protected $fillable = [
        'name',
    ];

    // Các cột không muốn Eloquent tự động chèn timestamp
    public $timestamps = false;
}
