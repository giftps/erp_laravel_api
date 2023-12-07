@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member->first_name}},<br />
        Please find the attached renewal quotation. You have 45 days before your membership expires. Please make payment before this day.<br />
    </p>
@endsection