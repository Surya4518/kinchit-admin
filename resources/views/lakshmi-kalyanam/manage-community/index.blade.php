<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="" />

    <title> KINCHITKARAM :: Manage Community </title>

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
                         <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary rounded-circle me-5" onclick="window.history.back()" role="button">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <h4 class="content-title mb-2">Hi , Welcome Admin!</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Manage Community</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Show Community List
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {!! $alldatas['rightsidenavbar'] !!}

                </div>

                <div class="card">
                    <div class="row">
                        <h3>Manage Community List</h3>
                        <div class="card-body">
                            <div class="button text-end mb-4">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#create_community_modal">Create Community<i
                                        class="fa fa-plus mx-2"></i></button>
                            </div>
                            <div class="table-responsive">
                                <table id="community-table" class="table">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                        <th>Community</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- //row -->

                </div>
            </div>

        </div>
         @include('lakshmi-kalyanam.manage-community.partials.manage_community_create_modal')
         @include('lakshmi-kalyanam.manage-community.partials.manage_community_edit_modal')
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
    <script></script>
    @include('lakshmi-kalyanam.manage-community.partials.communityjs')



</body>

</html>
