<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_6 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_6',
        //'comision3_6',
        'puntaje3_6',
        'puntajeHoras3_6',
        'obs3_6_1',
        'user_type',

    ];
    protected $table = 'users_response_form3_6';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_6';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
