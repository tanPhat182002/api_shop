<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'size';  // Renamed to follow Laravel's plural convention

    // Define the fillable attributes
    protected $fillable = ['name'];

    // Disable timestamps if your table does not have created_at and updated_at columns
    public $timestamps = false;

    /**
     * The products that belong to the size.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_items', 'id', 'product_id');
    }

    /**
     * The product items that belong to the size.
     */

}
