<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rolusuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {

        try
        {
            $credentials = $request->only('email', 'password');
            $id_empresa = $request->id_empresa;    
            $email = $request->email;

            if (!$tokenData = JWTAuth::attempt($credentials))
            {
                return response()->json(['resultado' => false,'mensaje'=>'Credenciales incorrectas','errores'=>[],'token'=>'','accesos'=>''], 200);
            }

            $itemsAccesos  = DB::table('users as aa')
                            ->join('rol_usuario as a', 'aa.id', '=', 'a.id_usuario')
                            ->join('rol_opcion as b', 'a.id_rol', '=', 'b.id_rol')
                            ->join('opcion as c', 'b.id_opcion', '=', 'c.id_opcion')
                            ->join('menu as d', 'c.id_menu', '=', 'd.id_menu')
                            ->join('modulo as e', 'd.id_modulo', '=', 'e.id_modulo')
                            ->where('a.id_empresa', $id_empresa)
                            ->where('aa.email', $email)
                            ->orderBy('e.orden')
                            ->orderBy('d.orden')
                            ->orderBy('c.orden')
                            ->get([
                                'e.id_modulo',
                                'e.descripcion as modulo',
                                'd.id_menu',
                                'd.descripcion as menu',
                                'd.icono',
                                'b.id_opcion',
                                'c.descripcion as opcion',
                                'c.ruta',
                            ]);
                            
            $json = "[";
            $lstModulo = 0;
            $lstMenu = 0;                        
            foreach ($itemsAccesos as $item) {
                if ($item->id_modulo != $lstModulo) {
                    if ($lstMenu != 0) {
                        $json .= "]}, ";
                    }

                    $json .= "{ ";
                    $json .= "key: '" . $item->id_modulo . "', ";
                    $json .= "label: '" . $item->modulo . "', ";
                    $json .= "isTitle: true, ";
                    $json .= "}, ";
                }

                if ($item->id_menu != $lstMenu) {
                    if ($lstMenu != 0 && $item->id_modulo == $lstModulo) {
                        $json .= "]}, ";
                    }

                    $json .= "{ ";
                    $json .= "key: '" . $item->id_menu . "', ";
                    $json .= "label: '" . $item->menu . "', ";
                    $json .= "icon: '" . $item->icono . "', ";
                    $json .= "children: [ ";
                }

                $json .= "{ ";
                $json .= "key: '" . $item->id_opcion . "', ";
                $json .= "label: '" . $item->opcion . "', ";
                $json .= "url: '" . $item->ruta . "', ";
                $json .= "parentKey: '" . $item->id_menu . "', ";
                $json .= "}, ";

                $lstModulo = $item->id_modulo;
                $lstMenu = $item->id_menu;
            }

            if ($lstMenu != 0) {
                $json .= "]}, ";
            }

            $json .= "]";                

            return response()->json(['resultado' => true,'mensaje'=>'Exito','errores'=>[],'token'=>$tokenData,'accesos'=>$json], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['resultado' => false,'mensaje'=>$e->getMessage(),'errores'=>[],'token'=>'','accesos'=>''], 200);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}