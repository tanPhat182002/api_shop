<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'product_image';

    // Khai báo các cột có thể được gán hàng loạt
    protected $fillable = [
        'product_id', 'image'
    ];

    // Tự động quản lý các cột timestamps (created_at và updated_at)
    public $timestamps = false;

    // Quan hệ với bảng products
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
