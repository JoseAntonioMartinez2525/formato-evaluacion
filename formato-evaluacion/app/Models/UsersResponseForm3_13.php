<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResponseForm3_13 extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'score3_13',
        'comision3_13',
        'obsInicioFinancimientoExt',
        'obsInicioInvInterno',
        'obsReporteFinanciamExt',
        'obsReporteInvInt',


    ];
    protected $table = 'users_response_form3_13';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'users_response_form3_13';
        $this->connection = 'mysql';
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
