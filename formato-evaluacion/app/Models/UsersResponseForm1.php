<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class UsersResponseForm1 extends BaseResponse
{
    protected $fillable = [
        'user_id',
        'convocatoria',
        'periodo',
        'nombre',
        'area',
        'departamento',
    ];

    protected $table = 'users_responses_form1';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_responses_form1';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}




