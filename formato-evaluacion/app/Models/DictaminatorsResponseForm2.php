<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm2 extends RulesForm2
{
    use HasFactory;
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'horasActv2',
        'puntajeEvaluar',
        'comision1',
        'obs1',
        'user_type',

    ];

    public $incrementing = false; // Indicates the primary key is not auto-incrementing
    protected $primaryKey = 'dictaminador_id'; // Specifies the primary key
    protected $keyType = 'bigint'; // Specifies the key type

    protected $table = 'dictaminators_response_form2';
    public function user()
    {
        return $this->belongsTo(User::class, 'dictaminador_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form2';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}




