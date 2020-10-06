@extends('layouts.app')

@section('content')
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Requests</a>
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
                  <h4 class="card-title ">Requests Table</h4>
                  <p class="card-category"> Here are all service requests of our customers</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class=" text-primary">
                        <th>No</th>
                        <th>Service</th>
                        <th>Customer</th>
                        <th>Provider</th>
                        <th>Contents</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @if(count((array)$data) == 0)
                        @else
                        @foreach($data as $service)
                        <tr>
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{$service->service_title}}</td>
                          <td>{{$service->customer_name}}</td>
                          <td>{{$service->provider_name}}</td>
                          <td>
                            @if (strlen($service->contents) > 40)
                                {{ substr($service->contents, 0, 40) }}...
                            @else
                                {{ $service->contents }}
                            @endif
                          </td>
                          <td>{{$service->created_date}}</td>
                          <td class="text-primary">
                            @if ($service->status == 0)
                              Waiting
                            @endif
                            @if ($service->status == 1)
                              On the way
                            @endif
                            @if ($service->status == 2)
                              Arrived
                            @endif
                            @if ($service->status == 3)
                              Rejected
                            @endif
                          </td>
                          <td  class="td-actions text-left">
                            <button type="button" rel="tooltip" class="btn btn-info previewRequestModal" title="Preview" data-title="{{ $service->service_title }}" data-customer="{{ $service->customer_name }}" data-provider="{{ $service->provider_name }}" data-contents="{{ $service->contents }}" data-createddate="{{ $service->created_date }}" data-status="{{ $service->status }}" data-rejectreason="{{ $service->reject_reason }}" data-rejecteddate="{{ $service->rejected_date }}" data-toggle="modal">
                              <i class="material-icons">person</i>
                            </button>
                            {{-- <button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="" onclick="getEditView()">
                              <i class="material-icons">edit</i>
                            <div class="ripple-container"></div></button> --}}
                            </button>
                            @if ($service->status == 3)
                              <button type="button" rel="tooltip" class="btn btn-danger" onclick="deletRequest({{$service->id}})" title="Delete" data-toggle="modal">
                                <i class="material-icons">close</i>
                              </button>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                    @if(count((array)$data) == 0)
                      <p style="align-content: center">There is no requests to display</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- Preview request Modal --}}
    <div class="modal fade" id="previewRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Preview the Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">            
            <form>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Customer</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_customer" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Provider</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_provider" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Service</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_service" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Contents</label>
                    <div class="form-group">
                      <textarea class="form-control" rows="4" id="pre_contents" disabled></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Created Date</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_createddate" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Status</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_status" disabled>
                  </div>
                </div>
              </div>
              <div class="row" style="display: none" id="rejecteddate">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Rejected Date</label>
                    <div class="row" style="height: 20px"></div>
                    <input type="text" class="form-control" id="pre_rejecteddate" disabled>
                  </div>
                </div>
              </div>
              <div class="row" style="display: none" id="rejectedreason">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Rejected Reason</label>
                    <div class="form-group">
                      <textarea class="form-control" rows="4" id="pre_rejectedreason" disabled></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </form>            
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
              </button>
          </div>
        </div>
      </div>
    </div>

    {{-- Delete Request rejected Modal --}}
    <div class="modal fade" id="deleteRejectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete the Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <p class="description text-center">Are you sure you want to delete this Request?</p>
            
          </div>
          <div class="modal-footer justify-content-center">
            <form class="form" method="post" action="{{ asset('/deleteRequest') }}">
              @csrf
              <input type="text" class="req_id" name="id" hidden />
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
    $('.previewRequestModal').click(function() {
      console.log($(this).data('status'));
      var modal = $('#previewRequestModal');
      $('#pre_service').val($(this).data('title'));
      $('#pre_customer').val($(this).data('customer'));
      $('#pre_provider').val($(this).data('provider'));
      $('#pre_contents').val($(this).data('contents'));
      $('#pre_createddate').val($(this).data('createddate'));
      if ($(this).data('status') == 0) {
        $('#pre_status').val('Waiting');
      }
      if ($(this).data('status') == 1) {
        $('#pre_status').val('On the way');
      }
      if ($(this).data('status') == 2) {
        $('#pre_status').val('Arrived');
      }
      if ($(this).data('status') == 3) {
        $('#pre_status').val('Rejected');
      }
      $('#pre_rejecteddate').val($(this).data('rejecteddate'));
      $('#pre_rejectedreason').val($(this).data('rejectreason'));
      if ($(this).data('status') == 3) {
        $('#rejecteddate').css('display', 'table');
        $('#rejectedreason').css('display', 'table');
      } else {
        $('#rejecteddate').css('display', 'none');
        $('#rejectedreason').css('display', 'none');
      }
      modal.modal('show');
    });

    function deletRequest(id) {
      var modal = $('#deleteRejectedModal');
      modal.find('.req_id').val(id);
      modal.modal('show');
    }
  </script>
@endsection
