@extends('notifications.layout.app')

@section('content')
    <p>
        Hi {{$user->first_name}},<br />
        Your password has been successfully reset as requested. Use the credentials below to login.
    </p>

    <p>
        <b>Email:</b> {{$user->email}}<br />
        <b>Password:</b> {{$password}}
    </p>

    <p>You can also login using your Phone Number and OTP by clicking the "Login by OTP" on your login page.</p>

    <a href="{{$ui_url}}/login" target="_blank" class="button">Login</a><br /><br />
@endsection 