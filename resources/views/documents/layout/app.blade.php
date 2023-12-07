<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">

    <title>Application Form</title>

    <style>
 @font-face {
            font-family: CenturyGothic;
            src: url('https://raw.githubusercontent.com/giftps/hosted_files/main/CenturyGothic.ttf') format("truetype");
            font-style: normal;
        }

        body {
            font-family: CenturyGothic;
        }

        @page {
            margin: 10px 0px;
            size: A4
        }

        html,
        html>* {
            padding: 0;
            box-sizing: border-box;
            margin: 0;
            font-size: 10px;
        }

        body {
            width: 211mm;
            margin: 0 auto;
            padding: 10px;
            /*transform: rotate(270deg) translate(-240mm, 0);*/
            /*transform-origin: 0 0;*/
        }

        .header {
            text-align: left;
        }

        .header_content_container img {
            width: 100%;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            background-color: #3D464A;
            color: white;
            padding: 5px;
            /* height: 200px;  */
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body class="tk-century-">
    <div style="padding: 20px;">
        <div class="header">
            @php
            $image = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/logo.png')));
            @endphp

            <!-- <hr style="height:1px"> -->

            <div class="header_content_container">
                
                <div>
                </div>
                @yield('content')
            </div>
</body>

</html>