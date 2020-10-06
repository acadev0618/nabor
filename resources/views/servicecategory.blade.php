@extends('layouts.app')

@section('content')
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Service Category</a>
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
            <div class="col-md-12">
              <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#addServiceModal"><i class="fa fa-plus"></i> Add New Service</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Service Category Table</h4>
                  <p class="card-category"> Here are service categories for our customers</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class=" text-primary">
                        <th>No</th>
                        <th>Category</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @if(count((array)$data) == 0)
                        @else
                        @foreach($data as $service)
                        <tr>
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{$service->title}}</td>
                          <td  class="td-actions text-left">
                            <button type="button" rel="tooltip" class="btn btn-success" title="Edit" onclick="editService({{$service->id}}, '{{$service->title}}')" data-toggle="modal">
                              <i class="material-icons">edit</i>
                            <div class="ripple-container"></div></button>
                            <button type="button" rel="tooltip" class="btn btn-danger" title="Delete" onclick="deleteService({{$service->id}})" data-toggle="modal">
                              <i class="material-icons">close</i>
                            </button>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                    @if(count((array)$data) == 0)
                      <p style="align-content: center">There are no services to display</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Add New Service Modal --}}
      <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form class="form" method="post" action="{{ asset('/addServiceCategory') }}">
            @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Service Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p class="description text-center">Enter new service</p>
                <div class="card-body">

                    <div class="form-group bmd-form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">flare</i></div>
                          </div>
                          <input type="text" name="title" class="form-control" placeholder="Service Title..." required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-primary">Save Service</button>
            </div>
          </div>
        </form>
        </div>
      </div>

      {{-- Edit Service Modal --}}
      <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form class="form" method="post" action="{{ asset('/editServiceCategory') }}">
            @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Service Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p class="description text-center">Enter service title</p>
                <div class="card-body">

                    <div class="form-group bmd-form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text"><i class="material-icons">flare</i></div>
                          </div>
                          <input type="text" name="title" class="form-control edit_title" placeholder="Service Title..." required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
              <input type="text" class="edit_id" name="id" hidden />
              <button type="submit" class="btn btn-primary">Update Service</button>
            </div>
          </div>
        </form>
        </div>
      </div>

    {{-- Delete Service Modal --}}
    <div class="modal fade" id="deleteServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Service Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <p class="description text-center">Are you sure you want to delete this Service Category?</p>
            
          </div>
          <div class="modal-footer justify-content-center">
            <form class="form" method="post" action="{{ asset('/deleteServiceCategory') }}">
              @csrf
              <input type="text" class="del_id" name="id" hidden />
              <button type="submit" class="btn btn-primary">Delete</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
  <script>
    function editService(id, title) {
      var modal = $('#editServiceModal');
      modal.find('.edit_title').val(title);
      modal.find('.edit_id').val(id);
      modal.modal('show');
    }

    function deleteService(id) {
      var modal = $('#deleteServiceModal');
      modal.find('.del_id').val(id);
      modal.modal('show');
    }
  </script>
@endsection
