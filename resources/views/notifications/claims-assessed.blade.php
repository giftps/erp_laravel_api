@extends('notifications.layout.app')

@section('content')
    <p>
        Dear {{$member->first_name}} {{$member->last_name}},<br />
        Assessement of your claim from {{$claim->serviceProvider?->name}} has been completed.
        @if($claim->preauthorisation_id)
        &nbsp; It is linked to auth Number: {{$claim->preauthorisation?->auth_code}} which was requested on {{$claim->preauthorisation?->created_at}}.
        @endif
    </p>
@endsection