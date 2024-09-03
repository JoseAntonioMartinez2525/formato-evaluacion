<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictaminatorsResponseForm3_18 extends Model
{
    use HasFactory;
    protected $fillable = [
        'dictaminador_id',
        'user_id',
        'email',
        'score3_18',
        'comision3_18',
        'cantComOrgInt',
        'cantComOrgNac',
        'cantComOrgReg',
        'cantComApoyoInt',
        'cantComApoyoNac',
        'cantComApoyoReg',
        'cantCicloComOrgInt',
        'cantCicloComOrgNac',
        'cantCicloComOrgReg',
        'cantCicloComApoyoInt',
        'cantCicloComApoyoNac',
        'cantCicloComApoyoReg',
        'subtotalComOrgInt',
        'subtotalComOrgNac',
        'subtotalComOrgReg',
        'subtotalComApoyoInt',
        'subtotalComApoyoNac',
        'subtotalComApoyoReg',
        'subtotalCicloComOrgInt',
        'subtotalCicloComOrgNac',
        'subtotalCicloComOrgReg',
        'subtotalCicloComApoyoInt',
        'subtotalCicloComApoyoNac',
        'subtotalCicloComApoyoReg',
        'obsComOrgInt',
        'obsComOrgNac',
        'obsComOrgReg',
        'obsComApoyoInt',
        'obsComApoyoNac',
        'obsComApoyoReg',
        'obsCicloComOrgInt',
        'obsCicloComOrgNac',
        'obsCicloComOrgReg',
        'obsCicloComApoyoInt',
        'obsCicloComApoyoNac',
        'obsCicloComApoyoReg',
        'comisionComOrgInt',
        'comisionComOrgNac',
        'comisionComOrgReg',
        'comisionComApoyoInt',
        'comisionComApoyoNac',
        'comisionComApoyoReg',
        'comisionCicloComOrgInt',
        'comisionCicloComOrgNac',
        'comisionCicloComOrgReg',
        'comisionCicloComApoyoInt',
        'comisionCicloComApoyoNac',
        'comisionCicloComApoyoReg',        
        'user_type',

    ];

    public $incrementing = false; // Indicates the primary key is not auto-incrementing
    protected $primaryKey = 'dictaminador_id'; // Specifies the primary key
    protected $keyType = 'bigint'; // Specifies the key type


    protected $table = 'dictaminators_response_form3_18';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'dictaminators_response_form3_18';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}


