<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NoCaptcha;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // Procesar el formulario
        return response()->json(['message' => 'Formulario enviado con éxito!']);
    }
}
