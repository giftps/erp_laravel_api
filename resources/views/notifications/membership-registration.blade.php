@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member->first_name}},<br />
        We are glad to inform you that your membership registration was complete. Please find the attached registration form.
    </p>
@endsection