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

/*マスターデータ*/
Route::post('/master/0400', 'App\Http\Controllers\Master\PCMST_0400@index');
Route::post('/master/0401', 'App\Http\Controllers\Master\PCMST_0401@index');
Route::post('/master/1200', 'App\Http\Controllers\Master\PCMST_1200@index');
Route::post('/master/1300', 'App\Http\Controllers\Master\PCMST_1300@index');
Route::post('/master/1301', 'App\Http\Controllers\Master\PCMST_1301@index');

//工程マスター
Route::post('/master/0600', 'App\Http\Controllers\Master\PCMST_0600@index');
Route::post('/master/0601', 'App\Http\Controllers\Master\PCMST_0601@index');

//置場、棚番
Route::post('/master/2100', 'App\Http\Controllers\Master\PCMST_2100@index');
Route::post('/master/2101', 'App\Http\Controllers\Master\PCMST_2101@index');

//シフトマスター
Route::post('/master/2900', 'App\Http\Controllers\Master\PCMST_2900@index');
Route::post('/master/2901', 'App\Http\Controllers\Master\PCMST_2901@index');

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

Route::post('/inquiry/0400', 'App\Http\Controllers\Inquiry\PCINQ_0400@index');
Route::post('/inquiry/0500', 'App\Http\Controllers\Inquiry\PCINQ_0500@index');
Route::post('/inquiry/0800', 'App\Http\Controllers\Inquiry\PCINQ_0800@index');
Route::post('/inquiry/0900', 'App\Http\Controllers\Inquiry\PCINQ_0900@index');
Route::post('/inquiry/1800', 'App\Http\Controllers\Inquiry\PCINQ_1800@index');
Route::post('/inquiry/1900', 'App\Http\Controllers\Inquiry\PCINQ_1900@index');
Route::post('/inquiry/GridRight',       'App\Http\Controllers\Inquiry\GridRight@index');
Route::post('/inquiry/GridLeft',        'App\Http\Controllers\Inquiry\GridLeft@index');
Route::post('/inquiry/GridNoData',      'App\Http\Controllers\Inquiry\GridNoData@index');
Route::post('/inquiry/GridRightKikai',  'App\Http\Controllers\Inquiry\GridRightKikai@index');
Route::post('/inquiry/GridLeftKikai',   'App\Http\Controllers\Inquiry\GridLeftKikai@index');
Route::post('/inquiry/GridRightGaichu', 'App\Http\Controllers\Inquiry\GridRightGaichu@index');
Route::post('/inquiry/GridLeftGaichu',  'App\Http\Controllers\Inquiry\GridLeftGaichu@index');
//ADD 山下△

//ADD 工藤▽
Route::post('/master/0100', 'App\Http\Controllers\Master\PCMST_0100@index');
Route::post('/master/0101', 'App\Http\Controllers\Master\PCMST_0101@index');
//ADD 工藤△

//ADD 土嶺▽
Route::post('/master/2600', 'App\Http\Controllers\Master\PCMST_2600@index');
Route::post('/master/2601', 'App\Http\Controllers\Master\PCMST_2601@index');
Route::post('/inquiry/2601', 'App\Http\Controllers\Inquiry\PCINQ_2601@index');
Route::post('/inquiry/2100', 'App\Http\Controllers\Inquiry\PCINQ_2100@index');
Route::post('/inquiry/2000', 'App\Http\Controllers\Inquiry\PCINQ_2000@index');
Route::post('/inquiry/1800', 'App\Http\Controllers\Inquiry\PCINQ_1800@index');
//ADD 土嶺△

/*受注データ*/
Route::post('/juchu/3800', 'App\Http\Controllers\Juchu\PCJUI_3800@index');
Route::post('/juchu/3801', 'App\Http\Controllers\Juchu\PCJUI_3801@index');

Route::get('/test', function () {
    return view('welcome');
});
