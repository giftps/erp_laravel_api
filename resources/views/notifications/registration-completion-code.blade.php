@extends('notifications.layout.app')

@section('content')
    <p>
        Hi {{$member->first_name}},<br />
        Your registration code is: {{$code}}
    </p>
@endsection