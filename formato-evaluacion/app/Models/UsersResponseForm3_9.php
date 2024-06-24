<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_9 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_9',
        'comision3_9',
        'obs3_9_1',
        'obs3_9_2',
        'obs3_9_3',
        'obs3_9_4',
        'obs3_9_5',
        'obs3_9_6',
        'obs3_9_7',
        'obs3_9_8',
        'obs3_9_9',
        'obs3_9_10',
        'obs3_9_11',
        'obs3_9_12',
        'obs3_9_13',
        'obs3_9_14',
        'obs3_9_15',
        'obs3_9_16',
        'obs3_9_17',
    ];
    protected $table = 'users_response_form3_9';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_9';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
