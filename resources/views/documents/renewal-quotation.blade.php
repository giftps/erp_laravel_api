@extends('documents.layout.app')

@section('content')
<div>
    <div class="quotation_contents">
        <p>
            <b>Account Name:</b> {{$member->first_name}} {{$member->other_names}} {{$member->last_name}}<br />
            <b>Reference:</b> {{$quotation_number}}<br />
        </p>

        <p>
            Dear Valued Member,
        </p>

        <p>
            We would like to take the chance to thank you for choosing SES. We hope that you shared a value filled and fruitful relationship with us over the last year. Our records show that your membership with SES is expiring on {{$member->family->next_renewal_date}}.
        </p>

        <p>
            To ensure that we can keep our relationship with you, kindly tender payment for the renewal of your policy. The membership renewal is not automatic, so we encourage you to please settle this as close to the renewal date as possible, so as not to fall off cover. We are under strict legal guidelines that prohibit the extension of cover to those whose accounts are not up-to-date.
        </p>

        <p>
            Additionally, SES is pleased to announce that we are now offering additional products that include Life Insurance. Please see details in the accompanying email.
        </p>

        <p>
            The renewal quotation provided below is based on the current membership you have with SES. Please take note, in order to keep meeting our promise of Healthcare with a Human Touch, and due to increases in medical inflation, our policy fees have increased for this year.
        </p>

        <p>
            All prices are based on your age. Our application form is attached. Kindly ensure that we have updated contact information for your file. Should you need clarification on the various options available to you, please feel free to call us on the telephone numbers detailed above, and the various options will be explained to you.
        </p>

        <p>
            I look forward to hearing from you in the near future and thank you for your continued support.
        </p>

        <p>
            Yours faithfully,<br />
            SES Team
        </p>
    </div>

    @include('documents.layout.footer', ['page' => '1 of 2'])

    {{-- Code for another page --}}
    <div class="page-break"></div>
    
    @include('documents.layout.banner', ['title' => 'RENEWAL QUOTE'])<br />

    <table>
        <tr>
            <td style="width: 150px; color: rgb(0, 132, 255);">Account Name</td>
            <td>Enock Soko</td>
        </tr>

        <tr>
            <td style="width: 150px; color: rgb(0, 132, 255);">Reference</td>
            <td>{{$quotation_number}}</td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; color: rgb(0, 132, 255);">Insurer</td>
            <td style="width: 50%;">SES</td>

            <td style="width: 50%; color: rgb(0, 132, 255);">Quote Number</td>
            <td style="width: 50%;">{{$quotation_number}}</td>
        </tr>

        <tr>
            <td style="width: 50%; color: rgb(0, 132, 255);">Address</td>
            <td style="width: 50%;">Corner of Kafue and <br />Mahogony Drive, Lilayi, Lusaka.</td>

            <td style="width: 50%; color: rgb(0, 132, 255);">Quote Date</td>
            <td style="width: 50%;">{{date('d-m-Y')}}</td>
        </tr>

        <tr>
            <td style="width: 50%; color: rgb(0, 132, 255);">Principal Contact</td>
            <td style="width: 50%;">memberships@ses-unisure.com</td>
        </tr>
    </table><br />

    {{-- Member and amount due table --}}
    <table border="1px" style="width: 100%;">
        <thead>
            <tr>
                <td><b>Member ID</b></td>
                <td><b>Given Name</b></td>
                <td><b>Family Name</b></td>
                <td><b>DOB</b></td>
                <td><b>Product</b></td>
                <td><b>Premium</b></td>
            </tr>
        </thead>

        <tbody>
            @php 
                $total_price = 0;
            @endphp

            @foreach($members as $member)
                @php 
                    $age = getAge($member->dob);
                    $age_group = ageGroup($age);

                    $scheme_price = getSchemePrice($year_id, $member->family->subscription_period_id, $member->scheme_option_id, $age_group->id);

                    $currency = $scheme_price->currency?->code;
                    $total_price = $total_price + $scheme_price->amount;
                @endphp

                <tr>
                    <td>{{$member->member_number}}</td>
                    <td>{{$member->first_name}} {{$member->other_names}}</td>
                    <td>{{$member->last_name}}</td>
                    <td>{{$member->dob}}</td>
                    <td>{{$member->schemeOption->name}}</td>
                    <td>{{$scheme_price->currency?->code}} {{$scheme_price->amount}}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
        
    <div style="max-width: 250px; width: 100%; float: right; margin-top: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; color: rgb(0, 132, 255);">Total Premium</td>
                <td style="width: 40%;">{{$currency}} {{$total_price}}</td>
            </tr>

            <tr>
                <td style="width: 60%; color: rgb(0, 132, 255);">Amount Due</td>
                <td style="width: 40%;">{{$currency}} {{$total_price}}</td>
            </tr>
        </table>
    </div><br /><br /><br /><br />

    {{-- Account details code --}}
    <div>
        {{-- Bank details go below --}}
        <table>
            <tr>
                <td style="width: 50%;">
                    <table>
                        <tr>
                            <td style="color: rgb(0, 132, 255);">Bank</td>
                            <td>Standard Chartered Bank</td>
                        </tr>

                        <tr>
                            <td style="color: rgb(0, 132, 255);">Sort Code</td>
                            <td>06 - 00 - 17</td>
                        </tr>

                        <tr>
                            <td style="color: rgb(0, 132, 255);">Swift Code</td>
                            <td>SCBLZMLX</td>
                        </tr>

                        <tr>
                            <td style="color: rgb(0, 132, 255);">Account Name</td>
                            <td>SPECIALTY EMERGENCY SERVICES LTD</td>
                        </tr>

                        <tr>
                            <td style="color: rgb(0, 132, 255);">Account Number (ZMW)</td>
                            <td>0100 1114 335 00</td>
                        </tr>

                        <tr>
                            <td style="color: rgb(0, 132, 255);">Account Number (USD)</td>
                            <td>8700 2114 335 00</td>
                        </tr>
                    </table>
                </td>

                <td style="width: 50%;">
                    <div style="width: 250px; border: 1px solid gray; padding: 10px; text-align: center; margin-left: 20px;">
                        <p>PLEASE QUOTE</p>
                        <p>"{{$quotation_number}}"</p>
                        <p>AS PAYMENT REFERENCE</p>
                    </div>
                </td>
            </tr>
        </table><br />

        {{-- Notes --}}
        <p style="color: red;">Please note: The member is responsible for the bank transfer fees.</p>
        <p>Please send through Proof of Payment for all Electronic Funds Transfer (EFT) to memberships@ses-unisure.com and use the reference number provided.</p>
        <p>Renewal fees are quoted in USD, as detailed above. However, payment will be accepted in Kwacha using the Standard Chartered Bank rate of the day.</p>
    </div>
    @include('documents.layout.footer', ['page' => '2 of 2'])
</div>
@endsection