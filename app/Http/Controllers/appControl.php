<?php

namespace App\Http\Controllers;

use App\mdUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class appControl extends Controller
{
    function index(){
        return view('panel.index');
    }

    function login(){
        return view('panel.login');
    }   
    function loginSubmit(Request $r){
        
         $username = $r->get("login")['username'];
        $password = md5($r->get("login")['password']);
        
        $user = mdUser::where("username", $username)  
                        ->get();
        if(count($user) > 0){
            $ur = mdUser::where("username", $username)
                        ->where("password", $password)
                        ->get();


            if(count($ur) > 0){

                if($ur[0]->is_active == 'false'){
                    return array(
                        "title"     => "Info",
                        "type"      => "error",
                        "message"   => "User Anda Sedang di nonaktifkan",
                        "code"      => "500"
                    ); 
                }
                else{
                    Session::put("aclGroupId", $ur[0]->aclGroup_id);
                    Session::put("username", $ur[0]->username);
                    Session::put("opd_id", $ur[0]->opd_id);
                    Session::put("user_id", $ur[0]->user_id);
                    Session::put("perusahaan_id", $ur[0]->perusahaan_id);

                    return array(
                        "title"     => "Info",
                        "type"      => "success",
                        "message"   => "Password Benar",
                        "code"      => "200"
                    ); 

                    
                }

                
            }
            else{
                return array(
                    "title"     => "Info",
                    "type"      => "error",
                    "message"   => "password salah",
                    "code"      => "500"
                ); 
            }
        }
        else{

            return array(
                "title"     => "Info",
                "type"      => "error",
                "message"   => "Account Tidak di temukan",
                "code"      => "500"
            );
        }

    }

    function logout(){
        Session::flush();
        return redirect('login');
    }
}
