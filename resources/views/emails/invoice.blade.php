@extends('beautymail::templates.sunny')

@section('content')
    @if($transaction_status)
        @include ('beautymail::templates.sunny.heading' , [
            'heading' => 'Transaction was Successful',
            'level' => 'h2'
        ])
    @else
        @include ('beautymail::templates.sunny.heading' , [
            'heading' => 'Transaction Failed!',
            'level' => 'h2'
        ])
    @endif

    @include('beautymail::templates.sunny.contentStart')
        <p>Dear <b>{{ $firstname or '' }}</b>,</p>
        <p>Here is your transaction status:</p>

        <p>Thank you for using FANEx to send money to <b>{{ $transaction->beneficiary->firstname . ' ' . $transaction->beneficiary->lastname }}</b></p>
    <br><br>
        <table border="0" cellpadding="0" cellspacing="0" class="w510" width="510">
            <tr style="border-bottom: solid 1px #ddd;">
                <td><p style="color:#999; font-weight: 500;">Item</p></td>
                <td><p style="color:#999; font-weight: 500;">Cost</p></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <td><p style="color:#999;">Premium Amount:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ number_format($transaction->premium_amount, 2) . ' ' . $transaction->currency }}</p></td>
            </tr>
            <tr>
                <td><p style="color:#999;">Expense:</p></td>
                <td><p style="color:#222; font-weight: 500;">0 Rials</p></td>
            </tr>
            <tr style="border-bottom: solid 1px #ddd;">
                <td><p style="color:#999;">Tax:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ number_format($invoice_result->vat) }} Rials</p></td>
            </tr>

            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>

            <tr style="border-bottom: solid 1px #ddd;">
                <td><p style="color:#999;">Sum:</p></td>
                <td>
                    <p>{{ number_format($transaction->premium_amount, 2) . ' ' . $transaction->currency . ' + &rlm;' . number_format($invoice_result->vat) }} @lang('index.formRials')</p>
                    <p style="color:#999;"> = {{ number_format($invoice_result->payableAmount) }} @lang('payment.invRials')</p></td>
            </tr>

            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>

            <tr>
                <td><p style="color:#999;">Transaction Reference No.:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ $transaction->uri }}</p></td>
            </tr>
            <tr>
                <td><p style="color:#999;">Bank Payment Status:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ $transaction->bank_status }}</p></td>
            </tr>
            <tr>
                <td><p style="color:#999;">Fanex Payment Status:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ $transaction->fanex_status }}</p></td>
            </tr>
            <tr>
                <td><p style="color:#999;">Transference Status:</p></td>
                <td><p style="color:#222; font-weight: 500;">{{ $transaction->upt_status }}</p></td>
            </tr>
        </table>
    <br><br>

        <p style="color: #999; font-size: 12px; margin:0;">Best Regards</p>
        <p style="font-size: 14px; color:#000;margin: 0;"><b style="float: left;">FANEx</b> <span style="float: right; color:#bbb; font-size: 13px;">{{ \Carbon\Carbon::now() ->format('d M Y') }}</span></p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        'title' => 'Visit My Transactions',
        'link' => 'http://185.133.159.140:12801/profile'
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