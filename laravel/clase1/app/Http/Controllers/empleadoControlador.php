<?php

namespace App\Http\Controllers;
use App\models\empleadomodelo;
use App\Http\controllers\controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use symfony\contracts\Service\Attribute\Required;

    class empleadoControlador extends Controller
    {
        public function index(){
            $empleado = empleadomodelo::all();
            if($empleado->isEmpty()){
                $data=[
                    'messsage'=>'No hay empleado Registrado',
                    'status'=>200
                ];
                return response()->json($data,404);
            }
            return response()->json($empleado,200);
        }

    public function store(Request $request){
        $validacion=Validator::make($request->all(),
        [
            'idEmpleado'=>'Required|numeric',
            'nombreEmpleado'=>'Required|min:2 |max:40',
            'correoEmpleado'=>'Required|email',
            'passwordEmpleado'=>'Required|min:2| max:40'
        ]);
        if($validacion->fails()){
            $data=[
                'messsage'=>'Error en la validacion de datos',
                'error'=>$validacion->errors(),
                'status'=>200
            ];
            return response()->json($data,400);
        }

        $empleado = empleadoModelo::create(
            [
                'idEmpleado'=>$request->idEmpleado,
                'nombreEmpleado'=>$request->nombreEmpleado,
                'correoEmpleado'=>$request->correoEmpleado,
                'passwordEmpleado'=>$request->passwordEmpleado
            ]
            );
            
            if(!$empleado){
                $data=[
                    'message'=>'Error al Registar el Empleado',
                    'status'=>500
                ];
                return response()->json($data,500);

            }
            $data=[
                'empleado'=>$empleado,
                'status'=>201
            ];
            return response()->json($data,201);
        }

        public function show($idEmpleado){
            $empleado = empleadoModelo::find($idEmpleado);
            if(!$empleado){
                $data=[
                    'messsage'=>'Empleado No Existe',
                    'status'=>404
                ];
                return response()->json($data,404);
            }
            $data=[
                'empleado'=>$empleado,
                'status'=>200
            ];
            return response()->json($data,200);
        }

        // Modificar
public function update(Request $request, $idEmpleado)
{
    $empleado = EmpleadoModelo::find($idEmpleado);
    if (!$empleado) {
        return response()->json([
            'message' => 'Empleado no encontrado',
            'status' => 404
        ], 404);
    }

    $validacion = Validator::make($request->all(), [
        'idEmpleado' => 'required|numeric',
        'nombreEmpleado' => 'required|min:2|max:40',
        'correoEmpleado' => 'required|email',
        'passwordEmpleado' => 'required|min:2|max:40'
    ]);

    if ($validacion->fails()) {
        return response()->json([
            'message' => 'Error al Registrar el Empleado',
            'errors' => $validacion->errors(),
            'status' => 400
        ], 400);
    }

    $empleado->idEmpleado = $request->idEmpleado;
    $empleado->nombreEmpleado = $request->nombreEmpleado;
    $empleado->correoEmpleado = $request->correoEmpleado;
    $empleado->passwordEmpleado = $request->passwordEmpleado;
    $empleado->save();

    return response()->json([
        'message' => 'Empleado modificado',
        'empleado' => $empleado,
        'status' => 200
    ], 200);
}

// Eliminar
public function destroy($idEmpleado)
{
    $empleado = EmpleadoModelo::find($idEmpleado);
    if (!$empleado) {
        return response()->json([
            'message' => 'Empleado no encontrado',
            'status' => 404
        ], 404);
    }

    $empleado->delete();

    return response()->json([
        'message' => 'Empleado Eliminado',
        'status' => 200
    ], 200);
}

}

    


