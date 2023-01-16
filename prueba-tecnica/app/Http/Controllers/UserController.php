<?php

namespace App\Http\Controllers;

use App\Repository\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;
use PharIo\Manifest\Email;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function all(){
        return $this->userRepository->all();
    }

    public function store(Request $request) {
        try {
            $countries = $this->countries();

            $validator = Validator::make($request->all(), [
                "nombre"    => 'required|regex:/^[a-zA-Z\s]*$/|max:100|min:5',
                "apellido"  => 'required|regex:/^[a-zA-Z\s]*$/|max:100',
                "cedula"    => 'required|numeric|unique:users,identification',
                "correo"    => 'required|email:rfc,dns|unique:users,email|max:150',
                "pais"      => 'required|in:'.implode(",",$countries),
                "direccion" => 'required|max:180',
                "telefono"  => 'required|regex:/^[0-9]+$/|max:10',
                "categoria" => 'required|in:1,2,3'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages(), "status" => 400]);
            }
            $res = $this->userRepository->store($request->all());

            if($res == 1){
                $users = $this->userRepository->getReport();
                $data = [
                    'email'       => $request->correo,
                    'name'        => $request->nombre,
                    'description' => "Ha sido registrado con exito!",
                    'subject'     => "Registro de usuario"
                ];
                $this->sendMail($data);

                $data['description'] = $users;
                $data['email'] = env('MAIL_FROM_ADDRESS', 'example@hotmail.com');
                var_dump($data['email']);
                $this->sendMail($data);

                return response()->json(['message' => 'Usuario creado con exito', "status"=>201]);
            }

            return response()->json(["message" => 'error al crear el usuario', 'status' => 400]);

        } catch (Exception $e) {

            return response()->json([$e->getMessage()], 400);

        }
    }

    public function update($id, Request $request){
        try {
            $countries = $this->countries();
            $validator = Validator::make($request->all(), [
                "nombre"    => 'regex:/^[a-zA-Z\s]*$/|max:100|min:5',
                "apellido"  => 'regex:/^[a-zA-Z\s]*$/|max:100',
                "cedula"    => 'numeric',
                "correo"    => 'email:rfc,dns|max:150',
                "pais"      => 'in:'.implode(",",$countries),
                "direccion" => 'max:180',
                "telefono"  => 'regex:/^[0-9]+$/|max:10',
                "categoria" => 'in:1,2,3'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }
            $res = $this->userRepository->update($id, $request->all());

            if($res == 1){
                return response()->json(['message' => 'Usuario actualizado con exito','status' => 201]);
            }

            return response()->json(["message" => 'error al actualizar el usuario', 'status' => 400]);

        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }


    public function delete($id){
        $res = $this->userRepository->delete($id);
        if($res == 1){
            return response()->json(['message' => 'Usuario eliminado con exito'], 201);
        }

        return response()->json(["message" => 'error al eliminar el usuario'], 400);
    }

    public function get($id){
        return $this->userRepository->get($id);
    }

    public function getCountries(){
        $countries = $this->countries();
        return $countries;
    }

    private function countries(){
        $request =  Http::get('https://restcountries.com/v3.1/region/americas');
        $response = array();
        if($request->status() == 200){
            $data = $request->object();
            foreach ($data as $key => $value) {
                array_push($response, $value->name->common);
            }
        }
        return $response;
    }

    private function sendMail($data){
        $cadena_de_texto = $data['email'];
        $cadena_buscada   = '@hotmail';
        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
        //se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
        if ($posicion_coincidencia === false) {
            Mail::send('mails.body', ['data' => $data], function ($message) use ($data){
                $message->from('admin@prueba.com', 'admin');
                $message->to($data['email'], $data['name']);
                $message->subject($data['subject']);
                //$message->bcc($data['email'], $data['name']);
            });
        }else{
            Mail::send('mails.body', ['data' => $data], function ($message) use ($data){
                $message->from('admin@prueba.com', 'admin');
                $message->to($data['email'], $data['name']);
                $message->subject($data['subject']);
                $message->bcc($data['email'], $data['name']);
            });
        }
    }
}
