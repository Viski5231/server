<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Premise extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'division_id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'premise_id');
    }
}

