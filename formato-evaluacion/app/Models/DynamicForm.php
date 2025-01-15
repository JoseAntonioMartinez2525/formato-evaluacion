<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_name',
        'puntaje_maximo',
        'user_id',
        'email',
        'user_type',
        'table_data',
    ];

    protected $casts = [
        'table_data' => 'array',  // Convierte la columna JSON en un array al obtenerla
    ];

    public function fields()
    {
        return $this->hasMany(DynamicFormField::class, 'user_id');
    }
}

