<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
    ];

    public function premises()
    {
        return $this->hasMany(Premise::class, 'division_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'division_id');
    }
}

