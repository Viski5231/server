<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phone extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'number',
        'premise_id',
    ];

    public function premise()
    {
        return $this->belongsTo(Premise::class, 'premise_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_phone', 'phone_id', 'subscriber_id')
            ->withPivot(['assigned_at'])
            ->withTimestamps();
    }
}

