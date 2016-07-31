<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Illuminate\Http\Response;


class productController extends Controller{
    public function store(Request $input){
        $this->validate($input,[
            'productName'=>'required|max:40',
            'productPrice'=>'required|integer',
            'currentStore'=>'required|integer'
        ]);
        DB::table('products')->insert([
            'productName'=>$input->productName,
            'productPrice'=>$input->productPrice,
            'currentStore'=>$input->currentStore,
            'created_at'=>date('Y-m-y H:i:s'),
            'updated_at'=>date('Y-m-y H:i:s')
        ]);
    }
    public function search(Request $input){
        $searchText=($input->has('searchText'))?$input->searchText:null;
        $page=($input->has('page'))?$input->page:1;
        $perPage=($input->has('perPage'))?$input->perPage:15;
        $sl=$page*$perPage;
        $data=DB::table('products')->whereRaw("`productName` LIKE '%$searchText%'")->paginate($perPage);
        return (new Response($data,200))
            ->header('Content-Type', 'application/json');
    }
    public function edit($id){
        $data=(array) DB::table('products')->where('id',$id)->first();
        if($data){
            return (new Response($data,200))
                ->header('Content-Type', 'application/json');
        }else{
            return (new Response([
                'error'=>true,
                'message'=>'Data not found'
            ],404))
                ->header('Content-Type', 'application/json');
        }
    }
    public function delete($id){
        DB::table('products')->where('id',$id)->delete();
    }
    public function update(Request $input,$id){
        $this->validate($input,[
            'productName'=>'required|max:40',
            'productPrice'=>'required|integer',
            'currentStore'=>'required|integer'
        ]);
        DB::table('products')->where('id',$id)->update([
            'productName'=>$input->productName,
            'productPrice'=>$input->productPrice,
            'currentStore'=>$input->currentStore
        ]);
    }
}