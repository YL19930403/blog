@extends('layouts.app')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
    <p>laravel学院致力于提供优质laravel学习资源, 自定义时间指令: @datetime(1508888888) </p>
@endsection

@section('content')
    <p>你好， {{ $name or '清华大学'}}, 现在的时间：{{ date('Y-m-d H:i:s', time()) }}</p>
    @env('local')
        The application is in the local environment...
    @else
        The application is not in the local environment...
    @endenv
@endsection

@component('alert', ['foo' => 'timo.peng'])
    @slot('title')
        Forbitten
    @endslot

    You are not allowed to access this resource!
@endcomponent



