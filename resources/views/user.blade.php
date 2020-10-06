@extends('layouts.app')

@section('content')
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">User Management</a>
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
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Customer Table</h4>
                  <p class="card-category"> Here are customers for providers</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="customertable">
                      <thead class=" text-primary">
                        <th>No</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        {{-- <th>Birthday</th> --}}
                        <th>Gender</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @if(count((array)$customers) == 0)
                        @else
                        @foreach($customers as $customer)
                        <tr>
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                          <td>{{$customer->display_name}}</td>
                          <td>{{$customer->email}}</td>
                          <td>{{$customer->phone}}</td>
                          <td>{{$customer->address}}</td>
                          {{-- <td>{{$customer->birthday}}</td> --}}
                          <td>
                              @if ($customer->gender == 0)
                                  Male
                              @else
                                  Female
                              @endif
                          </td>
                          <td  class="td-actions text-left">
                            <button type="button" rel="tooltip" class="btn btn-info" title="Preview" onclick="getPreView(false, {{$customer->id}})">
                              <i class="material-icons">person</i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-success" title="Edit" data-original-title="" title="" onclick="getEditView(false, {{$customer->id}})">
                              <i class="material-icons">edit</i>
                            <div class="ripple-container"></div></button>
                            <button type="button" rel="tooltip" class="btn btn-danger" onclick="deletCustomer({{$customer->id}})" title="Delete" data-toggle="modal">
                              <i class="material-icons">close</i>
                            </button>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                    @if(count((array)$customers) == 0)
                      <p style="align-content: center">There is no customers to display</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Provider Table</h4>
                  <p class="card-category"> Here are Service providers for our customers</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="providertable">
                      <thead class=" text-primary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Service</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        {{-- <th>Birthday</th> --}}
                        <th>Gender</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @if(count((array)$providers) == 0)
                        @else
                        @foreach($providers as $provider)
                        <tr>
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{$provider->first_name}} {{$provider->last_name}}</td>
                          <td>{{$provider->display_name}}</td>
                          <td>
                            @if(count((array)$services) != 0)
                            @foreach ($services as $service)
                              @if($service->user_id == $provider->id)
                              {{$service->title}}, 
                              @endif
                            @endforeach
                            @endif
                          </td>
                          <td>{{$provider->email}}</td>
                          <td>{{$provider->phone}}</td>
                          <td>{{$provider->address}}</td>
                          {{-- <td>{{$provider->birthday}}</td> --}}
                          <td>
                              @if ($provider->gender == 0)
                                  Male
                              @else
                                  Female
                              @endif
                          </td>
                          <td  class="td-actions text-left">
                            <button type="button" rel="tooltip" class="btn btn-info" title="Preview" onclick="getPreView(true, {{$provider->id}})">
                              <i class="material-icons">person</i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-success" title="Edit" onclick="getEditView(true, {{$provider->id}})">
                              <i class="material-icons">edit</i>
                            <div class="ripple-container"></div></button>
                            <button type="button" rel="tooltip" class="btn btn-danger" onclick="deletProvider({{$provider->id}})" title="Delete" data-toggle="modal">
                              <i class="material-icons">close</i>
                            </button>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                    @if(count((array)$providers) == 0)
                      <p style="align-content: center">There is no providers to display</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- Delete customer Modal --}}
    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <p class="description text-center">Are you sure you want to delete this Customer?</p>
            
          </div>
          <div class="modal-footer justify-content-center">
            <form class="form" method="post" action="{{ asset('/deleteCustomer') }}">
              @csrf
              <input type="text" class="cus_id" name="id" hidden />
              <button type="submit" class="btn btn-primary">Delete</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Delete Provider Modal --}}
    <div class="modal fade" id="deleteProviderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Provider</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <p class="description text-center">Are you sure you want to delete this Provider?</p>
            
          </div>
          <div class="modal-footer justify-content-center">
            <form class="form" method="post" action="{{ asset('/deleteProvider') }}">
              @csrf
              <input type="text" class="pro_id" name="id" hidden />
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
    function getEditView(is_provider, id) {
      // var url = '/editCustomerView/'+id
      if (is_provider) {
        location.href = "{{ asset('/editProviderView/') }}/"+id;
      } else {
        location.href = "{{ asset('/editCustomerView/') }}/"+id;
      }
    }

    function getPreView(is_provider, id) {
      // var url = '/editCustomerView/'+id
      if (is_provider) {
        location.href = "{{ asset('/providerPreView/') }}/"+id;
      } else {
        location.href = "{{ asset('/customerPreView/') }}/"+id;
      }
    }
  </script>

  <script>
    function deletCustomer(id) {
      var modal = $('#deleteCustomerModal');
      modal.find('.cus_id').val(id);
      modal.modal('show');
    }

    function deletProvider(id) {
      var modal = $('#deleteProviderModal');
      modal.find('.pro_id').val(id);
      modal.modal('show');
    }
  </script>
@endsection
