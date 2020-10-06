@extends('layouts.app')

@section('content')
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
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
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">New Requests</p>
                  <h3 class="card-title">{{$new_requests}}
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">autorenew</i>
                    <a href="javascript:;">Today New Requests</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Active Services</p>
                  <h3 class="card-title">{{$active_services}}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Now Processing Services
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Declined Services</p>
                  <h3 class="card-title">{{$decliened_service}}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Today Declined Services
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-times"></i>
                  </div>
                  <p class="card-category">Rejected Requests</p>
                  <h3 class="card-title">{{$rejected_services}}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Today Rejected Requests
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <button style="display: none" id="completed_services_chat" data-Jan="{{ $completed_services['Jan'] }}" data-Feb="{{ $completed_services['Feb'] }}" data-Mar="{{ $completed_services['Mar'] }}" data-Apr="{{ $completed_services['Apr'] }}" data-May="{{ $completed_services['May'] }}" data-Jun="{{ $completed_services['Jun'] }}" data-Jul="{{ $completed_services['Jul'] }}" data-Aug="{{ $completed_services['Aug'] }}" data-Sep="{{ $completed_services['Sep'] }}" data-Oct="{{ $completed_services['Oct'] }}" data-Nov="{{ $completed_services['Nov'] }}" data-Dec="{{ $completed_services['Dec'] }}" data-maxcompleted="{{ $max_completed }}">completed services</button>
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Completed Services</h4>
                  <p class="card-category">This Year Performance</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-warning">
                  <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Earned Performance</h4>
                  <p class="card-category">This Year Performance</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <button style="display: none" id="decliened_services_chat" data-Jan="{{ $decliened_services['Jan'] }}" data-Feb="{{ $decliened_services['Feb'] }}" data-Mar="{{ $decliened_services['Mar'] }}" data-Apr="{{ $decliened_services['Apr'] }}" data-May="{{ $decliened_services['May'] }}" data-Jun="{{ $decliened_services['Jun'] }}" data-Jul="{{ $decliened_services['Jul'] }}" data-Aug="{{ $decliened_services['Aug'] }}" data-Sep="{{ $decliened_services['Sep'] }}" data-Oct="{{ $decliened_services['Oct'] }}" data-Nov="{{ $decliened_services['Nov'] }}" data-Dec="{{ $decliened_services['Dec'] }}" data-maxdecliened="{{ $max_decliened }}">decliened services</button>
              <div class="card card-chart">
                <div class="card-header card-header-danger">
                  <div class="ct-chart" id="completedTasksChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Declined Services</h4>
                  <p class="card-category">This Year Performance</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title">Employees Stats</h4>
                      <p class="card-category">New employees on today</p>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover">
                        <thead class="text-warning">
                          <th>No</th>
                          <th>Name</th>
                          <th>Address</th>
                        </thead>
                        <tbody>
                          @if(count((array)$new_customers) == 0)
                          @else
                          @foreach($new_customers as $new_customer)
                          <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{$new_customer->display_name}}</td>
                            <td>{{$new_customer->address}}</td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                      @if(count((array)$new_customers) == 0)
                        <p style="align-content: center">There is no new customers to display</p>
                      @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Provider Stats</h4>
                  <p class="card-category">New providers on today</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>No</th>
                      <th>Name</th>
                      <th>Address</th>
                    </thead>
                    <tbody>
                      @if(count((array)$new_providers) == 0)
                      @else
                      @foreach($new_providers as $new_provider)
                      <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td>{{$new_provider->display_name}}</td>
                      <td>{{$new_provider->address}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                  @if(count((array)$new_providers) == 0)
                    <p style="align-content: center">There is no new providers to display</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
