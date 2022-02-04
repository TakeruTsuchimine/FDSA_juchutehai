<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'App\Http\Controllers\MainViewController@index');
Route::post('/master', 'App\Http\Controllers\MasterViewController@index');
Route::get('/menu', function () {
    return view('/menu/index');
});


/*マスターデータ*/
Route::post('/master/0100', 'App\Http\Controllers\Master\PCMST_0100@index');
Route::post('/master/0101', 'App\Http\Controllers\Master\PCMST_0101@index');
Route::post('/master/0300', 'App\Http\Controllers\Master\PCMST_0300@index');
Route::post('/master/0301', 'App\Http\Controllers\Master\PCMST_0301@index');
Route::post('/master/0400', 'App\Http\Controllers\Master\PCMST_0400@index');
Route::post('/master/0401', 'App\Http\Controllers\Master\PCMST_0401@index');
Route::post('/master/1200', 'App\Http\Controllers\Master\PCMST_1200@index');
Route::post('/master/1300', 'App\Http\Controllers\Master\PCMST_1300@index');
Route::post('/master/1301', 'App\Http\Controllers\Master\PCMST_1301@index');

//工程マスター
Route::post('/master/0600', 'App\Http\Controllers\Master\PCMST_0600@index');
Route::post('/master/0601', 'App\Http\Controllers\Master\PCMST_0601@index');

//機械マスター（真鍋追加）
Route::post('/master/0800', 'App\Http\Controllers\Master\PCMST_0800@index');
Route::post('/master/0801', 'App\Http\Controllers\Master\PCMST_0801@index');

//品目仕入単価マスター（真鍋追加）
Route::post('/master/2700', 'App\Http\Controllers\Master\PCMST_2700@index');
Route::post('/master/2701', 'App\Http\Controllers\Master\PCMST_2701@index');

//品目売上単価マスター（真鍋追加）
Route::post('/master/2800', 'App\Http\Controllers\Master\PCMST_2800@index');
Route::post('/master/2801', 'App\Http\Controllers\Master\PCMST_2801@index');

//得意先別納入先マスター
Route::post('/master/1600', 'App\Http\Controllers\Master\PCMST_1600@index');
Route::post('/master/1601', 'App\Http\Controllers\Master\PCMST_1601@index');

//置場、棚番
Route::post('/master/2100', 'App\Http\Controllers\Master\PCMST_2100@index');
Route::post('/master/2101', 'App\Http\Controllers\Master\PCMST_2101@index');

//シフトマスター
Route::post('/master/2900', 'App\Http\Controllers\Master\PCMST_2900@index');
Route::post('/master/2901', 'App\Http\Controllers\Master\PCMST_2901@index');

//カレンダーマスター
Route::post('/master/3100', 'App\Http\Controllers\Master\PCMST_3100@index');
Route::post('/master/3101', 'App\Http\Controllers\Master\PCMST_3101@index');

//メニューグループ
Route::post('/master/6100', 'App\Http\Controllers\Master\PCMST_6100@index');
Route::post('/master/6101', 'App\Http\Controllers\Master\PCMST_6101@index');

//メニュータブ
Route::post('/master/6200', 'App\Http\Controllers\Master\PCMST_6200@index');
Route::post('/master/6201', 'App\Http\Controllers\Master\PCMST_6201@index');

/*一覧データ*/
Route::post('/inquiry/0100', 'App\Http\Controllers\Inquiry\PCINQ_0100@index');
Route::post('/inquiry/0200', 'App\Http\Controllers\Inquiry\PCINQ_0200@index');
Route::post('/inquiry/0300', 'App\Http\Controllers\Inquiry\PCINQ_0300@index');
Route::post('/inquiry/0400', 'App\Http\Controllers\Inquiry\PCINQ_0400@index');
Route::post('/inquiry/1300', 'App\Http\Controllers\Inquiry\PCINQ_1300@index');
Route::post('/inquiry/1400', 'App\Http\Controllers\Inquiry\PCINQ_1400@index');
Route::post('/inquiry/1600', 'App\Http\Controllers\Inquiry\PCINQ_1600@index');
Route::post('/inquiry/2600', 'App\Http\Controllers\Inquiry\PCINQ_2600@index');
Route::post('/inquiry/6100', 'App\Http\Controllers\Inquiry\PCINQ_6100@index');

//ADD 山下▽
Route::post('/master/0500', 'App\Http\Controllers\Master\PCMST_0500@index');
Route::post('/master/0501', 'App\Http\Controllers\Master\PCMST_0501@index');
Route::post('/master/0800', 'App\Http\Controllers\Master\PCMST_0800@index');
Route::post('/master/0900', 'App\Http\Controllers\Master\PCMST_0900@index');
Route::post('/master/0901', 'App\Http\Controllers\Master\PCMST_0901@index');
Route::post('/master/1400', 'App\Http\Controllers\Master\PCMST_1400@index');
Route::post('/master/1401', 'App\Http\Controllers\Master\PCMST_1401@index');
Route::post('/master/1800', 'App\Http\Controllers\Master\PCMST_1800@index');
Route::post('/master/1801', 'App\Http\Controllers\Master\PCMST_1801@index');
Route::post('/master/1900', 'App\Http\Controllers\Master\PCMST_1900@index');
Route::post('/master/1901', 'App\Http\Controllers\Master\PCMST_1901@index');
Route::post('/master/2000', 'App\Http\Controllers\Master\PCMST_2000@index');
Route::post('/master/2001', 'App\Http\Controllers\Master\PCMST_2001@index');

Route::post('/inquiry/CalendarJigyoubu', 'App\Http\Controllers\Inquiry\CalendarJigyoubu@index');
Route::post('/inquiry/CalendarBusho', 'App\Http\Controllers\Inquiry\CalendarBusho@index');
Route::post('/inquiry/CalendarKikai', 'App\Http\Controllers\Inquiry\CalendarKikai@index');
Route::post('/inquiry/CalendarTantousha', 'App\Http\Controllers\Inquiry\CalendarTantousha@index');
Route::post('/inquiry/0400', 'App\Http\Controllers\Inquiry\PCINQ_0400@index');
Route::post('/inquiry/0500', 'App\Http\Controllers\Inquiry\PCINQ_0500@index');
Route::post('/inquiry/0800', 'App\Http\Controllers\Inquiry\PCINQ_0800@index');
Route::post('/inquiry/0900', 'App\Http\Controllers\Inquiry\PCINQ_0900@index');
Route::post('/inquiry/1800', 'App\Http\Controllers\Inquiry\PCINQ_1800@index');
Route::post('/inquiry/1900', 'App\Http\Controllers\Inquiry\PCINQ_1900@index');
Route::post('/inquiry/3500', 'App\Http\Controllers\Inquiry\PCINQ_3500@index');
Route::post('/inquiry/GridTantou',       'App\Http\Controllers\Inquiry\GridTantou@index');
Route::post('/inquiry/GridRight',       'App\Http\Controllers\Inquiry\GridRight@index');
Route::post('/inquiry/GridLeft',        'App\Http\Controllers\Inquiry\GridLeft@index');
Route::post('/inquiry/GridNoData',      'App\Http\Controllers\Inquiry\GridNoData@index');
Route::post('/inquiry/GridKikai',       'App\Http\Controllers\Inquiry\GridKikai@index');
Route::post('/inquiry/GridRightKikai',  'App\Http\Controllers\Inquiry\GridRightKikai@index');
Route::post('/inquiry/GridLeftKikai',   'App\Http\Controllers\Inquiry\GridLeftKikai@index');
Route::post('/inquiry/GridGaichu',      'App\Http\Controllers\Inquiry\GridGaichu@index');
Route::post('/inquiry/GridRightGaichu', 'App\Http\Controllers\Inquiry\GridRightGaichu@index');
Route::post('/inquiry/GridLeftGaichu',  'App\Http\Controllers\Inquiry\GridLeftGaichu@index');

Route::post('/juchu/4000', 'App\Http\Controllers\Juchu\PCJUI_4000@index');
Route::post('/juchu/4001', 'App\Http\Controllers\Juchu\PCJUI_4001@index');
//ADD 山下△

//ADD 工藤▽
Route::post('/master/0100', 'App\Http\Controllers\Master\PCMST_0100@index');
Route::post('/master/0101', 'App\Http\Controllers\Master\PCMST_0101@index');
Route::post('/master/3200', 'App\Http\Controllers\Master\PCMST_6300@index');
Route::post('/master/3201', 'App\Http\Controllers\Master\PCMST_6301@index');
Route::post('/master/6300', 'App\Http\Controllers\Master\PCMST_6300@index');
Route::post('/master/6301', 'App\Http\Controllers\Master\PCMST_6301@index');

Route::post('/inquiry/GridKouseiHinmoku',  'App\Http\Controllers\Inquiry\GridKouseiHinmoku@index');
Route::post('/inquiry/GridKouzyun',        'App\Http\Controllers\Inquiry\GridKouzyun@index');
//ADD 工藤△

//ADD 土嶺▽
Route::post('/master/2600', 'App\Http\Controllers\Master\PCMST_2600@index');
Route::post('/master/2601', 'App\Http\Controllers\Master\PCMST_2601@index');
Route::post('/inquiry/2601', 'App\Http\Controllers\Inquiry\PCINQ_2601@index');
Route::post('/inquiry/2100', 'App\Http\Controllers\Inquiry\PCINQ_2100@index');
Route::post('/inquiry/2000', 'App\Http\Controllers\Inquiry\PCINQ_2000@index');
Route::post('/inquiry/1800', 'App\Http\Controllers\Inquiry\PCINQ_1800@index');
Route::post('/inquiry/1900', 'App\Http\Controllers\Inquiry\PCINQ_1900@index');

Route::post('/juchu/4100', 'App\Http\Controllers\Juchu\PCJUI_4100@index');
Route::post('/juchu/4101', 'App\Http\Controllers\Juchu\PCJUI_4101@index');
Route::post('/juchu/4110', 'App\Http\Controllers\Juchu\PCJUI_4110@index');
Route::post('/juchu/4111', 'App\Http\Controllers\Juchu\PCJUI_4111@index');
Route::post('/juchu/4120', 'App\Http\Controllers\Juchu\PCJUI_4120@index');
Route::post('/juchu/4121', 'App\Http\Controllers\Juchu\PCJUI_4121@index');
Route::post('/juchu/4130', 'App\Http\Controllers\Juchu\PCJUI_4130@index');
Route::post('/juchu/4131', 'App\Http\Controllers\Juchu\PCJUI_4131@index');
//ADD 土嶺△

/*受注データ*/
Route::post('/juchu/3800', 'App\Http\Controllers\Juchu\PCJUI_3800@index');
Route::post('/juchu/3801', 'App\Http\Controllers\Juchu\PCJUI_3801@index');