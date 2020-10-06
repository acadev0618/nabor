@extends('layouts.app')

@section('content')
<style>
.checked {
  color: orange;
}
</style>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="{{ asset('/userManagement') }}" style="color: blueviolet">User Management</a>/
            <a class="navbar-brand" href="javascript:;">Customer Preview</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{-- <i class="material-icons">person</i> --}}
                  <img alt="" class="img-circle" src="{{ Session::get('avatar') }}" width="50px" height="50px" style="border-radius: 50%;"/>
                  <p class="d-lg-none d-md-block">
                    Admin
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="{{ asset('/logout') }}">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Preview</h4>
                  <p class="card-category">Preview your profile</p>
                </div>
                <div class="card-body">
                  <form>
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display Name</label>
                          <input type="text" name="display_name" class="form-control" value="{{$user[0]->display_name}}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fist Name</label>
                          <input type="text" name="first_name" class="form-control" value="{{$user[0]->first_name}}" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" name="last_name" class="form-control" value="{{$user[0]->last_name}}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Adress</label>
                          <input type="text" name="address" class="form-control" value="{{$user[0]->address}}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" name="email" class="form-control" value="{{$user[0]->email}}" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="text" name="phone" class="form-control" value="{{$user[0]->phone}}" disabled>
                        </div>
                      </div>
                      {{-- <div class="col-md-4">
                        <div class="form-group">
                          <label class="label-control">Birthday</label>
                          <input type="text" class="form-control datetimepicker" value="21/06/2018"/>
                        </div>
                      </div> --}}
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Gender</label>
                          <select class="form-control selectpicker" name="gender" data-style="btn btn-link" id="exampleFormControlSelect1" disabled>
                            <option value="0" @if ($user[0]->gender == 0)
                              selected
                              @endif>Male</option>
                            <option value="1" @if ($user[0]->gender == 1)
                              selected
                              @endif>Female</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>About Me</label>
                          <div class="form-group">
                            <textarea class="form-control" name="about_me" rows="5" disabled>{{$user[0]->about_me}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary pull-right">Update Profile</button> --}}
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="javascript:;">
                    @if ($user[0]->photo != null)
                    <img class="img" src="{{$user[0]->photo}}" />
                    @else
                    <img class="img" src="/assets/img/avatars/default_avatar.jpg" />
                    @endif
                  </a>
                </div>
                <div class="card-body">
                  <span class="fa fa-star @if ($user[0]->rate >= 1) checked @endif"></span>
                  <span class="fa fa-star @if ($user[0]->rate >= 2) checked @endif"></span>
                  <span class="fa fa-star @if ($user[0]->rate >= 3) checked @endif"></span>
                  <span class="fa fa-star @if ($user[0]->rate >= 4) checked @endif"></span>
                  <span class="fa fa-star @if ($user[0]->rate == 5) checked @endif"></span>
                  <span style="font-weight: bold; color: blue">{{$user[0]->rate}}</span>
                  <h6 class="card-category text-gray">Customer</h6>
                  <h4 class="card-title">{{$user[0]->first_name}} {{$user[0]->last_name}}</h4>
                  <p class="card-description">
                    {{$user[0]->about_me}}
                  </p>
                  {{-- <a href="javascript:;" class="btn btn-primary btn-round">Follow</a> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
