<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartsController;
use Illuminate\Support\Facades\Auth;

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

// include web copy routes
// include __DIR__ . '/web-copy.php';

// Main Page Route
Route::middleware(['auth'])
    ->get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');


// Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        // Main Page Route
        Route::get('', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
    });

// Client Routes Group
Route::middleware(['auth', 'role:cashier'])
    ->prefix('cashier')
    ->group(function () {

        // Main Page Route
        Route::get('', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');

    });
