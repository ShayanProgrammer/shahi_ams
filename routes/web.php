<?php

use App\Http\Controllers\{BankController,
    ClearingAgentController,
    CompanyAccountController,
    CompanyController,
    CustomerController,
    CustomerBillController,
    CustomerPaymentController,
    ExpenseController,
    GeneralController,
    ImportDutiesController,
    ImportStatusController,
    LengthController,
    PacketListController,
    PackingListController,
    ReportController,
    RightController,
    ShippingArrivalController,
    StockListController,
    UserController,
    WarehouseController,
    AuthController,
    AccountPaymentController};
use App\Models\{ImportDuties,CompanyAccount};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// Route::get('/test',function(Request $request){
//     // dd($this->most_recent_company_value($request->id));
//     $company_value=CompanyAccount::where('company_id',(int)'1')->orderby('id','desc')->first('value');
//     dd((int)$company_value->value);
// });

Route::get('/', function () {
    return view('authentication.login');
})->name('/');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


//General Controller
Route::post('/get_performa_by_company',[GeneralController::class, 'get_performa_by_company'])->name('get_performa_by_company');
Route::post('/get_number_of_container_by_bl_number',[GeneralController::class, 'get_number_of_container_by_bl_number'])->name('get_number_of_container_by_bl_number');
Route::get('/get_all_status',[GeneralController::class, 'get_all_status'])->name('get_all_status');
Route::post('/change_status',[GeneralController::class, 'change_status'])->name('change_status');
Route::get('/get_bill_number_by_invoice', [GeneralController::class, 'get_bill_number_by_invoice'])->name('get_bill_number_by_invoice');



//Company
Route::get('companies',[CompanyController::class, 'index'])->name('companies');
Route::post('/company_list',[CompanyController::class, 'company_list'])->name('company_list');
Route::get('/companies/create',[CompanyController::class, 'create'])->name('create_company');
Route::post('/companies/store',[CompanyController::class, 'store'])->name('store_company');
Route::get('/companies/edit/{id}',[CompanyController::class, 'edit'])->name('edit_company');
Route::post('/companies/delete',[CompanyController::class, 'delete'])->name('delete_company');
Route::post('/companies/update',[CompanyController::class, 'update'])->name('update_company');
Route::get('/importstatuses/company/{company_id}',[ImportStatusController::class, 'company_importstatuses']);


//Company Accounts
Route::get('company_accounts/{company_id}',[CompanyAccountController::class, 'index'])->name('company_accounts');
Route::post('/company_account_list',[CompanyAccountController::class, 'company_account_list'])->name('company_account_list');
Route::post('/company_accounts/delete',[CompanyAccountController::class, 'delete_company_account'])->name('delete_company_account');

//Import Statuses
Route::get('importstatuses',[ImportStatusController::class, 'index'])->name('importstatuses');
Route::post('/importstatus_list',[ImportStatusController::class, 'importstatus_list'])->name('importstatus_list');
Route::get('/importstatuses/create',[ImportStatusController::class, 'create'])->name('create_importstatus');
Route::post('/importstatuses/store',[ImportStatusController::class, 'store'])->name('store_importstatus');
Route::get('/importstatuses/edit/{id}',[ImportStatusController::class, 'edit'])->name('edit_importstatus');
Route::post('/importstatuses/delete',[ImportStatusController::class, 'delete'])->name('delete_importstatus');
Route::post('/importstatuses/update',[ImportStatusController::class, 'update'])->name('update_importstatus');
Route::post('/import_status_detail/view',[ImportStatusController::class, 'import_status_detail'])->name('import_status_detail');
Route::post('/import_status_detail/remove_single_importstatus',[ImportStatusController::class, 'remove_single_importstatus'])->name('remove_single_importstatus');

//Account Payments
Route::group(['prefix'=>'accountpayments','as'=>'accountpayments.'], function(){
    Route::get('index',[AccountPaymentController::class, 'index'])->name('index');
    Route::post('list',[AccountPaymentController::class, 'list'])->name('list');
    Route::get('create/{company_id}',[AccountPaymentController::class, 'create'])->name('create');
    Route::post('store',[AccountPaymentController::class, 'store'])->name('store');
});


//Package List
Route::get('packinglists',[PackingListController::class, 'index'])->name('packinglists');
Route::post('/packinglist_list',[PackingListController::class, 'packinglist_list'])->name('packinglist_list');
Route::get('/packinglists/create',[PackingListController::class, 'create'])->name('create_packinglist');
Route::post('/packinglists/store',[PackingListController::class, 'store'])->name('store_packinglist');
Route::get('/packinglists/edit/{id}',[PackingListController::class, 'edit'])->name('edit_packinglist');
Route::post('/packinglists/delete',[PackingListController::class, 'delete'])->name('delete_packinglist');
Route::post('/packinglists/update',[PackingListController::class, 'update'])->name('update_packinglist');
Route::post('/packing_list_detail/view',[PackingListController::class, 'packing_list_detail'])->name('packing_list_detail');
Route::post('/packing_list_detail/remove_single_packinglist',[PackingListController::class, 'remove_single_packinglist'])->name('remove_single_packinglist');

//Banks
Route::get('banks',[BankController::class, 'index'])->name('banks');
Route::post('/bank_list',[BankController::class, 'bank_list'])->name('bank_list');
Route::get('/banks/create',[BankController::class, 'create'])->name('create_bank');
Route::post('/banks/store',[BankController::class, 'store'])->name('store_bank');
Route::get('/banks/edit/{id}',[BankController::class, 'edit'])->name('edit_bank');
Route::post('/banks/delete',[BankController::class, 'delete'])->name('delete_bank');
Route::post('/banks/update',[BankController::class, 'update'])->name('update_bank');


//Bank Account
Route::get('/banks/bank_account/{id}',[BankController::class, 'bank_account'])->name('bank_account');
Route::post('/banks/bank_account_list',[BankController::class, 'bank_account_list'])->name('bank_account_list');
Route::post('/bank_account_delete/{id}',[BankController::class, 'delete_bank_account'])->name('delete_bank_account');



//Users
Route::get('users',[UserController::class, 'index'])->name('users');
Route::post('/user_list',[UserController::class, 'user_list'])->name('user_list');
Route::get('/users/create',[UserController::class, 'create'])->name('create_user');
Route::post('/users/store',[UserController::class, 'store'])->name('store_user');
Route::get('/users/edit/{id}',[UserController::class, 'edit'])->name('edit_user');
Route::post('/users/delete',[UserController::class, 'delete'])->name('delete_user');
Route::post('/users/update',[UserController::class, 'update'])->name('update_user');
Route::get('/users/change_password/{id}',[UserController::class, 'change_password'])->name('change_password');
Route::post('/users/change_password_store/{id}',[UserController::class, 'change_password_store'])->name('change_password_store');
Route::get('users/redirect',[UserController::class, 'redirect'])->name('redirect');


//Imort Duties
Route::get('/banks/importduties/{id}',[ImportDutiesController::class, 'bank_importduties'])->name('company_importduties');
Route::get('importduties',[ImportDutiesController::class, 'index'])->name('importduties');
Route::post('/importduty_list',[ImportDutiesController::class, 'importduty_list'])->name('importduty_list');
Route::get('/importduties/create',[ImportDutiesController::class, 'create'])->name('create_importduty');
Route::post('/importduties/store',[ImportDutiesController::class, 'store'])->name('store_importduty');
Route::get('/importduties/edit/{id}',[ImportDutiesController::class, 'edit'])->name('edit_importduty');
Route::post('/importduties/delete',[ImportDutiesController::class, 'delete'])->name('delete_importduty');
Route::post('/importduties/update',[ImportDutiesController::class, 'update'])->name('update_importduty');


//Warehouse
Route::get('warehouses',[WarehouseController::class, 'index'])->name('warehouses');
Route::post('/warehouse_list',[WarehouseController::class, 'warehouse_list'])->name('warehouse_list');
Route::get('/warehouses/create',[WarehouseController::class, 'create'])->name('create_warehouse');
Route::post('/warehouses/store',[WarehouseController::class, 'store'])->name('store_warehouse');
Route::get('/warehouses/edit/{id}',[WarehouseController::class, 'edit'])->name('edit_warehouse');
Route::post('/warehouses/delete',[WarehouseController::class, 'delete'])->name('delete_warehouse');
Route::post('/warehouses/update',[WarehouseController::class, 'update'])->name('update_warehouse');

//Stock List
Route::get('stocklists',[StockListController::class, 'index'])->name('stocklists');
Route::post('/stocklist_list',[StockListController::class, 'stocklist_list'])->name('stocklist_list');
Route::get('/stocklist/create',[StockListController::class, 'create'])->name('create_stocklist');
Route::post('/stocklist/store',[StockListController::class, 'store'])->name('store_stocklist');
Route::get('/stocklist/edit/{id}',[StockListController::class, 'edit'])->name('edit_stocklist');
Route::post('/stocklist/delete',[StockListController::class, 'delete'])->name('delete_stocklist');
Route::post('/stocklist/update',[StockListController::class, 'update'])->name('update_stocklist');


//Packet List
Route::get('packetlists',[PacketListController::class, 'index'])->name('packetlists');
Route::post('/packetlist_list',[PacketListController::class, 'packetlist_list'])->name('packetlist_list');
Route::get('/packetlist/create',[PacketListController::class, 'create'])->name('create_packetlist');
Route::post('/packetlist/store',[PacketListController::class, 'store'])->name('store_packetlist');
Route::get('/packetlist/edit/{id}',[PacketListController::class, 'edit'])->name('edit_packetlist');
Route::post('/packetlist/delete',[PacketListController::class, 'delete'])->name('delete_packetlist');
Route::post('/packetlist/update',[PacketListController::class, 'update'])->name('update_packetlist');
Route::post('/packetlist_detail/view',[PacketListController::class, 'packetlist_detail'])->name('packetlist_detail');
Route::post('/packetlist_detail/remove_single_packetlist',[PacketListController::class, 'remove_single_packetlist'])->name('remove_single_packetlist');


//Length List
Route::get('lengths',[LengthController::class, 'index'])->name('lengths');
Route::post('/length_list',[LengthController::class, 'length_list'])->name('length_list');
Route::get('/length/edit/{id}',[LengthController::class, 'edit'])->name('edit_length');
Route::post('/length/update',[LengthController::class, 'update'])->name('update_length');
Route::post('/length_detail/view',[LengthController::class, 'length_detail'])->name('length_detail');
Route::post('/length_detail/remove_single_length',[LengthController::class, 'remove_single_length'])->name('remove_single_length');



//Expense
Route::get('expenses',[ExpenseController::class, 'index'])->name('expenses');
Route::post('/expense_list',[ExpenseController::class, 'expense_list'])->name('expense_list');
Route::get('/expenses/create',[ExpenseController::class, 'create'])->name('create_expense');
Route::post('/expenses/store',[ExpenseController::class, 'store'])->name('store_expense');
Route::get('/expenses/edit/{id}',[ExpenseController::class, 'edit'])->name('edit_expense');
Route::post('/expenses/delete',[ExpenseController::class, 'delete'])->name('delete_expense');
Route::post('/expenses/update',[ExpenseController::class, 'update'])->name('update_expense');


//Shipping Arrival
Route::get('shipping_arrivals',[ShippingArrivalController::class, 'index'])->name('shipping_arrivals');
Route::get('arrived_shipping',[ShippingArrivalController::class, 'arrived_shipping'])->name('arrived_shipping');
Route::post('/shipping_arrival_list',[ShippingArrivalController::class, 'shipping_arrival_list'])->name('shipping_arrival_list');
Route::get('/shipping_arrivals/create',[ShippingArrivalController::class, 'create'])->name('create_shipping_arrival');
Route::post('/shipping_arrivals/store',[ShippingArrivalController::class, 'store'])->name('store_shipping_arrival');
Route::get('/shipping_arrivals/edit/{id}',[ShippingArrivalController::class, 'edit'])->name('edit_shipping_arrival');
Route::post('/shipping_arrivals/delete',[ShippingArrivalController::class, 'delete'])->name('delete_shipping_arrival');
Route::post('/shipping_arrivals/update',[ShippingArrivalController::class, 'update'])->name('update_shipping_arrival');
Route::post('/shipping_arrival_detail/view',[ShippingArrivalController::class, 'shipping_arrival_detail'])->name('shipping_arrival_detail');
Route::post('/shipping_arrival_detail/view_arrived',[ShippingArrivalController::class, 'shipping_arrived_detail'])->name('shipping_arrived_detail');
Route::post('/update_shipping_arrival_arrived',[ShippingArrivalController::class, 'update_shipping_arrival_arrived'])->name('update_shipping_arrival_arrived');
Route::post('/shipping_arrival_detail/remove_single_shipping_arrival',[ShippingArrivalController::class, 'remove_single_shipping_arrival'])->name('remove_single_shipping_arrival');


//Customer
Route::get('customers',[CustomerController::class, 'index'])->name('customers');
Route::post('/customer_list',[CustomerController::class, 'customer_list'])->name('customer_list');
Route::get('/customers/create',[CustomerController::class, 'create'])->name('create_customer');
Route::post('/customers/store',[CustomerController::class, 'store'])->name('store_customer');
Route::get('/customers/edit/{id}',[CustomerController::class, 'edit'])->name('edit_customer');
Route::post('/customers/delete',[CustomerController::class, 'delete'])->name('delete_customer');
Route::post('/customers/update',[CustomerController::class, 'update'])->name('update_customer');
Route::get('/customers/customer_account/{id}',[CustomerController::class, 'customer_account'])->name('customer_account');
Route::post('/customers/customer_account_list',[CustomerController::class, 'customer_account_list'])->name('customer_account_list');
Route::post('/customer_account_delete/{id}',[CustomerController::class, 'delete_customer_account'])->name('delete_customer_account');


//Customer Bill
Route::get('customer_bills',[CustomerBillController::class, 'index'])->name('customer_bills');
Route::post('/customer_bill_list',[CustomerBillController::class, 'customer_bill_list'])->name('customer_bill_list');
Route::get('/customer_bills/create',[CustomerBillController::class, 'create'])->name('create_customer_bill');
Route::post('/customer_bills/store',[CustomerBillController::class, 'store'])->name('store_customer_bill');
Route::get('/customer_bills/edit/{id}',[CustomerBillController::class, 'edit'])->name('edit_customer_bill');
Route::post('/customer_bills/delete',[CustomerBillController::class, 'delete'])->name('delete_customer_bill');
Route::post('/customer_bills/update',[CustomerBillController::class, 'update'])->name('update_customer_bill');
Route::post('/customer_bills/get_stocklist_by_warehouse',[CustomerBillController::class, 'get_stocklist_by_warehouse'])->name('get_stocklist_by_warehouse');
Route::post('/customer_bills/get_stocklist_by_warehouse_and_company',[CustomerBillController::class, 'get_stocklist_by_warehouse_and_company'])->name('get_stocklist_by_warehouse_and_company');
Route::post('/customer_bills/get_packetlist_by_stocklist',[CustomerBillController::class, 'get_packetlist_by_stocklist'])->name('get_packetlist_by_stocklist');
Route::post('/customer_bills/get_size_by_packetlist',[CustomerBillController::class, 'get_size_by_packetlist'])->name('get_size_by_packetlist');
Route::post('/customer_bills/get_length_by_size',[CustomerBillController::class, 'get_length_by_size'])->name('get_length_by_size');
Route::post('/customer_bills/get_quantity_by_length',[CustomerBillController::class, 'get_quantity_by_length'])->name('get_quantity_by_length');
Route::post('/customer_bills/get_company_by_warehouse',[CustomerBillController::class, 'get_company_by_warehouse'])->name('get_company_by_warehouse');
Route::post('/customer_bills/get_stocklist_by_company',[CustomerBillController::class, 'get_stocklist_by_company'])->name('get_stocklist_by_company');
Route::post('/customer_bill_detail/view',[CustomerBillController::class, 'customer_bill_detail'])->name('customer_bill_detail');
Route::post('/customer_bills_detail/remove_single_customer_bill',[CustomerBillController::class, 'remove_single_customer_bill'])->name('remove_single_customer_bill');
Route::get('invoice/{id}',[CustomerBillController::class, 'invoice'])->name('invoice');


//Customer Payment
Route::get('customer_payments',[CustomerPaymentController::class, 'index'])->name('customer_payments');
Route::post('/customer_payment_list',[CustomerPaymentController::class, 'customer_payment_list'])->name('customer_payment_list');
Route::get('/customer_payments/create',[CustomerPaymentController::class, 'create'])->name('create_customer_payment');
Route::post('/customer_payments/store',[CustomerPaymentController::class, 'store'])->name('store_customer_payment');
Route::get('/customer_payments/edit/{id}',[CustomerPaymentController::class, 'edit'])->name('edit_customer_payment');
Route::post('/customer_payments/delete',[CustomerPaymentController::class, 'delete'])->name('delete_customer_payment');
Route::post('/customer_payments/update',[CustomerPaymentController::class, 'update'])->name('update_customer_payment');


//Clearing Agent
Route::get('clearing_agents',[ClearingAgentController::class, 'index'])->name('clearing_agents');
Route::post('/clearing_agent_list',[ClearingAgentController::class, 'clearing_agent_list'])->name('clearing_agent_list');
Route::get('/clearing_agents/create',[ClearingAgentController::class, 'create'])->name('create_clearing_agent');
Route::post('/clearing_agents/store',[ClearingAgentController::class, 'store'])->name('store_clearing_agent');
Route::get('/clearing_agents/edit/{id}',[ClearingAgentController::class, 'edit'])->name('edit_clearing_agent');
Route::post('/clearing_agents/delete',[ClearingAgentController::class, 'delete'])->name('delete_clearing_agent');
Route::post('/clearing_agents/update',[ClearingAgentController::class, 'update'])->name('update_clearing_agent');


//Clearing Agent Account
Route::get('/clearing_agents/clearing_agent_account/{id}',[ClearingAgentController::class, 'clearing_agent_account'])->name('clearing_agent_account');
Route::get('/clearing_agent_account_create/{id}',[ClearingAgentController::class, 'create_clearing_agent_account'])->name('create_clearing_agent_account');
Route::post('/clearing_agent_account_store/{id}',[ClearingAgentController::class, 'store_clearing_agent_account'])->name('store_clearing_agent_account');
Route::get('/clearing_agent_account_edit/{id}',[ClearingAgentController::class, 'edit_clearing_agent_account'])->name('edit_clearing_agent_account');
Route::post('/clearing_agent_account_update/{id}',[ClearingAgentController::class, 'update_clearing_agent_account'])->name('update_clearing_agent_account');
Route::post('/clearing_agents/clearing_agent_account_list',[ClearingAgentController::class, 'clearing_agent_account_list'])->name('clearing_agent_account_list');
Route::post('/clearing_agent_account_delete/{id}',[ClearingAgentController::class, 'delete_clearing_agent_account'])->name('delete_clearing_agent_account');


//Reports
Route::get('stock_report',[ReportController::class, 'stock_report'])->name('stock_report');
Route::post('/stock_report_list',[ReportController::class, 'stock_report_list'])->name('stock_report_list');


//Rights
Route::get('right',[RightController::class, 'index'])->name('right');
Route::post('/right_list',[RightController::class, 'right_list'])->name('right_list');
Route::post('/general_view_detail',[RightController::class, 'general_view_detail'])->name('general_view_detail');



});





