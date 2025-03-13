<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Type;

class Pet extends Model
{
    /** @use HasFactory<\Database\Factories\PetFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type_id',
        'user_id',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
