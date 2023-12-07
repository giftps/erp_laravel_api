@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member_details->first_name}},<br />
        We are pleased to inform you that your premium payment of USD {{$amount}} has been processed. <br />
        Please check the attached receipt and membership schedule for more details.<br /><br />
        Kind Regards.
    </p>
@endsection