<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="" />

    <title> KINCHITKARAM :: Gnanakaithaa Request </title>

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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Gnanakaithaa Request</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Show Gnanakaithaa Request
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {!! $alldatas['rightsidenavbar'] !!}

                </div>

                <div class="card">
                    <div class="row">
                        <h3 id="page_title_name">Gnanakaithaa Request </h3>
                        <div class="card-body">
                            <div class="volun-frm">
                                <form method="post" enctype="multipart/form-data" id="user_profile_update_form">
                                   <div class="row mb-2">
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Name of Student: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->name_of_student }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Contact no: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->contact_no }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Email: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->contact_no }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">DOB: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->email }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                         <label for="name" class="form-label">Age : <span style="color:#f90404">*</span></label>
                                         <input type="name" class="form-control" readonly value="{{ $results[0]->age }}">
                                     </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Door No. & Street Name: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->dob }}">
                                       </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Country: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->door_no }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">State: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->country }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Town or City: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->state }}">
                                       </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Pincode: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->city }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Pincode: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->pincode }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Present Address is same as Permanent Address: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->pre_permanent }}">
                                       </div>
                                       <div class="row yes-no {{ $results[0]->pre_permanent == 'no' ? 'd-block' : 'd-none' }}">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Door No. & Street Name: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->door_no1 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Country: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->country1 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">State: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->state1 }}">
                                        </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Town or City: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->city1 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Pincode: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->pincode1 }}">
                                        </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name of Father/ Mother/ Guardian: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->name_of_parent }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Parent Contact Number: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->parent_contact }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Email: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->email1 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Aadhaar (or) Family card number of Student (or) Father/ Mother/ Guardian: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->aadhaar_no }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">No of Siblings: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->no_of_siblings }}">
                                        </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label"> Family Annual Income: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->family_annual_Income }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <label for="name" class="form-label">Occupation of Father/ Mother/ Guardian: <span style="color:#f90404">*</span></label>
                                           <input type="name" class="form-control" readonly value="{{ $results[0]->parent_work }}">
                                       </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Completed School standard/ UG year (or) Semester: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->from_education }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name of School (or) College: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->from_school }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Percentage of marks obtained (Attach certified mark sheet): <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->from_mark_sheet }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Joining Education Type (School/ College Education): <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->to_education }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Joining in standard / Year (or) Semester of U.G course: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->to_school }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Joining/ studying Name of School (or) College: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->to_mark_sheet }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Annual fees (Attach school / college admission letter & fees demand certificate): <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->first_name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Referred by Volunteer / Member/ Archagar/ Bagavathar's Name: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->bagavathar_name }}">
                                    </div>
                                       <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Volunteer Contact Number: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->volunteer_contact_number }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Declaration: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->declaration }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Amount may be issued in the form of: <span style="color:#f90404">*</span></label>
                                        <input type="name" class="form-control" readonly value="{{ $results[0]->payment_type }}">
                                       </div>
                                       <div class="row cheque {{ $results[0]->payment_type == 'காசோலை / Cheque' ? 'd-block' : 'd-none' }}">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Cheque to be issued in the name of: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->cheque_issued_name }}">
                                        </div>
                                       </div>
                                       <div class="row bank-acc {{ $results[0]->payment_type == 'வங்கி பரிவர்த்தனை / Bank Transfer' ? 'd-block' : 'd-none' }}">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Account Holder: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->ac_holder_name }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">IFSC: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->ifsc_of_ac }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Account Number: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->acc_no }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Bank Name & Branch: <span style="color:#f90404">*</span></label>
                                            <input type="name" class="form-control" readonly value="{{ $results[0]->bank_of_acc }}">
                                        </div>
                                       </div>
                                   </div>
                                   <div class="row justify-content-center">
                                       <div class="col-md-12 text-center">
                                          <button type="button" id="verify-request" onclick="VerifyRequest({{ $results[0]->id }})" {{ $results[0]->is_approved != '0' ? 'disabled' : '' }} class="btn btn-secondary">{{ $results[0]->is_approved == '3' ? 'Verified' : ($results[0]->is_approved == '2' ? 'Rejected' : ($results[0]->is_approved == '1' ? 'Approved' : 'Verify')) }}</button>
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

    @include('gnanakaithaa.partials.gnanakaithaajs')


</body>

</html>
