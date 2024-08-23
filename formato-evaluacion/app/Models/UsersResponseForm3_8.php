<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_8 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_8',
        //'comision3_8',
        'obs3_8_1',
        'user_type',

    ];
    protected $table = 'users_response_form3_8';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_8';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
