<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'color';  // Renamed to follow Laravel's plural convention

    // Define the fillable attributes
    protected $fillable = ['name'];

    // Disable timestamps if your table does not have created_at and updated_at columns
    public $timestamps = false;


}
