<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class UsersResponseForm2 extends BaseResponse
{
    protected $fillable = [
        'user_id',
        'horasActv2',
        'puntajeEvaluar',
        'comision1',
        'obs1',
        
    ];

    protected $table = 'users_responses_form2';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_responses_form2';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}




