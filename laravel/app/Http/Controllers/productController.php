<?php

namespace App\Http\Controllers;

use App\model\appRegistration;
use Illuminate\Http\Request;

use App\Http\Requests;
use Curl;
use Auth;

class productController extends Controller
{
    public function index(){
        $appData=appRegistration::where('userID',Auth::user()->id)->get();
        return view('productHome',['appData'=>$appData]);
    }
    public function search(Request $input,$id){
        $appData=appRegistration::where('userID',Auth::user()->id)
            ->where('id',$id)
            ->firstOrFail();
        $appID=$appData->appID;
        $appSecret=$appData->appSecret;

        $response=Curl::to('http://api.shamim.rocks/v1/product/search')->withData([
            '_clientID'=>$appID,
            '_clientSecret'=>$appSecret,
            'searchText'=>$input->searchText,
            'page'=>$input->page,
            'perPage'=>$input->perPage
        ])->post();
        if($response){
            $responseData=json_decode($response);
            $currentPage=$responseData->current_page+1;
            $previousPage=$responseData->current_page-1;
            $next=$url=$input->url().'?searchText='.$input->searchText.'&perPage='.$input->perPage.'&page='.$currentPage;
            $previous=$url=$input->url().'?searchText='.$input->searchText.'&perPage='.$input->perPage.'&page='.$previousPage;
            $sl=($responseData->current_page-1)*$responseData->per_page;

            return view('productShow',['responseData'=>$responseData,'searchText'=>$input->searchText,'perPage'=>$input->perPage,'sl'=>$sl,'next'=>$next,'previous'=>$previous]);
        }
        return view('productShow',['responseData'=>$response,'searchText'=>$input->searchText,'perPage'=>$input->perPage,'sl'=>0]);
    }

    public function rand($length=5){
        $str='abcdefghijklmnopstruv';
        return substr(str_shuffle($str),0,$length);
    }
    public function wordList($length=2){
        $productName='';
        $sl=1;
        while($sl<=$length){
            $productName.=' '.$this->rand(random_int(3,10));
            $sl++;
        }
        return $productName;
    }
    public function productMultiCreate(){
        $sl=1000;
        $total=200;
        while($sl<=$total){
            $productName=ucwords(trim($this->wordList(random_int(2,4))));
            /*
            DB::table('products')->insert([
                'productName'=>$productName,
                'productPrice'=>random_int(50,5000),
                'currentStore'=>random_int(0,500),
                'created_at'=>date('Y-m-y H:i:s'),
                'updated_at'=>date('Y-m-y H:i:s')
            ]);
            */
            $sl++;
        }
    }
}
