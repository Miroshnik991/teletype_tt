<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Traits\ToEntityTrait;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use ToEntityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
    ];
}
