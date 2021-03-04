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



Route::group(['middleware' => ['auth']], function()  
{
	Route::get('/', 'DatLichKhamController@index')->name('home');
	//benh vien
	Route::resource('benh-vien','BenhVienPKController');
	Route::get('changeStatusBV', 'BenhVienPKController@changeStatus');
	//chuyen khoa
	Route::resource('chuyen-khoa','ChuyenKhoaController');
	//bac si
	Route::resource('bac-si','BacSiController');
	Route::post('/showBacSiInBenhVien', 'BacSiController@showBacSiInBenhVien');
	Route::post('/showBacSiInChuyenKhoa', 'BacSiController@showBacSiInChuyenKhoa');
	
	//khung gio
	Route::resource('khung-gio','KhungGioController');
	//tuy chinh khung gio
	Route::resource('tuychinh-khunggio','TuyChinhKhungGioController');
	Route::get('changeStatusTuyChinhKG', 'TuyChinhKhungGioController@changeStatus');
	Route::post('/showKhungGioInBenhVien', 'TuyChinhKhungGioController@showKhungGioInBenhVien');
	Route::post('/showChuyenKhoaInBenhVien', 'TuyChinhKhungGioController@showChuyenKhoaInBenhVien');
	//vac xin va su dung vac xin
	Route::resource('su-dung-vac-xin','SuDungVacXinController');
	Route::get('changeStatusSuDungVacXin', 'SuDungVacXinController@changeStatus');
	Route::resource('vac-xin','VacXinController');
	Route::get('chi-tiet-vac-xin', 'VacXinController@chitiet')->name('vac-xin.chitiet');
	Route::get('changeStatusVacXin', 'VacXinController@changeStatus');
	Route::post('vac-xin-update_stt', 'VacXinController@update_stt')->name('vac-xin.update_stt');

	//tuy chinh ngay off
	Route::resource('tuychinh-ngayoff','TuyChinhNgayOffController');
	Route::get('changeStatusTuyChinhOff', 'TuyChinhNgayOffController@changeStatus');
	//dat lich kham
	Route::resource('dat-lich-kham','DatLichKhamController')->only(['edit', 'show','update','destroy','index']);
	Route::post('/showKhungGioInBenhVienDatLichKham', 'DatLichKhamController@showKhungGioInBenhVien');

	Route::group(['prefix' => '/dat-lich-kham-tao-moi'], function()  
	{
		Route::get('/buoc-1', 'DatLichKhamController@createStep1')->name('dat-lich-kham.createStep1');
		Route::post('/buoc-1', 'DatLichKhamController@PostcreateStep1')->name('dat-lich-kham.PostcreateStep1');
		Route::get('/buoc-2', 'DatLichKhamController@createStep2')->name('dat-lich-kham.createStep2');
		Route::post('/buoc-2', 'DatLichKhamController@PostcreateStep2')->name('dat-lich-kham.PostcreateStep2');
		Route::get('/buoc-3', 'DatLichKhamController@createStep3')->name('dat-lich-kham.createStep3');
		Route::post('/buoc-3-post', 'DatLichKhamController@PostcreateStep3')->name('dat-lich-kham.PostcreateStep3');
		Route::get('/buoc-4', 'DatLichKhamController@createStep4')->name('dat-lich-kham.createStep4');
		Route::post('/buoc-4', 'DatLichKhamController@PostcreateStep4')->name('dat-lich-kham.PostcreateStep4');
	});
	//gui lai sms
	Route::get('dat-lich-kham-gui-lai-sms/{id}', 'DatLichKhamController@editSms')->name('dat-lich-kham.editSms');
	Route::PATCH('dat-lich-kham-gui-lai-sms/{id}', 'DatLichKhamController@updateSms')->name('dat-lich-kham.updateSms');
	//ActivityLogController
	Route::resource('activity-log','ActivityLogController');
	//export 
	Route::get('xuat-file', 'ExcelController@index')->name('export.index');
	Route::get('export-excel','ExcelController@export')->name('export.export');
	//thong bao
	Route::get('thong-bao-dat-lich', 'ThongBaoController@thongbao_datlich')->name('thongbao.thongbao_datlich');
	Route::get('thong-bao-vac-xin', 'ThongBaoController@thongbao_vacxin')->name('thongbao.thongbao_vacxin');
	Route::post('update-thongbao', 'ThongBaoController@update')->name('thongbao.update');
	//tuy chinh form dat lich
	Route::resource('tuychinh-datlich','TuyChinhDatLichController')->only(['edit','update','index']);
	// mau tin nhan
	Route::resource('mau-tin-nhan','TinNhanController');

	// clear cache
	Route::get('/clear-cache', function() {
	    Artisan::call('cache:clear');
	    Artisan::call('route:clear');
	    Artisan::call('config:clear');
	    Artisan::call('view:clear');
	    return redirect()->back()->with('success','clear successfully');
	});
});

