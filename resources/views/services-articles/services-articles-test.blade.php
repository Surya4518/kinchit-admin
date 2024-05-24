<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="" />

    <title> KINCHITKARAM :: Services Contents </title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="{{ asset('theme/assets/img/brand/logo.png') }}" type="image/x-icon" />
    <link href="{{ asset('theme/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style" />
    <link href="{{ asset('theme/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/animate.css') }}" rel="stylesheet">
    <style>
        /* Style for the custom modal */

        /* Add your desired styles to customize the dialog appearance */


        .tab-1 button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 11px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
            border-radius: 50px;
        }

        /* Change background color of buttons on hover */
        .tab-1 button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .tab-1 button.active {
            /* background-color: #ccc; */
            background: linear-gradient(121deg, #ff8000 0%, #ffb502 100%);
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
                        <a href="" class="header-logo"><img src="{{ asset('theme/assets/img/brand/logo-white.png') }}"
                                class="logo-1"></a>
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
                            src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="main-logo" alt="logo"></a>
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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Services Articles</a></li>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {!! $alldatas['rightsidenavbar'] !!}

                </div>

                <div class="">
                    <div class="row my-3">
                        <div class="col-lg-4 col-xl-3">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">Services</div>
                                </div>
                                <div class="main-content-left main-content-left-mail card-body pt-0 ">
                                    <div class="main-settings-menu">
                                        <div class="tab-1">
                                            <button class="tablinks" onclick="openCity(event, 'London')"
                                                id="defaultOpen"> Create Article</button>
                                            <button class="tablinks" onclick="openCity(event, 'Paris')">Add
                                                Contents</button>
                                            <!-- <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button> -->
                                            <!-- <button class="tablinks" onclick="openCity(event, 'Tokyo1')">Tokyo1</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="London" class=" col-lg-8 col-xl-9 tabcontent">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h3>Create Service</h3>
                                </div>
                                <div class="card-header">
                                    <form method="post" id="create_service_form">
                                        <div class="row">
                                            <div class="col-6 md-form mb-2">
                                                <label for="">Service Title </label>
                                                <input type="text" class="form-control" name="service_title"
                                                    id="service_title">
                                                <p id="service_title_error"
                                                    style="color: red;font-size: 12px;margin-left: 2px;"></p>
                                            </div>
                                            <div class="col-6 md-form mb-2">
                                                <label for="">Meta Title </label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    id="meta_title">
                                                <p id="meta_title_error"
                                                    style="color: red;font-size: 12px;margin-left: 2px;"></p>
                                            </div>
                                            <div class="col-6 md-form mb-2">
                                                <label for="">Meta Description </label>
                                                <textarea class="form-control" name="meta_description"
                                                    id="meta_description"></textarea>
                                                <p id="meta_description_error"
                                                    style="color: red;font-size: 12px;margin-left: 2px;"></p>
                                            </div>
                                            <div class="col-6 md-form mb-2">
                                                <label for="">Meta Keyword </label>
                                                <textarea class="form-control" name="meta_key" id="meta_key"></textarea>
                                                <p id="meta_key_error"
                                                    style="color: red;font-size: 12px;margin-left: 2px;">
                                                </p>
                                            </div>
                                            <div class="col-12 text-center md-form my-2 ">
                                                <button class="btn btn-secondary"
                                                    onclick="CreateService()">Submit</button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                            <table id="example" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Age</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>John Doe</td>
                                                            <td>john@example.com</td>
                                                            <td>25</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jane Doe</td>
                                                            <td>jane@example.com</td>
                                                            <td>30</td>
                                                        </tr>
                                                        <!-- Add more rows as needed -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>

                        <div id="Paris" class="col-lg-8 col-xl-9 tabcontent">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h3>Create Service Content</h3>
                                </div>
                                <div class="card-header">
                                    <form method="post" id="create_service_form1">
                                        <div class="row">
                                            <div class="col-6 md-form mb-2">
                                                <label for="">Select Content Title </label>
                                                <select name="" id="" class="form-select">
                                                    <option value="" selected>----Select----</option>
                                                    <option value="">List-1</option>
                                                    <option value="">List-2</option>
                                                    <option value="">List-3</option>
                                                </select>

                                            </div>
                                            <!-- <div class="col-6 md-form mb-2">
                                            <label for="">Meta Title </label>
                                            <input type="text" class="form-control" name="meta_title" id="meta_title">
                                            <p id="meta_title_error"
                                                style="color: red;font-size: 12px;margin-left: 2px;"></p>
                                            </div> -->

                                            <div class="col-4 text-center md-form my-2 ">
                                                <br>
                                                <button class="btn btn-secondary">Submit</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="example1" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Age</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>John Doe</td>
                                                            <td>john@example.com</td>
                                                            <td>25</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jane Doe</td>
                                                            <td>jane@example.com</td>
                                                            <td>30</td>
                                                        </tr>
                                                        <!-- Add more rows as needed -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div><!-- //row -->

            </div>


            <!-- <div id="Tokyo" class="col-lg-8 col-xl-9 tabcontent">
                        <div class="card custom-card">
                            <div class="card-header">
                                <h3>Tokyo</h3>
                                <p>Tokyo is the capital of Japan.</p>
                            </div>
                        </div>
                    </div> -->

            <!-- General Div -->


            <!-- 
                    <div class="col-lg-8 col-xl-9 d-none" id="general-tab">
                        <form name="frm1" id="frm1" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card custom-card">
                                <div class="card-header">

                                    <div class="card-title">Upload Image</div>
                                    <p>This section you can add or edit doctor photo.</p>
                                </div>
                            </div>


                        </form>
                    </div> -->

            <!-- General Div -->



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

    {{--
    <script src="{{ asset('theme/assets/jsscript/createnewfaqjs.js') }}"></script> --}}

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('.table');
    </script>
    @include('services-articles.partials.service_contentjs')
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element  id=tOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#example').DataTable();
        });


        $(document).ready(function () {
            $('#example1').DataTable();
        });
    </script>

</body>

</html>