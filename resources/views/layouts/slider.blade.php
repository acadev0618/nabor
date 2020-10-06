<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo"><a href="{{ asset('/dashboard') }}" class="simple-text logo-normal">
        Nabor Admin
      </a></div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        @if($sliderAction == "dashboard")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/dashboard') }}">
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
            </a>
        </li>

        @if($sliderAction == "user")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/userManagement') }}">
                <i class="material-icons">person</i>
                <p>User Management</p>
            </a>
        </li>

        {{-- @if($sliderAction == "performance")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/performance') }}">
                <i class="material-icons">content_paste</i>
                <p>Performance</p>
            </a>
        </li> --}}

        @if($sliderAction == "servicecategory")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/serviceCategory') }}">
                <i class="material-icons">library_books</i>
                <p>Service Category</p>
            </a>
        </li>

        @if($sliderAction == "requests")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/requests') }}">
                <i class="material-icons">bubble_chart</i>
                <p>Requests</p>
            </a>
        </li>

        @if($sliderAction == "services")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/services') }}">
                <i class="material-icons">bubble_chart</i>
                <p>Services</p>
            </a>
        </li>

        @if($sliderAction == "history")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/history') }}">
                <i class="material-icons">bubble_chart</i>
                <p>History</p>
            </a>
        </li>

        @if($sliderAction == "setting")
        <li class="nav-item active  ">
        @else
        <li class="nav-item ">
        @endif
            <a class="nav-link" href="{{ asset('/setting') }}">
                <i class="material-icons">language</i>
                <p>Setting</p>
            </a>
        </li>
      </ul>
    </div>
  </div>