@php
$image = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/logo.png')));
@endphp

<div class="header_content_container" style="padding-top:20px; padding-left:30px; padding-right:30px">


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
</div>