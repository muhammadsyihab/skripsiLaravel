<?php

// use Exception;
// use Throwable;
use App\Models\Unit;
use App\Events\HistoryChat;
use Illuminate\Support\Facades\Auth;
use Ladumor\OneSignal\OneSignal;
// use App\Events\serviceNotifications;
use Illuminate\Support\Facades\Route;
// use App\Notifications\ServiceNotification;
use Illuminate\Support\Facades\Notification;

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
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('welcome');

Auth::routes();
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {


    // Users routes
    Route::resource('user', App\Http\Controllers\RegisterController::class);
    Route::post('import/user', [App\Http\Controllers\RegisterController::class, 'import'])->name('user.import');
    Route::post('pdf/user', [App\Http\Controllers\RegisterController::class, 'pdf'])->name('user.pdf');
    Route::post('excel/user', [App\Http\Controllers\RegisterController::class, 'excel'])->name('user.excel');

    // Lokasi
    Route::resource('lokasi', App\Http\Controllers\AdminMasterLokasiController::class);



    Route::get('/notifikasi', [App\Http\Controllers\HomeController::class, 'notifikasi'])->name('notif.index');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/sparepart', [App\Http\Controllers\HomeController::class, 'getSparepart'])->name('home.sparepart');
    Route::get('/home/sparepart/qty', [App\Http\Controllers\HomeController::class, 'getQtySparepart'])->name('home.sparepart.qty');
    Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'indexArea'])->name('area');


    // Ticket
    Route::get('pengaduan/{id}', [App\Http\Controllers\ChatLiveWireController::class, 'show'])->name('pengaduan.show');


    // vue
    Route::get('ticketVue/{id}', [App\Http\Controllers\TicketVueController::class, 'show'])->name('ticket.vue.show');
    Route::get('ticketVue/getTicket/{id}', [App\Http\Controllers\TicketVueController::class, 'getTicketById'])->name('ticket.vue.getTicketById');
    Route::post('ticketVue/history', [App\Http\Controllers\TicketVueController::class, 'postHistory'])->name('history.store');
    Route::post('ticketVue/history/unit', [App\Http\Controllers\TicketVueController::class, 'postHistoryUnit'])->name('history.unit.store');
    Route::post('ticketVue/request', [App\Http\Controllers\TicketVueController::class, 'postRequest'])->name('request.store');
    Route::post('ticketVue/request/kosong', [App\Http\Controllers\TicketVueController::class, 'postRequestKosong'])->name('request.kosong.store');
    Route::put('ticketVue/request/{id}/acc', [App\Http\Controllers\TicketVueController::class, 'accRequest'])->name('request.acc');
    Route::put('ticketVue/request/{id}/cancel', [App\Http\Controllers\TicketVueController::class, 'cancelRequest'])->name('request.cancel');
    Route::put('ticketVue/prb/{id}/acc', [App\Http\Controllers\TicketVueController::class, 'postRequestKosongAcc'])->name('requestprb.acc');
    Route::put('ticketVue/prb/{id}/cancel', [App\Http\Controllers\TicketVueController::class, 'postRequestKosongCancel'])->name('requestprb.cancel');
    Route::put('ticketVue/ulang/{id}', [App\Http\Controllers\TicketVueController::class, 'ulangTicket'])->name('ulangTicket.dibuatkembali');
    Route::put('ticketVue/tutup/{id}', [App\Http\Controllers\TicketVueController::class, 'tutupTicket'])->name('tutupTicket');
    Route::post('ticketVue/refresh', [App\Http\Controllers\TicketVueController::class, 'refresh'])->name('refresh.ticket');


    // Ticketing
    Route::resource('ticket', App\Http\Controllers\TiketController::class)->except('show');
    Route::get('req-ticket', [App\Http\Controllers\TiketController::class, 'reqTiket'])->name('req.ticket.operator');
    Route::get('all-ticket', [App\Http\Controllers\TiketController::class, 'allTiket'])->name('all.ticket.allTiket');
    Route::get('history-ticket', [App\Http\Controllers\TiketController::class, 'historyTiket'])->name('history.ticket.historyTiket');

    Route::post('excel/ticket', [App\Http\Controllers\TiketController::class, 'excelReqTicket'])->name('req-ticket.excel');
    Route::post('excel/ticket2', [App\Http\Controllers\TiketController::class, 'excelTicket'])->name('ticket2.excel');
    Route::post('excel/allticker', [App\Http\Controllers\TiketController::class, 'excelAllTicket'])->name('ticketall.excel');
    Route::post('excel/historyticker', [App\Http\Controllers\TiketController::class, 'excelHistoryTicket'])->name('ticketHistory.excel');

    Route::post('pdf/ticket', [App\Http\Controllers\TiketController::class, 'pdfReqTicket'])->name('req-ticket.pdf');
    Route::post('pdf/ticket2', [App\Http\Controllers\TiketController::class, 'pdfTicket'])->name('ticket2.pdf');
    Route::post('pdf/allticker', [App\Http\Controllers\TiketController::class, 'pdfAllTicket'])->name('ticketall.pdf');
    Route::post('pdf/historyticker', [App\Http\Controllers\TiketController::class, 'pdfHistoryTicket'])->name('ticketHistory.pdf');

    Route::post('ticket/filter', [App\Http\Controllers\TiketController::class, 'indexFilter'])->name('indexFilter');
    Route::post('req-ticket/filter', [App\Http\Controllers\TiketController::class, 'reqTiketFilter'])->name('reqTiketFilter');
    Route::post('all-ticket/filter', [App\Http\Controllers\TiketController::class, 'allTiketFilter'])->name('allTiketFilter');
    Route::post('history-ticket/filter', [App\Http\Controllers\TiketController::class, 'historyTiketFilter'])->name('historyTiketFilter');


    Route::get('password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'edit'])->name('user.password.edit');
    Route::post('password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'update'])->name('user.password.update');

    Route::group(
        ['middleware' => 'CheckRole:logistik'],
        function () {
            // Logistik
            Route::resource('sparepart', App\Http\Controllers\AdminMasterSparepartController::class)->except('show');
            Route::get('sparepart/oli', [App\Http\Controllers\AdminMasterSparepartController::class, 'indexOli'])->name('oli.index');
            Route::get('sparepart/oli/create', [App\Http\Controllers\AdminMasterSparepartController::class, 'createOli'])->name('oli.create');
            Route::get('sparepart/oli/{id}', [App\Http\Controllers\AdminMasterSparepartController::class, 'editOli'])->name('oli.edit');
            Route::patch('sparepart/oli/{id}', [App\Http\Controllers\AdminMasterSparepartController::class, 'updateOli'])->name('oli.update');
            Route::post('sparepart/oli/store', [App\Http\Controllers\AdminMasterSparepartController::class, 'storeOli'])->name('oli.store');

            // report sparepart
            Route::get('pdf/sparepart', [App\Http\Controllers\AdminMasterSparepartController::class, 'pdf'])->name('sparepart.pdf');
            Route::get('excel/sparepart', [App\Http\Controllers\AdminMasterSparepartController::class, 'excel'])->name('sparepart.excel');

            // report sparepart oli
            Route::get('pdf/sparepart/oli', [App\Http\Controllers\AdminMasterSparepartController::class, 'pdfOli'])->name('sparepart.oli.pdf');
            Route::get('excel/sparepart/oli', [App\Http\Controllers\AdminMasterSparepartController::class, 'excelOli'])->name('sparepart.oli.excel');


            Route::resource('brgmasuk', App\Http\Controllers\AdminLgBrgMskController::class)->except('show');
            Route::post('filter/brgmasuk', [App\Http\Controllers\AdminLgBrgMskController::class, 'filter'])->name('brgmasuk.filter');
            Route::post('pdf/brgmasuk', [App\Http\Controllers\AdminLgBrgMskController::class, 'pdf'])->name('brgmasuk.pdf');
            Route::post('excel/brgmasuk', [App\Http\Controllers\AdminLgBrgMskController::class, 'excel'])->name('brgmasuk.excel');



            Route::get('purchasing-order', [App\Http\Controllers\AdminLgBrgMskController::class, 'indexPO'])->name('purchasing.order.index');
            Route::get('purchasing-order/batal', [App\Http\Controllers\AdminLgBrgMskController::class, 'indexPOBatal'])->name('purchasing.order.index.batal');
            Route::post('purchasing-order', [App\Http\Controllers\AdminLgBrgMskController::class, 'storePO'])->name('purchasing.order.store');
            Route::post('purchasing-order/filter', [App\Http\Controllers\AdminLgBrgMskController::class, 'filterPO'])->name('purchasing.order.filter');
            Route::get('purchasing-order/create', [App\Http\Controllers\AdminLgBrgMskController::class, 'createPO'])->name('purchasing.order.create');
            Route::patch('purchasing-order/{id}', [App\Http\Controllers\AdminLgBrgMskController::class, 'updatePO'])->name('purchasing.order.update');
            Route::get('purchasing-order/{id}/edit', [App\Http\Controllers\AdminLgBrgMskController::class, 'editPO'])->name('purchasing.order.edit');
            Route::get('purchasing-order/receive/{id}', [App\Http\Controllers\AdminLgBrgMskController::class, 'receivePO'])->name('purchasing.order.receive');
            Route::post('pdf/purchasing-order', [App\Http\Controllers\AdminLgBrgMskController::class, 'pdfPo'])->name('purchasing.order.pdf');
            Route::post('excel/purchasing-order', [App\Http\Controllers\AdminLgBrgMskController::class, 'excelPo'])->name('purchasing.order.excel');

            Route::resource('brgkeluar', App\Http\Controllers\AdminLgBrgKlrController::class)->except('show');
            Route::post('filter/brgkeluar', [App\Http\Controllers\AdminLgBrgKlrController::class, 'filter'])->name('brgkeluar.filter');
            Route::post('pdf/brgkeluar', [App\Http\Controllers\AdminLgBrgKlrController::class, 'pdf'])->name('brgkeluar.pdf');
            Route::post('excel/brgkeluar', [App\Http\Controllers\AdminLgBrgKlrController::class, 'excel'])->name('brgkeluar.excel');

            Route::resource('brgkeluarprb', App\Http\Controllers\AdminLgBrgKlrPribadiController::class)->except('show');
            Route::post('filter/brgkeluarprb', [App\Http\Controllers\AdminLgBrgKlrPribadiController::class, 'filter'])->name('brgkeluarprb.filter');
            Route::post('pdf/brgkeluarprb', [App\Http\Controllers\AdminLgBrgKlrPribadiController::class, 'pdf'])->name('brgkeluarprb.pdf');
            Route::post('excel/brgkeluarprb', [App\Http\Controllers\AdminLgBrgKlrPribadiController::class, 'excel'])->name('brgkeluarprb.excel');
        }
    );

    // Fuel
    Route::resource('fuel-stock', App\Http\Controllers\FuelStockController::class);
    Route::post('filter/fuel-stock', [App\Http\Controllers\FuelStockController::class, 'filter'])->name('fstock.filter');
    Route::post('pdf/fuel-stock', [App\Http\Controllers\FuelStockController::class, 'pdf'])->name('fuel-stock.pdf');
    Route::post('excel/fuel-stock', [App\Http\Controllers\FuelStockController::class, 'excel'])->name('fuel-stock.excel');


    Route::resource('fuel-suply', App\Http\Controllers\FuelSuplyController::class);
    Route::post('filter/fuel-suply', [App\Http\Controllers\FuelSuplyController::class, 'filter'])->name('fuel-suply.filter');
    Route::post('pdf/fuel-suply', [App\Http\Controllers\FuelSuplyController::class, 'pdf'])->name('fuel-suply.pdf');
    Route::post('excel/fuel-suply', [App\Http\Controllers\FuelSuplyController::class, 'excel'])->name('fuel-suply.excel');


    Route::resource('fuel-unit', App\Http\Controllers\FuelUnitController::class);
    Route::post('filter/fuel-unit', [App\Http\Controllers\FuelUnitController::class, 'filter'])->name('fuel-unit.filter');
    Route::post('pdf/fuel-unit', [App\Http\Controllers\FuelUnitController::class, 'pdf'])->name('fuel-unit.pdf');
    Route::post('excel/fuel-unit', [App\Http\Controllers\FuelUnitController::class, 'excel'])->name('fuel-unit.excel');


    Route::group(
        ['middleware' => 'CheckRole:planner'],
        function () {
            // Unit
            Route::resource('unit', App\Http\Controllers\AdminMasterUnitController::class)->middleware('CheckRole:planner');
            Route::post('filter/unit', [App\Http\Controllers\AdminMasterUnitController::class, 'filter'])->name('unit.filter');
            Route::post('import/unit', [App\Http\Controllers\AdminMasterUnitController::class, 'import'])->name('unit.import');
            Route::post('pdf/unit', [App\Http\Controllers\AdminMasterUnitController::class, 'pdf'])->name('unit.pdf');
            Route::post('excel/unit', [App\Http\Controllers\AdminMasterUnitController::class, 'excel'])->name('unit.excel');

            //service
            Route::resource('service', App\Http\Controllers\AdminMasterServiceController::class);
            Route::post('filter/service', [App\Http\Controllers\AdminMasterServiceController::class, 'filter'])->name('service.filter');

            // Daily
            Route::resource('daily', App\Http\Controllers\DailyUnitController::class);
            Route::post('filter/daily', [App\Http\Controllers\DailyUnitController::class, 'filter'])->name('daily.filter');
            Route::post('pdf/daily', [App\Http\Controllers\DailyUnitController::class, 'pdf'])->name('daily.pdf');
            Route::post('excel/daily', [App\Http\Controllers\DailyUnitController::class, 'excel'])->name('daily.excel');
        }
    );


    Route::group(
        ['middleware' => 'CheckRole:planner'],
        function () {
            // daily operator
            Route::resource('operator', App\Http\Controllers\DailyOperatorController::class);
            Route::post('operator/filter', [App\Http\Controllers\DailyOperatorController::class, 'filter'])->name('operator.filter');

            // daily mekanik
            Route::resource('mekanik', App\Http\Controllers\DailyMekanikController::class);
            Route::post('mekanik/filter', [App\Http\Controllers\DailyMekanikController::class, 'filter'])->name('mekanik.filter');


            // Storage
            Route::resource('storage', App\Http\Controllers\StorageController::class);

            // Penjadwalan
            // Route::resource('grup', App\Http\Controllers\AdminGrupController::class)->except('show');
            Route::get('jadwal', [App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal');
            Route::get('jadwal/create', [App\Http\Controllers\JadwalController::class, 'create'])->name('buat-jadwal');
            Route::get('jadwal/{id}/edit', [App\Http\Controllers\JadwalController::class, 'edit'])->name('edit-jadwal');
            Route::post('jadwal', [App\Http\Controllers\JadwalController::class, 'store'])->name('jadwal');
            Route::patch('jadwal/{id}/update', [App\Http\Controllers\JadwalController::class, 'update'])->name('update-jadwal');
            Route::delete('jadwal/{id}/hapus', [App\Http\Controllers\JadwalController::class, 'destroy'])->name('hapus-jadwal');
            Route::get('jadwal/{id}/show', [App\Http\Controllers\JadwalController::class, 'show'])->name('show-jadwal-operator');

            Route::post('jadwal/replicate', [App\Http\Controllers\JadwalController::class, 'replicate'])->name('jadwal-replicate');
            Route::post('jadwal/lokasi', [App\Http\Controllers\JadwalController::class, 'perPit'])->name('jadwal-lokasi');

            Route::post('/group', [App\Http\Controllers\JadwalController::class, 'storeGroup'])->name('group');
            Route::get('/group/create', [App\Http\Controllers\JadwalController::class, 'createGroup'])->name('tambah-group');
            Route::get('/group/{id}/edit', [App\Http\Controllers\JadwalController::class, 'editGroup'])->name('edit-group');
            Route::patch('group/{id}/update', [App\Http\Controllers\JadwalController::class, 'updateGroup'])->name('update-group');
            Route::delete('/group/{id}/hapus', [App\Http\Controllers\JadwalController::class, 'destroyGroup'])->name('hapus-group');

            // Penjadwalan Mekanik
            Route::get('jadwal/mekanik', [App\Http\Controllers\JadwalMekanikController::class, 'index'])->name('jadwal-mekanik');
            Route::get('jadwal/mekanik/create', [App\Http\Controllers\JadwalMekanikController::class, 'create'])->name('buat-jadwal-mekanik');
            Route::get('jadwal/mekanik/{id}/edit', [App\Http\Controllers\JadwalMekanikController::class, 'edit'])->name('edit-jadwal-mekanik');
            Route::post('jadwal/mekanik', [App\Http\Controllers\JadwalMekanikController::class, 'store'])->name('jadwal-mekanik');
            Route::patch('jadwal/mekanik/{id}/update', [App\Http\Controllers\JadwalMekanikController::class, 'update'])->name('update-jadwal-mekanik');
            Route::post('jadwal/mekanik/replicate', [App\Http\Controllers\JadwalMekanikController::class, 'replicate'])->name('jadwal-replicate-mekanik');
            Route::delete('jadwal/mekanik/{id}/hapus', [App\Http\Controllers\JadwalMekanikController::class, 'destroy'])->name('hapus-jadwal-mekanik');
            Route::get('jadwal/mekanik/{id}/show', [App\Http\Controllers\JadwalMekanikController::class, 'show'])->name('show-jadwal-mekanik');
            Route::post('jadwal/mekanik/lokasi', [App\Http\Controllers\JadwalMekanikController::class, 'perPit'])->name('jadwal-lokasi-mekanik');
        }
    );

    Route::resource('chat/livewire', App\Http\Controllers\ChatLiveWireController::class);
});
