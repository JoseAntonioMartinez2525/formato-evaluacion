<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm2_2 extends RulesForm2_2
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'user_type',
        'hours',
        'horasPosgrado',
        'horasSemestre',
        'dse',
        'dse2',
        'obs2',
        'obs2_2',

    ];

    protected $table = 'users_response_form2_2';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form2_2';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


    public function dictaminadores()
    {
        return $this->morphedByMany(
            DictaminatorsResponseForm2_2::class,    // Modelo objetivo
            'id_type',                    // Nombre del campo morph
            'dictaminador_docente',               // Nombre de la tabla pivot
            'user_id',                            // Llave de la tabla de usuarios
            'dictaminador_form_id'                // Llave de la tabla objetivo en la relación polimórfica
        )
            ->withPivot('form_type', 'docente_email') // Campos adicionales en la tabla pivot
            ->withTimestamps();
    }


}





