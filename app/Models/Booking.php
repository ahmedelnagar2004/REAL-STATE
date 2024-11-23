<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'notes',
        'unite_id',
        'status'
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    protected $attributes = [
        'status' => 'pending'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}