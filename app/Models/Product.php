<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'products';

    // Khai báo các cột có thể được gán hàng loạt
    protected $fillable = [
        'nameproduct', 'description', 'price', 'status', 'brands_id', 'category_id', 'total_rating'
    ];

    // Tự động quản lý các cột timestamps (created_at và updated_at)
    public $timestamps = true;

    // Quan hệ với bảng brands
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public  function size()
    {
        return $this->belongsToMany(Size::class, 'product_items', 'product_id', 'id_size');
    }
    public function color()
    {
        return $this->belongsToMany(Color::class, 'product_items', 'product_id', 'id_color');
    }
    // Quan hệ với bảng category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function productItems()
    {
        return $this->hasMany(ProductItem::class);
    }


}
