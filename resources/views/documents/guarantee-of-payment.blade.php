@extends('documents.layout.app')

@section('content')
    @include('documents.layout.banner', ['title' => 'LETTER OF GUARANTEE'])

    <br />
    {{-- Authorisation Details  --}}
    <table style="width: 100%;">
        <td style="width: 50%;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%; text-align: right;">Authorisation No.</td>
                    <td style="width: 65%; border: 0.5px solid gray;">{{$preauthorisation->auth_code}}</td>
                </tr>
            </table>
        </td>

        <td style="width: 50%; padding-left: 20px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%; text-align: right;">Authorisation Date</td>
                    <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{$date}}</td>
                </tr>
            </table>
        </td>
    </table><br />

    {{-- Patient Details --}}
    <h4 style="color: #2981C4; text-align: center; margin-top: 10px;">PATIENT DETAILS</h4>
    <table style="width: 100%;">
        <td style="width: 50%;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%; text-align: right;">First Name</td>
                    <td style="width: 65%; border: 0.5px solid gray;">{{$member->first_name}}</td>
                </tr>
                <tr>
                    <td style="width: 35%; text-align: right;">Date of birth</td>
                    <td style="width: 65%; border: 0.5px solid gray;">{{$member->dob}}</td>
                </tr>
                <tr>
                    <td style="width: 35%; text-align: right;">email</td>
                    <td style="width: 65%; border: 0.5px solid gray;">{{$member->email}}</td>
                </tr>
            </table>
        </td>

        <td style="width: 50%; padding-left: 20px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%; text-align: right;">Surname</td>
                    <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{$member->last_name}}</td>
                </tr>
                <tr>
                    <td style="width: 35%; text-align: right;">Membership No.</td>
                    <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{$member->member_number}}</td>
                </tr>
                <tr>
                    <td style="width: 35%; text-align: right;">Tel</td>
                    <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{$member->mobile_number}}</td>
                </tr>
                <tr>
                    <td style="width: 35%; text-align: right;">Health Plan</td>
                    <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{strtoupper($member->schemeOption->name)}}</td>
                </tr>
            </table>
        </td>
    </table>

    {{-- International Appointment details --}}
    @if($is_international === true)
        <h4 style="color: #2981C4; text-align: center; margin-top: 10px;">APPOINTMENT DETAILS</h4>
        <table style="width: 100%;">
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 35%; text-align: right;">Date of Appointment</td>
                        <td style="width: 65%; border: 0.5px solid gray;">{{$preauthorisation->appointment_date}}</td>
                    </tr>
                    <tr>
                        <td style="width: 35%; text-align: right;">Treating Doctor</td>
                        <td style="width: 65%; border: 0.5px solid gray;">{{strtoupper($service_provider->provider_name)}}</td>
                    </tr>
                    <tr>
                        <td style="width: 35%; text-align: right;">Facility Address</td>
                        <td style="width: 65%; border: 0.5px solid gray;">{{strtoupper($service_provider->contact_physical_address)}}</td>
                    </tr>
                </table>
            </td>

            <td style="width: 50%; padding-left: 20px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 35%; text-align: right;">Treating Facility</td>
                        <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{strtoupper($service_provider->provider_name)}}</td>
                    </tr>
                    <tr>
                        <td style="width: 35%; text-align: right;">Diagnosis Code</td>
                        <td style="width: 65%; border: 0.5px solid gray; height: 10px;">{{strtoupper($preauthorisation->diagnosis)}}</td>
                    </tr>
                </table>
            </td>
        </table>
    @endif

    @if($is_international === false)
    {{-- Local Appointment Details --}}
    <table style="width: 100%;">
        <tr>
            <td style="width: 17.5%; text-align: right;">Treating Doctor</td>
            <td style="width: 82.5%; border: 0.5px solid gray;">{{strtoupper($service_provider->provider_name)}}</td>
        </tr>
        {{-- <tr>
            <td style="width: 17.5%; text-align: right;">Service Requested</td>
            <td style="width: 82.5%; border: 0.5px solid gray;">{{strtoupper($preauthorisation->claim->description)}}</td>
        </tr> --}}
        <tr>
            <td style="width: 17.5%; text-align: right;">Exclusions</td>
            <td style="width: 82.5%; border: 0.5px solid gray;"></td>
        </tr>
    </table>
    @endif
    <hr style="border: none; height: 0.5px; color: gray; background-color: gray;" />

    @if($is_international === true)
        <p>
            <b><u>Inclusive of the following Services Provided:</u></b><br />
            SES Assistance (PTY) Ltd ("SES") hereby stands guarantee in the amount of {{$currency}} {{$total_amount}} consolidated for all reasonable and necessary medical expenses relating to the above medical condition from the authorisation date.This letter serves for the treating doctor mentioned only, any additional health care providers must obtain their own authorisation to ensure the necessary approvals.<br /><br />
            Every claim submitted to SES in respect of the rendering of a relevant health service, must be accompanied by an itemised account or statement containing at least the following information: The name, membership number and health plan of the member, the name and practice number of the practitioner, the date of services rendered, the relevant diagnostic and procedure codes as required by SES, the total amount charged for services rendered and the practitioner's banking details.<br /><br />
            SES may, at its discretion and based on justifiable reason, reject part of or all claims in respect of services obtained from a provider where it can be shown on probable cause that such provider has rendered services not medically necessary, including but not limited to financial risk such as fraud, irregular billing and code abuse.<br /><br />
            SES shall not be obliged to pay any cost related to high Body Mass Index (BMI) charges.These additional charges will be the member's responsibility.<br /><br />
            For benefit confirmation and any other information please contact us on <span style="color: #2981C4;">internationalclaims@ses-unisure.com.</span>. All claims should be submitted within 3 months from the last service date. Any claims received after the 3-month period will not be considered for reimbursement.<br /><br />
            Please send all case management updates and medical reports to <span style="color: #2981C4;">casemanagement@ses-unisure.com</span> Payments will be made within fifteen days upon receipt of accounts.<br /><br />
            Kind regards,<br />
            SES ASSISTANCE (PTY) Ltd
        </p>
    @endif
    
    @if($is_international !== true)
        <p>
            SES hereby stands guarantee of payment for the above-mentioned patient for reasonable and necessary medical expenses related to the above medical condition from the authorisation date. We undertake to ensure that all related costs will be paid within 30 days upon receipt of your original Invoice. Claims can also be emailed to <span style="color: #2981C4;">claims@ses-unisure.com.</span>
        </p>

        <p>
            Please see details below that relate to this authorisation(Authisation no.). Please note this guarantee of payment is only for the below services authorised, and that each service is limited to a specific amount. Any costs that exceed the service limit require further authorisation. Any additional services will require further authorisation.
        </p>

        @if($services && count($services) > 0)
            {{-- Service Details --}}
            <table style="width: 100%; border-collapse:collapse;" border="1">
                <tr>
                    <td style="font-weight: 600;">Service Requested</td>
                    <td style="font-weight: 600;">Service Amount</td>
                </tr>

                @foreach($services as $service)
                    <tr>
                        <td>{{$service['attributes']['description']}}</td>
                        <td>{{$service['attributes']['currency']}} {{$service['attributes']['amount']}}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    @endif
    
    @if($is_international === false)
        @include('documents.layout.footer', ['page' => '1 of 2'])
    @endif

    @if($is_international === true)
        @include('documents.layout.footer', ['page' => '1 of 1'])
    @endif
    
    @if($is_international === false)
        <div class="page-break"></div>

        @include('documents.layout.app')
        <p>
            <b>Notes:</b><br />
            Every claim submitted to SES, in respect of the rendering of a relevant health service must be accompanied by an itemised invoice containing the following information: The name, membership number and health plan of the member, the facility and treating practitioner's name, the date of services rendered, the relevant treatment information and diagnosis, as required by SES, and the total amount charged for services rendered.<br /><br />
            Only services listed on the guarantee of payment will be considered for payment up to the amount set out on the guarantee of payment.<br /><br />
            All planned/high cost procedures will need to be pre-approved by SES at least 48 hours before the procedure. Planned procedures include all surgical procedures, normal or caesarean delivery (Excluding Emergencies), MRI/CT scans, scopes and dental procedures. For pre-approval of planned/high cost procedures, please submit the completed planned/high cost application to <span style="color: #2981C4;">preauthorisations@ses-unisure.com</span> at least 48 hours before the procedure.<br /><br />
            SES requires the details of any pathology test performed to be listed on the claim. Only pathology tests deemed medically necessary will be paid by SES. SES reserves the right to request supporting documentation to determine if the tests performed were deemed medically necessary.<br /><br />
            SES requires any prescription medication dispensed to be listed on the claim.<br /><br />
            SES may, at its discretion and based on justifiable reason, reject part of or all claims in respect of services obtained from a provider where it can be shown on probable cause that such provider has rendered services not medically necessary, including but not limited to, financial risk such as fraud, irregular billing and the abuse of a member's benefits.<br /><br />
            SES shall not be obliged to pay for any treatment, procedures, tests and medications that are excluded from the member's health plan. These additional charges will be the member's responsibility.<br /><br />
            For benefit confirmation, exclusions and any other information please, contact us on 737 or email <span style="color: #2981C4;">preauthorisations@ses-unisure.com</span>. Please be advised that accounts received more than 4 months after the treatment date will not be considered for payment.<br /><br />
            We thank you for your kind cooperation in this matter and look forward to receiving your invoices as soon as possible.<br /><br />
            <b>Yours sincerely,<br /> SES Claims</b>
        </p>

        @include('documents.layout.footer', ['page' => '2 of 2'])
    @endif
@endsection