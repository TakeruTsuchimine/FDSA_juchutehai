@extends('templete.header.base_header')
@section('pageTitle')
    FDSA 業務メニュー
@endsection
@section('contents')
    <form id="frmMenu" action="{{ url('/master') }}" method="POST" target="_blank">
        @csrf
        <input id="targetPage" name="targetPage" type="hidden" value="0000">
        <button name="0400" class="btn-primary" type="button" style="margin:10px;">担当者マスター</button>
        <br>
        <button name="1300" class="btn-primary" type="button" style="margin:10px;">階層分類マスター</button>
        <button name="1301" class="btn-primary" type="button" style="margin:10px;">備考マスター</button>
        <button name="1302" class="btn-primary" type="button" style="margin:10px;">不良マスター</button>
        <button name="1303" class="btn-primary" type="button" style="margin:10px;">グレードマスター</button>
        <button name="1304" class="btn-primary" type="button" style="margin:10px;">業種マスター</button>
        <button name="1305" class="btn-primary" type="button" style="margin:10px;">業態マスター</button>
        <button name="1306" class="btn-primary" type="button" style="margin:10px;">品目区分マスター</button>
        <button name="1307" class="btn-primary" type="button" style="margin:10px;">配送便マスター</button>
        <button name="1308" class="btn-primary" type="button" style="margin:10px;">色マスター</button>
        <button name="1309" class="btn-primary" type="button" style="margin:10px;">受注区分マスター</button>
        <button name="1310" class="btn-primary" type="button" style="margin:10px;">クレームマスター</button>
        <button name="1311" class="btn-primary" type="button" style="margin:10px;">メーカーマスター</button>
        <button name="1312" class="btn-primary" type="button" style="margin:10px;">見積区分マスター</button>
        <button name="1313" class="btn-primary" type="button" style="margin:10px;">納入場所マスター</button>
        <button name="1314" class="btn-primary" type="button" style="margin:10px;">仕入区分マスター</button>
        <button name="1315" class="btn-primary" type="button" style="margin:10px;">材料手配マスター</button>
        <button name="1316" class="btn-primary" type="button" style="margin:10px;">単位マスター</button>
        <br>
        {{-- 真鍋対応分 --}}
        <button name="0600" class="btn-primary" type="button" style="margin:10px;">工程マスター</button>
        <button name="1310" class="btn-primary" type="button" style="margin:10px;">業務マスター</button>
        <button name="2100" class="btn-primary" type="button" style="margin:10px;">置場・棚番マスター</button>
        <button name="2900" class="btn-primary" type="button" style="margin:10px;">シフトマスター</button>
        <button name="3100" class="btn-primary" type="button" style="margin:10px;">カレンダーマスター</button>
        <button name="6100" class="btn-primary" type="button" style="margin:10px;">メニュータブマスター</button>
        <button name="6200" class="btn-primary" type="button" style="margin:10px;">メニューマスター</button>
        <br>
        {{-- 山下対応分 --}}
        <button name="0500" class="btn-primary" type="button" style="margin:10px;">担当割付候補マスター</button>
        <button name="0900" class="btn-primary" type="button" style="margin:10px;">機械割付候補マスター</button>
        <button name="1400" class="btn-primary" type="button" style="margin:10px;">得意先マスター</button>
        <button name="1800" class="btn-primary" type="button" style="margin:10px;">仕入外注先マスター</button>
        <button name="1900" class="btn-primary" type="button" style="margin:10px;">外注先手配候補マスター</button>
        <button name="2000" class="btn-primary" type="button" style="margin:10px;">メーカーマスター</button>
        <br>
        {{-- 工藤対応分 --}}
        <button name="0100" class="btn-primary" type="button" style="margin:10px;">事業部マスター</button>
        <button name="0300" class="btn-primary" type="button" style="margin:10px;">部署マスター</button>
        <button name="0800" class="btn-primary" type="button" style="margin:10px;">機械マスター</button>
        <br>
        {{-- 土嶺対応分 --}}
        <button name="2600" class="btn-primary" type="button" style="margin:10px;">品目マスター</button>
    </form>
        <br>
        <button name="3800" class="btn-primary" type="button" style="margin:10px;">受注入力</button>
    </form>
    <script>
        $('.btn-primary').click(function(event)
        {
            $('#targetPage')[0].value = $(this)[0].name;
            $('#frmMenu').submit();
        });
    </script>
@endsection