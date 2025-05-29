<?php

namespace App\Infrastructure\Models;

use App\Domain\ValueObjects\Phone;
use App\Infrastructure\Traits\ToEntityTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use ToEntityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'phone',
    ];
}
