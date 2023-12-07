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

        <div class="content" style="padding: 15px;">
            <p><b>From:</b> {{$user}}</p>
            <p><b>Subject:</b> {{$subject}}</p>
            <p><b>Message:</b> {{$message}}</p>
            <p><b>Reply to:</b> {{$email}}</p>
        </div><br />
    </div>
</body>
</html>