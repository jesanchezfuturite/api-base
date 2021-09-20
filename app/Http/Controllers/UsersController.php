<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\UserprofilesRepositoryEloquent;
use App\Repositories\UserstoolsRepositoryEloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $users;
    protected $users_profiles;
    protected $users_tools;

    public function __construct(
        UsersRepositoryEloquent $users,
        UserprofilesRepositoryEloquent $users_profiles,
        UserstoolsRepositoryEloquent $users_tools
    )
    {
        
        $this->middleware('auth');

        $this->users = $users;

        $this->users_profiles = $users_profiles;
        
        $this->users_tools = $users_tools;

    }

    /**
     * 
     * getOne() Obtener un registro de un usuario
     * 
     * @param id
     * 
     * @return informacion de la perfil, error no existe
     * 
     */

    public function getOne($id)
    {
        try{
            
            $info = $this->users->find($id);  

            $results = array();
           
            
            $results []= array(
                "id"            => $info->id,
                "name"          => $info->name,
                "email"         => $info->email,
                "info"          => $info->info,
                "status_id"     => $info->status_id,
                "created_at"    => $info->created_at
            );
            

            return response()->json(
                    [
                        "code"      => 200,
                        "results"   => $results
                    ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                );

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 550,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }
    
    /**
     * 
     * getAll() Obtener todos los usuarios activos
     * 
     * @param ninguno
     * 
     * @return enlista todas los usuarios activos en el sistema
     * 
     */

    public function getAll()
    {
        try{
            $info = $this->users->findWhere(["status_id" => 1]);   

            if($info->count() == 0){
                return response()->json(
                    [
                        "code"      => 552,
                        "message"   => "No existen usuarios registrados"
                    ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                );    
            }else{
                $results = array();
                foreach ($info as $i) {
                    $results []= array(
                        "id"            => $i->id,
                        "name"          => $i->name,
                        "email"         => $i->email,
                        "info"          => $i->info,
                        "status_id"     => $i->status_id,
                        "created_at"    => $i->created_at
                    );
                }
                return response()->json(
                    [
                        "code"      => 200,
                        "results"   => $results
                    ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                );
            }

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 551,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * 
     * create() inserta un nuevo usuario en el sistema
     * 
     * @param descripcion
     * 
     * @return el array que se inserto
     * 
     */

    public function create(Request $request)
    {
        try{
            $info = $this->users->create([
                "name"          => $request->name,
                "email"         => $request->email,
                "info"          => $request->info,
                "password"      => Hash::make($request->password),
                "status_id"     => 1,
            ]);   

            return response()->json(
                [
                    "code"  => 200,
                    "id"    => $info->id,
                    "email" => $request->email,
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 553,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * 
     * delete() cambia el status de un usuario
     * 
     * @param descripcion
     * 
     * @return mensaje codigo 200
     * 
     */

    public function delete($id)
    {
        try{
            $info = $this->users->update([
                "status_id"     => 0
            ],$id);   

            return response()->json(
                [
                    "code"          => 200,
                    "message"       => "El registro ha sido eliminado",
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 554,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * 
     * update() actualiza los datos de usuario 
     * 
     * @param descripcion
     * 
     * @return mensaje codigo 200
     *
     * 
     */

    public function update(Request $request)
    {
        try{

            $modifications = array();

            if(isset($request->name))
            {
                $modifications["name"] = $request->name;
            }
            if(isset($request->email))
            {
                $modifications["email"] = $request->email;
            }
            if(isset($request->info))
            {
                $modifications["info"] = $request->info;
            }
            if(isset($request->password))
            {
                $modifications["password"] = Hash::make($request->password);
            }

            $info = $this->users->update( $modifications,$request->id);   

            return response()->json(
                [
                    "code"          => 200,
                    "message"       => "Se actualizo la información",
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 555,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * 
     * addProfile() asignar un perfil a un usuario 
     * 
     * @param user_id, profile_id
     * 
     * @return mensaje codigo 200
     *
     * 
     */

    public function addProfile(Request $request)
    {
        $profile = $request->profile;
        $user = $request->user;

        try
        {
            $this->users_profiles->updateOrCreate(
                [
                    'users_id'      => $user,
                ],
                [
                    'users_id'      => $user,
                    'profiles_id'   => $profile,
                ]
            );
            return response()->json(
                [
                    "code"      => 200,
                    "message"   => "El perfil se asigno correctamente"
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            ); 
        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 559,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );    
        }
    }

    /**
     * 
     * addTool() asignar un herramienta a un usuario 
     * 
     * @param user_id, profile_id
     * 
     * @return mensaje codigo 200
     *
     * 
     */

    public function addTool(Request $request)
    {
        $tool = $request->tool;
        $user = $request->user;

        try
        {
            $this->users_tools->updateOrCreate(
                [
                    'users_id'   => $user,
                    'tools_id'   => $tool,
                ],
                [
                    'users_id'   => $user,
                    'tools_id'   => $tool,
                ]
            );
            return response()->json(
                [
                    "code"      => 200,
                    "message"   => "La herramienta se asigno correctamente"
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            ); 
        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 559,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );    
        }
    }
}
