<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferDynamicFormData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-dynamic-form-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer data from dynamic_form_columns and dynamic_form_values to dynamic_form_combined';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all dynamic form columns and values
        $columns = DB::table('dynamic_form_columns')->get();
        $values = DB::table('dynamic_form_values')->get();

        // Fetch form names based on dynamic_form_id
        $formName = DB::table('dynamic_forms')->pluck('form_name', 'id');
        $formTypeMatch = preg_match('/^([\d.]+(_[\d.]+)*)?(?=\s|$)/', $formName, $matches);
        $formType = $formTypeMatch ? 'form' . $matches[0] : 'form';        

        foreach ($columns as $column) {
            foreach ($values as $value) {
                // Insert into dynamic_form_combined
                DB::table('dynamic_form_combined')->insert([
                    'dynamic_form_id' => $value->dynamic_form_id,
                    'dynamic_form_column_id' => $column->id,
                    'dynamic_form_value_id' => $value->id,
                    'form_name' => $formName, // Exclude form_name as it's not in dynamic_form_values
                    'puntaje_maximo' => $value->puntaje_maximo,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'form_type' => $formType,
                ]);
            }
        }

        $this->info('Data transferred successfully!');
    }
}
