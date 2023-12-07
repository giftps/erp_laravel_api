<style>
    .trees{
        position: fixed;
        bottom: 65px;
        right: 10px;
        max-width: 200px;
    }
</style>

<div>
    @php
        $trees = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/Unisure-Trees.png')));
    @endphp

    <div class="trees">
        <img src={{$trees}} alt="" style="width: 100%;" />
    </div>

    <div class="footer">
        @php
            $unisure = "data:image/png;base64," . base64_encode(file_get_contents(public_path('/images/unisure.png')));
        @endphp

        <table style="width: 100%;">
                <tr>
                    <td style="width: 20%; text-align: center;">
                        <img src={{$unisure}} alt="" style="width: 100%;" />
                        <small style="font-size: 12px;">A <b>Unisure Group</b> Company</small>
                    </td>
                    <td style="width: 60%; text-align: center;">{{$page}}</td>
                    <td style="width: 20%; text-align: right;"><br /><br />www.ses-unisure.com</td>
                </tr>
        </table>
    </div>
</div>