<?php

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

Route::GET("/", "appControl@login");

Route::get("/pendaftaran", "pendaftaranControl@index");
Route::get("/pendaftaran/selesai", "pendaftaranControl@pendaftaranSelesai");
Route::get("/pendaftaran/sendemail", "pendaftaranControl@SendEmailConfirmation");
Route::get("/pendaftaran/confirmation", "perusahaanControl@konfirmasiViaEmail");
Route::post("/pendaftaran/form", "pendaftaranControl@ToSelf");



Route::POST("/master/opd", "opdControl@index");


Route::POST("/perizinan/permohonan", "permohonanControl@index");
Route::POST("/perizinan/perusahaan", "perusahaanControl@index");

Route::POST("/track", "trackControl@index");


Route::POST("/opd/izin", "opdIzinControl@index");



Route::POST("/surat/rekomendasi", "suratRekomendasiControl@index");


Route::post("/master/modul", "modulControl@index");
Route::post("/master/acl", "aclControl@index");
Route::POST("/master/aclGroup", "aclGroupControl@index");

Route::POST("/master/users", "userControl@index");

Route::POST("/master/opd", "opdControl@index");

Route::POST("/master/perusahaan", "perusahaanControl@index");



Route::GET("/login", "appControl@login");
Route::POST("/login/loginSubmit", "appControl@loginSubmit");
Route::get("/logout", "appControl@logout");



Route::get("/acl", "aclControl@index");
Route::post("/aclgetR", "aclControl@aclGet");
Route::get("/{any}", "appControl@index")->where("any", ".*");
