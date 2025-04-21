<?php

namespace App\Http\Controllers;
use App\Models\DynamicFormCommission;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\DynamicForm;
use App\Models\DynamicFormColumn;
use App\Models\DynamicFormValue;
use Illuminate\Http\Request;
use App\Models\DynamicFormItem;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;// Corrected line without extraneous character

class DynamicFormController extends Controller
{
    public function store(Request $request)
    {
        // Valida los datos
        try {
            $validatedData = $request->validate([
                'form_name' => 'required|string|max:255',
                'puntaje_maximo' => 'required|numeric|min:0',
                'table_data' => 'required|array',
                'user_id' => 'required|integer',
                'email' => 'required|email',
                'user_type' => 'nullable|string',
                'column_names' => 'required|array',
                'acreditacion' => 'nullable|string', // Validate column names
            ]);

            // Procesar los datos (puedes guardar en la base de datos aquí)
            $formId = \DB::table('dynamic_forms')->insertGetId([
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email'],
                'user_type' => $validatedData['user_type'] ?? null,
                'form_name' => $validatedData['form_name'],
                'puntaje_maximo' => $validatedData['puntaje_maximo'],
                'table_data' => json_encode($validatedData['table_data']),
                'acreditacion' => $validatedData['acreditacion'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Inserta cada elemento en dynamic_form_items
            foreach ($validatedData['table_data'] as $key => $value) {
                \DB::table('dynamic_form_items')->insert([
                    'dynamic_form_id' => $formId,
                    'puntaje_maximo' => $validatedData['puntaje_maximo'],
                    'key' => $key,
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Inserta cada columna dinámica en dynamic_form_columns
            $columnIds = [];
            foreach ($validatedData['column_names'] as $columnName) {
                $validatedColumnName = preg_replace('/[^a-zA-Z0-9_]/', '_', $columnName); // Replace invalid characters
                $validatedColumnName = is_numeric($validatedColumnName[0]) ? '_' . $validatedColumnName : $validatedColumnName;

                $columnId = \DB::table('dynamic_form_columns')->insertGetId([
                    'dynamic_form_id' => $formId,
                    'column_name' => $validatedColumnName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $columnIds[] = $columnId;
            }

            // Inserta cada valor en dynamic_form_values
            foreach ($validatedData['table_data'] as $index => $row) {
                foreach ($row as $key => $value) {
                    $columnId = $columnIds[array_search($key, array_keys($validatedData['table_data'][0]))];
                    // Use insertGetId to get the valueId
                    $valueId = \DB::table('dynamic_form_values')->insertGetId([
                        'dynamic_form_id' => $formId,
                        'dynamic_form_column_id' => $columnId,
                        'value' => $value ?? '', // Replace null values with an empty string
                        'puntaje_maximo' => $validatedData['puntaje_maximo'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);


                    // Fetch the form_name from dynamic_form_items using key 0
                    $formName = \DB::table('dynamic_form_values')
                        ->where('id', $valueId) // Use the unique id from dynamic_form_values
                        ->value('value'); // Fetch the specific value based on the unique id

                    // Insert into dynamic_form_combined using the auto-generated valueId
                    $formTypeMatch = preg_match('/^([\d.]+(_[\d.]+)*)?(?=\s|$)/', $formName, $matches);
                    $formType = $formTypeMatch ? 'form' . $matches[0] : 'form'; // Construct the form type

                    // Insert into dynamic_form_combined using the auto-generated valueId
                    \DB::table('dynamic_form_combined')->updateOrInsert(
                        [
                            'dynamic_form_id' => $formId,
                            'dynamic_form_column_id' => $columnId,
                            'dynamic_form_value_id' => $valueId,
                        ],
                        [
                            'form_name' => $formName, // Use the fetched form_name
                            'puntaje_maximo' => $validatedData['puntaje_maximo'],
                            'form_type' => $formType,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }



            // Responder al cliente
            return response()->json([
                'success' => true,
                'form_type' => $formType,
                'form_name' => $validatedData['form_name'],
                'vaue_id'=> $valueId
            ]);
        } catch (\Exception $e) {
            // Captura errores y retorna un mensaje JSON
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Método para recuperar el formulario del usuario
public function getFormByName($formName)
{
    $form = DynamicForm::with('combinedData') // Assuming 'combinedData' is the relationship defined in the DynamicForm model
        ->where('form_name', $formName)
        ->first();

    if ($form) {
        return response()->json([
            'success' => true,
            'form' => $form,
            'combined_data' => $form->combinedData // Include combined data in the response

            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Formulario no encontrado.']);
        }
    }

    public function calculateScore($activity)
    {
        // Ejemplo de cálculo dinámico
        $score = $activity['base_score'] * $activity['weight'];
        return $score;
    }

    public function showDynamicForm(Request $request)
    {
        \Log::info('Accessing showDynamicForm', [
            'user' => Auth::user(),
            'session' => $request->session()->all()
        ]);

        Log::info('User attempting to access edit_delete_form', [
            'user_id' => Auth::id(),
            'user_type' => Auth::user()->user_type
        ]);
        

        // Verify user is authenticated and has correct type
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->user_type !== '') {
            Log::warning('Unauthorized user type attempted to access edit_delete_form');
            return redirect()->route('login');
        }
        
        $form = \DB::table('dynamic_forms')->first();
        if (!$form) {
            return redirect()->route('edit_delete_form')->with('error', 'Formulario no encontrado.');
        }
        // Obtener las columnas y valores para este formulario
        $columns = \DB::table('dynamic_form_columns')->where('dynamic_form_id', $form->id)->get();
        $values = \DB::table('dynamic_form_items')->where('dynamic_form_id', $form->id)->get();

        // Fetch all forms from the database
        $forms = DynamicForm::all();

         // Check if there are any forms
        if ($forms->isEmpty()) {
            return redirect()->route('secretaria')
            >with('message', 'No hay formularios disponibles. Por favor, cree un nuevo formulario.');
    
        }

        return view('edit_delete_form', [
            'form' => $form,
            'columns' => $columns,
            'values' => $values,
            'forms' => $forms // Pass the forms to the view
        ]);



}
    public function showSecretaria()
    {
        $forms = DynamicForm::all(); // Fetch all forms from the database
        return view('secretaria', compact('forms')); // Pass the forms to the view
    
    }

    public function edit($formName, $columnId)
    {
        $form = DynamicForm::with(['columns', 'values'])
            ->where('form_name', $formName)
            ->firstOrFail();

        $column = $form->columns->where('id', $columnId)->firstOrFail();        
        $value = $form->values->where('dynamic_form_column_id', $columnId)->first();


        dd($form, $column, $value); // Esto mostrará los datos en la pantalla
        return view('edit_delete_form', compact('form', 'column', 'value'));
    }


    public function update(Request $request, $id)
    {
        $form = DynamicForm::find($id);

            if (!$form) {
                return response()->json(['success' => false, 'message' => 'Formulario no encontrado'], 404);
            }
        // Debugging: Log the incoming request data
        \Log::info('Updating Form:', $request->all());
        // Get the values first
        try {
            $validator = Validator::make($request->all(), [
                'form_name' => 'required|string',
                'column_name' => 'nullable|array',
                'column_name.*' => 'nullable|string',
                'value' => 'required|array',
                'value.*' => 'nullable|string',
                'puntajeMaximo' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

              
            $this->updateDynamicFormValues($id, $request->value);
            return response()->json([
            'success' => true,
            'message' => 'Form updated successfully',
            'changes'=> true
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating form: ' . $e->getMessage()
            ], 422);
        }
    }


    public function destroy($formId)
    {
        try {
            $form = DynamicForm::find($formId);

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Formulario no encontrado.'
                ], 404);
            }

            $form->delete();

           // Check if there are any remaining forms
        $remainingForms = DynamicForm::count();

        return response()->json([
            'success' => true,
            'message' => 'Formulario eliminado correctamente.',
            'remainingForms' => $remainingForms,
            'redirectUrl' => $remainingForms === 0 ? route('secretaria') : null
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el formulario: ' . $e->getMessage()
        ], 500);
    }
}
    

    public function getColumns($formId)
    {
        $columns = DynamicFormColumn::where('dynamic_form_id', $formId)->get();
        return response()->json(['columns' => $columns]);
    }

    public function getFormData($formName)
    {
        // Agregar logs para depuración
        \Log::info('Buscando formulario con nombre:', ['formName' => $formName]);

        $form = DynamicForm::where('form_name', $formName)->first();
        if ($form) {
            $columns = DynamicFormColumn::where('dynamic_form_id', $form->id)->get();
            $values = DynamicFormValue::where('dynamic_form_id', $form->id)->get();
           
            \Log::info('Datos del formulario:', [
                'form_name' => $formName,
                'columnas' => $columns->count(),
                'valores' => $values->count(),
                'puntaje_maximo' => $form->puntaje_maximo,
                'acreditacion' => $form->acreditacion ?? 'No encontrado',
            ]);
            
            return response()->json([
                'success' => true,
                'columns' => $columns,
                'values' => $values,
                'puntaje_maximo' => $form->puntaje_maximo,
                'acreditacion' => $form->acreditacion, // Asegúrate de incluir este campo

            ]);
        } else {
            \Log::info('Formulario no encontrado para:', ['formName' => $formName]);
            return response()->json(['success' => false, 'message' => 'Formulario no encontrado.']);
        }
    }

    

    public function getFormId($formName)
{   // Extract only numbers and dots from formName using regex
        $formId = preg_replace('/[^0-9.]/', '', $formName);

    if (!$formId) {
            return response()->json([
                'success' => false,
                'message' => 'Formulario no encontrado.'
            ]);
    }
    
    return $formId;
}

//transfer the update functionality, directly 
protected function checkAndUpdateForm($formName, $data = [], $action = 'update')
{

        // Add logging
        \Log::info("Checking and updating form: {$formName}, Action: {$action}");
   try {
        // Add your conditions here if needed
        if (isset($data['user_type']) && $data['user_type'] === '') {
                \Log::debug("Executing Artisan command for form update");

                $exitCode = Artisan::call('form:update', [
                'action' => $action,
                'formName' => $formName,
                '--data' => $action === 'update' ? [json_encode($data)] : []
            ]);
                if ($exitCode !== 0) {
                    throw new \Exception("Artisan command failed with exit code: {$exitCode}");
                }
            }
        } catch (\Exception $e) {
            \Log::error("Error in checkAndUpdateForm: " . $e->getMessage());
            throw $e;
        }
    }

    protected function updateDynamicFormValues($formId, $newValues)
    {
        // Obtener los registros existentes de dynamic_form_values para este formulario
        $existingValues = DynamicFormValue::where('dynamic_form_id', $formId)->get();
        $existingScore = DynamicForm::find($formId);
        
        // Recorrer los nuevos valores y actualizar los registros correspondientes
        foreach ($newValues as $index => $newValue) {
            if (isset($existingValues[$index])) {
                $existingValue = $existingValues[$index];
                $existingValue->value = $newValue;
                $existingValue->save();
            }
        }
        // Actualizar el puntaje máximo si el modelo existe
        if ($existingScore) {
            $existingScore->puntaje_maximo = request('puntajeMaximo'); // Obtener el nuevo puntaje del request
            $existingScore->save();
        }
        
    }

    /*
     public function getFormContent($selectedForm)
    {
        try {
            $form = DynamicForm::where('form_name', $selectedForm)->first();
            
            if (!$form) {
                return response()->json(['error' => 'Form not found'], 404);
            }

            // Get columns and values for this form
            $columns = DynamicFormColumn::where('dynamic_form_id', $form->id)->get();
            $values = DynamicFormValue::where('dynamic_form_id', $form->id)->get();

            // Build the HTML table
            $html = '<table class="table table-bordered">';
            
            // Add header row
            $html .= '<thead><tr>';
            foreach ($columns as $column) {
                $html .= '<th>' . htmlspecialchars($column->column_name) . '</th>';
            }
            $html .= '</tr></thead>';
            
            // Add data rows
            $html .= '<tbody>';
            $groupedValues = $values->groupBy('dynamic_form_column_id');
            
            foreach ($groupedValues->first() as $rowIndex => $value) {
                $html .= '<tr>';
                foreach ($columns as $column) {
                    $cellValue = $groupedValues[$column->id][$rowIndex]->value ?? '';
                    $html .= '<td>' . htmlspecialchars($cellValue) . '</td>';
                }
                $html .= '</tr>';
            $html .= '</tbody></table>';

            return response()->json([
                'formName' => $form->form_name,
                'puntajeMaximo' => $form->puntaje_maximo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }*/

    public function getFirstNonNumericValue($formId)
    {
        $value = DynamicFormValue::where('dynamic_form_id', $formId)
            ->whereRaw('value NOT REGEXP "^[0-9]+$"') // Excluir valores numéricos
            ->where('value', '!=', '') // Excluir valores vacíos
            ->orderBy('id', 'asc') // Ordenar por ID para obtener el primero
            ->value('value'); // Obtener solo el valor

        return response()->json([
            'success' => true,
            'value' => $value ?? 'No encontrado', // Retornar un valor predeterminado si no se encuentra
        ]);
    }

    public function loadFormView($formType)
    {
        // Esta función maneja los formularios estáticos
        return view($formType);
    }

    public function getDynamicFormForSecretaria($formName)
    {
        // Esta función es similar a getFormData pero con algunas modificaciones para secretaria
        $form = DynamicForm::where('form_name', $formName)->first();
        if ($form) {
            $columns = DynamicFormColumn::where('dynamic_form_id', $form->id)->get();
            $values = DynamicFormValue::where('dynamic_form_id', $form->id)->get();

            return response()->json([
                'success' => true,
                'columns' => $columns,
                'values' => $values,
                'puntaje_maximo' => $form->puntaje_maximo,
                'acreditacion' => $form->acreditacion,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Formulario no encontrado.']);
        }
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateFormData(Request $request, $formId)
    {
        try {
            $form = DynamicForm::findOrFail($formId);

            // Validar los datos enviados
            $validatedData = $request->validate([
                '*' => 'nullable|string|max:255', // Valida todos los campos como cadenas opcionales
            ]);

            // Actualizar los valores en la base de datos
            foreach ($validatedData as $columnName => $value) {
                $column = DynamicFormColumn::where('dynamic_form_id', $formId)
                    ->where('column_name', $columnName)
                    ->first();

                if ($column) {
                    $formValue = DynamicFormValue::where('dynamic_form_id', $formId)
                        ->where('dynamic_form_column_id', $column->id)
                        ->first();

                    if ($formValue) {
                        $formValue->value = $value;
                        $formValue->save();
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Formulario actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

public function updateCommissionData(Request $request, $formId)
{
    try {
        $form = DynamicForm::findOrFail($formId);

        // Validar los datos enviados
        $validatedData = $request->validate([
            'rows' => 'required|array', // Cada fila de datos
            'rows.*.row_identifier' => 'nullable|string',
            'rows.*.puntaje_input_values' => 'nullable|numeric',
            'rows.*.puntaje_comision' => 'nullable|numeric',
            'rows.*.observaciones' => 'nullable|string',
            'rows.*.dynamic_form_value_id' => 'nullable|integer', // Relación con dynamic_form_values
            'user_id' => 'required|integer', // Validar user_id
            'email' => 'required|email',    // Validar email
            'user_type' => 'nullable|string', // Validar user_type

            ]);

        foreach ($validatedData['rows'] as $row) {
            DynamicFormCommission::updateOrCreate(
                [
                    'dynamic_form_id' => $formId,
                    'row_identifier' => $row['row_identifier'] ?? null,
                ],
                [
                    'dynamic_form_column_id' => $row['dynamic_form_column_id'] ?? null,
                    'dynamic_form_value_id' => $row['dynamic_form_value_id'] ?? null,
                    'puntaje_input_values' => $row['puntaje_input_values'] ?? null,
                    'puntaje_comision' => $row['puntaje_comision'] ?? null,
                    'observaciones' => $row['observaciones'] ?? null,
                    'user_id' => $validatedData['user_id'],
                    'email_docente' => $validatedData['email'], // Aquí se asigna
                    'user_type' => $validatedData['user_type'] ?? null, // Asignar user_type si está presente
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Datos actualizados correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }

    }

    public function getDocentesOtrosForm()
    {
        $docentes = User::where('user_type', 'docente')->get(['id', 'email']);
        return response()->json($docentes);
    }
}
