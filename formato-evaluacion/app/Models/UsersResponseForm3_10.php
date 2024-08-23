<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_10 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        //'score3_10',
        'comision3_10',
        'obsGrupal',
        'obsIndividual',
        'user_type',

    ];
    protected $table = 'users_response_form3_10';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_10';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
