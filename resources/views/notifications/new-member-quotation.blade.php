@extends('notifications.layout.app')

@section('content')
    @if($receipient == 'Member')
        <p>
            Dear {{$member_details->first_name}},<br />
            Please find the attached quotation for membership schemes at SES. <br />
            In order to reject or accept quotation and fill in all your details in order to have your account registered with SES, click the button below.<br /><br />
            <a href="{{$ui_url}}/accept-or-reject-quotation/{{$registration_token}}" target="_blank" class="button">Proceed</a><br /><br />
        </p>
    @endif

    @if($receipient == 'Broker')
        <p>
            Please find the attached quotation sent to {{$member_details->first_name}} {{$member_details->last_name}} whose membership number is {{$member_details->member_number}}.
        </p>
    @endif
@endsection