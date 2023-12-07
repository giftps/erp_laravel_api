@extends('documents.layout.app')
@extends('documents.layout.cover')

@section('content')
    <style>
        .container{
            padding: 10px;
            margin-top: -10px;
        }
        .content{
            border-bottom: 0.5px solid rgb(190, 190, 190);
            padding-top: 10px;
            padding-bottom: 10px;
        }
        h4, h5{
            color: #2981C4;
            margin: 0px; 
            padding: 0px;
        }
        p{
            margin: 0;
            padding: 0;
            font-size: 10px;
        }
        .input_box{
            width: 20px;
            height: 20px;
            border: 0.5px solid rgb(178, 178, 178);
            padding-top: 2px;
            padding-left: 3px;
            padding-right: 3px;
        }
        table td{
            font-size: 10px;
        }
        .table, .table th, .table td {
            border: 0.5px solid rgb(184, 184, 184);
            border-collapse: collapse;
        }
        .table td{
            padding-left: 10px;
        }

        .content{
            font-size: 10px;
        }
    </style>

    <div class="container">
        @php 
            $check = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/check.png')));
        @endphp 
        <br>
        <br>
        <section>
            {{-- Second Page --}}
            <div class="content">
                <p style="margin-top: 15px; font-size:15px; color:#567ABE;" class="h">
                    <span>SCHEME ADMINISTRATOR</span>
                </p>
            </div>

            {{-- Scheme Administrator top part --}}
            <div class="content">
                <p>
                    The Scheme Administrator must be the Principle Member for Retail Clients or Group Clients, or a Company Secretary for Retail, Group and Corporate Clients. These parameters are defined as follows:
                </p>

                <ul>
                    <li>1-14 members = Retail Client</li>
                    <li>15+ members = Group Client</li>
                    <li>15+ principle members = Corporate Client</li>
                </ul>

                <p>
                    The scheme administrator must be 18 years of age or older. The scheme administrator accepts responsibility and authority to engage with the business on all aspects related to policy administration, payments, payment terms, renewals, updates, additions, and removals.
                </p>
            </div>

            {{-- Scheme Administrator application types --}}
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 100px;">New Application</td>
                        <td>
                            <div class="input_box">
                                @if($is_new_application == true)
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>

                        <td style="padding-left: 20px; min-width: 100px;">Existing Application</td>
                        <td>
                            <div class="input_box">
                                @if($is_new_application != true)
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>

                        <td style="padding-left: 20px; min-width: 200px;">Membership Number (if Existing)</td>
                        <td>
                            <div class="input_box" style="width: 233px;">
                                @if($is_new_application != true)
                                    {{$principal->member_number}}
                                @endif
                            </div>
                        </td>
                    </tr><br />

                    <tr>
                        <td>Individual Account</td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="padding-left: 20px;">Company Account</td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="padding-left: 20px;">Account Name <br /><small style="font-size: 8px;">For invoice purposes</small></td>
                        <td>
                            <div class="input_box" style="width: 313px; margin-left: -80px;">
                                {{$principal->first_name}} {{$principal->last_name}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Scheme Administrator personal details --}}
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 160px;">Title</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 50%;">
                                {{$principal->title}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name of Administrator</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->first_name}} {{$principal->other_names}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Second Name of Administrator</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->last_name}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td style="width: 100%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                        <div class="input_box" style="width: 100%; margin-left: -3px;">
                                            {{$principal->dob}}
                                        </div>
                                    </td>

                                    <td style="width: 80px; padding-left:10px">Sex at Birth</td>

                                    <td style="width: 10px;">
                                        M
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            @if($principal->gender == 'Male')
                                                <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td style="width: 10px;">
                                        F
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            @if($principal->gender == 'Female')
                                                <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td style="font-size: 10px; width: 90px;">(tick as appropriate)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width: 160px;">Nationality</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 49%;">
                                {{$family->nationality}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Scheme Administrator address --}}
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 120px;">Postal Address</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$family->postal_address}}
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 117px;"></td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Postal Code</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->postal_code}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 117px;">Telephone No:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->work_number}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Mobile No:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->mobile_number}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 117px;">Primary Email:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->email}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Secondary Email:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->email}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            {{--  --}}
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 350px;">I.D Number (can be NRC or Passport)/ Company Registration Number):</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->nrc_or_passport_no}}
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 230px;">Tax Identification Number/ TPIN Number:</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 70%;"></div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Signitory details --}}
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 117px;">Authorised Signatory:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->first_name}} {{$principal->last_name}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Date:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{explode(" ", $principal->created_at)[0]}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <p style="margin-top: 20px;">
                I understand that all fields of this application/membership upload sheet have been completed accurately in order to be considered for a medical scheme with Specialty Emergency Services. I also understand that I must notify Specialty Emergency Services of any changes in the details contained on this application form/membership upload sheet, including a change in the state of health of any person named on it, or contact information.
            </p>

            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <td style="width: 10px;">
                        Agree
                    </td>
                    <td>
                        <div class="input_box"><i class="fa fa-check-square-o" style="font-size:20px"></i></div>
                    </td>
                </tr>
            </table>

            @include('documents.layout.footer', ['page' => '2 of 8'])

            <div class="page-break"></div>
        </section>
        
        <section>
            {{-- Third Page --}}
            <br>
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">A. Your Personal Details</span>
            </div>

            <div class="" style="padding-top:9px">
                <p>
                    Please complete the following details for yourself as the main applicant.<br />
                    Skip to <b>Section B</b> if adding additional members only. Please only provide information regarding additional members in sections; <b> B,C, E & F</b>.
                </p>
            </div>
            <div class="">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 100px; max-width: 100px;">Retail Member</td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="padding-left: 20px; min-width: 100px; max-width: 100px;">Group Member</td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="padding-left: 20px; min-width: 100px;">Corporate Member</td>
                        <td>
                            <div class="input_box" style="width: 150px;"></div>
                        </td>
                        <td style="padding-left: 20px;">(tick as appropriate)</td>
                    </tr>
                </table>
            </div>

            {{-- Details --}}
            <div class="content" style="border-bottom: none !important;">
                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 160px;">Account Name</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 70%;">
                                {{$principal->first_name}} {{$principal->last_name}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width: 160px;">Title (Mr, Mrs, Ms, Other)</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 50%;">
                                {{$principal->title}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Surname</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->last_name}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name(s)</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->first_name}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td style="width: 100%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                        <div class="input_box" style="width: 100%; margin-left: -3px;">
                                            {{$principal->dob}}
                                        </div>
                                    </td>

                                    <td style="width: 180px; padding-left: 20px;">Sex at Birth (tick as appropriate)</td>

                                    <td style="width: 10px;">
                                        M
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            @if($principal->gender == 'Male')
                                                <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td style="width: 10px;">
                                        F
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            @if($principal->gender == 'Female')
                                                <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="margin:-20px">
                        <td>Nationality</td>
                        <table style="width: 100%;">
                            <td style="width: 100%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 100%;">
                                            <div class="input_box" style="width: 100%; margin-left: -5px;"></div>
                                        </td>

                                        <td style="width: 110px; padding-left: 20px;">Nrc/Passport No:</td>
                                        <td style="width: 100%;">
                                            <div class="input_box" style="width: 100%;">
                                                {{$principal->nrc_or_passport_no}}
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </table>
                    </tr>
                    <tr>
                        <td>Occupation</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$principal->occupation}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Residential Address</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;">
                                {{$family->physical_address}}
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;"></td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Postal Code</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->postal_code}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="min-width: 160px;">Postal Address</td>
                        <td style="width: 100%;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>    

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;"></td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->postal_address}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Postal Code:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->postal_code}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;">Telephone Number:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->work_number}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Mobile No:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->mobile_number}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;">Primary Email:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->email}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Secondary Email:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$principal->email}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;">Next of Kin Name:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->beneficiary_name}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Relationship:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 157px;">Next of Kin Address:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 120px; padding-left: 15px;">Next of Kin Mobile No:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;">
                                            {{$family->beneficiary_mobile_number}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%; padding-left: 5px;">Do you and/or any applicant participate in any competitive sporting activities?</td>

                        <td style="width: 10px;">
                            Yes
                        </td>
                        <td>
                            <div class="input_box">
                                @if($principal->has_sports_loading == true)
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>

                        <td style="width: 10px; padding-left: 10px;">
                            No
                        </td>
                        <td>
                            <div class="input_box">
                                @if($principal->has_sports_loading != true)
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>

                <div style="padding: 5px;">
                    <p>If yes, please give full details of any sporting activities you participate in, and how often:</p>
                    <div class="input_box" style="width: 100%; margin-top: 5px;">
                        {{$principal->sporting_activity}}
                    </div>
                </div>
                
                <div style="padding: 5px;">
                    <p>Competitive sporting activities include (but are not limited to): parachuting; gliding; paragliding; parascending; scuba diving; hang gliding; bungee jumping; polo; motor rallying and motor-cycle racing, equestrian events, or any other high risk activity.</p>
                </div>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%; padding-left: 5px;">Have you previously held a policy, or do you currently hold a policy, with Specialty Emergency Services?</td>

                        <td style="width: 10px;">
                            Yes
                        </td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="width: 10px; padding-left: 10px;">
                            No
                        </td>
                        <td>
                            <div class="input_box"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 150px;">Previous/Current Policy No:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 130px; padding-left: 15px;">Date of Expiry of Policy:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%; padding-left: 5px;">Were you excluded from any benefits as a result of a pre-existing medical condition/chronic illness?</td>

                        <td style="width: 10px;">
                            Yes
                        </td>
                        <td>
                            <div class="input_box"></div>
                        </td>

                        <td style="width: 10px; padding-left: 10px;">
                            No
                        </td>
                        <td>
                            <div class="input_box"></div>
                        </td>
                    </tr>
                </table>

                <div style="padding: 5px;">
                    <p>Please explain:</p>
                    <div class="input_box" style="width: 100%; margin-top: 5px; height: 70px;"></div>
                </div>
            </div>
            @include('documents.layout.footer', ['page' => '3 of 8'])
            <div class="page-break"></div>
        </section>
        
        <section>
            {{-- Fourth Page --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">B. Health Plan Applied For</span>
            </div>

            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Tanzanite')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        
                        <td>Tanzanite</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Amethyst+')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Amethyst+</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Silver')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Silver</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Sapphire')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Sapphire</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Amber')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Amber</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Chrome')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Chrome</td>
                    </tr><br />

                    <tr>
                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Gold+')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Gold+</td>

                        <td>
                            <div class="input_box">
                                @if($principal->schemeOption->name == 'Platinum+')
                                    <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                @endif
                            </div>
                        </td>
                        <td>Platinum+</td>

                        <td>
                            <div class="input_box"></div>
                        </td>
                        <td>Other</td>

                        <td colspan="3">
                            <div class="input_box" style="width: 150px;"></div>
                        </td>
                    </tr><br />
                </table>
                
                <div>
                    <p><b>Frequency of Premium Payment:</b></p>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <div class="input_box">
                                    @if($family->subscriptionPeriod->name == 'Annually')
                                        <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                    @endif
                                </div>
                            </td>
                            <td>1) Annually</td>
        
                            <td>
                                <div class="input_box">
                                    @if($family->subscriptionPeriod->name == 'Bi-Annually')
                                        <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                    @endif
                                </div>
                            </td>
                            <td>2) 6 Monthly</td>
        
                            <td>
                                <div class="input_box">
                                    @if($family->subscriptionPeriod->name == 'Quarterly')
                                        <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                    @endif
                                </div>
                            </td>
                            <td>3) Monthly (Online Direct Debit Only)</td>
                        </tr><br />
                    </table>
                </div>

                <div>
                    <p><b>Options:</b></p>
                    <table style="width: 50%;">
                        <tr>
                            <td>
                                <div class="input_box">
                                    @if($family->has_funeral_cash_benefit == true)
                                        <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                    @endif
                                </div>
                            </td>
                            <td>Funeral Cash Benefit</td>
        
                            <td>
                                <div class="input_box">
                                    @if($principal->has_sports_loading == true)
                                        <i class="fa fa-check-square-o" style="font-size:20px"></i>
                                    @endif
                                </div>
                            </td>
                            <td>Sports Loading</td>
                        </tr><br />
                    </table>
                </div>
            </div>

            {{-- Family Members --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">C. Family Members</span>
            </div>
            
            <div style="margin-top: 10px;">
                <p>Please enter the names and details of all dependants for whom cover is required. You may include your partner and children, up to age 18 (or up to age 25 if in full-time education - proof will be required). Children aged 18 or over who are not in full-time education must submit their own application for cover.</p>

                <table class="table" style="width: 100%; margin-top: 10px;">
                    <tr>
                        <td></td>
                        <td style="background-color: #a9d8fc; font-weight: 600;">First Name</td>
                        <td style="font-weight: 600;">Surname</td>
                        <td style="background-color: #a9d8fc; font-weight: 600;">Occupation</td>
                        <td style="font-weight: 600;">Passport No</td>
                        <td style="background-color: #a9d8fc; font-weight: 600;">Date of Birth</td>
                        <td style="font-weight: 600;">Sex at Birth</td>
                    </tr>

                    @foreach($family_members as $member)
                        <tr>
                            <td>
                                @if($member->dependent_code == '00')
                                    Main Member
                                @else 
                                    {{$member->relationship}}
                                @endif
                            </td>
                            <td style="background-color: #a9d8fc;">{{$member->first_name}}</td>
                            <td>{{$member->last_name}}</td>
                            <td style="background-color: #a9d8fc;">{{$member->occupation}}</td>
                            <td>{{$member->nrc_or_passport_no}}</td>
                            <td style="background-color: #a9d8fc;">{{$member->dob}}</td>
                            <td>{{$member->gender}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Family Members --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">D. Health Declaration</span>
            </div>

            <div>
                <p>
                    Specialty Emergency Services is not obliged to provide cover for any pre-existing or past conditions for which you have previously received medication, advice or treatment or experienced symptoms, whether the condition has been diagnosed or not, at any time before the start of your cover. A related condition is any disease, illness or injury that is caused by a pre-existing condition or result from the same underlying cause as a pre-existing condition.<br /><br />
                    Should Specialty Emergency Services accept pre-existing or past conditions, then special terms, exclusions or loading may apply, at Specialty Emergency Services’ discretion.<br /><br />
                    Should treatment for any pre-existing or related condition be required, and has not been declared on this application, or the full details disclosed, Specialty Emergency Services is not obliged to pay these associated claims.<br /><br />
                    Specialty Emergency Services has the right to refuse membership or apply special terms, exclusions or loading for any new application or renewal.<br /><br />
                    Please, therefore, take the greatest care to ensure that this application form is completed fully and accurately. If you are uncertain if any particular fact needs to be disclosed, you must include it.<br /><br />
                    If, after completing your application form, any changes occur that may affect the information provided by you on this form, such as
                    a change in your state of health or the state of health of any of your dependants, please inform Specialty Emergency Services in writing about the change. Specialty Emergency Services reserves the right to decline or accept an application with special terms, exclusions or loading on receipt of any further health information.<br /><br />
                    <b>PLEASE NOTE:</b> Failure to disclose all current and previous medical conditions on each new application or renewal, renders the Specialty Emergency Services membership void.
                </p>
            </div>
            @include('documents.layout.footer', ['page' => '4 of 8'])
            <div class="page-break"></div>
        </section>

        <section>
            {{-- Fifth Page --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">E. Medical History</span>
            </div>

            <div>
                <p>
                    This section asks for health and medical details, past and present, about the applicant/s named in section C. Please complete every question for each individual.<br />
                    If the answer to a question is yes, please give full details in section F on the next page. If you are unsure of the relevance of any details, please include them.
                </p><br />

                <p>
                    Have you ever:
                    <ul>
                        <li>Seen a GP or other health care professional?</li>
                        <li>Received treatment?</li>
                        <li>Experienced symptoms?</li>
                    </ul>
                </p>

                <table class="table" style="width: 100%">
                    <tr>
                        <td style="width: 45%;"></td>
                        <td colspan="2" style="min-width: 70px; text-align: center;">Main Member</td>
                        <td colspan="2" style="text-align: center;">Spouse</td>
                        <td colspan="2" style="text-align: center;">Dependat 1</td>
                        <td colspan="2" style="text-align: center;">Dependat 2</td>
                        <td colspan="2" style="text-align: center;">Dependat 3</td>
                        <td colspan="2" style="text-align: center;">Dependat 4</td>
                    </tr>

                    <tr>
                        <td style="width: 45%;">Name</td>
                        
                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>

                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>

                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>

                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>

                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>

                        <td style="background-color: #a9d8fc;">Yes</td>
                        <td>No</td>
                    </tr>

                    @php 
                        $count = 0;
                    @endphp

                    @foreach($medical_history_options as $medical_history_option)
                        <tr>
                            <td style="width: 45%;">{{$medical_history_option->medical_history_option_id}}) {{$medical_history_option->description}}</td>
                            
                            {{-- Main Member --}}
                            @php
                                $main_member = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '00');
                            @endphp
                            <td style="background-color: #a9d8fc;">
                                @if($main_member['has_condition'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($main_member['has_condition'] != true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>

                            {{-- Spouse --}}
                            @php 
                                $spouse = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '01');
                            @endphp

                            <td style="background-color: #a9d8fc;">
                                @if($spouse['has_condition'] == true && $spouse['is_spouse'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($spouse['has_condition'] != true && $spouse['is_spouse'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>

                            {{-- Dependent 1 --}}
                            @php 
                                $dependant1 = null;
                                if($spouse['is_spouse'] == true){
                                    $dependant1 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '02');
                                }else{
                                    $dependant1 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '01');
                                }
                            @endphp
                            <td style="background-color: #a9d8fc;">
                                @if($dependant1['has_condition'] != 'none' && $dependant1['has_condition'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($dependant1['has_condition'] != 'none' && $dependant1['has_condition'] == false)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>

                            {{-- Dependent 2 --}}
                            @php 
                                $dependant2 = null;
                                if($spouse['is_spouse'] == true){
                                    $dependant2 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '03');
                                }else{
                                    $dependant2 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '02');
                                }
                            @endphp
                            <td style="background-color: #a9d8fc;">
                                @if($dependant2['has_condition'] != 'none' && $dependant2['has_condition'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($dependant2['has_condition'] != 'none' && $dependant2['has_condition'] == false)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>

                            {{-- Dependent 3 --}}
                            @php 
                                $dependant3 = null;
                                if($spouse['is_spouse'] == true){
                                    $dependant3 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '04');
                                }else{
                                    $dependant3 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '03');
                                }
                            @endphp
                            <td style="background-color: #a9d8fc;">
                                @if($dependant3['has_condition'] != 'none' && $dependant3['has_condition'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($dependant3['has_condition'] != 'none' && $dependant3['has_condition'] == false)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>

                            {{-- Dependent 4 --}}
                            @php 
                                $dependant4 = null;
                                if($spouse['is_spouse'] == true){
                                    $dependant4 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '05');
                                }else{
                                    $dependant4 = hasMedicalConditionOptions($family, $medical_history_option->medical_history_option_id, '04');
                                }
                            @endphp
                            <td style="background-color: #a9d8fc;">
                                @if($dependant4['has_condition'] != 'none' && $dependant4['has_condition'] == true)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                            <td>
                                @if($dependant4['has_condition'] != 'none' && $dependant4['has_condition'] == false)
                                    <img src="{{$check}}" style="width: 14px; height: 14px" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>  
        
            @include('documents.layout.footer', ['page' => '5 of 8'])
            <div class="page-break"></div>
        </section>

        <section>
            {{-- Sixth Page --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">E. Medical History </span> <span style="margin-top: 15px; font-size: 15px;">(Continued)</span>
            </div>

            <table class="table" style="width: 100%; margin-top: 10px;">
                <tr>
                    <td></td>
                    <td style="background-color: #a9d8fc; font-weight: 600;">Main Member</td>
                    <td style="font-weight: 600;">Spouse</td>
                    <td style="background-color: #a9d8fc; font-weight: 600;">Dependant 1</td>
                    <td style="font-weight: 600;">Dependant 2</td>
                    <td style="background-color: #a9d8fc; font-weight: 600;">Dependant 3</td>
                    <td style="font-weight: 600;">Dependant 4</td>
                </tr>

                @php
                    $principal_member = $family_members->where('dependent_code', '=', '00')->first();
                    $spouse_details = $family_members->where('dependent_code', '=', '01')->where('relationship', '=', 'Spouse')->first();
                    $dependent1_details = null;
                    $dependent2_details = null;
                    $dependent3_details = null;
                    $dependent4_details = null;

                    if($spouse_details){
                        $dependent1_details = $family_members->where('dependent_code', '=', '02')->first();
                        $dependent2_details = $family_members->where('dependent_code', '=', '03')->first();
                        $dependent3_details = $family_members->where('dependent_code', '=', '04')->first();
                        $dependent4_details = $family_members->where('dependent_code', '=', '05')->first();
                    }else{
                        $dependent1_details = $family_members->where('dependent_code', '=', '01')->first();
                        $dependent2_details = $family_members->where('dependent_code', '=', '02')->first();
                        $dependent3_details = $family_members->where('dependent_code', '=', '03')->first();
                        $dependent4_details = $family_members->where('dependent_code', '=', '04')->first();
                    }
                @endphp 

                <tr>
                    <td>Height (cm)</td>
                    <td style="background-color: #a9d8fc;">{{$principal_member?->height}}</td>
                    <td>{{$spouse_details?->height}}</td>
                    <td style="background-color: #a9d8fc;">{{$dependent1_details?->height}}</td>
                    <td>{{$dependent2_details?->height}}</td>
                    <td style="background-color: #a9d8fc;">{{$dependent3_details?->height}}</td>
                    <td>{{$dependent4_details?->height}}</td>
                </tr>

                <tr>
                    <td>Weight (kg)</td>
                    <td style="background-color: #a9d8fc;">{{$principal_member?->weight}}</td>
                    <td>{{$spouse_details?->weight}}</td>
                    <td style="background-color: #a9d8fc;">{{$dependent1_details?->weight}}</td>
                    <td>{{$dependent2_details?->weight}}</td>
                    <td style="background-color: #a9d8fc;">{{$dependent3_details?->weight}}</td>
                    <td>{{$dependent4_details?->weight}}</td>
                </tr>

                <tr>
                    <td style="max-width: 200px;">Alcohol Consumption/Week 1unit = 1 Tot/Small Glass of wine/1 Bottle Beer</td>
                    <td style="background-color: #a9d8fc;"></td>
                    <td></td>
                    <td style="background-color: #a9d8fc;"></td>
                    <td></td>
                    <td style="background-color: #a9d8fc;"></td>
                    <td></td>
                </tr>
            </table>

            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">F. Additional Information</span>
            </div>

            <p>If you have answered YES to any questions, please give full details below. Please continue on a separate sheet if necessary.</p>
            @foreach([0, 1, 2] as $num)
                <div class="content">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 20%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td>Question No:</td>
                                        <td style="width: 30%;">
                                            <div class="input_box" style="width: 100%;"></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width: 80%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="min-width: 250px; padding-left: 15px;">Name of person who suffered the illness/injury:</td>
                                        <td style="width: 100%; padding-right: 0px;">
                                            <div class="input_box" style="width: 100%;"></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 250px;">Date(s) on which the illness/injury occurred:</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 80px;">Diagnosis</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 350px;">Treatment/test performed and results (please attach medical report):</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 350px;">Date you last suffered symptoms or received treatment relating to this condition:</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 250px;">Name and contact details of treating physician:</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 450px;">Give details of any foreseeable need for further consultation or treatment for this condition:</td>
                            <td style="width: 100%; padding-right: 0px;">
                                <div class="input_box" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach

            @include('documents.layout.footer', ['page' => '6 of 8'])
            <div class="page-break"></div>
        </section>

        <section>
            <br>
             {{-- Seventh Page --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">F. Additional Information</span> <span style="margin-top: 15px; font-size: 15px;">(Continued)</span>
            </div>

            <div class="content">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 20%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>Question No:</td>
                                    <td style="width: 30%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 80%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 250px; padding-left: 15px;">Name of person who suffered the illness/injury:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 250px;">Date(s) on which the illness/injury occurred:</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 80px;">Diagnosis</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 350px;">Treatment/test performed and results (please attach medical report):</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 350px;">Date you last suffered symptoms or received treatment relating to this condition:</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 250px;">Name and contact details of treating physician:</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 450px;">Give details of any foreseeable need for further consultation or treatment for this condition:</td>
                        <td style="width: 100%; padding-right: 0px;">
                            <div class="input_box" style="width: 100%;"></div>
                        </td>
                    </tr>
                </table>
            </div>

            <p style="margin-top: 10px;">Please give details of the doctor who is most familiar with the medical history of each person named in this application</p>
            @foreach([0, 1, 2, 3, 4] as $num)
            <div class="content" style="margin-left: -7px;">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 100px;">Name of Doctor:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>Tel:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 100px;">Email:</td>
                                    <td style="width: 100%;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="min-width: 130px;">Length of Treatment:</td>
                                    <td style="width: 100%; padding-right: 0px;">
                                        <div class="input_box" style="width: 100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach

            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">G. Disclosure by Applicant</span>
            </div>

            <p>
                I have made full and complete disclosure about the medical history of each person included on this application and fully understand that pre-existing conditions will not be covered by this policy.<br />
                To the best of my knowledge and belief, each person included on this application is in good physical health and free from physical defect or infirmity except where the condition has been disclosed herein on the medical questionnaire.<br />
                I am not aware of any reason for the above cover to be cancelled or curtailed and I have not withheld any material facts. I understand that non-disclosure or misinterpretation of material fact will entitle the underwriters to void this policy.
            </p>

            <table style="width: 100%; margin-left: -7px; margin-top: 10px;">
                <tr>
                    <td style="width: 50%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>Signed:</td>
                                <td style="width: 100%;">
                                    <div class="input_box" style="width: 100%;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td style="width: 50%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>Date:</td>
                                <td style="width: 100%; padding-right: 0px;">
                                    <div class="input_box" style="width: 100%;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <p style="margin-top: 10px;">
                *Please supply passport copies for all individuals included in this application form. (Not necessary for Tanzanite+ & Amethyst+ or where applicable)
            </p>

            @include('documents.layout.footer', ['page' => '7 of 8'])
            <div class="page-break"></div>
        </section>

        <section>
        {{-- Eighth Page --}}
            <div class="content">
                <span style="margin-top: 15px; font-size: 15px; color:#567ABE">H. Legal Declaration</span>
            </div>

            <p>
                I hereby apply for cover on behalf of all the persons named on this application form for the Specialty Emergency Services Health Plan specified above. I declare that I have read and understood the Health Plan Terms and Conditions, and that I am aware that cover shall be provided in accordance with the Terms and Conditions, and that pre-existing conditions will not be covered by this Health Plan.<br /><br />
                I understand that all fields of this application must be completed in order to be considered for a medical scheme with Specialty Emergency Services. I also understand that I must notify Specialty Emergency Services of any changes in the details contained on this application form, including a change in the state of health of any person named on it, or contact information.<br /><br />
                I authorise any doctor who has ever treated or advised any persons named on this application to provide Specialty Emergency Services with information they may require in connection with treatment related to any claim under the above plan. I, and all those named in this application, understand that in order to assess my claim, Specialty Emergency Services may need to obtain details of my medical history.<br /><br />
                I, and all those named in this application, hereby authorise any physician, healthcare professional, hospital, clinic and other healthcare institution to disclose to Specialty Emergency Services, to the extent allowed by applicable law, any information concerning the medical history, services, supplies or treatment provided to anyone listed in this application. I understand that Specialty Emergency Services may rely on this information to administer my policy and claims and to determine policy coverage according to applicable laws and regulations.<br /><br />
                I understand that Specialty Emergency Services will hold and process my personal data for the purpose of processing my Health Plan, processing any claims submitted under my Health Plan and providing other related services, which may include sharing my personal data with doctors and other medical professionals involved in my treatment or care (or the treatment or care of the persons insured on my policy). I understand that this may include the transfer of personal data to countries outside of Zambia and in signing this form I consent to such transfer and use. SES employees are bound by patient confidentiality and data protection processes.<br /><br />
                I understand that on receipt of my Health Plan documents, if I am not entirely satisfied, I can cancel this application and receive a full refund of the premium I have paid minus an administration fee, provided that I have not submitted any claim and that I return my documents to the company within 30 days of the start of the plan.<br /><br />
                I declare that, I have been provided with a copy of the cover Terms and Conditions which I have read for myself and on behalf of the persons insured on my policy. I understand that this Health Plan starts from the date of the cover and, therefore, no refund of premium will be allowed after 30 days if this cover is cancelled. I understand that an excess is deductible for each international claim I make on my Health Plan Policy, and that Specialty Emergency Services has the right to collect the excess.<br /><br />
                I declare that, to the best of my knowledge and belief, all the information I have given on this application form is true and complete and that I have confirmed the family details with the respective family members, and that, in the event of fraud or suspected fraud, my Health Policy will be annulled immediately by Specialty Emergency Services, and my personal data may be disclosed to other parties, including, but not limited to, the appropriate law enforcement agencies.<br /><br />
                I understand that Specialty Emergency Services will give me reasonable notice on renewal and premiums which may vary each year.<br /><br />
                I understand that Specialty Emergency Services cannot be liable if my cover has lapsed should the credit/debit card be declined and if I do not respond to requests for alternative methods of payment.<br /><br />
                I agree that I will inform Specialty Emergency Services if any of the details given on this application form change.
            </p>

            <table style="width: 100%; margin-left: -7px; margin-top: 10px;">
                <tr>
                    <td style="width: 50%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>Signed:</td>
                                <td style="width: 100%;">
                                    <div class="input_box" style="width: 100%;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td style="width: 50%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>Date:</td>
                                <td style="width: 100%; padding-right: 0px;">
                                    <div class="input_box" style="width: 100%;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            @include('documents.layout.footer', ['page' => '8 of 8'])
        </section>
    </div>
@endsection