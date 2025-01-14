<?php

namespace App\Http\Controllers;

use App\Models\DynamicForm;
use Illuminate\Http\Request;

class DynamicFormController extends Controller
{
    public function storeForm(Request $request)
    {
        // Cálculos de puntajes, comisiones y validaciones
        $formData = $request->all();

        foreach ($formData['activities'] as $activity) {
            // Aquí puedes realizar cálculos de los puntajes, como la división por promedio, etc.
            $activityScore = $this->calculateScore($activity);
            // Guardar los datos en la base de datos o pasar al siguiente paso
            $this->saveActivityData($activity, $activityScore);
        }
        return redirect()->route('form.success');
    }

    public function calculateScore($activity)
    {
        // Ejemplo de cálculo dinámico
        $score = $activity['base_score'] * $activity['weight'];
        return $score;
    }

}
