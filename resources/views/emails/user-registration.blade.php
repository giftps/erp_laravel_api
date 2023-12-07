<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        .container{
            max-width: 800px;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 2px gray;
            margin-left: auto;
            margin-right: auto;
        }

        .content{
            margin: 15px;
        }
    </style>
</head>
<body style="margin-top: 5%;">
    <div class="container">
        <img src="https://www.ses-unisure.com/wp-content/uploads/2019/10/SES-Logo-WS-2019-FC-x300.png" style="width: 140px; margin-left: 10px;" />
        <div style="width: 100%; background-color: red; height: 10px; box-shadow: 0 2px 0 gray;"></div>

        <div class="content">
            @if ($type === 'registration')
                <p style="margin-left: 15px;">Enter this confirmation code in order to login.</p>
            @else
                <p style="margin-left: 15px;">Enter the code below to reset the password.</p>
            @endif
            
            <p style="color: blue; margin-left: 15px;">
                {{$confirmation_code}}
            </p>

            <p style="margin-left: 15px;">Kind Regards, <br /> SES-Unisure Team.</p>
        </div><br />
    </div>
</body>
</html>