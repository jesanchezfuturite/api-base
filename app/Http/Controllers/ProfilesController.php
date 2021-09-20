<?php

namespace App\Http\Controllers;

use App\Repositories\ProfilesRepositoryEloquent;
use App\Repositories\ProfilestoolsRepositoryEloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $profile;
    protected $profileTool;

    /**
     * 
     * construct() 
     * 
     * 
     * 
     */

    public function __construct(
        ProfilesRepositoryEloquent $profile,
        ProfilestoolsRepositoryEloquent $profileTool
    )
    {    
        $this->middleware('auth');

        $this->profile = $profile;

        $this->profileTool = $profileTool;
    }


    /**
     * 
     * getOne() Obtener un registro de una perfil
     * 
     * @param id
     * 
     * @return informacion de la perfil, error no existe
     * 
     */

    public function getOne($id)
    {
        try{
            
            $info = $this->profile->find($id);  

            $results = array();
           
            
            $results []= array(
                "id"            => $info->id,
                "description"   => $info->description,
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
     * getAll() Obtener todas las perfiles activas en el sistema
     * 
     * @param ninguno
     * 
     * @return enlista todas las perfiles registradas
     * 
     */

    public function getAll()
    {
        try{
            $info = $this->profile->findWhere(["status_id" => 1]);   

            if($info->count() == 0){
                return response()->json(
                    [
                        "code"      => 552,
                        "message"   => "No existen perfiles registradas"
                    ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                );    
            }else{
                $results = array();
                foreach ($info as $i) {
                    $results []= array(
                        "id"            => $i->id,
                        "description"   => $i->description,
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
     * create() inserta una nueva perfil en el sistema
     * 
     * @param descripcion
     * 
     * @return el array que se inserto
     * 
     */

    public function create(Request $request)
    {
        try{
            $info = $this->profile->create([
                "description"   => $request->description,
                "status_id"     => 1
            ]);   

            return response()->json(
                [
                    "code"          => 200,
                    "id"            => $info->id,
                    "description"   => $request->description,
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
     * delete() cambia el status de una perfil
     * 
     * @param descripcion
     * 
     * @return mensaje codigo 200
     * 
     */

    public function delete($id)
    {
        try{
            $info = $this->profile->update([
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
     * update() cambia el valor de la description en la tabla
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

            $info = $this->profile->update([
                "description"     => $request->description
            ],$request->id);   

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
     * addTools() agregar herramientas a un perfil la insercion de estos datos es en profiles tools
     *  se pueden recibir n perfiles y n herramientas e insertaremos todas las combinaciones de los dos 
     *  arreglos json
     * 
     * @param profilesid_array, toolsid_array
     * 
     * @return mensaje codigo 200
     *
     * 
     */

    public function addTools(Request $request)
    {
        try
        {
            $profiles       = $request->profiles;   
            $tools          = $request->tools;   
            $organization   = $request->organization;  

            Log::info("Profiles type " . gettype($profiles));
            if(is_array($profiles))
            {
                if(is_array($tools))
                {

                    foreach($profiles as $p)
                    {
                        foreach($tools as $t)
                        {
                            try
                            {
                                $this->profileTool->updateOrCreate(
                                    [
                                        'profiles_id'       => $p,
                                        'tools_id'          => $t,
                                        'organization_id'   => $organization,
                                    ],
                                    [
                                        'profiles_id'       => $p,
                                        'tools_id'          => $t,
                                        'organization_id'   => $organization,
                                    ]
                                );
                                return response()->json(
                                    [
                                        "code"      => 200,
                                        "message"   => "Herramientas se agregaron correctamente al perfil"
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

                }else{
                    return response()->json(
                        [
                            "code"      => 557,
                            "message"   => "El API espera recibir el parametro tools como arreglo"
                        ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                    );  
                }
            }else{
                return response()->json(
                    [
                        "code"      => 558,
                        "message"   => "El API espera recibir el parametro profiles como arreglo"
                    ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
                );
            }

        }catch(\Exception $e){
            return response()->json(
                [
                    "code"      => 556,
                    "message"   => $e->getmessage()
                ],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE
            );
        }
    }


}
