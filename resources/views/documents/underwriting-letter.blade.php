@extends('documents.layout.app')

@section('content')
    <br />
    <p style="padding: 0; margin: 0px;">
        Dear {{$member->first_name}},<br />
        We are pleased to inform you that the next onboarding step with SES is complete. Please take a look at the exclusions below:
    </p>

    <h5>Exclusions</h5>

    @foreach($exclusions as $exclusion)
        <p style="padding: 0; margin: 0px; font-weight: bold;">{{$exclusion['attributes']['name']}}</p>
        <table style="width: 100%; border-collapse: collapse;" border="1">
            <tr>
                <td style="padding-left: 5px;"><b>Diagnosis</b></td>
                <td style="padding-left: 5px;"><b>Start Date</b></td>
                <td style="padding-left: 5px;"><b>End Date</b></td>
            </tr>
            
            @if(count($exclusion['exclusions']) > 0)
                @foreach($exclusion['exclusions'] as $excl)
                    <tr>
                        <td style="padding-left: 5px;">{{$excl['attributes']['diagnosis']}}</td>
                        <td style="padding-left: 5px;">{{$excl['attributes']['start_date']}}</td>
                        <td style="padding-left: 5px;">{{$excl['attributes']['end_date']}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="padding-left: 5px;" colspan="3">
                        <p style="text-align: center; margin: 0; padding:">No exclusions</p>
                    </td>
                </tr>
            @endif
        </table><br />
    @endforeach
@endsection