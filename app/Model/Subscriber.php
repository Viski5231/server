<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'birthdate',
        'division_id',
    ];

    protected $casts = [
        'birthdate' => 'date:Y-m-d',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function phones()
    {
        return $this->belongsToMany(Phone::class, 'subscriber_phone', 'subscriber_id', 'phone_id')
            ->withPivot(['assigned_at'])
            ->withTimestamps();
    }
}

