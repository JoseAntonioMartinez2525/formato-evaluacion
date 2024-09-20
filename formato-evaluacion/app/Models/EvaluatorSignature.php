<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluatorSignature extends Model
{
    use HasFactory;

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'evaluator_name_1',
        'evaluator_name_2',
        'evaluator_name_3',
        'signature_path_1',
        'signature_path_2',
        'signature_path_3',
        'user_type',
    ];


    protected $table = 'evaluator_signatures';

    public function user()
    {
        return $this->belongsTo(User::class, 'dictaminador_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'evaluator_signatures';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}

