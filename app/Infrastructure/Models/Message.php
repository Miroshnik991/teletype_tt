<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Traits\ToEntityTrait;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use ToEntityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'dialog_id',
        'message',
        'sent_at'
    ];
}
