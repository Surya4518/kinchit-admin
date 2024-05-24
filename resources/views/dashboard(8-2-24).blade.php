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

		<title> KINCHITKARAM :Dashboard</title>


		<link rel="icon" href="{{ asset('theme/assets/img/brand/logo.png') }}" type="image/x-icon"/>
		<link href="{{ asset('theme/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style"/>


		<link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/plugins.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/icons.css') }}" rel="stylesheet">
		<link href="{{ asset('theme/assets/css/animate.css') }}" rel="stylesheet">

	</head>

	<body class="main-body app sidebar-mini ltr" oncontextmenu="return false;">


		<div id="global-loader">
			<img src="{{ asset('theme/assets/img/loaders/loader-4.svg') }}" class="loader-img" alt="Loader">
		</div>



	   <div class="page custom-index">


			<div class="main-header side-header sticky nav nav-item">
				<div class="container-fluid main-container ">
					<div class="main-header-left ">
						<div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
							<a class="open-toggle"   href="javascript:void(0);"><i class="header-icons" data-eva="menu-outline"></i></a>
							<a class="close-toggle"   href="javascript:void(0);"><i class="header-icons" data-eva="close-outline"></i></a>
						</div>
						<div class="responsive-logo">
							{{-- <a href="" class="header-logo"><img src="{{ asset('theme/assets/img/brand/logo.png') }}" class="logo-11"></a> --}}
							<a href="" class="header-logo"><img src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="logo-1"></a>
						</div>
						<ul class="header-megamenu-dropdown  nav">


						</ul>
					</div>
					<button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
					</button>
					<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
						<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
							<div class="main-header-right">


								<div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
									<div class="nav-item full-screen fullscreen-button">
										<a class="new nav-link full-screen-link"   href="javascript:void(0);"><i class="fe fe-maximize"></i></span></a>
									</div>



									<div class="dropdown main-profile-menu nav nav-item nav-link">

										<?php echo $alldatas['toprightmenu'];?>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
			<div class="sticky">
				<aside class="app-sidebar sidebar-scroll">
					<div class="main-sidebar-header active">
						<a class="desktop-logo logo-light " href="#"><img src="{{ asset('theme/assets/img/brand/logo.png') }}" class=" m-0 mb-2" alt="logo"></a>
						<a class="desktop-logo logo-dark active" href=""><img src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="main-logo" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-light active" href=""><img src="{{ asset('theme/assets/img/brand/favicon.png') }}" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-dark active" href=""><img src="{{ asset('theme/assets/img/brand/favicon-white.png') }}" alt="logo"></a>
					</div>
					<div class="main-sidemenu">
						<div class="main-sidebar-loggedin">
							<div class="app-sidebar__user">
								<?php echo $alldatas['userinfo'];?>
							</div>
						</div>
						<?php echo $alldatas['sidenavbar'];?>
						<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>


						<?php echo $alldatas['mainmenu'];?>



						<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
					</div>
				</aside>
			</div>



			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Hi , Welcome Admin!</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a   href="javascript:void(0);">Dashboard</a></li>
								</ol>
							</nav>
						</div>

						<?php echo $alldatas['rightsidenavbar']; ?>

					</div>
					<!-- /breadcrumb -->

					<!-- main-content-body -->
					<div class="main-content-body">
						<div class="row row-sm">
							<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
								<div class="card overflow-hidden project-card">
									<div class="card-body">
										<div class="d-flex">
											<div class="my-auto">
												<svg enable-background="new 0 0 469.682 469.682" version="1.1"  class="me-4 ht-60 wd-60 my-auto primary" viewBox="0 0 469.68 469.68" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
													<path d="m120.41 298.32h87.771c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449h-87.771c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449z"/>
													<path d="m291.77 319.22h-171.36c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h171.36c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m291.77 361.01h-171.36c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h171.36c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m420.29 387.14v-344.82c0-22.987-16.196-42.318-39.183-42.318h-224.65c-22.988 0-44.408 19.331-44.408 42.318v20.376h-18.286c-22.988 0-44.408 17.763-44.408 40.751v345.34c0.68 6.37 4.644 11.919 10.449 14.629 6.009 2.654 13.026 1.416 17.763-3.135l31.869-28.735 38.139 33.959c2.845 2.639 6.569 4.128 10.449 4.18 3.861-0.144 7.554-1.621 10.449-4.18l37.616-33.959 37.616 33.959c5.95 5.322 14.948 5.322 20.898 0l38.139-33.959 31.347 28.735c3.795 4.671 10.374 5.987 15.673 3.135 5.191-2.98 8.232-8.656 7.837-14.629v-74.188l6.269-4.702 31.869 28.735c2.947 2.811 6.901 4.318 10.971 4.18 1.806 0.163 3.62-0.2 5.224-1.045 5.493-2.735 8.793-8.511 8.361-14.629zm-83.591 50.155-24.555-24.033c-5.533-5.656-14.56-5.887-20.376-0.522l-38.139 33.959-37.094-33.959c-6.108-4.89-14.79-4.89-20.898 0l-37.616 33.959-38.139-33.959c-6.589-5.4-16.134-5.178-22.465 0.522l-27.167 24.033v-333.84c0-11.494 12.016-19.853 23.51-19.853h224.65c11.494 0 18.286 8.359 18.286 19.853v333.84zm62.693-61.649-26.122-24.033c-4.18-4.18-5.224-5.224-15.673-3.657v-244.51c1.157-21.321-15.19-39.542-36.51-40.699-0.89-0.048-1.782-0.066-2.673-0.052h-185.47v-20.376c0-11.494 12.016-21.42 23.51-21.42h224.65c11.494 0 18.286 9.927 18.286 21.42v333.32z"/>
													<path d="m232.21 104.49h-57.47c-11.542 0-20.898 9.356-20.898 20.898v104.49c0 11.542 9.356 20.898 20.898 20.898h57.469c11.542 0 20.898-9.356 20.898-20.898v-104.49c1e-3 -11.542-9.356-20.898-20.897-20.898zm0 123.3h-57.47v-13.584h57.469v13.584zm0-34.482h-57.47v-67.918h57.469v67.918z"/>
												</svg>
											</div>
											<div class="project-content">
												<h6>Users</h6>
												<ul>
													<li>
														<strong>Active
														<span>{{ $active_users }}</span></strong>
													</li>

													<li>
														<strong>Inactive
														<span>{{ $inactive_users }}</span></strong>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- row -->
						<div class="row row-sm ">
						</div>
						<!-- /row -->
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /main-content -->


			<input type="hidden" name="hidbaseurl" id="hidbaseurl" value="<?php echo URL::to('/');?>" />
			<input type="hidden" name="hidapiurl" id="hidapiurl" value="<?php echo getenv("APIURL");?>" />

			<?php echo $alldatas['footer'];?>

	</div>



		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>


		<script src="{{ asset('theme/assets/plugins/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/ionicons/ionicons.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('theme/assets/js/chart.flot.sampledata.js') }}"></script>
		<script src="{{ asset('theme/assets/js/eva-icons.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/moment/moment.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/side-menu/sidemenu.js') }}"></script>
		<script src="{{ asset('theme/assets/js/sticky.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/sidebar/sidebar.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/sidebar/sidebar-custom.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/raphael/raphael.min.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/morris.js/morris.min.js') }}"></script>
		<script src="{{ asset('theme/assets/js/script.js') }}"></script>
		<script src="{{ asset('theme/assets/js/index.js') }}"></script>
		<script src="{{ asset('theme/assets/js/themecolor.js') }}"></script>
		<script src="{{ asset('theme/assets/js/swither-styles.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom.js') }}"></script>
		<script src="{{ asset('theme/assets/js/dashboardjs.js') }}"></script>
	</body>
</html>
