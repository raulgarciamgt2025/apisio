<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;

class MetodosExternosController extends Controller
{
    private $token_externo = "Bearer 2y-10-zpfrTptK6qA4yhXIz7ueSPi9nRzD8y749oexLQpeUeAN8vFlkJ2";
    public function empresas(Request $request)
    {
        $token = $request->header('Authorization');
        $code_result = 200;
        $data = $request->all();
        try
        {
            if ( $token == $this->token_externo )
            {
                $data =  Empresa::all();    
                $respuesta = array("resultado"=>true,'mensaje'=>'Exito','errores'=>[],'data'=>$data);
            }
            else
            {
                $respuesta = array('resultado'=>false,'mensaje'=>'Credenciales incorrectas','errores'=>[],'data'=>[]);
            }

        }
        catch (\Exception $e)
        {
            $respuesta = array('resultado'=>false,'mensaje'=>$e->getMessage(),'errores'=>[],'data'=>[]);
        }
        return response()->json($respuesta, $code_result);
     }
}
