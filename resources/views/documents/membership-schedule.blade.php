@extends('documents.layout.app')

@section('content')
    <style>
        .color_and_bordered_bottom{
            max-width: 211mm;
            width: 94%;
            min-height: 50px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: blanchedalmond;
            padding: 20px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>

    <div style="width: 100%;">

        @include('documents.layout.banner', ['title' => 'MEMBERSHIP SCHEDULE'])
        <p style="text-align: center;"><b>Giving insurance a human <span style="color: red;">touch</span><b></p>
        <table style="width: 100%;">
            <tr style="width: 100%;">
                <td style="width: 35%;">Member: </td>
                <td style="font-size: 16px; font-weight: bold;">{{$member->schemeOption->name}}</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;">Membership Number: </td>
                <td style="font-size: 16px; font-weight: bold;">{{$member->member_number}}</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;">Area of coverage: </td>
                @if($member->schemeOption->tier_level == 1)
                <td style="font-size: 16px;"><b>Worldwide excluding USA, Canada and South America</b><br /> Coverage within Zambia included.</td>
                @endif

                @if($member->schemeOption->tier_level != 1)
                <td style="font-size: 16px;"><b>Coverage within Zambia</b></td>
                @endif
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;">Address: </td>
                <td style="font-size: 16px;"><b>{{$member->family->physical_address}}</b></td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;">Membership Period: </td>
                <td style="font-size: 16px; font-weight: bold;">1/01/2023 - 31/01/2024</td>
            </tr>
        </table><br /><br />

        <p style="text-align: center;"><b>Benefits<b></p>
        <table style="width: 100%;">
            <tr style="width: 100%;">
                <td style="width: 35%;"><b>Upto to $4,000,000</b></td>
                <td style="font-size: 16px; font-weight: bold;">Hospitalisation, Treatment & Evacuation.</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;"><b>Repatriation of Mortal Remains</b></td>
                <td style="font-size: 16px; font-weight: bold;">Up to $25,000</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;"><b>Welness Benefit</b></td>
                <td style="font-size: 16px; font-weight: bold;">For adults only, every two years.</td>
            </tr>
        </table><br /><br />

        <table style="width: 100%;">
            <tr style="width: 100%;">
                <td style="width: 35%;">Excess Deductable</td>
                <td>Nil</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 35%;">Endorsements</td>
                <td>Nil</td>
            </tr>
        </table><br /><br />

        <div class="color_and_bordered_bottom">
            <p style="text-align: center; font-weight: bold; padding: 0; margin: 0;">For 24 hour emergency service and medical attention</p><br />

            <table style="width: 100%;">
                <tr style="width: 100%;">
                    <td style="width: 30%;">Zambia</td>
                    <td style="width: 30%;">Local</td>
                    <td style="width: 40%;">737</td>
                </tr>
                <tr style="width: 100%;">
                    <td style="width: 30%;"></td>
                    <td style="width: 30%;">International</td>
                    <td style="width: 40%;">+260 96 274 03 00 or +260 97 777 03 02</td>
                </tr>
                <tr style="width: 100%;">
                    <td style="width: 30%;">South Africa</td>
                    <td style="width: 30%;">International</td>
                    <td style="width: 40%;">+27 11 792 8796 / 0287</td>
                </tr>

                <tr style="width: 100%;">
                    <td style="width: 30%;">Email</td>
                    <td style="width: 30%;">International</td>
                    <td style="width: 40%;">iona@ses-unisure.com or kim@ses-unisure.com</td>
                </tr>
            </table><br />
            <p style="text-align: center; font-weight: bold; padding: 0; margin: 0;">For questions on your health plan, payments and extent of coverage</p>
        </div>
        @include('documents.layout.footer', ['page' => '1 of 1'])
    </div>
@endsection