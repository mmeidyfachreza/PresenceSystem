<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Presensi Karyawan</title>

    <link rel="stylesheet" href="{{asset('css/main.css')}}">    
	<link rel="stylesheet" type="text/css" href="{{mix('css/hasil_combine.css')}}">
    
    
</head>
<body>
    
<div class="limiter">
		<div class="container-login100" style="background-image: url('{{ asset('images/bg-01.jpg') }}');">
			<div class="wrap-login100 p-t-30 p-b-50">
				
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="POST" action="{{ route('login') }}">
					@csrf
					
					
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
						<input class="input100" type="text" name="email" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password ">
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button type="submit" class="login100-form-btn">
							{{ __('Login') }}
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	<script type="text/javascript" src="{{asset('js/app.js')}}"></script></body>	
	<script type="text/javascript" src="{{mix('js/hasil_combine.js')}}"></script>

</body>
<!-- Footer -->
<footer class="page-footer font-small footer-bg">
       
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2019 Copyright:
          <a href="#">CV. Thortech Asia Software</a>
        </div>
        <!-- Copyright -->
      
      </footer>
      <!-- Footer -->
</html>
