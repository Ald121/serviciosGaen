<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'cors'], function(){
	// Lista productos
    Route::get('getProductos','productosController@get_productos');
    Route::get('getProductosById','productosController@get_productos_by_id');
    // Ingreso App
    Route::post('login','loginController@login');
    // Registro
    Route::post('Registrar','loginController@registro');

    Route::post('getProvincias','cmbController@get_provincias');
    Route::post('getCiudades','cmbController@get_ciudades');

    Route::post('getDatosDeposito','pagoController@get_datos_deposito');
    Route::post('confirmarPedido','pedidosController@confirmar_pedido');
    Route::post('getCostoEnvio','pagoController@get_costo_envio');
    Route::post('getEmpresasEnvio','cmbController@get_empresas_envio');
    Route::post('getBancos','cmbController@get_Bancos');
    Route::post('getParametros','parametrosController@get_parametros');
    Route::get('DownloadApp', 'DownloadController@download_app');

    Route::group(['middleware' => ['jwt.auth']], function ()
        {
    Route::get('misPedidos','pedidosController@mis_pedidos');
    Route::post('uploadDeposito','pagoController@upload_deposito');
    });
    
});