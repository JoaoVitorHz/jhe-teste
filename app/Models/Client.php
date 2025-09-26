<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'cnpj',
        'observation',
        'contract_value'
    ];

    protected $casts = [
        'contract_value' => 'decimal:2'
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
