<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\EmployeesController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::prefix('admin')->group( function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
/**
 *
 * SETTINGS
 * 
 */
    Route::resource('settings', SettingController::class);
/**
 *
 * PRODUCTS
 * 
 */
    Route::resource('products', ProductsController::class);
/**
 *
 * CUSTOMERS
 * 
 */
    Route::resource('customers', CustomerController::class);
/**
 *
 * EMPLOYEES
 * 
 */
    Route::resource('employees', EmployeesController::class);
    Route::get('employee/employee-data-to-word/{employee_id}', [EmployeesController::class, 'employeeDataToWord']);
/**
 *
 * CART
 * 
 */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty'])->name('cart.changeQty');
    Route::delete('/cart/delete-user_cart-product', [CartController::class, 'delete'])->name('cart.delete');
    Route::delete('/cart/empty', [CartController::class, 'empty'])->name('cart.empty');
/**
 *
 * ORDER
 * 
 */
    Route::resource('orders', OrderController::class);
    /**
     * Export with date set
     */
    Route::get('export/customer-order-pdf', [OrderController::class, 'exportToPDFWithDateSet'])->name('export.customer-order-to-pdf');
    Route::get('export/customer-order-excel', [OrderController::class, 'exportToExcelWithDateSet'])->name('export.customer-order-to-excel');
    Route::get('export/customer-order-csv', [OrderController::class, 'exportToCSVWithDateSet'])->name('export.customer-order-to-csv');

    /**
     * Export All
     */
    Route::get('export/all-customer-order-pdf', [OrderController::class, 'exportAllToPDF'])->name('export.all-customer-order-to-pdf');
    Route::get('export/all-customer-order-excel', [OrderController::class, 'exportAllToExcel'])->name('export.all-customer-order-to-excel');
    Route::get('export/all-customer-order-csv', [OrderController::class, 'exportAllToCSV'])->name('export.all-customer-order-to-csv');

});
/**
 *
 * PRODUCTS
 * 
 */
Route::get('products/fetch-more-products', [ProductsController::class, 'getMoreProducts'])->name('products.get-more-products');

/**
 *
 * CUSTOMER
 * 
 */

Route::get('customers/fetch-more-customers', [CustomerController::class, 'getMoreCustomers'])->name('customers.get-more-customers');


/**
 *
 * EMPLOYEES
 * 
 */

Route::get('employees/fetch-more-employees/{searchTerm?}', [EmployeesController::class, 'getMoreEmployees'])->name('employees.get-more-employees');
Route::get('employees/search-employees/{searchTerm?}', [EmployeesController::class, 'search'])->name('employees.search-employees');


/**
 *
 * USER CART
 * 
 */






/**
 * If you use resource to create a url immediately you must not copy its URL if your creating a new custom request
 * EX:
 * resource : Route::get('admin/products/{product}', class)
 * custom : Route::get('admin/products) DONT DO THIS YOU`LL GET AN ERROR
 * 
 * Resource
 * (Arg1, Arg2)
 * Arg1 = table name
 * Arg2 = Controller name
 */