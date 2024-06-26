<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="">
		<meta name="Author" content="">
		<meta name="Keywords" content=""/>

		<meta name="csrf-token" content="{{ csrf_token() }}" />

		<title> KINCHITKARAM </title>

		<link rel="icon" href="{{ asset('theme/assets/img/brand/logo.png') }}" type="image/x-icon"/>
		<link href="{{ asset('theme/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style"/>
		<link href="{{ asset('theme/assets/css/icons.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/plugins.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/animate.css') }}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

	</head>
	<body class="main-body app sidebar-mini ltr  login-img" oncontextmenu="return false;">


			<div id="global-loader">
				<img src="{{ asset('theme/assets/img/loaders/loader-4.svg') }}" class="loader-img" alt="Loader">
			</div>



	<div class="page">


		<div class="my-auto page">
			<div class="main-signin-wrapper">
				<div class="main-card-signin forgot-password d-md-flex wd-100p">
					<div class="wd-md-50p  page-signin-style p-md-5 p-4 text-white d-none d-md-block ">
						<div class="my-auto authentication-pages">
						<div>
							<img src="{{ asset('theme/assets/img/brand/logo.png') }}" class=" m-0 mb-4" alt="logo">
							<p class="mb-5">Kinchitkaram Trust was formed ten years ago to serve the needy and enhance the spiritual awareness of devotees. The holy scriptures say “akinchitkarasya seshatva anupapatti:” (He who does not serve his little mite, is not a devotee). Drawing the message of this saying, your trust is engaged in little services and rightly named as “Kinchitkaram” or “My little mite". </p>

							<p class="mb-5">

                             &copy; {{date('Y')}} Kinchitkaram</p>

						</div>
					</div>
					</div>
					<div class="p-5 wd-md-50p">
						<div class="main-signin-header">
							<h2>Forgot Password!</h2>
							<h4>Please Enter Your Email</h4>
							<div class="alert alert-success background-success" id="successmsg">
									Password reset Successfully. We have sent you an email with new password.
                                </div>
							<form method="post" name="frm" id="frm" autocomplete="off">
								<div class="form-group">
									<label>Email</label> <input class="form-control" placeholder="Enter your email" type="text" name="txtemailid" id="txtemailid" maxlength="255">
									<small class="form-text text-muted errortxt" id="txtemailiderror"></small>
								</div>
								<button class="btn btn-primary btn-block" id="txtsubmitbtn">Send</button>
								<input type="hidden" name="hidbaseurl" id="hidbaseurl" value="{{ URL::to('/') }}" />
							</form>
						</div>
						<div class="main-signup-footer mg-t-10">
							<p>Forget it, <a href="{{ URL::to('/') }}"> Send me back</a> to the sign in screen.</p>

							<center>
							<p>&nbsp;</p>
							</center>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

		<script src="{{ asset('theme/assets/plugins/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/ionicons/ionicons.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/moment/moment.js') }}"></script>
		<script src="{{ asset('theme/assets/js/eva-icons.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('theme/assets/js/themecolor.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom.js') }}"></script>
		<script src="{{ asset('theme/assets/jsscript/forgotpasswordjs.js') }}"></script>

	</body>
</html>
