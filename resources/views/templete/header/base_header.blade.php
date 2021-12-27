{{-- PHP処理 --}}
<?php
    // 「systemName」が送信されていなければ空白を設定
    if(!isset($systemName)) $systemName = '';
    // 「loginmName」が送信されていなければ空白を設定
    if(!isset($loginName)) $loginName = '';
    // 「pageTitle」が送信されていなければ空白を設定
    if(!isset($pageTitle)) $pageTitle = '';
?>
@extends('templete.base')
@section('pageTitle')
    {{ $pageTitle }}
@endsection
@push('css')
    @stack('css')
@endpush
@push('javascript')
    @stack('javascript')
@endpush
<header>
        <div class="flex-box flex-start flex-wrap">
            {{-- メインタイトル --}}
            {{-- $systemNameに値がある場合は表示 --}}
            @if($systemName)
                <div class="logo flex-box flex-center">
                    <span class="logo-title">{{ $systemName }}</span>
                </div>
            @endif
            {{-- ページタイトル --}}
            {{-- $pageTitleに値がある場合は表示 --}}
            @if($pageTitle)
                <h2 style="margin: 0;">{{ $pageTitle }}</h2>
            @endif
            {{-- ログイン者名 --}}
            {{-- $loginNameに値がある場合は表示 --}}
            @if($loginName)
                <div class="main-color-front flex-right">
                    <i class="fas fa-user-alt fa-2x" style="margin-right:5px;"></i>{{ $loginName }}
                </div>
            @endif
        </div>
    </header>
@section('contents')
@yield('contents')
@endsection
