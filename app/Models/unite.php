<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    use HasFactory;
    
    protected $table = 'unites';
    
    protected $fillable = [
        'name',
        'description',
        'status',
        'location',
        'price'
        // حذفنا image_id لأننا سنستخدم العلاقة العكسية
    ];

    // علاقة مع الصور - وحدة واحدة لها عدة صور
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // دالة للحصول على الصورة الرئيسية
    public function mainImage()
    {
        return $this->images()->first();
    }
}
