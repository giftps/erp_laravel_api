@extends('documents.layout.app')

@section('content')
    <style>
        td{
            padding: 3px;
        }
    </style>

    <div>
        {{-- @php
            $renewal_quote = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/renewal_quote.png')));
            $totals = [];
            $currency_symbol = null;
        @endphp --}}

        @include('documents.layout.banner', ['title' => 'INDIVIDUAL INVOICE'])

        {{-- Top content --}}
        <table style="width: 100%">
            <tr>
                <td>
                    <br /><br />
                    <b style="margin-top: 100px;">Invoice For</b><br />
                    {{$member->first_name}} {{$member->last_name}},<br />
                    {{$member->mobile_number}},<br />
                    {{$member->email}}
                </td>

                <td style="text-align: right;">
                    <b>Date:</b> <?php echo date('d M Y'); ?><br />
                    <b>Invoice Number:</b> {{$invoice_number}}<br />
                </td>
            </tr>
        </table><br />

        {{-- Broker Details --}}
        {{-- <table style="width: 100%; border-collapse: collapse;" border="1">
            <tr>
                <td style="padding: 5px; padding-left: 10px;"><b>Broker:</b> {{$broker->first_name}} {{$broker->surname}}</td>
                <td style="padding: 5px; padding-left: 10px;"><b>Contact Number:</b> {{$broker->phone_number}}</td>
                <td style="padding: 5px; padding-left: 10px;"><b>Email:</b> {{$broker->email}}</td>
            </tr>
        </table><br /> --}}

        {{-- Quotation Price Comparisons --}}
        <table style="width: 100%; border-collapse: collapse; border-top: 1px solid gray; border-top: 1px solid gray;">
            {{-- Headers --}}
            <tr>
                <td style="border: 0.7px solid gray;"><b>Member Name</b></td>
                <td style="border: 0.7px solid gray;"><b>Age Group</b></td>
                <td style="border: 0.7px solid gray;"><b>Scheme</b></td>
                <td style="border: 0.7px solid gray;"><b>Period</b></td>
                <td style="border: 0.7px solid gray;"><b>Amount</b></td>
            </tr>

            @foreach($invoice_data as $inv)
                <tr>
                    <td style="border: 0.7px solid gray;">{{$inv['member']}}</td>
                    <td style="border: 0.7px solid gray;">{{$inv['age_group']}}</td>
                    <td style="border: 0.7px solid gray;">{{$inv['scheme']}}</td>
                    <td style="border: 0.7px solid gray;">{{$inv['period']}}</td>
                    <td style="border: 0.7px solid gray;">{{$inv['currency']}} {{$inv['amount']}}</td>
                </tr>
            @endforeach

            {{-- Summed up info below the details table --}}
            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><br /><b>Sub Total</b></td>
                <td style="border:none;"><br />USD {{$total_amount}}</td>
            </tr>

            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><b>Included PIA Levy</b></td>
                <td style="border:none;">0%</td>
            </tr>

            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><b>Discount</b></td>
                <td style="border:none;">0</td>
            </tr>

            <tr style="border-bottom: 0.5px solid gray;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><b>Total</b></td>
                <td style="border:none;"><b>USD {{$total_amount}}</b></td>
            </tr>
        </table><br />

        <table style="margin-top: 30px;">
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
                        <p>"{{$invoice_number}}"</p>
                        <p>AS PAYMENT REFERENCE</p>
                    </div>
                </td>
            </tr>
        </table><br />

        {{-- <p>Payment Frequency: Annually</p>
        <p>Cover Start Date: {{$cover_start_date}}</p>
        <p>Cover Start Date: {{$cover_end_date}}</p> --}}

        @include('documents.layout.footer', ['page' => '1 of 1'])
    </div>
@endsection