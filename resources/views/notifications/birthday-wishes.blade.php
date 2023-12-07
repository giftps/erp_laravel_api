@extends('notifications.layout.app')

@section('content')
    <p>
        Happy birthday {{$member->first_name}}<br />
        {{$messages}}
    </p>
@endsection 