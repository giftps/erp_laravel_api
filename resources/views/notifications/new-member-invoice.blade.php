@extends('notifications.layout.app')

@section('content')
    @if($receipient == 'Member')
        <p>
            Dear {{$member_details->first_name}},<br />
            Please find the attached invoice for the scheme that you selected. <br />
            In order to reject or accept invoice and proceed with payment, click the button below.<br /><br />
            <a href="{{$ui_url}}/accept-invoice/{{$registration_token}}" target="_blank" class="button">Proceed</a><br /><br />
        </p>
    @endif

    @if($receipient == 'Finance' || $receipient == 'Broker')
        <p>
            Please find the attached invoice that was sent to {{$member_details->first_name}} {{$member_details->last_name}} whose member number is {{$member_details->member_number}}.
        </p>
    @endif
@endsection