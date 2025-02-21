<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\DynamicForm;
use App\Models\DynamicFormColumn;
use App\Models\DynamicFormValue;
use Illuminate\Http\Request;
use App\Models\DynamicFormItem;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF; 
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
                'column_names' => 'required|array', // Validate column names
            ]);

            // Procesar los datos (puedes guardar en la base de datos aquí)
            $formId = \DB::table('dynamic_forms')->insertGetId([
                'user_id' => $validatedData['user_id'],
                'email' => $validatedData['email'],
                'user_type' => $validatedData['user_type'] ?? null,
                'form_name' => $validatedData['form_name'],
                'puntaje_maximo' => $validatedData['puntaje_maximo'],
                'table_data' => json_encode($validatedData['table_data']),
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
        $form = DynamicForm::where('form_name', $formName)->first();
        if ($form) {
            return response()->json([
                'success' => true,
                'form' => $form,
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

    public function showDynamicForm()
    {
        
        $form = \DB::table('dynamic_forms')->first();
        if (!$form) {
            return redirect()->route('edit_delete_form')->with('error', 'Formulario no encontrado.');
        }
        // Obtener las columnas y valores para este formulario
        $columns = \DB::table('dynamic_form_columns')->where('dynamic_form_id', $form->id)->get();
        $values = \DB::table('dynamic_form_items')->where('dynamic_form_id', $form->id)->get();

        // Fetch all forms from the database
        $forms = DynamicForm::all();
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

            // Call the helper method for automatic execution
            //$this->checkAndUpdateForm($request->form_name, $request->all(), 'update');

            /*
                        // Begin transaction
                        \DB::beginTransaction();
                        // Check if values have changed
                    $hasChanges = $form->form_name !== $request->form_name ||
                                 $form->puntajeMaximo !== $request->puntajeMaximo ||
                                 json_encode($form->columns) !== json_encode($request->column_name) ||
                                 json_encode($form->values) !== json_encode($request->value);
                        
                    if ($hasChanges) {
                        $data = [
                            'form_name' => $request->form_name,
                            'puntajeMaximo' => $request->puntajeMaximo,
                            'columns' => $request->column_name,
                            'values' => $request->value
                        ];

                            $form->update([
                            'form_name' => $request->form_name,
                            'puntajeMaximo' => $request->puntajeMaximo,
                            'columns' => $request->column_name,
                            'values' => $request->value
                        ]);

                        // Execute the command with the same data
                        $exitCode = \Artisan::call('form:update', [
                            'action' => 'update',
                            'formName' => $request->form_name,
                            '--data' => [json_encode($data)]
                        ]);

                        // Check if the command executed successfully
                        if ($exitCode !== 0) {
                            \DB::rollBack();
                            throw new \Exception('Command execution failed');
                        }

                        \DB::commit();


              
                        return response()->json([
                            'success' => true,
                            'message' => 'Form updated successfully',
                            'changes'=> true
                        ]);
                        
                        } else {
                            return response()->json([
                                'success' => true,
                                'message' => 'No changes detected',
                                'changes'=> false
                            ]);
                        }*/
            //$form->save();     
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
    

    public function destroy($formName)
    {
        try {
            $this->checkAndUpdateForm($formName, [], 'delete');
            /*
            \Artisan::call('form:update', [
                'action' => 'delete',
                'formName' => $formName
            ]);*/

            return response()->json([
                'success' => true,
                'message' => 'Form deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting form: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getColumns($formId)
    {
        $columns = DynamicFormColumn::where('dynamic_form_id', $formId)->get();
        return response()->json(['columns' => $columns]);
    }

    public function getFormData($formName)
    {
        $form = DynamicForm::where('form_name', $formName)->first();
        if ($form) {
            $columns = DynamicFormColumn::where('id', $form->id)->get();
            $values = DynamicFormValue::where('dynamic_form_id', $form->id)->get();

            return response()->json([
                'success' => true,
                'columns' => $columns,
                'values' => $values,
                'puntaje_maximo' => $form->puntaje_maximo,
            ]);
        } else {
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
}


    

