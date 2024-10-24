<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_18 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_18',
        //'comision3_18',
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
        'user_type',


    ];
    protected $table = 'users_response_form3_18';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_18';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }

    public function dictaminadores()
    {
        return $this->belongsToMany(DictaminatorsResponseForm3_18::class, 'dictaminador_docente', 'user_id', 'dictaminator_form_id')
            ->withPivot('form_type')
            ->withTimestamps();
    }
}
