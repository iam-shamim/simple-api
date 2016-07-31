@extends('layouts.app')
@section('title','Create New App')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Products List</div>

                <div class="panel-body">
                    <form action="">
                        <div class="row m-b15">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Search Product......" name="searchText" value="{!! $searchText !!}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="perPage">
                                    <option value="15">Per Page</option>
                                    <option value="20" @if($perPage=='20') selected @endif>20</option>
                                    <option value="30" @if($perPage=='30') selected @endif>30</option>
                                    <option value="50" @if($perPage=='50') selected @endif>50</option>
                                    <option value="100" @if($perPage=='100') selected @endif>100</option>
                                    <option value="200" @if($perPage=='200') selected @endif>200</option>
                                    <option value="500" @if($perPage=='500') selected @endif>500</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive table-hover">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Product Name</td>
                                    <td>Price</td>
                                    <td>Current Store</td>
                                    <td>Add</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($responseData->data AS $key=>$value)
                                    <tr>
                                        <td>{!! ++$sl !!}</td>
                                        <td>{!! $value->productName !!}</td>
                                        <td>{!! $value->productPrice !!}</td>
                                        <td>{!! $value->currentStore !!}</td>
                                        <td>#</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="">
                            <a href="{!! $previous !!}" class="btn btn-primary pull-left @if(!$responseData->prev_page_url) disabled @endif"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a href="{!! $next !!}" class="btn btn-primary pull-right @if(!$responseData->next_page_url) disabled @endif"><i class="fa fa-arrow-circle-right"></i> Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
