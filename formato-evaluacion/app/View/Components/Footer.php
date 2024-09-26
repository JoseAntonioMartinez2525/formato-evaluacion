<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Footer extends Component
{
    public $convocatoria;

    public function __construct($convocatoria)
    {
        $this->convocatoria = $convocatoria;
    }

    public function render()
    {
        return view('components.footer');
    }
}
