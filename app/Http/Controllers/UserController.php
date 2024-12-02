<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uuid;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $search = $request->get('name');
        $pageSize = $request->get('pagesize');
        $currentPage = $request->get('page');
        $user_query = User::query();
        
        if($pageSize && $currentPage):
            $skip = $pageSize * ($currentPage-1);
        endif;

        if(empty($search)||$search == 'null'):
            $users = $user_query->skip($skip)->limit($pageSize)->get();
            $count =  User::count();
        else:
            $users = $user_query->skip($skip)->where('name', 'like', '%' . $search . '%')->limit($pageSize)->get();
            $count =  User::where('name', 'like', '%' . $search . '%')->count();
        endif;

        return response()->json([
            'users' => $users,
            'message' => 'LIST LOADED',
            'maxUsers'=>$count
        ], 200);
    }

    public function create(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $is_admin = $request->input('is_admin');
        $is_production = $request->input('is_production');
        $is_qc = $request->input('is_qc');
        $hash_password = bcrypt($password);
        $image = $request->file('image');
        $signature = $request->file('signature');
        
        // PHOTO
        $photo_name = time().'.'.$image->extension();
        $image->move('images', $photo_name);
        $photo_image_post = $photo_name;

        // SIGNATURES
        $signature_name = time().'.'.$signature->extension();
        $signature->move('signature', $signature_name);
        $signature_image_post = $signature_name;
        $id = Uuid::generate(4);

        $check_user = User::where('email',$email)->first();
        if(empty($check_user)):
            $user = User::create([
                'id'=>$id,
                'name'=>$name,
                'email'=>$email,
                'password'=>$hash_password,
                'is_admin'=>$is_admin,
                'is_production'=>$is_production,
                'is_qc'=>$is_qc,
                'image'=>$photo_image_post,
                'signature'=>$signature_image_post,
            ]);
            return  response()->json([
                'result'=>$user,
                // 'token'=>$token,
                // 'authorization' => 'Bearer '.$token,
                'message'=>'USER CREATED'
            ], 201);
        else:
            return  response()->json([
                'result'=>$user,
                // 'token'=>$token,
                // 'authorization' => 'Bearer '.$token,
                'message'=>'EMAIL ALREADY EXIST'
            ], 409);
        endif;
    }
}
