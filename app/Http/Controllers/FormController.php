<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\NoCaptcha;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
        $request->validate([
            // Otras validaciones
            'g-recaptcha-response' => 'required|captcha',
        ]);
    
        // Maneja la solicitud después de la validación
    }
}
