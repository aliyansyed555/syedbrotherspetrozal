<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="../../">
		<title>Petrozal | Resource not found</title>
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon2.ico') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<!--begin::Illustration-->
				<img src="assets/media/illustrations/sketchy-1/18.png" alt="" class="mw-100 mb-10 h-lg-450px" />
				<!--end::Illustration-->
				<!--begin::Message-->
				{{-- <p>{{ $error }}</p> --}}
				@if (isset($error))
					<h1 class="fw-bold mb-10" style="color: #A3A3C7">{{$error}}</h1>
				@else
					<h1 class="fw-bold mb-10" style="color: #A3A3C7">Seems there is nothing here</h1>
				@endif
				<!--end::Message-->
				<!--begin::Link-->
				<a href="javascript:void(0);" class="btn btn-primary" onclick="window.history.back();">Go Back</a>
				<!--end::Link-->
			</div>
			<!--end::Authentication - 404 Page-->
		</div>
		<!--end::Main-->

        <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
	</body>
	<!--end::Body-->
</html>