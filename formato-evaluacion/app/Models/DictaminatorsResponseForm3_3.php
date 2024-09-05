<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm3_3 extends Model
{
    use HasFactory;
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'score3_3',
        'comision3_3',
        'rc1',
        'rc2',
        'rc3',
        'rc4',
        'stotal1',
        'stotal2',
        'stotal3',
        'stotal4',
        'comIncisoA',
        'comIncisoB',
        'comIncisoC',
        'comIncisoD',
        'obs3_3_1',
        'obs3_3_2',
        'obs3_3_3',
        'obs3_3_4',      
        'user_type',
    ];

    public $incrementing = false; // Indicates the primary key is not auto-incrementing
    protected $primaryKey = 'dictaminador_id'; // Specifies the primary key
    protected $keyType = 'bigint'; // Specifies the key type


    protected $table = 'dictaminators_response_form3_3';
    public function user()
    {
        return $this->belongsTo(User::class, 'dictaminador_id', 'id');
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form3_3';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}


