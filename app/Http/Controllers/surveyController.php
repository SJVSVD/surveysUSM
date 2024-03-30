<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class surveyController extends Controller
{
    public function respuestaCorta(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://evaluacionservicios.usm.cl/api/encuesta/respuesta',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('totem' => $request->totem,'subunidad' => $request->subunidad,'respuesta' => $request->respuesta),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiQURNSU4iLCJleHAiOjE3MTE4MjE0OTV9.QF0qZ4zoOyQIGxTeave1okFVD1gAY9z85QI4kJLZJi4',
            'Cookie: SERVERIDevaluacionservicios=EVAL1'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return response()->json($response);
    }

    public function respuestaLarga(Request $request)
    {
        // Obtener los datos del cuerpo de la solicitud HTTP de Laravel
        $requestData = $request->all();

        // Codificar los datos en formato JSON
        $jsonData = json_encode($requestData);

        // URL de la API
        $url = 'https://evaluacionservicios.usm.cl/api/encuesta/larga/respuesta';

        // Configuración de la solicitud cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiQURNSU4iLCJleHAiOjE3MTE4MjE0OTV9.QF0qZ4zoOyQIGxTeave1okFVD1gAY9z85QI4kJLZJi4',
            'Cookie: SERVERIDevaluacionservicios=EVAL1'
        ));

        // Realizar la solicitud cURL
        $response = curl_exec($curl);

        // Manejar la respuesta
        if ($response === false) {
            // Error en la solicitud cURL
            $error = curl_error($curl);
            echo "Error en la solicitud cURL: " . $error;
        } else {
            // Decodificar la respuesta JSON
            $responseData = json_decode($response, true);
            
            // Manejar la respuesta
            if (isset($responseData['message'])) {
                echo "Respuesta exitosa: " . $responseData['message'];
            } elseif (isset($responseData['error'])) {
                echo "Error en la respuesta: " . $responseData['error'];
            } else {
                echo "Respuesta desconocida: " . $response;
            }
        }

        // Cerrar la conexión cURL
        curl_close($curl);
        
        return response()->json($response);
    }
}
