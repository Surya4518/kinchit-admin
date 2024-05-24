<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="" />

    <title> KINCHITKARAM :: User </title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="{{ asset('theme/assets/img/brand/logo.png') }}" type="image/x-icon"/>
    <link href="{{ asset('theme/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style" />
    <link href="{{ asset('theme/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/animate.css') }}" rel="stylesheet">
    <style>
        /* Style for the custom modal */

        /* Add your desired styles to customize the dialog appearance */


        .tab-pane {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .nav-stacked {
            display: initial !important;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .drp {
            padding: 10px;
            font-size: 15px;
        }



        a {
            color: #000;
        }

        .card {
            box-shadow: 0px 4px 16px 0px rgba(0, 0, 0, 0.16);
            padding: 20px;
        }

        .drp:hover {
            background: #d1d1d1;
            color: #fff !important;
        }

        .pr15 {
            box-shadow: 0px 4px 16px 0px rgba(0, 0, 0, 0.16);
            padding: 10px;
        }

        .number {
            height: 18px;
            width: 18px;
            background-color: #f9133e;
            border-radius: 20px;
            color: white;
            text-align: center;
            position: absolute;
            top: -4px;
            left: 30px;
            border-style: solid;
            border-width: 2px;
            font-size: 10px;
        }
        .volun-frm{
            padding:20px;
        }
    </style>

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
                        <a class="open-toggle" href="javascript:void(0);"><i class="header-icons"
                                data-eva="menu-outline"></i></a>
                        <a class="close-toggle" href="javascript:void(0);"><i class="header-icons"
                                data-eva="close-outline"></i></a>
                    </div>
                    <div class="responsive-logo">
                        <a href="" class="header-logo"><img src="{{ asset('theme/assets/img/brand/logo.png') }}"
                                class="logo-11"></a>
                        <a href="" class="header-logo"><img
                                src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="logo-1"></a>
                    </div>
                    <ul class="header-megamenu-dropdown  nav">

                    </ul>
                </div>
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div
                    class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="main-header-right">


                            <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                                {{-- <div class="nav-item full-screen fullscreen-button">
                                    <a class="new nav-link full-screen-link" href="javascript:void(0);"><i
                                            class="fe fe-bell"></i></span></a>
                                    <div class="number">2</div>
                                </div> --}}
                                <div class="nav-item full-screen fullscreen-button">
                                    <a class="new nav-link full-screen-link" href="javascript:void(0);"><i
                                            class="fe fe-maximize"></i></span></a>
                                </div>

                                <div class="dropdown main-profile-menu nav nav-item nav-link">

                                    {!! $alldatas['toprightmenu'] !!}

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
                    <a class="desktop-logo logo-light active" href=""><img
                            src="{{ asset('theme/assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
                    <a class="desktop-logo logo-dark active" href=""><img
                            src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="main-logo"
                            alt="logo"></a>
                    <a class="logo-icon mobile-logo icon-light active" href=""><img
                            src="{{ asset('theme/assets/img/brand/favicon.png') }}" alt="logo"></a>
                    <a class="logo-icon mobile-logo icon-dark active" href=""><img
                            src="{{ asset('theme/assets/img/brand/favicon-white.png') }}" alt="logo"></a>
                </div>
                <div class="main-sidemenu">
                    <div class="main-sidebar-loggedin">
                        <div class="app-sidebar__user">

                            {!! $alldatas['userinfo'] !!}

                        </div>
                    </div>

                    {!! $alldatas['sidenavbar'] !!}

                    <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                            fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                        </svg></div>

                    {!! $alldatas['mainmenu'] !!}

                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                        </svg></div>
                </div>
            </aside>
        </div>



        <div class="main-content app-content">


            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div>
                        <h4 class="content-title mb-2">Hi , Welcome Admin!</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">User</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> User Edit
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {!! $alldatas['rightsidenavbar'] !!}

                </div>

                <div class="card">
                    <div class="row">
                        <h3 id="page_title_name">User Edit </h3>
                        <div class="card-body">
                            <div class="volun-frm">
                                <form method="post" enctype="multipart/form-data" id="user_profile_update_form">
                                   <div class="row mb-2">
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Enter Your First Name: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->first_name }}" id="user_first_name" name="user_first_name" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="user_first_name_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Enter Your Last Name: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" value="{{ $user[0]->last_name }}" id="user_last_name" name="user_last_name" aria-describedby="emailHelp">
                                        <p class="validate_errors" id="user_last_name_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Select Your Gender: <span style="color:#f90404">*</span></label>
                                        <select class="form-control" name="user_gender" id="user_gender">
                                            <option value="">Select</option>
                                            <option {{ $user[0]->gender == 'Male' ? 'selected' : '' }} value="Male">Male</option>
                                            <option {{ $user[0]->gender == 'Female' ? 'selected' : '' }} value="Female">Female</option>
                                        </select>
                                        <p class="validate_errors" id="user_gender_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                         <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Email Address: <span style="color:#f90404">*</span></label>
                                            <input type="email" class="form-control" value="{{ $user[0]->usermail }}" id="user_email" name="user_email" aria-describedby="emailHelp">
                                            <p class="validate_errors" id="user_email_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Mobile / SMS: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" value="{{ $user[0]->phone_number }}" id="user_sms_no" name="user_sms_no" aria-describedby="emailHelp">
                                            <p class="validate_errors" id="user_sms_no_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Mobile / Whatsapp: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" value="{{ $user[0]->phone_number_wa }}" id="user_wa_no" name="user_wa_no" aria-describedby="emailHelp">
                                            <p class="validate_errors" id="user_wa_no_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Date of Birth: <span style="color:#f90404">*</span></label>
                                            <input type="date" class="form-control" value="{{ $user[0]->dob }}" id="date_birth" name="date_birth" aria-describedby="emailHelp">
                                            <p class="validate_errors" id="date_birth_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Samasrayana Acharyan (if applicable): <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->acharyan }}" id="samasar" name="samasar" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="samasar_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Address Line1: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->address_1 }}" id="address1" name="address1" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="address1_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Address Line2: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->address_2 }}" id="address2" name="address2" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="address2_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">City: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" value="{{ $user[0]->city }}" id="city_name" name="city_name" aria-describedby="emailHelp">
                                        <p class="validate_errors" id="city_name_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">State: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->state }}" id="state_name" name="state_name" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="state_name_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Country: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->country }}" id="country_name" name="country_name" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="country_name_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                         <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Pincode: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->postcode }}" id="pincode" name="pincode" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="pincode_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Educationa Qualification: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->qualification }}" id="qualification" name="qualification" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="qualification_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Work Experience: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->work_experience }}" id="workexp" name="workexp" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="workexp_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Special Interest/ Hobby: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->hobbies }}" id="special_interest" name="special_interest" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="special_interest_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Any Special Skill Set ?Please Mention Below: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" value="{{ $user[0]->skills }}" id="special_skill" name="special_skill" aria-describedby="emailHelp">
                                           <p class="validate_errors" id="special_skill_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                         <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Upload Profile Photo: <span style="color:#f90404">*</span></label>
                                           <input type="file" accept=".jpg,.jpeg,.png,.webp" class="form-control" id="user_photo" name="user_photo" aria-describedby="emailHelp">
                                           @if ($user[0]->user_image != NULL)
                                           <img src="{{ asset($user[0]->user_image) }}" alt="" style="width: 19%;">
                                           <span><a href="javascript:DeleteTheUserImage({{ $user[0]->user_main_id }})" title="Edit Item" class="mb-2 mr-2 btn-sm btn-transition btn btn-outline-secondary editservices"><i class="fe fe-x" style="font-size:16px;"></i></a></span>
                                           @endif
                                           <p class="validate_errors" id="user_photo_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Username: <span style="color:#f90404">*</span></label>
                                        <input type="text" class="form-control" id="user_username" {{ $user[0]->user_type == 'volunteer' ? 'readonly' : '' }} value="{{ $user[0]->userlogin }}"  name="user_username">
                                        <p class="validate_errors" id="user_username_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                                    </div>
                                   </div>
                                   <div class="row justify-content-center">
                                       <div class="col-md-12 text-center">
                                        <input type="hidden" name="user_edit_id" id="user_edit_id" value="{{ $user[0]->user_main_id }}">
                                          <button type="button" id="user-profile-update" class="btn btn-secondary">Submit</button>
                                       </div>
                                   </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- //row -->

                </div>
            </div>

        </div>

    </div>

    {!! $alldatas['footer'] !!}


    </div>

    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>


    <script src="{{ asset('theme/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/summernote-editor/summernote1.js') }}"></script>
    <script src="{{ asset('theme/assets/js/summernote.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/side-menu/sidemenu.js') }}"></script>
    <script src="{{ asset('theme/assets/js/sticky.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/sidebar/sidebar.js') }}"></script>
    <script src="{{ asset('theme/assets/plugins/sidebar/sidebar-custom.js') }}"></script>
    <script src="{{ asset('theme/assets/js/eva-icons.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/script.js') }}"></script>
    <script src="{{ asset('theme/assets/js/themecolor.js') }}"></script>
    <script src="{{ asset('theme/assets/js/swither-styles.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- <script src="{{ asset('theme/assets/jsscript/createnewfaqjs.js') }}"></script> --}}

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('.table');
    </script>

    @include('volunteer.partials.volunteerjs')


</body>

</html>
