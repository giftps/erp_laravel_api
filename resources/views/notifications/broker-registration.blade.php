@extends('notifications.layout.app')

@section('content')
    <p>
        Hi {{$user->first_name}},<br />
        You have been successfully registered as a broker under <span style="color: #2981c4;">{{$broker_house}}</span>. Your details will be used for login. In order to login use the details before, and change the password immediately after login.
    </p>

    <p>
        <b>Email:</b> {{$user->email}}<br />
        <b>Password:</b> {{$password}}
    </p>

    <p>You can also login using your Phone Number and OTP by clicking the "Login by OTP" on your login page.</p>
    <a href="{{$ui_url}}/login" target="_blank" class="button">Login</a><br /><br />
@endsection