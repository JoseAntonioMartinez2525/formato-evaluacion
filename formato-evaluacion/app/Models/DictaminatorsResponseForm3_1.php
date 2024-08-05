<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm3_1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'actv3Comision',
        'obs3_1_1',
        'obs3_1_2',
        'obs3_1_3',
        'obs3_1_4',
        'obs3_1_5',
    ];


    protected $table = 'dictaminators_response_form3_1';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form3_1';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}


