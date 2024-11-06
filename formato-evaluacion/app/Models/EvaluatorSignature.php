<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluatorSignature extends Model
{
    use HasFactory;

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        //'docente_id',
        'user_id',
        'email',
        'evaluator_name',
        /*'evaluator_name_2',
        'evaluator_name_3',
        'signature_path_1',
        'signature_path_2',
        */
        'signature_path',
        'user_type',
    ];


    protected $table = 'evaluador_por_firmas';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'evaluador_por_firmas';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}

