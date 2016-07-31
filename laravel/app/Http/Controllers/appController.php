<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\model\appRegistration;
use Auth;
use Hash;
use Response;
use Session;
class appController extends Controller{
    public function index(){
        $appData=appRegistration::where('userID',Auth::user()->id)->get();
        return view('appHome',['appData'=>$appData]);
    }
    public function create(){
        return view('appCreate');
    }
    private function appIdGenerate($chars = 15){
        $letters = '57893895489258573859207';
        return substr(str_shuffle($letters), 0, $chars);
    }
    private function appIdAppSecret(){
        $appIdLength=random_int(15,20);
        $appID=$this->appIdGenerate($appIdLength);
        $appSecret=str_random(40);
        $data=appRegistration::where('appID',$appID)->where('appSecret',$appSecret)->count();
        if($data){
            return $this->appIdAppSecret();
        }
        $appData=[];
        $appData['appID']=$appID;
        $appData['appSecret']=$appSecret;
        return (object) $appData;

    }
    public function store(Request $input){
        if(empty(trim($input->appName))){
            return redirect()->back();
        }
        $appName=$input->appName;
        $appIdAppSecret=$this->appIdAppSecret();

        $appRegistration=new appRegistration();
        $appRegistration->userID=Auth::user()->id;
        $appRegistration->appName=$appName;
        $appRegistration->appID=$appIdAppSecret->appID;
        $appRegistration->appSecret=$appIdAppSecret->appSecret;
        $appRegistration->appStatus='Active';
        $appRegistration->save();

        Session::flash('success','App Create Successfully');
        return redirect()->back();
    }
    public function secret(Request $input){
        $password=$input->password;
        $appID=$input->appID;
        if(!Hash::check($password,Auth::user()->password)){
            return Response::json([
                'error'=>true,
                'message'=>'Password not matched.'
            ]);
        }else{
            $appData=appRegistration::where('userID',Auth::user()->id)->where('id',$appID)->first();
            if(!$appData){
                return Response::json([
                    'error'=>true,
                    'message'=>'API App not found.'
                ]);
            }
            return Response::json([
                'error'=>false,
                'data'=>$appData->appSecret
            ]);

        }
    }
    public function destroy($id){
        appRegistration::where('userID',Auth::user()->id)->where('id',$id)->delete();
        return redirect()->back();
    }
}
