<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="" />

    <title> KINCHITKARAM :: Seo Configuration </title>

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
            heidht: 18px;
            width: 18px;
            background-color: #f9133e;
            border-radius: 20px;
            color: white;
            text-alidn: center;
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
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navidation">
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
                    <a class="desktop-logo logo-lidht active" href=""><img
                            src="{{ asset('theme/assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
                    <a class="desktop-logo logo-dark active" href=""><img
                            src="{{ asset('theme/assets/img/brand/logo-white.png') }}" class="main-logo"
                            alt="logo"></a>
                    <a class="logo-icon mobile-logo icon-lidht active" href=""><img
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
                            fill="#7b8191" width="24" heidht="24" viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                        </svg></div>

                    {!! $alldatas['mainmenu'] !!}

                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" heidht="24" viewBox="0 0 24 24">
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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Seo Configuration</a></li>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {!! $alldatas['rightsidenavbar'] !!}

                </div>

                <div class="card">
                    <div class="row">
                        <h3>Seo Configuration</h3>
                        <div class="card-body">
                            <div class="show_error"></div>
                            <form enctype="multipart/form-data" id="update_seo_config_form">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>User Register</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="reg_meta_title" id="reg_meta_title" value="{{ $data[0]->reg_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="reg_meta_description" id="reg_meta_description">{{ $data[0]->reg_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="reg_meta_keywords" id="reg_meta_keywords">{{ $data[0]->reg_meta_description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Login</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="login_meta_title" id="login_meta_title" value="{{ $data[0]->login_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="login_meta_description" id="login_meta_description">{{ $data[0]->login_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="login_meta_keywords" id="login_meta_keywords">{{ $data[0]->login_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Become A Volunteer</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="bec_vol_meta_title" id="bec_vol_meta_title" value="{{ $data[0]->bec_vol_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="bec_vol_meta_description" id="bec_vol_meta_description">{{ $data[0]->bec_vol_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="bec_vol_meta_keywords" id="bec_vol_meta_keywords">{{ $data[0]->bec_vol_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Become A Member</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="bec_mem_meta_title" id="bec_mem_meta_title" value="{{ $data[0]->bec_mem_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="bec_mem_meta_description" id="bec_mem_meta_description">{{ $data[0]->bec_mem_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="bec_mem_meta_keywords" id="bec_mem_meta_keywords">{{ $data[0]->bec_mem_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Audio</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="aud_meta_title" id="aud_meta_title" value="{{ $data[0]->aud_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="aud_meta_description" id="aud_meta_description">{{ $data[0]->aud_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="aud_meta_keywords" id="aud_meta_keywords">{{ $data[0]->aud_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Video</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="vid_meta_title" id="vid_meta_title" value="{{ $data[0]->vid_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="vid_meta_description" id="vid_meta_description">{{ $data[0]->vid_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="vid_meta_keywords" id="vid_meta_keywords">{{ $data[0]->vid_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>En Pani</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="en_meta_title" id="en_meta_title" value="{{ $data[0]->en_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="en_meta_description" id="en_meta_description">{{ $data[0]->en_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="en_meta_keywords" id="en_meta_keywords">{{ $data[0]->en_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Dharmasandheha</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="dharma_meta_title" id="dharma_meta_title" value="{{ $data[0]->dharma_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="dharma_meta_description" id="dharma_meta_description">{{ $data[0]->dharma_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="dharma_meta_keywords" id="dharma_meta_keywords">{{ $data[0]->dharma_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Donation</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="don_meta_title" id="don_meta_title" value="{{ $data[0]->don_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="don_meta_description" id="don_meta_description">{{ $data[0]->don_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="don_meta_keywords" id="don_meta_keywords">{{ $data[0]->don_meta_keywords ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4>Lakshmi Kalyanam</h4>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Title</lable>
                                    <input class="form-control" type="text" name="laksh_meta_title" id="laksh_meta_title" value="{{ $data[0]->laksh_meta_title ?? '' }}">
                                </div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Description</lable>
                                    <textarea class="form-control" name="laksh_meta_description" id="laksh_meta_description">{{ $data[0]->laksh_meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <lable>Meta Keywords</lable>
                                    <textarea class="form-control" name="laksh_meta_keywords" id="laksh_meta_keywords">{{ $data[0]->laksh_meta_keywords ?? '' }}</textarea>
                                    <input type="hidden" name="id" id="id" value="{{ $data[0]->id ?? '' }}">
                                </div>
                            </div>
                        </form>
                            <div class="text-center">
                                <button class="btn btn-primary" id="update_seo_config">Save</button>
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
    @include('settings.seo-keyword.partials.seojs')
</body>

</html>
