@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart', ['logo' => '/css/images/favicon.png'])

    <h4 class="secondary"><strong>Hello</strong></h4>
    <p>This is a test</p>

    @include('beautymail::templates.widgets.articleEnd')


    @include('beautymail::templates.widgets.newfeatureStart')

    <h4 class="secondary"><strong>Hello World again</strong></h4>
    <p>This is another test</p>

    @include('beautymail::templates.widgets.newfeatureEnd')

@stop