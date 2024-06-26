<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_19 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_19',
        'comision3_19',
        'obsCGUtitular',
        'obsCGUespecial',
        'obsCGUpermanente',
        'obsCAACtitular',
        'obsCAACintegCom',
        'obsComDepart',
        'obsComPEDPD',
        'obsComPartPos',
        'obsRespPos',
        'obsRespCarrera',
        'obsRespProd',
        'obsRespLab',
        'obsExamProf',
        'obsExamAcademicos',
        'obsPRODEPformResp',
        'obsPRODEPformInteg',
        'obsPRODEPenconsResp',
        'obsPRODEPenconsInteg',
        'obsPRODEPconsResp',
        'obsPRODEPconsInteg',


    ];
    protected $table = 'users_response_form3_19';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_19';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
