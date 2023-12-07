@extends('documents.layout.app')

@section('content')
<style>
    td {
        padding: 3px;
    }

    strong {
        font-family: CenturyGothic !important;
    }

    p {
        font-size: 12px;
        padding: 7px
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
    $scheme = $scheme_options[0];

    $cover_start_date = date('Y-m-d');
    $cover_end_date = date('Y-m-d');
    @endphp
    @php
    $image = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/logo.png')));
    @endphp
    {{-- Top content --}}
    <section>
        @extends('documents.layout.header')

        <div>
            <span>Account Name:</span> {{$members->where('dependent_code', '=', '00')->first()->first_name}} {{$members->where('dependent_code', '=', '00')->first()->last_name}}
            <div><span>Reference:</span> 1003150</div>
        </div>
        <br />


        <div>
            <p>Dear Valued Member,</p>

            <p>We would like to take the chance to thank you for choosing SES. We hope that you shared a value filled and fruitful
                relationship with us over the last year. Our records show that your membership with SES is expiring on 2023-10-31.</p>

            <p>To ensure that we can keep our relationship with you, kindly tender payment for the renewal of your policy. The
                membership renewal is not automatic, so we encourage you to please settle this as close to the renewal date as possible,
                so as not to fall off cover. We are under strict legal guidelines that prohibit the extension of cover to those whose accounts
                are not up-to-date.</p>

            <p>Additionally, SES is pleased to announce that we are now offering additional products that include Life Insurance. Please
                see details in the accompanying email.</p>

            <p>The renewal quotation provided below is based on the current membership you have with SES. Please take note, in order
                to keep meeting our promise of Healthcare with a Human Touch, and due to increases in medical inflation, our policy fees
                have increased for this year.</p>

            <p>All prices are based on your age. Our application form is attached. Kindly ensure that we have updated contact
                information for your file. Should you need clarification on the various options available to you, please feel free to call us on
                the telephone numbers detailed above, and the various options will be explained to you.</p>

            <p>I look forward to hearing from you in the near future and thank you for your continued support.</p>

            <p>Yours faithfully,</p>

            <p>SES Team</p>
        </div>

        @include('documents.layout.footer', ['page' => '1 of 2'])
    </section>

    <section>
        <div style="float: right;">
            <p style="font-size: 10px; text-align: right; ">
                <span style="color: #2981C4;">Lusaka</span> PO Box 30337, Lusaka, Zambia | Corner of Kafue Road and Mahogony Drive, Lilayi, Lusaka<br />
                <span style="color: #2981C4;">Kitwe</span> PO Box 20324, Kitwe, Zambia | 6127 Zambezi Way, Riverside, Kitwe<br />
                <span style="color: #2981C4;">South Africa</span> 139 Greenway, Impello Office, 3rd Floor, Greenside, Randburg, Johannesburg 2198<br />
                <span style="color: #2981C4;">Website</span> www.ses-unisure.com | <span style="color: #2981C4;">Tel</span> +260 967 770 304 | +27 87 057 0661<br />
            </p>
        </div>

        <div style="max-width: 150px; margin-top: 10px;">
            <img src="{{$image}}" style="object-fit: fill;" />
        </div>
        <table style="width: 100%">

            <tr>
                <td>
                    <br /><br />
                    <span style="margin-top: 100px; font-family:CenturyGothic">Quotation For</span><br />
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

        @include('documents.layout.footer', ['page' => '2 of 2'])

    </section>
</div>
@endsection