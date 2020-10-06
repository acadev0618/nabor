<!DOCTYPE html>
<html lang="en">
 
<head>
    @include('common.meta')
    @include('common.css')
</head>

<body class="">

	{{-- @include('layouts.header') --}}
	
	<div class="wrapper">
        @include('layouts.slider')

		@yield('content')
	</div>

	@include('common.js')
	@yield('script')
</body>
</html>