<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name_clint',
        'email_clint',
        'phone_clint',
        'type_unite',
        'price_unite',
        'status_unite'
    ];

    public function images()
    {
        return $this->hasMany(UnitImage::class);
    }
}
