@extends('documents.layout.app')

@section('content')
    <style>
        td{
            padding: 3px;
        }
    </style>

    <div>
        @php
            $renewal_quote = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/renewal_quote.png')));
            $totals = [];
            $currency_symbol = null;

            //!! My custom $vars to make the code work without Controller
            $members = App\Models\Api\V1\Membership\Member::where('member_id', '>', 0);
            $quotation_number = 001;
            $quotation_type = 'New';
            
            $brokers = App\Models\Api\V1\Sales\Broker::where('broker_id', '=', 1)->get();
            $broker = $brokers[0];
            
            $scheme_options = App\Models\Api\V1\Lookups\SchemeOption::where('id', '=', 2)->get();

            $cover_start_date = date('Y-m-d');
            $cover_end_date = date('Y-m-d');
        @endphp

        @include('documents.layout.banner', ['title' => 'INDIVIDUAL QUOTATION'])

        {{-- Top content --}}
        <table style="width: 100%">
            <tr>
                <td>
                    <br /><br />
                    <b style="margin-top: 100px;">Quotation For</b><br />
                    {{$members->where('dependent_code', '=', '00')->first()->first_name}} {{$members->where('dependent_code', '=', '00')->first()->last_name}},<br />
                    {{$members->where('dependent_code', '=', '00')->first()->mobile_number}},<br />
                    {{$members->where('dependent_code', '=', '00')->first()->email}}
                </td>

                <td style="text-align: right;">
                    <b>Date:</b> <?php echo date('d M Y'); ?><br />
                    <b>Quotation Number:</b> {{$quotation_number}}<br />
                    <b>Quotation Type:</b> {{$quotation_type}}
                </td>
            </tr>
        </table><br />

        {{-- Broker Details --}}
        <table style="width: 100%; border-collapse: collapse;" border="1">
            <tr>
                <td style="padding: 5px; padding-left: 10px;"><b>Broker:</b> {{$broker?->first_name}} {{$broker?->surname}}</td>
                <td style="padding: 5px; padding-left: 10px;"><b>Contact Number:</b> {{$broker?->phone_number}}</td>
                <td style="padding: 5px; padding-left: 10px;"><b>Email:</b> {{$broker?->email}}</td>
            </tr>
        </table><br />

        {{-- Quotation Price Comparisons --}}
        <table style="width: 100%; border-collapse: collapse; border-top: 1px solid gray; border-top: 1px solid gray;">
            {{-- Headers --}}
            <tr>
                <td style="border: 0.7px solid gray;"><b>Member Name</b></td>
                <td style="border: 0.7px solid gray;"><b>Age</b></td>
                @foreach($scheme_options as $scheme)
                    <td style="border: 0.7px solid gray;"><b>{{$scheme->name}}</b></td>
                @endforeach
            </tr>

            {{-- Members --}}

            @foreach($members as $member)
                @php
                    $age = date_diff(date_create($member->dob), date_create($cover_start_date ?? date('Y-m-d')));
                    $member_age = $age->format('%y');
                    $count = 0;
                @endphp

                <tr>
                    <td style="border: 0.7px solid gray;">{{$member->first_name}}</td>
                    <td style="border: 0.7px solid gray;">{{$member_age}}</td>
                    @foreach($scheme_options as $scheme)
                        @php
                            // The subscription price is collected by using the subscription_period id and the age group id which is gotten by calling the age group helper
                            $subscription = $scheme->subscriptions->where('subscription_period_id', '=', $subscription_period_id)->where('age_group_id', '=', ageGroup($member_age)->id)->first();

                            // Getting the currency that will be used
                            if($subscription && $subscription->currency->symbol){
                                $currency_symbol = $subscription->currency->symbol;
                            }

                            if (count($scheme_options) > count($totals)){
                                // Adding elements to an empty totals array
                                array_push($totals, $subscription ? $subscription->amount : 0);
                            }else{
                                // Changing the values of the existing elements
                                // Changing value to current element at a specific index
                                $totals[$count] = (double)$totals[$count] + (double)($subscription ? $subscription->amount : 0);
                            }

                            // Incrementing the count which is used to get the index of the element
                            $count++;
                        @endphp

                        <td style="border: 0.7px solid gray;">{{$subscription ? $subscription->currency->symbol : ''}} {{$subscription ? $subscription->amount : ''}}</td>
                    @endforeach
                </tr>
            @endforeach

            {{-- Summed up info below the details table --}}
            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="2"><br /><b>Sub Total</b></td>
                @foreach($totals as $total)
                    <td style="border:none;"><br />{{$currency_symbol}} {{$total}}</td>
                @endforeach
            </tr>

            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="2"><b>Included PIA Levy</b></td>
                @foreach($totals as $total)
                    <td style="border:none;">0</td>
                @endforeach
            </tr>

            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="2"><b>Discount</b></td>
                @foreach($totals as $total)
                    <td style="border:none;">0</td>
                @endforeach
            </tr>

            <tr style="border-bottom: 0.5px solid gray;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="2"><b>Total</b></td>
                @foreach($totals as $total)
                    <td style="border:none;"><b>{{$currency_symbol}} {{$total}}</b></td>
                @endforeach
            </tr>
        </table><br />

        <p>Payment Frequency: Annually</p>
        <p>Cover Start Date: {{$cover_start_date}}</p>
        <p>Cover Start Date: {{$cover_end_date}}</p>
        <p>Comment or Special Instructions: None</p>
        <p>To accept this quotation please click on the link below</p>
        <a href="https://google.com">Accept Quotation</a>

        @include('documents.layout.footer', ['page' => '1 of 1'])
    </div>
@endsection