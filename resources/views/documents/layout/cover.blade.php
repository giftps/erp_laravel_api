<style>
    .left {
        width: 10%;
        background: #DF1E26;
        transform: skew(-30deg);
        padding: 7px;
    }

    .middle {
        width: 80%;
        background-color: #3D464A;
        transform: skew(-30deg);
        text-align: center;
        color: white;
        text-transform: uppercase;
        padding: 5px;
    }
</style>

<!-- <div style="margin: 0px; overflow: hidden;">
    <div style="margin-right: -30px; margin-left: -30px;">
        <table style="width:100%; margin-top: 15px;">
            <tr>
                <td class="left"></td>
                <td class="middle">
                    <span style="text-align: center; transform: skew(30deg); margin">Application Form</span>
                </td>
                <td style="width: 10%; background-color: #2981C4; transform: skew(-30deg); padding: 3px;"></td>
            </tr>
        </table>
    </div>
</div> -->
@php
$coverImg = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/ses-cover.png')));
@endphp
<div style="">
    <section>
        {{-- Second Page --}}
        <div class="content">
            <div>
                <div style="padding-top: 120px">
                    <img src="{{ $coverImg }}" alt="" style="width: 100%; height: 550px" />
                </div>
                <p style="padding:20px; margin-top: 15px; font-size:35px;" class="h">
                    <span>APPLICATION FORM</span><br>
                    <span style="color:#567ABE;">{{ date('Y') }}</span>
                </p>
            </div>
        </div>



        @include('documents.layout.footer', ['page' => '2 of 8'])

        <div class="page-break"></div>
    </section>
</div>