<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Crypt;
use Auth;

class appRegistration extends Model{
    protected $table='app_registration';
    public function getAppSecretViewAttribute(){
        $password=Auth::user()->password;
        return Crypt::encrypt($this->attributes['appSecret'].$password);
    }

}
