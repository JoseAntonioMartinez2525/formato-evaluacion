<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;

    protected $fillable = ['form_name', 'description'];

    public function fields()
    {
        return $this->hasMany(DynamicFormField::class, 'form_id');
    }
}

