<?php

use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\ServiceOrderController;
use App\Http\Controllers\Back\MasterData\DeviceRepairController;
use App\Http\Controllers\Back\MasterData\CustomersController;
use App\Http\Controllers\Back\MasterData\NotaController;
use App\Http\Controllers\Back\MasterData\ReportController;
use App\Http\Controllers\Back\Cms\HeroSectionController;
use App\Http\Controllers\Back\Cms\AdvantageController;
use App\Http\Controllers\Back\Cms\AdvantageSectionController;
use App\Http\Controllers\Back\Cms\ServiceController;
use App\Http\Controllers\Back\Cms\ServiceSectionController;
use App\Http\Controllers\Back\Cms\StepController;
use App\Http\Controllers\Back\Cms\StepSectionController;
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

Route::group(['as' => 'front.'], function () {
    Route::get('/', FrontHomeController::class)->name('home');

    Route::get('/cek-status', [FrontHomeController::class, 'cekStatus'])->name('cek-status');

    
    // Service Order Routes
    Route::post('/service-order', [ServiceOrderController::class, 'store'])->name('service-order.store');
    
    // Chatbot Routes
    Route::post('/chatbot-order', [ServiceOrderController::class, 'storeChatbot'])->name('chatbot-order.store');
    Route::post('/klik-wa', [ServiceOrderController::class, 'klikWa'])->name('klik-wa');

});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'authenticate')->name('authenticate');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::group(['middleware' => ['auth:web']], function () {

        // Dashboard route
        Route::get('dashboard', function () {
            return view('back.dashboard');
        })->name('dashboard');

        Route::group(['prefix' => 'MasterData', 'as' => 'MasterData.'], function () {

            Route::resource('customers', CustomersController::class)->except('show')->parameters(['customers' => 'customer']);
            Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
                Route::post('data', [CustomersController::class, 'data'])->name('data');
            });

            Route::resource('DeviceRepair', DeviceRepairController::class)->except('show')->parameters(['DeviceRepair' => 'deviceRepair']);
            Route::group(['prefix' => 'DeviceRepair', 'as' => 'DeviceRepair.'], function () {
                Route::post('data', [DeviceRepairController::class, 'data'])->name('data');
                Route::post('{deviceRepair}/update-status', [DeviceRepairController::class, 'updateDeviceRepairStatus'])->name('updateStatus');
                Route::get('{deviceRepair}/preview', [DeviceRepairController::class, 'preview'])->name('preview');
            });

            Route::resource('Nota', NotaController::class)->only('index');
            Route::group(['prefix' => 'Nota', 'as' => 'Nota.'], function () {
                Route::post('data', [NotaController::class, 'data'])->name('data');
                Route::match(['GET', 'POST'], '{id}/print', [NotaController::class, 'print'])->name('print');
                Route::match(['GET', 'POST'], '{id}/pdf', [NotaController::class, 'pdf'])->name('pdf');
            });

            // Report Routes - Brand and Dashboard only
            Route::resource('Report', ReportController::class)->only('index');
            Route::group(['prefix' => 'Report', 'as' => 'Report.'], function () {
                // Brand report
                Route::get('brand', [ReportController::class, 'brand'])->name('brand');
                Route::post('brand/data', [ReportController::class, 'brandData'])->name('brand.data');
                
                // Main dashboard report (previously history)
                Route::get('dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
                Route::post('dashboard/data', [ReportController::class, 'dashboardData'])->name('dashboard.data');
                Route::post('dashboard/summary', [ReportController::class, 'dashboardSummary'])->name('dashboard.summary');
                
                // Export endpoints
                Route::get('export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
                Route::get('export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
            });

        });

        // CMS Routes
        Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {
            Route::resource('hero', HeroSectionController::class)->parameters(['hero' => 'hero']);
            Route::group(['prefix' => 'hero', 'as' => 'hero.'], function () {
                Route::post('data', [HeroSectionController::class, 'data'])->name('data');
                Route::post('{hero}/toggle-status', [HeroSectionController::class, 'toggleStatus'])->name('toggleStatus');
            });

            Route::group(['prefix' => 'advantage', 'as' => 'advantage.'], function () {
                Route::get('reorder-page', [AdvantageController::class, 'reorderPage'])->name('reorderPage');
                Route::post('reorder', [AdvantageController::class, 'reorder'])->name('reorder');
                Route::post('{advantage}/toggle-status', [AdvantageController::class, 'toggleStatus'])->name('toggleStatus');
            });
            Route::resource('advantage', AdvantageController::class)->parameters(['advantage' => 'advantage']);
            
            Route::group(['prefix' => 'advantage-section', 'as' => 'advantage-section.'], function () {
                Route::get('get-title', [AdvantageSectionController::class, 'getTitle'])->name('getTitle');
                Route::post('update-title', [AdvantageSectionController::class, 'updateTitle'])->name('updateTitle');
            });
            Route::resource('advantage-section', AdvantageSectionController::class)->parameters(['advantage_section' => 'advantageSection']);
            
            // Service Routes
            Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
                Route::get('reorder-page', [ServiceController::class, 'reorderPage'])->name('reorderPage');
                Route::post('reorder', [ServiceController::class, 'reorder'])->name('reorder');
                Route::post('{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('toggleStatus');
            });
            Route::resource('service', ServiceController::class)->parameters(['service' => 'service']);
            
            Route::group(['prefix' => 'service-section', 'as' => 'service-section.'], function () {
                Route::get('get-title', [ServiceSectionController::class, 'getTitle'])->name('getTitle');
                Route::post('update-title', [ServiceSectionController::class, 'updateTitle'])->name('updateTitle');
            });
            Route::resource('service-section', ServiceSectionController::class)->parameters(['service_section' => 'serviceSection']);
            
            // Step Routes
            Route::group(['prefix' => 'step', 'as' => 'step.'], function () {
                Route::get('reorder-page', [StepController::class, 'reorderPage'])->name('reorderPage');
                Route::post('reorder', [StepController::class, 'reorder'])->name('reorder');
                Route::post('{step}/toggle-status', [StepController::class, 'toggleStatus'])->name('toggleStatus');
            });
            Route::resource('step', StepController::class)->parameters(['step' => 'step'])->except(['show']);
            
            Route::group(['prefix' => 'step-section', 'as' => 'step-section.'], function () {
                Route::get('data', [StepSectionController::class, 'getSectionData'])->name('data');
                Route::post('{stepSection}/toggle-status', [StepSectionController::class, 'toggleStatus'])->name('toggleStatus');
            });
            Route::resource('step-section', StepSectionController::class)->parameters(['step_section' => 'stepSection'])->except(['show']);
        });

    });
});
