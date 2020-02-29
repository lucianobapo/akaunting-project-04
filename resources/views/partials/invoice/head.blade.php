<head>
    @stack('head_start')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8; charset=ISO-8859-1"/>

    <title>@yield('title') - @setting('general.company_name')</title>

    <link rel="stylesheet" href="{{ asset('public/css/invoice.css?v=' . version('short')) }}">

    <style type="text/css">
        @php include('public/css/invoice.css') @endphp
        * {
            font-family: DejaVu Sans;
        }

        /** 
        * Define the width, height, margins and position of the watermark.
        **/
        #watermark {
            position: fixed;
            bottom:   0px;
            left:     0px;
            /** The width and height may change 
                according to the dimensions of your letterhead
            **/
            width:    21.8cm;
            height:   28cm;

            /** Your watermark should be behind every content**/
            z-index:  -1000;
        }
/*
        #watermark {
          height: 450px;
          width: 600px;
          position: relative;
          overflow: hidden;
        }
        #watermark img {
          max-width: 100%;
        }*/
        #watermark p {
          position: absolute;
          top: 0;
          left: 0;
          color: #f0f0f0;
          font-size: 40px;
          pointer-events: none;
          -webkit-transform: rotate(-45deg);
          -moz-transform: rotate(-45deg);
        }
    </style>

    @stack('css')

    @stack('stylesheet')

    @stack('js')

    @stack('scripts')

    @stack('head_end')
</head>
