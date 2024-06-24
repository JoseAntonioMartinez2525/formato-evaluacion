<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_11 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_11',
        'comision3_11',
        'obs3_11_1',
        'obs3_11_2',
        'obs3_11_3',

    ];
    protected $table = 'users_response_form3_11';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_11';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
