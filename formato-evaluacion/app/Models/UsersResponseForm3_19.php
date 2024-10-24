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
        'cantCGUtitular',   
        'subtotalCGUtitular',
        'cantCGUespecial',
        'subtotalCGUespecial',
        'cantCGUpermanente',
        'subtotalCGUpermanente',
        'cantCAACtitular',
        'subtotalCAACtitular',
        'cantCAACintegCom',
        'subtotalCAACintegCom',
        'cantComDepart',
        'subtotalComDepart',
        'cantComPEDPD',
        'subtotalComPEDPD',
        'cantComPartPos',
        'subtotalComPartPos',
        'cantRespPos',
        'subtotalRespPos',
        'cantRespCarrera',
        'subtotalRespCarrera',
        'cantRespProd',
        'subtotalRespProd',
        'cantRespLab',
        'subtotalRespLab',
        'cantExamProf',
        'subtotalExamProf',
        'cantExamAcademicos',
        'subtotalExamAcademicos',
        'cantPRODEPformResp',
        'subtotalPRODEPformResp',
        'cantPRODEPformInteg',
        'subtotalPRODEPformInteg',
        'cantPRODEPenconsResp',
        'subtotalPRODEPenconsResp',
        'cantPRODEPenconsInteg',
        'subtotalPRODEPenconsInteg',
        'cantPRODEPconsResp',
        'subtotalPRODEPconsResp',
        'cantPRODEPconsInteg',
        'subtotalPRODEPconsInteg',
        //'comision3_19',
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
        'user_type',


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

    public function dictaminadores()
    {
        return $this->belongsToMany(DictaminatorsResponseForm3_19::class, 'dictaminador_docente', 'user_id', 'dictaminator_form_id')
            ->withPivot('form_type')
            ->withTimestamps();
    }
}
