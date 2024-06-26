<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_14 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_14',
        'comision3_14',
        'obsCongresoInt',
        'obsCongresoNac',
        'obsCongresoLoc',


    ];
    protected $table = 'users_response_form3_14';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_14';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
