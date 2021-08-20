<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepositoryEloquent;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $users;

    public function __construct(
        UsersRepositoryEloquent $users
    )
    {
        
        $this->middleware('auth');

        $this->users = $users;
    }

    //
    public function showAllUsers(){
        try{

            return response()->json($this->users->all());   
        
        }catch(\Exception $e){
        
            return response()->json($e->getMessage());
        
        }
    }
}
