<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Service\S3Service;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    public function list(){
        $users = User::all();

        return view('welcome', compact('users'));
    }

    public function add(UserRequest $request){
        $data = $request->validated();
        $data['password'] = bcrypt('abc123');
        
        try{
            $user = new User;
            $user->fill($data);
            $user->save();
            return redirect()->route('list');
        }
        catch(Exception $e){
            dd($e);
        }
    }
}
