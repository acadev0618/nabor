@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
		<h3 class="page-title">
		    App Setting
		</h3>
		<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="from" method="post" action="{{ asset('/updateSetting') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <label class="label_des col-sm-2" for="title">App Splash Image:</label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" name="splash" accept="image/png, image/jpeg, image/jpg">
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <img src="{{$data[0]->splash_image}}"  width="80" height="80">
                            </div>
                        </div>
                        <div class="row" style="height: 50px;"></div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <label class="label_des col-sm-2" for="title">App Sidebar Image:</label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" name="sidebar" accept="image/png, image/jpeg, image/jpg">
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <img src="{{$data[0]->sidebar_image}}"  width="80" height="80">
                            </div>
                        </div>
            
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                <span id="" class='glyphicon glyphicon-check'></span> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection