<style>
    .left{
        width: 10%;
        background: #DF1E26;
        transform: skew(-30deg);
        padding: 7px;
    }
    .middle{
        width: 80%; 
        background-color: #3D464A; 
        transform: skew(-30deg); 
        text-align: center; 
        color: white; 
        text-transform: uppercase; 
        padding: 5px;
    }
</style>

<div style="margin: 0px; overflow: hidden;">
    <div style="margin-right: -30px; margin-left: -30px;">
        <table style="width:100%; margin-top: 15px;">
            <tr>
                <td class="left"></td>
                <td class="middle">
                    <span style="text-align: center; transform: skew(30deg); margin">{{$title}}</span>
                </td>
                <td style="width: 10%; background-color: #2981C4; transform: skew(-30deg); padding: 3px;"></td>
            </tr>
        </table>
    </div>
</div>