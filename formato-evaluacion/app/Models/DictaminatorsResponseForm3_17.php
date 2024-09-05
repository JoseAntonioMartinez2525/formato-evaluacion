<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm3_17 extends Model
{
    use HasFactory;
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'score3_17',
        'comision3_17',
        'cantDifusionExt',
        'cantDifusionInt',
        'cantRepDifusionExt',
        'cantRepDifusionInt',
        'subtotalDifusionExt',
        'subtotalDifusionInt',
        'subtotalRepDifusionExt',
        'subtotalRepDifusionInt',
        'comisionDifusionExt',
        'comisionDifusionInt',
        'comisionRepDifusionExt',
        'comisionRepDifusionInt',
        'obsDifusionExt',
        'obsDifusionInt',
        'obsRepDifusionExt',
        'obsRepDifusionInt',        
        'user_type',

    ];

    public $incrementing = false; // Indicates the primary key is not auto-incrementing
    protected $primaryKey = 'dictaminador_id'; // Specifies the primary key
    protected $keyType = 'bigint'; // Specifies the key type


    protected $table = 'dictaminators_response_form3_17';
    public function user()
    {
        return $this->belongsTo(User::class, 'dictaminador_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form3_17';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}


