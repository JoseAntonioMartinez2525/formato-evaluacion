<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_4 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_4',
        'comision3_4',
        'obs3_4_1',
        'obs3_4_2',
        'obs3_4_3',
        'obs3_4_4',

    ];
    protected $table = 'users_response_form3_4';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_4';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}

