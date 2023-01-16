<?php

namespace App\Repository\User;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface {

    public function all(){
        $req = User::all();
        $data = array();

        foreach ($req as $key => $value) {
            $value->category;
            $user = json_decode($value, true);
            $info = [
                "id"        => $user["id"],
                "nombre"    => $user["name"],
                "apellido"  => $user["last_name"],
                "cedula"    => $user["identification"],
                "correo"    => $user["email"],
                "pais"      => $user["country"],
                "direccion" => $user["address"],
                "telefono"  => $user["phone"]
            ];
            if(array_key_exists("category", $user) && $user["category"] != null){
                $info["categoria"] = $user["category"]["name"];
            }
            array_push($data, $info);
        }
        return $data;
    }

    public function store($data){
        $info = [
            'name'             => $data["nombre"],
            'last_name'        => $data["apellido"],
            'identification'   => $data["cedula"],
            'email'            => $data["correo"],
            'country'          => $data["pais"],
            'address'          => $data["direccion"],
            'phone'            => $data["telefono"],
            'category_id'      => $data["categoria"],
        ];
        $req = User::create($info);
        if($req){
            return 1;
        }
        return 0;
    }

    public function update($id, $data)
    {

        $info = [
            'name'             => key_exists("nombre",$data) ? $data["nombre"] : null,
            'last_name'        => key_exists("apellido",$data) ? $data["apellido"] : null,
            'identification'   => key_exists("cedula",$data) ? $data["cedula"] : null,
            'email'            => key_exists("correo",$data) ? $data["correo"] : null,
            'country'          => key_exists("pais",$data) ? $data["pais"] : null,
            'address'          => key_exists("direccion",$data) ? $data["direccion"] : null,
            'phone'            => key_exists("telefono",$data) ? $data["telefono"] : null,
            'category_id'      => key_exists("categoria",$data) ? $data["categoria"] : null
        ];
        $info = array_diff($info, array("",0,null));
        $req = User::find($id)->update($info);
        return $req;
    }

    public function delete($id)
    {
        $req = User::find($id)->delete();
        return $req;
    }

    public function get($id)
    {
        $req = User::find($id);
        $req->category;
        $user = json_decode($req, true);
        $data = [
            "id"        => $user["id"],
            "nombre"    => $user["name"],
            "apellido"  => $user["last_name"],
            "cedula"    => $user["identification"],
            "correo"    => $user["email"],
            "pais"      => $user["country"],
            "direccion" => $user["address"],
            "telefono"  => $user["phone"],
        ];
        if(array_key_exists("category", $user)){
            $data["categoria"] = $req["category"]["name"];
        }
        return $data;
    }

    public function getReport(){
        $req = User::groupBy('country')->select('country', DB::raw('count(*) as cant'))->get();
        $inf =json_decode($req, true);
        $data = "";
        foreach ($inf as $key => $value) {
            $data .= $value["country"]."  ". $value["cant"]."\n" ;
        }
        return $data;
    }
}
