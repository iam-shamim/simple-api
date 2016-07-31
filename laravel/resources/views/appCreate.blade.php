@extends('layouts.app')
@section('title','Create New App')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New App</div>

                <div class="panel-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">{!! session()->get('success') !!}</div>
                    @endif
                    <form action="{!! route('app.create') !!}" method="post" id="appCreateForm">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <h1><small>Create New App</small></h1>
                                <div class="form-group">
                                    <label for="appName">App Name</label>
                                    <input type="text" class="form-control" placeholder="App Name" id="appName" name="appName">
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Create App" class="form-control btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $('#appCreateForm').submit(function () {
            if($.trim($('#appName').val())==''){
                return false;
            }
        });
    </script>
@endsection
