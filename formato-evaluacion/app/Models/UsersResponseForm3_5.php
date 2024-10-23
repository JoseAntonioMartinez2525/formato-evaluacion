<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_5 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_5',
        //'comision3_5',
        'cantDA',
        'cantCAAC',
        'cantDA2',
        'cantCAAC2',
        'obs3_5_1',
        'obs3_5_2',
        'user_type',

    ];
    protected $table = 'users_response_form3_5';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_5';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }

    public function dictaminadores()
    {
        return $this->belongsToMany(DictaminatorsResponseForm3_5::class, 'dictaminators_response_form3_5');
    }
}



