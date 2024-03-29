<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
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

Route::get('session', [SessionController::class, 'index'])->name('login');
Route::post('session', [SessionController::class, 'store'])->middleware('throttle:login')->name('session.store');

Route::middleware('auth')->group(function() {
    // Rotas módulo dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/last-activities', [DashboardController::class, 'activities'])->name('dashboard.activities');
    Route::get('dashboard/most-actives', [DashboardController::class, 'actives'])->name('dashboard.actives');
    Route::get('dashboard/numbers', [DashboardController::class, 'numbers'])->name('dashboard.numbers');
    // Rotas módulo de sessão
    Route::get('session/edit', [SessionController::class, 'edit'])->name('session.edit');
    Route::patch('session', [SessionController::class, 'update'])->name('session.update');
    Route::delete('session', [SessionController::class, 'destroy'])->name('session.destroy');
    // Rotas módulo usuários
    Route::resource('users', UserController::class)->except(['show, destroy']);
    Route::delete('users/{user}', [UserController::class, 'destroy'])->withTrashed()->name('users.destroy');
    // Rotas módulo clientes
    Route::resource('customers', CustomerController::class)->except(['destroy']);
    Route::get('/cities/{state}', [CustomerController::class, 'cities'])->name('customers.cities');
    Route::get('/customers-search', [CustomerController::class, 'search'])->name('customers.search');
    // Rotas módulo financeiras
    Route::resource('partners', PartnerController::class)->except(['show, destroy']);
    Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->withTrashed()->name('partners.destroy');
    // Rotas módulo produtos
    Route::resource('products', ProductController::class)->except(['show, destroy']);
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->withTrashed()->name('products.destroy');
    // Rotas módulo de configurações
    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations.index');
    Route::patch('/configurations', [ConfigurationController::class, 'update'])->name('configurations.update');
    // Rotas módulo de propostas
    Route::resource('proposals', ProposalController::class)->except(['show', 'destroy']);
    // Rotas módulo relatórios
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/url', [ReportController::class, 'url'])->name('reports.url');
    Route::get('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});
