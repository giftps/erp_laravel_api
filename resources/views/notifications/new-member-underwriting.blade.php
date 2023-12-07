@extends('notifications.layout.app')

@section('content')
    <p>
        Hi {{$user->first_name}},<br />
        Family with family code {{$family_code}} needs underwriting. Login to the system to see all members that need underwriting.
        <br />
        Please find the membership form attached.
    </p>
@endsection