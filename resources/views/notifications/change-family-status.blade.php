@extends('notifications.layout.app')

@section('content')
    <p>
        Hi {{$member->first_name}},<br />
        Your membership has been moved to active. Your benefits start today and you can now visit any service provider that is supported by ses.
    </p>

    <p>You can also download our app on app store or play store and login to see your membership details.</p>
@endsection