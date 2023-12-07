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

        @include('documents.layout.banner', ['title' => 'RECEIPT'])

        {{-- Top content --}}
        <table style="width: 100%">
            <tr>
                <td>
                    <br /><br />
                    <b style="margin-top: 100px;">Receipt For</b><br />
                    {{$member->first_name}} {{$member->last_name}},<br />
                    {{$member->mobile_number}},<br />
                    {{$member->email}}
                </td>

                <td style="text-align: right;">
                    <b>Date:</b> <?php echo date('d M Y'); ?><br />
                    <b>Receipt Number:</b> {{$receipt_number}}<br />
                </td>
            </tr>
        </table><br />

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

            @foreach($receipt_data as $receipt)
                <tr>
                    <td style="border: 0.7px solid gray;">{{$receipt['member']}}</td>
                    <td style="border: 0.7px solid gray;">{{$receipt['age_group']}}</td>
                    <td style="border: 0.7px solid gray;">{{$receipt['scheme']}}</td>
                    <td style="border: 0.7px solid gray;">{{$receipt['period']}}</td>
                    <td style="border: 0.7px solid gray;">{{$receipt['currency']}} {{$receipt['amount']}}</td>
                </tr>
            @endforeach

            {{-- Summed up info below the details table --}}
            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><br /><b>Sub Total</b></td>
                <td style="border:none;"><br />USD {{$total_amount}}</td>
            </tr>

            <tr style="border:none;">
                <td style="border:none; text-align: right; padding-right: 20px;" colspan="4"><b>Included PIA Levy</b></td>
                <td style="border:none;">0</td>
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

        {{-- <p>Payment Frequency: Annually</p>
        <p>Cover Start Date: {{$cover_start_date}}</p>
        <p>Cover Start Date: {{$cover_end_date}}</p> --}}

        @include('documents.layout.footer', ['page' => '1 of 1'])
    </div>
@endsection