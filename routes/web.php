<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ClientAdmin\Pump\CardPaymentController;
use App\Http\Controllers\ClientAdmin\Pump\DipRecordController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ClientAdmin\FuelTypeController;
use App\Http\Controllers\ClientAdmin\PetrolPumpController;
use App\Http\Controllers\ClientAdmin\TeamController;

use App\Http\Controllers\ClientAdmin\Pump\FuelPurchaseController;
use App\Http\Controllers\ClientAdmin\Pump\PricingController;
use App\Http\Controllers\ClientAdmin\Pump\TankController;
use App\Http\Controllers\ClientAdmin\Pump\TankStockController;
use App\Http\Controllers\ClientAdmin\Pump\NozzleController;
use App\Http\Controllers\ClientAdmin\Pump\CustomerController;
use App\Http\Controllers\ClientAdmin\Pump\EmployeeController;
use App\Http\Controllers\ClientAdmin\Pump\ProductController;
use App\Http\Controllers\ClientAdmin\Pump\ProductInventoryController;

use App\Http\Controllers\SuperAdmin\ClientController;
use App\Http\Controllers\SuperAdmin\CompanyController;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', [AuthController::class, 'loginAction'])->name('signin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/404', 'errors.404')->name('error.404');


Route::controller(ClientController::class)->prefix('clients')->middleware('super_admin')->group(function(){
    Route::get('/', 'index')->name('clients.index');
    Route::get('/get_all_clients', 'get_all_clients')->name('clients.getAllClients');
    Route::post('/create', 'create')->name('clients.create');
    Route::put('/update/{id}', 'update')->name('clients.update');
    Route::delete('/delete/{id}',  'delete')->name('clients.delete');
    
});

Route::controller(CompanyController::class)->prefix('company')->middleware('super_admin')->group(function(){
    Route::get('/', 'index')->name('company.index');
    Route::get('/get_all_companies', 'get_all_companies')->name('company.get_all_companies');
    Route::get('/get_available_admins', 'get_available_admins')->name('company.get_available_admins');
    Route::post('/create', 'create')->name('company.create');
    Route::put('/update/{id}', 'update')->name('company.update');
    Route::delete('/delete/{id}',  'delete')->name('company.delete');
});


Route::controller(TeamController::class)
    ->prefix('team')
    ->middleware(['client_admin', 'check_owner_access'])
    ->group(function(){
        Route::get('/', 'index')->name('team.index');
        Route::get('/get_all_members', 'get_all_members')->name('team.get_all_members');
        Route::post('/create', 'create')->name('team.create');
        Route::put('/update/{id}', 'update')->name('team.update');
        Route::delete('/delete/{id}',  'delete')->name('team.delete');
        Route::post('/multi_delete',  'multi_delete')->name('team.multi_delete');

    }

);

// PetrolPumpController
Route::controller(PetrolPumpController::class)->prefix('pump')->middleware('client_admin')->group(function(){
    Route::post('/{pump_id}/saveReport', 'saveReport')->middleware('verify.pump')->name('pump.saveReport');
    Route::get('/{pump_id}/report', 'getPumpReport')->middleware('verify.pump')->name('pump.getPumpReport');

    Route::get('/{pump_id}/expenses', 'get_expenses')->middleware('verify.pump')->name('pump.get_expenses');

    Route::post('/{pump_id}/daily-reports/create', 'save_bank_deposit')->middleware('verify.pump')->name('pump.save_bank_deposit');
    
    

    Route::get('/{pump_id}/sales-history', 'get_sales_history')->middleware('verify.pump')->name('pump.get_sales_history');

    Route::get('/', 'index')->name('pump.index');
    Route::get('/get_all', 'get_all')->name('pump.get_all');
    Route::post('/create', 'create')->name('pump.create');
    Route::put('/update/{id}', 'update')->name('pump.update');
    Route::delete('/delete/{id}',  'delete')->name('pump.delete');
    Route::get('/{pump_id}', 'show')->name('pump.show');
    
    Route::get('/getProducts/{pump_id}', 'getProducts')->name('pump.getProducts');
    Route::get('/getEmployees/{pump_id}', 'getEmployees')->name('pump.getEmployees');
    Route::get('/getCustomers/{pump_id}', 'getCustomers')->name('pump.getCustomers');
    Route::post('/getTanksByFuelType', 'getTanksByFuelType')->name('pump.purchase.getTanksByFuelType');
    

    Route::post('/{pump_id}/saveReport', 'saveReport')->name('pump.saveReport');

    // Fuel Purchase As Subpage of Pump
    Route::prefix('{pump_id}/purchase')->middleware('verify.pump')->controller(FuelPurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('pump.purchase.index');
        Route::get('/get_all', 'get_all')->name('pump.purchase.get_all');
        Route::post('/create', 'create')->name('pump.purchase.create');
        Route::put('/update/{purchase_id}', 'update')->name('pump.purchase.update');
        Route::post('/addStock/{purchase_id}', 'addStock')->name('pump.purchase.addStock');
        Route::delete('/delete/{purchase_id}', 'delete')->name('pump.purchase.delete');
    });

    // Pricing As Subpage of Pump
    Route::prefix('{pump_id}/pricing')->controller(PricingController::class)->group(function () {
        Route::get('/', 'index')->name('pump.pricing.index');
        Route::get('/get_all', 'get_all')->name('pump.pricing.get_all');
        Route::post('/create', 'create')->name('pump.pricing.create');
        Route::put('/update/{pricing_id}', 'update')->name('pump.pricing.update')->middleware('verify.pump');
        Route::delete('/delete/{pricing_id}', 'delete')->name('pump.pricing.delete');
    });

    // Tanks As Subpage of Pump
    Route::prefix('{pump_id}/tank')->middleware('verify.pump')->controller(TankController::class)->group(function () {
        Route::get('/', 'index')->name('pump.tank.index');
        Route::get('/get_all', 'get_all')->name('pump.tank.get_all');
        Route::post('/create', 'create')->name('pump.tank.create');
        Route::put('/update/{tank_id}', 'update')->name('pump.tank.update')->middleware('verify.pump');
        Route::delete('/delete/{tank_id}', 'delete')->name('pump.tank.delete');
    });

    // Tank Stock As Subpage of Pump
    Route::prefix('{pump_id}/stock')->controller(TankStockController::class)->group(function () {
        Route::get('/', 'index')->name('pump.stock.index')->middleware('verify.pump');
        Route::get('/get_all', 'get_all')->name('pump.stock.get_all')->middleware('verify.pump');
        Route::post('/create', 'create')->name('pump.stock.create')->middleware('verify.pump');
        Route::put('/update/{stock_id}', 'update')->name('pump.stock.update')->middleware('verify.pump');
        Route::delete('/delete/{stock_id}', 'delete')->name('pump.stock.delete')->middleware('verify.pump');
    });

    // Dip As Subpage of Pump
    Route::prefix('{pump_id}/dip')->controller(DipRecordController::class)->group(function () {
        Route::get('/', 'index')->name('pump.stock.index')->middleware('verify.pump');
        Route::get('/get_all', 'get_all')->name('pump.stock.get_all')->middleware('verify.pump');
        Route::post('/create', 'create')->name('pump.stock.create')->middleware('verify.pump');
        Route::put('/update/{stock_id}', 'update')->name('pump.stock.update')->middleware('verify.pump');
        Route::delete('/delete/{stock_id}', 'delete')->name('pump.stock.delete')->middleware('verify.pump');
    });

    // Nozzles As Subpage of Pump
    Route::prefix('{pump_id}/nozzle')->middleware('verify.pump')->controller(NozzleController::class)->group(function () {
        Route::get('/', 'index')->name('pump.nozzle.index');
        Route::get('/get_all', 'get_all')->name('pump.nozzle.get_all');
        Route::get('/getTanksByFuelType', 'getTanksByFuelType')->name('pump.nozzle.getTanksByFuelType');
        Route::post('/create', 'create')->name('pump.nozzle.create');
        Route::put('/update/{nozzle_id}', 'update')->name('pump.nozzle.update');
        Route::delete('/delete/{nozzle_id}', 'delete')->name('pump.nozzle.delete');
    });

    // Customers As Subpage of Pump
    Route::prefix('{pump_id}/customer')
    ->middleware('verify.pump')
    ->controller(CustomerController::class)
    ->name('pump.customer.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/getAll', 'getAll')->name('getAll');
        Route::get('/credits/{customer_id}', 'get_credits')->name('get_credits');
        Route::post('/create', 'create')->name('create');
        Route::put('/update/{customer_id}', 'update')->name('update');
        Route::delete('/delete/{customer_id}', 'delete')->name('delete');
    });

    // Customers As Subpage of Pump
    Route::prefix('{pump_id}/card-payments')
    ->middleware('verify.pump')
    ->controller(CardPaymentController::class)
    ->name('pump.card_transaction.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create', 'create')->name('create');
        // Route::get('/', 'index')->name('index');
        // Route::get('/getAll', 'getAll')->name('getAll');
        // Route::get('/credits/{customer_id}', 'get_credits')->name('get_credits');
        // Route::put('/update/{customer_id}', 'update')->name('update');
        // Route::delete('/delete/{customer_id}', 'delete')->name('delete');
    });

    // Employees As Subpage of Pump
    Route::prefix('{pump_id}/employee')
        ->middleware('verify.pump')
        ->controller(EmployeeController::class)
        ->name('pump.employee.')
        ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{employee_id}', 'show')->name('show');
        Route::get('/getAll', 'getAll')->name('getAll');
        Route::post('/create', 'create')->name('create');
        Route::put('/update/{employee_id}', 'update')->name('update');
        Route::delete('/delete/{employee_id}', 'delete')->name('delete');
    });
   
    // products As Subpage of Pump
    Route::prefix('{pump_id}/product')->middleware('verify.pump')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('pump.product.index');
        Route::get('/getAll', 'getAll')->name('pump.product.getAll');
        Route::post('/create', 'create')->name('pump.product.create');
        Route::put('/update/{product_id}', 'update')->name('pump.product.update');
        Route::post('/addStock/{product_id}', 'addStock')->name('pump.product.addStock');
        Route::delete('/delete/{product_id}', 'delete')->name('pump.product.delete');
    });

});

// Fuel type
Route::controller(FuelTypeController::class)->prefix('fuel_type')->middleware('client_admin')->group(function(){
    Route::get('/', 'index')->name('fuel_type.index');
    Route::get('/get_all', 'get_all')->name('fuel_type.get_all');
    Route::post('/create', 'create')->name('fuel_type.create');
    Route::put('/update/{id}', 'update')->name('fuel_type.update');
    Route::delete('/delete/{id}',  'delete')->name('fuel_type.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'index'])->name('account.settings');
    Route::post('/account/settings/update', [AccountSettingsController::class, 'update'])->name('account.settings.update');
    Route::post('/account/settings/resend-verification-email', [AccountSettingsController::class, 'resend_verification_email'])->name('account.settings.resend_verificatione_email');
});

Route::get('verify-email/{token}', [AccountSettingsController::class, 'verify'])->name('account.settings.verify');


Route::get('/test-email', function () {
    Mail::raw('This is a test email!', function ($message) {
        $message->to('usmanrana18989@gmail.com')
                ->subject('Test Email');
    });

    return 'Email sent!';
});