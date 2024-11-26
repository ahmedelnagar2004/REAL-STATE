<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitImage extends Model
{
    protected $table = 'unit_images';

    protected $fillable = [
        'client_id',
        'image_path'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}