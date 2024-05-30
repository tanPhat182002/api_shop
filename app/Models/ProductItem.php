<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;
// Tên bảng trong cơ sở dữ liệu
    protected $table = 'product_item';

    // Khai báo các cột có thể được gán hàng loạt
    protected $fillable = [
        'product_id', 'color', 'size', 'quantity'
    ];

    // Tự động quản lý các cột timestamps (created_at và updated_at)
    public $timestamps = true;

    // Quan hệ với bảng Product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ với bảng Color

}
