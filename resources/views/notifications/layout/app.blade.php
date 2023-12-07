<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        .notifications_container{
            font-family: 'Roboto', sans-serif;
            max-width: 600px;
            width: 100%;
            padding: 2px;
        }

        .button{
            background-color: #2981c4;
            border: 1px solid #2981c4;
            padding: 5px;
            min-width: 150px;
            font-size: 16px;
            color: white;
            font-weight: 500;
            text-decoration: none !important;
            box-shadow: 0 0 2px gray;
        }

        .footer_left_and_right_container{
            display: flex;
            flex-direction: row;
        }

        .footer_left{
            width: 50%;
            padding-top: 10px;
            border-right: 1px solid rgb(228, 228, 228);
            border-top: 1px solid rgb(228, 228, 228);
            border-bottom: 1px solid rgb(228, 228, 228);
        }

        .footer_left_and_right_container p{
            margin: 3px;
            padding: 3px;
        }

        .footer_left .logo_container{
            margin-top: 70px;
        }

        .footer_right{
            width: 50%;
            padding-top: 10px;
            padding-left: 10px;
            border-top: 1px solid rgb(228, 228, 228);
            border-bottom: 1px solid rgb(228, 228, 228);
        }
    </style>
</head>
<body>
    <div class="notifications_container">
        @yield('content')

        @if(config('app.env') == 'local')
            <div class="footer">
                <div class="footer_left_and_right_container">
                    <div class="footer_left">
                        <p>Novus-Connect</p>

                        <div class="logo_container">
                            <img style="width: 130px;" src="{{url('/images/logo.png')}}" alt="" />
                        </div>
                    </div>

                    <div class="footer_right">
                        <p style="color: #414141;"><b>Important Emails:</b></p>
                        <p><i class="fa fa-envelope" style="color: #2981c4;"></i> info@ses-unisure.com</p>
                        <p><i class="fa fa-envelope" style="color: #2981c4;"></i> membership@ses-unisure.com</p>
                        <p><i class="fa fa-envelope" style="color: #2981c4;"></i> sales@ses-unisure.com</p>
                        <p><i class="fa fa-envelope" style="color: #2981c4;"></i> insurance@ses-unisure.com</p>

                        <p style="color: #DF1E26;">EMERGENCY CALL: 737</p>
                    </div>
                </div>
                <img style="width: 100%;" src="{{url('/images/signature_footer_trees.jpg')}}" alt="" />
                <img style="width: 100%;" src="{{url('/images/below_footer_trees.jpg')}}" alt="" />
            </div>
        @endif
    </div>
</body>
</html>