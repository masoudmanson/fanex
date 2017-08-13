@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Thank You!',
        'level' => 'h2'
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Dear <b>{{ $senderName or '' }}</b>,</p>
    <p>Thank you for sharing your thoughts and feedback with us. We are trying so hard to deliver the best Online Exchange Service you wish for.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => 'Click me',
        	'link' => 'http://google.com'
    ])

@stop