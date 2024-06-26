<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_16 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_16',
        'comision3_16',
        'obsArbInt',
        'obsArbNac',
        'obsPubInt',
        'obsPubNac',
        'obsRevInt',
        'obsRevNac',
        'obsRevista',


    ];
    protected $table = 'users_response_form3_16';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_16';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
