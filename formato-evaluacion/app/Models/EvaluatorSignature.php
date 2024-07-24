<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluatorSignature extends Model
{
    use HasFactory;

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'email',
        'evaluator_name',
        'signature_path',
    ];


    protected $table = 'evaluator_signatures';

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

