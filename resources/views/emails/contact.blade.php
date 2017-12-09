@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Thank You!',
        'level' => 'h2'
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Dear <b>{{ $firstname or '' }}</b>,</p>
    <p>Thank you for sharing your thoughts and feedback with us. We are trying so hard to deliver the best Online
        Exchange Service you wish for.</p>

    <p style="color: #999; font-size: 12px; margin:0;">Best Regards</p>
    <p style="font-size: 14px; color:#000;margin: 0;"><b style="float: left;">FANEx</b> <span style="float: right; color:#bbb; font-size: 13px;">{{ \Carbon\Carbon::now() ->format('d M Y') }}</span></p>
    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => 'Visit FANEx',
        	'link' => 'http://185.133.159.140:12801'
    ])

@stop

@section('footer')
    <table width="640" class="w640" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td class="w15" width="15"></td>
            <td class="w410" width="410">
                <table align="left">
                    <tr>
                        <td><p class="footer-text"><b>FANEx</b> International Money E-Transfer</p></td>
                    </tr>
                    <tr>
                        <td><p class="footer-text">#123, 12<sup>th</sup> Noavari Ave., Pardis Tech Park, Tehran, Iran
                            </p></td>
                    </tr>
                </table>
            </td>
            <td>
                <table align="right">
                    <tr>
                        <td><p class="footer-text"><b>Tel:</b></p></td>
                        <td><p class="footer-text">+98 21 8951 0000</p></td>
                    </tr>
                    <tr>
                        <td><p class="footer-text"><b>Email:</b></p></td>
                        <td><p class="footer-text">fanex@fanap.ir</p></td>
                    </tr>
                    <tr>
                        <td><p class="footer-text"><b>Postal Code:</b></p></td>
                        <td><p class="footer-text">19176-35514</p></td>
                    </tr>
                </table>
            </td>
            <td class="w15" width="15"></td>
        </tr>
    </table>
    <p style="color: #bbb; font-size: 11px; font-family: Tahoma; padding: 0 15px; text-align: left">This email and any files transmitted with it
        are confidential and intended solely for the use of the individual or entity to whom they are addressed.
        If you are not the intended recipient, you are notified that disclosing, copying, distributing or taking
        any action in reliance on the contents of this information is strictly prohibited,
        and therefore, please contact the sender by return the e-mail and destroy all copies of the original
        message.</p>
@stop