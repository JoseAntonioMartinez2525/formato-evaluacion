<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_7 extends Model
{
    use HasFactory;    
    protected $fillable = [
        'user_id',
        'email',
        'score3_7',
        //'comision3_7',
        'puntaje3_7',
        'puntajeHoras3_7',
        'obs3_7_1',
        'user_type',

    ];
    protected $table = 'users_response_form3_7';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_7';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }

    public function dictaminadores()
    {
        return $this->belongsToMany(DictaminatorsResponseForm3_7::class, 'dictaminators_response_form3_7');
    }
}
