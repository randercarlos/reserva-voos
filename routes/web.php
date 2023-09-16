<?php

use App\Http\Controllers\Panel\AirplaneController;
use App\Http\Controllers\Panel\AirportController;
use App\Http\Controllers\Panel\BrandController;
use App\Http\Controllers\Panel\CityController;
use App\Http\Controllers\Panel\FlightController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\ReserveController;
use App\Http\Controllers\Panel\StateController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Site\SiteController;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {

    Fpdf::AddPage();
    Fpdf::SetFont('Courier', 'B', 18);
    Fpdf::Cell(50, 25, 'Hello World!');
    Fpdf::Output();
    exit();
});

// Rotas do Painel
Route::group(['prefix' => '/panel', 'middleware' => ['auth', 'admin']], function () {

    // Home / Dashboard
    Route::get('/', [PanelController::class, 'index'])->name('panel.index');

    // Marcas
    Route::get('/brands/report', [BrandController::class, 'report'])->name('brands.report');
    Route::resource('/brands', BrandController::class);
    Route::match(['get', 'post'], '/brands/search', [BrandController::class, 'search'])->name('brands.search');
    Route::get('/brands/{id}/airplanes', [BrandController::class, 'airplanes'])->name('brands.airplanes');

    // Aviões
    Route::get('/airplanes/report', [AirplaneController::class, 'report'])->name('airplanes.report');
    Route::resource('/airplanes', AirplaneController::class);
    Route::match(['get', 'post'], '/airplanes/search', [AirplaneController::class, 'search'])->name('airplanes.search');

    // Estados e Cidades
    Route::get('/states', [StateController::class, 'index'])->name('states.index');
    Route::post('/states/search', [StateController::class, 'search'])->name('states.search');
    Route::get('/states/{initials}/cities', [CityController::class, 'index'])->name('state.cities');
    Route::match(['get', 'post'], '/states/{initials}/cities/search', [CityController::class, 'search'])->name('state.cities.search');

    // Voos
    Route::get('/flights/report', [FlightController::class, 'report'])->name('flights.report');
    Route::resource('/flights', FlightController::class);
    Route::match(['get', 'post'], '/flights/search', [FlightController::class, 'search'])->name('flights.search');

    // Aeroportos
    Route::get('/airports/report', [AirportController::class, 'report'])->name('airports.report');
    Route::resource('/airports', AirportController::class);
    Route::match(['get', 'post'], '/airports/search', [AirportController::class, 'search'])->name('airports.search');
    Route::get('/city/{id}/airports', [AirportController::class, 'city'])->name('airports.city');

    // Usuários
    Route::get('/users/report', [UserController::class, 'report'])->name('users.report');
    Route::resource('/users', UserController::class);
    Route::match(['get', 'post'], '/users/search', [UserController::class, 'search'])->name('users.search');

    // Reservas
    Route::get('/reserves/report', [ReserveController::class, 'report'])->name('reserves.report');
    Route::resource('/reserves', ReserveController::class, ['except' => ['show', 'destroy']]);
    Route::match(['get', 'post'], '/reserves/search', [ReserveController::class, 'search'])->name('reserves.search');
});

// Rotas do Site
Route::group(['prefix' => '/', 'namespace' => 'Site'], function () {

    Route::get('/', [SiteController::class, 'index'])->name('site.index');
    Route::get('/promocoes', [SiteController::class, 'promotions'])->name('site.promotions');
    Route::post('/pesquisar', [SiteController::class, 'search'])->name('site.flights.search');

    // Rotas do Site que necessitam de autenticação
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/detalhes-voo/{id}', [SiteController::class, 'detailsFlight'])->name('site.flight.details');
        Route::post('/reservar', [SiteController::class, 'reserveFlight'])->name('site.reserve.flight');

        Route::get('/minhas-compras', [SiteController::class, 'myPurchases'])->name('site.purchases');
        Route::get('/detalhes-compra/{id}', [SiteController::class, 'purchaseDetail'])->name('site.purchase.detail');

        Route::get('/meu-perfil', [SiteController::class, 'myProfile'])->name('site.user.profile');
        Route::post('/atualizar-perfil', [SiteController::class, 'updateProfile'])->name('site.user.update_profile');

        Route::get('/sair', [SiteController::class, 'logout'])->name('site.logout');

    });

});

// Rotas de autenticação
Auth::routes();
