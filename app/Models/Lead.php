<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    /**
     * @return HasOne<Address>
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
