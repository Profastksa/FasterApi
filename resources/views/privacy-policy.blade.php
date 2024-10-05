<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $OrganizationProfile->name}}| privacy policy</title>
    @if (app()->getLocale()== 'ar')
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/vendors.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/custom-rtl.css')}}">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/login-register.css')}}">
    <!-- END Page Level CSS-->
    {{-- Google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    {{-- End Google fonts --}}
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style-rtl.css')}}">
    <!-- END Custom CSS-->
    @else
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/vendors.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/custom.css')}}">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/login-register.css')}}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END Custom CSS-->
    @endif
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo&display=swap');

        * {
            font-family: 'Cairo', sans-serif;
            padding: 0;
            margin: 0;
        }

        body {
            background: #f4f4f4;
        }

        .container {
            max-width: 992px;
            margin: auto;
        }

        .top_nav {
            display: flex;
            background: #fff;
            justify-content: space-between;
            align-items: center;
        }

        .top_nav .logo {
            max-width: 70px;
            overflow: hidden;
        }

        .top_nav .logo>img {
            max-width: 100%;
            height: auto;
        }

        .middel_nav {
            background: #006bcc;
            color: #fff;
            padding: 10px;
        }

        .top_nav_color {
            background: #fff;
        }

        ul {
            list-style-type: none;
        }

        ul li {
            display: inline-block;
            padding: 10px;
            font-size: 15px;
        }

        .text_center {
            text-align: center;
        }

        .margin_none {
            margin: 3px !important;
        }

        .heading_2 {
            font-size: 25px;
        }

        .margin_top {
            margin: 30px 0 0 0;
        }

        .content {
            margin: 50 0 0 0
        }

        section {
            color: #777;
        }

        h1,
        h2,
        h3 {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <div class="top_nav_color">
            <div class="container">
                <div class="top_nav">
                    <div>
                        <ul>
                            <li>
                                سياسه الخصوصيه
                            </li>
                        </ul>
                    </div>
                    <div class="logo">
                        <img src="https://fastersaudi.com/wp-content/uploads/2021/05/unnamed-1.png" alt="">
                    </div>
                </div>
            </div>

            <div class="middel_nav">
                <div class="container">
                    <div class="text_center">
                        <div>
                            <sapn class="heading_2">سياسه الخصوصيه</sapn>

                        </div>
                        <div>
                            <span class="m-0">الرئيسه / سياسه الخصوصيه</sapn>
                        </div>

                    </div>

                </div>




            </div>
        </div>
    </header>
    <div class="container">
        <section>
            <p class="text_center margin_top">
                تنص سياسة الخصوصية هذه بأنه قد تتم معالجة المعلومات التي تُقدم من جانبك أو التي تجمعها شركة فاستر سعودي
                عنك، للأغراض الموضحة أدناه.
            </p>
            <div class="content margin_top">
                @if (app()->getLocale()== 'ar')
                {!! $OrganizationProfile->pravicy_en !!}
                @else
                {!! $OrganizationProfile->pravicy_ar !!}

                @endif </div>
    </div>




</body>

</html>
