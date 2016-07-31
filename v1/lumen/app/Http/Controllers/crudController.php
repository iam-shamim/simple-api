<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class crudController extends Controller{
    public function getToken(){
        return \csrf_token();
    }
    public function add(Request $input){

    }
}