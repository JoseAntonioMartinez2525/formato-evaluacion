<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_12 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_12',
        'comision3_12',
        'obsCientificos',
        'obsDivulgacion',
        'obsTraduccion',
        'obsArbitrajeInt',
        'obsArbitrajeNac',
        'obsSinInt',
        'obsSinNac',
        'obsAutor',
        'obsEditor',
        'obsWeb',

    ];
    protected $table = 'users_response_form3_12';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_12';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
