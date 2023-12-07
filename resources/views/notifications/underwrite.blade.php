@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member->first_name}}<br />
        Please find your underwriting document attached to this email.<br />
        In order to accept underwriting and proceed to the next step, click the button below.<br />
    </p>
    <a href="{{$link}}" target="_blank" class="button">Proceed</a><br /><br />
@endsection