@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member->first_name}},<br />
        Your account of family code {{$member->family?->family_code}} has been suspended due to none payment. Please make payment so that your account is restored.
    </p>
@endsection 