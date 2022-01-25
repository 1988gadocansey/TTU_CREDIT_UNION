<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'relationship',
        'benefit',
        'address',
        'number'
    ];
}
