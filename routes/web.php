<?php

use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\BoilController;
use App\Http\Controllers\Admin\BreadController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientsDebtController;
use App\Http\Controllers\Admin\DebtController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ExpectedDebtController;
use App\Http\Controllers\Admin\ExpenditureController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\DebtClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RefundBreadController;
use App\Http\Controllers\ReturnBreadController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSalaryController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// login
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware(['guest']);
Route::post('/login',[AuthController::class,'auth'])->name('auth.login');

// logout
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
// change password
Route::get('/change-password',[HomeController::class,'changePassword'])->name('change-password');
// change-password.update
Route::post('/change-password',[HomeController::class,'changePasswordUpdate'])->name('change-password.update');

// home
Route::get('/', [HomeController::class,'home'])->name('home')->middleware('auth');


Route::group(['middleware'=>['auth']],function(){
    
    // expenditure
    // index
    Route::get('/expenditure',[ExpenditureController::class,'index'])->name('expenditure.index');
    // index
    Route::get('/expenditure/{user}',[ExpenditureController::class,'show'])->name('expenditure.show');
    // create
    Route::post('/expenditure/create',[ExpenditureController::class,'store'])->name('expenditure.create');
    // create tip
    Route::post('/expenditure_type/create',[ExpenditureController::class,'type_store'])->name('expenditure_type.create');
    // destroy
    Route::delete('/expenditure/{expenditure}',[ExpenditureController::class,'delete'])->name('expenditure.delete');
    // filter
    Route::post('/expenditure',[ExpenditureController::class,'filter'])->name('expenditure.filter');

});


Route::group(['middleware'=>['auth','all_admin']],function(){
    
    // sales
    // index
    Route::get('/sales3',[SaleController::class,'sales3'])->name('sales3');
    // index
    Route::get('/sales',[SaleController::class,'index'])->name('sales.index');
    // index
    Route::post('/sales/create',[SaleController::class,'store'])->name('sales.create');
    // destroy
    Route::delete('/sales/destroy/{id}',[SaleController::class,'destroy'])->name('sales.destroy');

    // sales2.index
    Route::get('/sales2',[SaleController::class,'sale2_index'])->name('sales2.index');


    // deliveries
    // index
    Route::get('/delivery',[DeliveryController::class,'index'])->name('deliveries.index');
    // create
    Route::post('/delivery/create',[DeliveryController::class,'store'])->name('deliveries.create');
    // deliveries.destroy
    Route::post('/delivery/destroy/{delivery}',[DeliveryController::class,'destroy'])->name('deliveries.destroy');
    
    // deliveries.delivery-history
    Route::get('/delivery-history',[DeliveryController::class,'deliveryHistory'])->name('deliveries.delivery-history');
    // deliveries.move.edit
    Route::post('/delivery/refund',[DeliveryController::class,'refund'])->name('deliveries.refund');
    // deliveries.refund-destroy
    Route::get('/delivery/expected-refund/destroy/{id}',[DeliveryController::class,'refundDestroy'])->name('expected-refund.destroy');
    Route::get('/delivery/expected-refund/confirm/{id}',[DeliveryController::class,'refundConfirm'])->name('expected-refund.confirm');

    // clients
    // index
    Route::get('/clients',[ClientController::class,'index'])->name('clients.index');
    // show
    Route::get('/clients/{client}',[ClientController::class,'show'])->name('clients.show');
    // create
    Route::post('/clients/create',[ClientController::class,'store'])->name('clients.create');
    // destroy
    Route::post('/client/destroy/{id}',[ClientController::class,'destroy'])->name('clients.destroy');
    // update
    Route::post('/client/update',[ClientController::class,'update'])->name('clients.update');
    // histories
    Route::get('/client/{client}',[ClientController::class,'histories'])->name('client_histories');
    // pay_client
    Route::post('/client/pay',[ClientController::class,'pay_client'])->name('pay_client');
    // return_bread
    Route::post('/client/return',[ClientController::class,'return_bread'])->name('return_bread');
     // debts
    // index
    Route::get('/debts',[DebtController::class,'index'])->name('debts.index');
    // update
    Route::post('/debts/update',[DebtController::class,'update'])->name('debts.update');
    // index
    Route::post('/payment',[DebtController::class,'payment'])->name('payment');

    // debt clients
    // index
    Route::get('/clients-debt',[DebtClientController::class,'index'])->name('debt_clients.index');

    
});
Route::group(['middleware'=>['auth','GL_OR_SELLER_ADMIN']],function(){
    
    // users
    // index
    Route::get('/users',[UserController::class,'users'])->name('users.index');
    // update
    Route::post('/users/update/{user}',[UserController::class,'update'])->name('users.update');
    // edit
    Route::get('/users/{user}/edit',[UserController::class,'edit'])->name('users.edit');
    // delete
    Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');
    // create
    Route::post('/users/create',[UserController::class,'store'])->name('users.create');
    // key
    Route::post('/key/{id}',[UserController::class,'Userkey'])->name('user.key');

    
    // users_salary
    
    Route::get('/users_salary',[UserSalaryController::class,'index'])->name('users_salary.index');
    Route::get('/users_salary/f',[UserSalaryController::class,'filter'])->name('users_salary.filter');
    Route::get('/users_salary/show/{user}',[UserSalaryController::class,'show'])->name('users_salary.show');
    // users_salary.expenditure
    Route::post('/users_salary/expenditure',[UserSalaryController::class,'expenditure'])->name('users_salary.expenditure');


    // breads
    // index
    Route::get('/store-two',[BreadController::class,'index'])->name('breads.index');
    // create
    Route::post('/breadProduct/create',[BreadController::class,'store'])->name('breads.create');
    // destroy
    Route::post('/bread/destroy/{id}',[BreadController::class,'destroy'])->name('breads.destroy');
    // update
    Route::post('/bread/update',[BreadController::class,'update'])->name('breads.update');
    Route::get('/store-two/{bread}',[BreadController::class,'showBread'])->name('breads.show');


    // clients debt
    // index
    // Route::get('/clients-debt',[ClientsDebtController::class,'index'])->name('clients.debt.index');


    // products
    // index
    Route::get('/store-one',[ProductController::class,'index'])->name('products.index');
    // create
    Route::post('/product/create',[ProductController::class,'store'])->name('products.create');
    // show
    Route::get('/store-one/{product}',[ProductController::class,'show'])->name('products.show');
    // show product destroy
    Route::post('/store-one/show-destroy/{id}',[ProductController::class,'showDestory'])->name('product-show.destroy');
    // destroy
    Route::post('/store-one/destroy/{id}',[ProductController::class,'destroy'])->name('products.destroy');
    // update
    Route::post('/store-one/update',[ProductController::class,'update'])->name('products.update');
    Route::post('/store-one/addQuantity',[ProductController::class,'addQuantity'])->name('products.addQuantity');

    // suppliers
    // index
    Route::get('/suppliers',[SupplierController::class,'index'])->name('suppliers.index');
    // create
    Route::post('/suppliers/create',[SupplierController::class,'store'])->name('suppliers.create');
    // update
    Route::post('/suppliers/update',[SupplierController::class,'update'])->name('suppliers.update');
    // show
    Route::get('/suppliers/{supplier}',[SupplierController::class,'show'])->name('suppliers.show');
    // paid
    Route::post('/suppliers/paid/{supplier}',[SupplierController::class,'paid'])->name('suppliers.paid');
    // suppliers.payment.destroy
    // paid
    Route::post('/suppliers/destroy/{supplier_id}/{id}',[SupplierController::class,'paymentDestroy'])->name('suppliers.payment.destroy');
    
   
    // expected.debts.index
    // index
    Route::get('/wait-duty',[ExpectedDebtController::class,'index'])->name('expected.debts.index');
    // update
    Route::post('/wait-duty/update',[ExpectedDebtController::class,'update'])->name('expected.debts.update');
    // status edit
    Route::post('/wait-duty',[ExpectedDebtController::class,'wallet'])->name('expected.debts.status');

    
    // controls
    // index
    Route::get('/access-control',[AccessController::class,'index'])->name('controls.index');
    // create
    Route::post('/access-control/create',[AccessController::class,'store'])->name('controls.create');



});


Route::group(['middleware'=>['auth','GL_ADMIN']],function(){



    // report 

    // active clients
    Route::get('/report-active',[ReportController::class,'reportActive'])->name('report-active');
    // admin sale
    Route::get('/report-admin',[ReportController::class,'reportAdmin'])->name('report-admin');

    // history-admin
    Route::get('/report-admin/{user}',[ReportController::class,'historyAdmin'])->name('history-admin');
    
    // history-admin
    Route::get('/history/{user}',[ReportController::class,'ha'])->name('ha');

    Route::post('/report-admin/money',[ReportController::class,'historyAdminMoney'])->name('history-admin-money');
    Route::get('/report-admin/{user}/filter',[ReportController::class,'historyAdminFilter'])->name('history-admin-filter');
    // history client
    Route::get('/history-client/{sale}',[ReportController::class,'historyClient'])->name('history-client');

    // report Delivery
    Route::get('/report-delivery',[ReportController::class,'reportDelivery'])->name('report-delivery');
    // report Group
    Route::get('/report-group',[ReportController::class,'reportGroup'])->name('report-group');
    // report Balance
    Route::get('/report-balance',[ReportController::class,'reportBalance'])->name('report-balance');
    // report Balance
    Route::get('/report-balance/{user}',[ReportController::class,'reportBalanceShow'])->name('report-balance-show');
    
    // report sale
    Route::get('/report-sale',[ReportController::class,'reportSale'])->name('report-sale');
    // report sale show
    Route::get('/report-sale/{sale}',[ReportController::class,'reportSaleShow'])->name('report-sale-show');
    // report-benifit
    Route::get('/report-benifit',[ReportController::class,'reportBenifit'])->name('report-benifit');

    
    // report sale
    Route::get('/report-sale2',[ReportController::class,'reportSale2'])->name('report-sale2');
    // report sale show
    // Route::get('/report-sale/{sale}',[ReportController::class,'reportSaleShow'])->name('report-sale2-show');


    // report sale back
    Route::get('/r',[ReportController::class,'reportSaleBack'])->name('report-back');
    // report sale money
    Route::post('/report-sale-money',[ReportController::class,'reportSaleMoney'])->name('report-sale-money');

    // report-production
    Route::get('/report-production',[ReportController::class,'reportProduction'])->name('report-production');

    // report-warehouse
    Route::get('/report-warehouse',[ReportController::class,'reportWarehouse'])->name('report-warehouse');
    // report-warehouse.filter
    Route::post('/report-warehouse',[ReportController::class,'reportWareFilter'])->name('report-warehouse.filter');

    // report-warehouse-2
    Route::get('/report-warehouse-2',[ReportController::class,'reportWarehouse2'])->name('report-warehouse-2');
    
    // report-money
    Route::get('/report-money',[ReportController::class,'reportMoney'])->name('report-money');
});

Route::group(['middleware'=>['auth','GL_OR_WORKER']],function() {
    // production
    // index
    Route::get('/production',[ProductionController::class,'index'])->name('productions.index');
    // create
    Route::post('/production/create',[ProductionController::class,'store'])->name('productions.create');
    // change quantity
    Route::post('/production/changeQuan/{production}',[ProductionController::class,'changeQuan'])->name('productions.changeQuan');
    // delete
    Route::post('/production/destroy/{id}',[ProductionController::class,'destroy'])->name('productions.destroy');


});