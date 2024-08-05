<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm2 extends RulesForm2
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'comision1',
        'obs1',

    ];

    protected $table = 'dictaminators_response_form2';

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




