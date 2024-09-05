<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm3_12 extends Model
{
    use HasFactory;
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'score3_12',
        'comision3_12',
        'cantCientifico',
        'subtotalCientificos',
        'comisionCientificos',
        'obsCientificos',
        'cantDivulgacion',
        'subtotalDivulgacion',
        'comisionDivulgacion',
        'obsDivulgacion',
        'cantTraduccion',
        'subtotalTraduccion',
        'comisionTraduccion',
        'obsTraduccion',
        'cantArbitrajeInt',
        'subtotalArbitrajeInt',
        'comisionArbitrajeInt',
        'obsArbitrajeInt',
        'cantArbitrajeNac',
        'subtotalArbitrajeNac',
        'comisionArbitrajeNac',
        'obsArbitrajeNac',
        'cantSinInt',
        'subtotalSinInt',
        'comisionSinInt',
        'obsSinInt',
        'cantSinNac',
        'subtotalSinNac',
        'comisionSinNac',
        'obsSinNac',
        'cantAutor',
        'subtotalAutor',
        'comisionAutor',
        'obsAutor',
        'cantEditor',
        'subtotalEditor',
        'comisionEditor',
        'obsEditor',
        'cantWeb',
        'subtotalWeb',
        'comisionWeb',
        'obsWeb',
        'user_type',

    ];

    public $incrementing = false; // Indicates the primary key is not auto-incrementing
    protected $primaryKey = 'dictaminador_id'; // Specifies the primary key
    protected $keyType = 'bigint'; // Specifies the key type


    protected $table = 'dictaminators_response_form3_12';
    public function user()
    {
        return $this->belongsTo(User::class, 'dictaminador_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form3_12';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}


