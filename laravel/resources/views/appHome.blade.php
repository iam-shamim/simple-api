@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">App</div>

                <div class="panel-body">
                    <div class="col-xs-12">
                        <a href="{!! route('app.create') !!}" class="btn btn-primary m-b15 pull-right"><i class="fa fa-plus-circle"></i> Create New App</a>
                    </div>
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>App Name</td>
                                    <td>App ID</td>
                                    <td>App Secret</td>
                                    <td width="5%">#</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appData AS $key=>$value)
                                    <tr>
                                        <td>{!! $value->appName !!}</td>
                                        <td>{!! $value->appID !!}</td>
                                        <td align="right" width="50%">
                                            <span class="appSecret {!! $value->id !!}">••••••••••••••••••••••••••••••••••••••</span>
                                            <p class="hidden">{!! $value->app_secret_view !!}</p>
                                            <button class="appSecretControl" app-id="{!! $value->id !!}" status="show" id="{!! $value->id !!}">Show</button>
                                        </td>
                                        <td>
                                            <a href="{!! route('app.destroy',$value->id) !!}" onclick="if(!confirm('Are you sure?')){return false;}" class="p-5"><i class="fa fa-trash-o fa-1-2x text-danger"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal Start -->
                <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <form id="passwordReSubmitForm" action="{!! route('app.secret') !!}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Please Re-enter Your Password</h4>
                                </div>
                                <div class="modal-body">
                                    <label for="password">For your security, you must re-enter your password to continue.</label>
                                    <input type="password" class="form-control" placeholder="Password" id="password" autofocus>
                                    <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                    <input type="hidden" value="null" class="app_id" id="appID">
                                    <p class="alert-danger errorMessage" style="margin-top:5px"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary passwordSubmit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal End -->
            </div>
        </div>
    </div>
</div>
    <style>
        .appSecret{margin:auto 7px;border:1px solid #9C9A9A;padding:3px 5px;border-radius:4px;}
        .appSecretControl{margin:auto 7px;border:1px solid #9C9A9A;padding:1px 5px;border-radius:4px;cursor: pointer}
    </style>
    <script>
        $(document).ready(function () {
            $('.appSecretControl').click(function(){
                var status=$(this).attr('status');
                var appID=$(this).attr('app-id');
                if(status=='show'){
                    if(!appID){
                        location.reload();
                        return false;
                    }
                    $('.app_id').val(appID);
                    $(function () {
                        $('#passwordModal').modal('toggle');
                    });
                }else{
                    $('.'+appID).html('••••••••••••••••••••••••••••••••••••••');
                    var status=$(this).attr('status','show');
                }

            });
            $('#passwordReSubmitForm').submit(function () {
                var password=$('#password').val();
                if(password==''){
                    return false;
                }
                var appID=$('#appID').val();
                var token=$('#token').val();
                var action_to=$('#passwordReSubmitForm').attr('action');
                $.ajax({
                    'url':action_to,
                    'type':'POST',
                    'data':{_token:token,password:password,appID:appID},
                    'beforeSend':function(){
                        $('.passwordSubmit').attr('disabled',true);
                    }
                }).done(function(received){
                    if(received.error){
                        $('.errorMessage').html(received.message);
                    }else{
                        $('.'+appID).html(received.data);
                        $('#'+appID).attr('status','hidden');
                        $(function () {
                            $('#passwordModal').modal('toggle');
                        });
                    }
                    $('.passwordSubmit').attr('disabled',false);
                    console.log(data);
                }).fail(function() {
                    $('.errorMessage').html('Please, try Again.');
                    $('.passwordSubmit').attr('disabled',false);
                });
                return false;

            });
        })
    </script>
@endsection
