<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

use Illuminate\Support\Facades\Route;
use App\Events\BetUpdated;
use Pusher\Pusher;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminBalanceController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AdminSystemManageController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\BankChanelController;
use App\Http\Controllers\BetAdminController;
use App\Http\Controllers\BroadCastController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventControllerPrev;
use App\Http\Controllers\FinanceAdminController;
use App\Http\Controllers\ServerConinManageController;
use App\Http\Controllers\UserPanelController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\HomeController;
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


// //Clear Cache facade value:
// Route::get('/clear-cache', function() {
//     $exitCode = Artisan::call('cache:clear');
//     return '<h1>Cache facade value cleared</h1>';
// });

// //Reoptimized class loader:
// Route::get('/optimize', function() {
//     $exitCode = Artisan::call('optimize');
//     return '<h1>Reoptimized class loader</h1>';
// });

// //Route cache:
// Route::get('/route-cache', function() {
//     $exitCode = Artisan::call('route:cache');
//     return '<h1>Routes cached</h1>';
// });

// //Clear Route cache:
// Route::get('/route-clear', function() {
//     $exitCode = Artisan::call('route:clear');
//     return '<h1>Route cache cleared</h1>';
// });

// //Clear View cache:
// Route::get('/view-clear', function() {
//     $exitCode = Artisan::call('view:clear');
//     return '<h1>View cache cleared</h1>';
// });

// //Clear Config cache:
// Route::get('/config-cache', function() {
//     $exitCode = Artisan::call('config:cache');
//     return '<h1>Clear Config cleared</h1>';
// });



//Live routes
Route::get('/getCategory',[
    BroadCastController::class,
    'getCategory'
])->name('getCategory');

Route::get('/broadcast/{catId}',[
    BroadCastController::class,
    'broadcast'
])->name('broadcast');

Route::get('/broadcastMain',[
    BroadCastController::class,
    'broadcastMain'
])->name('broadcastMain');

Route::get('/broadcastCategory',[
    BroadCastController::class,
    'broadcastCategory'
])->name('broadcastCategory');

//Question hide show leader routes
Route::get('/fqHideShowLeader/{tournamentId}/{matchId}',[
    EventController::class,
    'fqHideShowLeader'
])->name('fqHideShowLeader');

Route::get('/cqHideShowLeader/{tournamentId}/{matchId}',[
    EventController::class,
    'cqHideShowLeader'
])->name('cqHideShowLeader');

//Question update leader
Route::get('/cqUpdateLeader/{cqId}/{tournamentId}/{matchId}',[
    EventController::class,
    'cqUpdateLeader'
])->name('cqUpdateLeader');
//Live match hide/show routes
Route::get('control-panel/admin/matchStatus/{id}/{tournament}/{status}',[
    EventController::class,
    'matchStatus'
])->name('matchStatus');
Route::get('/matchStatusLeader/{matchId}/{tournamentId}',[
    EventController::class,
    'matchStatusLeader'
])->name('matchStatusLeader');
//Live Bet show/hide routes
Route::get('control-panel/admin/allBetHideShow/{id}/{tournament}/{status}',[
    EventController::class,
    'allBetHideShow'
])->name('allBetHideShow');
Route::get('/allBetHideShowStatusLeader/{matchId}/{tournamentId}',[
    EventController::class,
    'allBetHideShowStatusLeader'
])->name('allBetHideShowStatusLeader');
//Live Bet On/Off routes
Route::get('control-panel/admin/liveBetOnOff/{id}/{tournament}/{status}',[
    EventController::class,
    'liveBetOnOff'
])->name('liveBetOnOff');
Route::get('/liveBetOnOffStatusLeader/{matchId}/{tournamentId}',[
    EventController::class,
    'liveBetOnOffStatusLeader'
])->name('liveBetOnOffStatusLeader');
//All Bet show/hide routes
Route::get('control-panel/admin/allBetOnOff/{id}/{tournament}/{status}',[
    EventController::class,
    'allBetOnOff'
])->name('allBetOnOff');
Route::get('/allBetOnOffStatusLeader/{matchId}/{tournamentId}',[
    EventController::class,
    'allBetOnOffStatusLeader'
])->name('allBetOnOffStatusLeader');
//Betting turn on/off status
Route::get('control-panel/admin/fqStatusChange/{id}/{matchId}/{tournament}/{status}',[
    EventController::class,
    'fqStatusChange'
])->name('fqStatusChange');

Route::get('control-panel/admin/cqStatusChange/{id}/{matchId}/{tournament}/{status}',[
    EventController::class,
    'cqStatusChange'
])->name('cqStatusChange');
//Hide question status
Route::get('control-panel/admin/fqHideShow/{id}/{matchId}/{tournament}/{status}',[
    EventController::class,
    'fqHideShow'
])->name('fqHideShow');

Route::get('control-panel/admin/cqHideShow/{id}/{matchId}/{tournament}/{status}',[
    EventController::class,
    'cqHideShow'
])->name('cqHideShow');
//Match finish from live match
Route::get('control-panel/admin/matchFinish/{tournament}/{id}',[
    EventController::class,
    'matchFinish'
])->name('matchFinish');
Route::get('control-panel/admin/matchHide/{tournament}/{id}',[
    EventController::class,
    'matchHide'
])->name('matchHide');
 Route::get('control-panel/admin/hideUserPage/{tournament}/{id}',[
     EventController::class,
     'hideUserPage'
 ])->name('hideUserPage');
//Update question details
 
Route::post('control-panel/admin/fqUpdate',[
    EventController::class,
    'fQupdate'
])->name('fQupdate');
Route::get('/fqUpdateLeader/{fqId}/{tournamentId}/{matchId}',[
    EventController::class,
    'fqUpdateLeader'
])->name('fqUpdateLeader');

Route::post('control-panel/admin/cqUpdate',[
   EventController::class,
   'cQupdate'
])->name('cQupdate');

//Publish single result
Route::get('control-panel/admin/publishSingleResult/{team}/{id}/{matchId}/{tournament}',[
    EventController::class,
    'publishSingleResult'
])->name('publishSingleResult');
//Unpublish fixed question
Route::get('control-panel/admin/fqUnpublish/{id}/{matchId}/{tournament}',[
    EventController::class,
    'fqUnpublish'
])->name('fqUnpublish');
Route::get('control-panel/admin/pertialPublish/{id}/{matchId}/{tournament}/{quesId}/{betOn}/{pertialAmount}',[
    EventController::class,
    'pertialPublish'
])->name('');
//Unpublish custom answer
Route::get('control-panel/admin/cqUnpublish/{id}/{matchId}/{tournament}',[
    EventController::class,
    'cqUnpublish'
])->name('pertialPublish');

Route::get('control-panel/admin/publishCQResult/{answer}/{id}/{matchId}/{tournament}',[
    EventController::class,
    'publishCQResult'
])->name('publishCQResult');
 
Route::post('dashboard/cqBetPlace',[
    UserPanelController::class,
    'cqBetPlace'
])->name('cqBetPlace');
 
Route::post('dashboard/fqBetPlace',[
    UserPanelController::class,
    'fqBetPlace'
])->name('fqBetPlace');
 
Route::get('fqsendLiveRoom/{id}/{matchId}/{tournament}',[
    EventController::class,
    'fqsendLiveRoom'
])->name('fqsendLiveRoom');
 

//Manual Routes
Route::get('/',[
    FrontController::class,
    'frontHome'
])->name('frontHome');

Route::get('/advanceBet',[
    FrontController::class,
    'advanceBet'
])->name('advanceBet');

//user login/registration system
Route::get('user-register',[
    FrontController::class,
    'userRegister'
])->name('userRegister');
 
Route::post('confirm-user-register',[
    FrontController::class,
    'confirmRegister'
])->name('confirmRegister');

Route::get('user-login',[
    FrontController::class,
    'userLogin'
])->name('userLogin');

Route::post('confirm-user-login',[
    FrontController::class,
    'confirmLogin'
])->name('confirmLogin');
 
Route::post('user-logout',[
    FrontController::class,
    'userlogout'
])->name('userlogout');
 
Route::post('admin-logout',[
    FrontController::class,
    'adminLogout'
])->name('adminLogout');
 
Route::post('club-logout',[
    FrontController::class,
    'clubLogout'
])->name('clubLogout');
 
 //User Dashboard Routes
 
Route::get('dashboard',[
    UserViewController::class,
    'userdash'
])->name('userdash');
 
Route::get('dashboard/profile',[
    UserViewController::class,
    'userprofile'
])->name('userprofile');

Route::post('dashboard/update-profile',[
    UserPanelController::class,
    'profileupdate'
])->name('profileupdate');
 
//Change password
Route::get('dashboard/changeMyPass',[
    UserViewController::class,
    'changeMyPass'
])->name('changeMyPass');

Route::post('dashboard/updateMyPass',[
    UserPanelController::class,
    'updateMyPass'
])->name('updateMyPass');
 
//Change club
Route::get('dashboard/changeMyClub',[
    UserViewController::class,
    'changeMyClub'
])->name('changeMyClub');

Route::post('dashboard/updateMyClub',[
    UserPanelController::class,
    'updateMyClub'
])->name('updateMyClub');
 
//Betting History routes
Route::get('dashboard/betHistory',[
    UserViewController::class,
    'betHistory'
])->name('betHistory');
 
Route::get('dashboard/myFollowerList',[
    UserViewController::class,
    'myFollowerList'
])->name('myFollowerList');
 
//account statement routes
Route::get('dashboard/customerAccountStmt',[
    UserViewController::class,
    'customerAccountStmt'
])->name('customerAccountStmt');
 //Deposit routes
 Route::get('dashboard/makeDeposit',[
     UserViewController::class,
     'makeDeposit'
 ])->name('makeDeposit');
 
Route::get('dashboard/deposit/hisroty',[
    UserViewController::class,
    'depositHistory'
])->name('depositHistory');

Route::post('dashboard/depositRequest',[
    UserPanelController::class,
    'depositRequest'
])->name('depositRequest');
 
//Withdrawal routes
Route::get('dashboard/makeWithdraw',[
    UserViewController::class,
    'makeWithdraw'
])->name('makeWithdraw');
 
Route::get('dashboard/withdraw/hisroty',[
    UserViewController::class,
    'withdrawHistory'
])->name('withdrawHistory');

Route::post('dashboard/withdrawRequest',[
    UserPanelController::class,
    'withdrawRequest'
])->name('withdrawRequest');

Route::get('dashboard/refundWithdraw/{id}',[
    UserPanelController::class,
    'refundWithdraw'
])->name('refundWithdraw');
 
//C2C Transfer routes
Route::get('dashboard/makeC2CTransfer',[
    UserViewController::class,
    'makeC2CTransfer'
])->name('makeC2CTransfer');
 
Route::get('dashboard/c2c/transfer-history',[
    UserViewController::class,
    'C2CTransferHistory'
])->name('C2CTransferHistory');

Route::post('dashboard/C2CTransferRequest',[
    UserPanelController::class,
    'C2CTransferRequest'
])->name('C2CTransferRequest');

Route::get('dashboard/c2c/receiving-history',[
    UserViewController::class,
    'C2CReceivingHistory'
])->name('C2CReceivingHistory');
 
 
 //club management routes
Route::get('club/login',[
    FrontController::class,
    'clubLogin'
])->name('clubLogin');
 
Route::post('club/confirmClubLogin',[
    FrontController::class,
    'confirmClubLogin'
])->name('confirmClubLogin');
 
//Withdrawal routes
Route::get('club/home',[
    ClubController::class,
    'home'
])->name('clubHome');
 
Route::get('club/makeClubWithdraw',[
    ClubController::class,
    'makeClubWithdraw'
])->name('makeClubWithdraw');

Route::post('club/submitClubWithdraw',[
    ClubController::class,
    'submitClubWithdraw'
])->name('submitClubWithdraw');
 
Route::get('club/clubWithdrawHistory/{club}',[
    ClubController::class,
    'clubWithdrawHistory'
])->name('clubWithdrawHistory');
//Club Statement
Route::get('club/statement/{club}',[
    ClubController::class,
    'clubStatement'
])->name('clubStatement');
 
Route::get('club/follower/{clubid}',[
    ClubController::class,
    'clubFollower'
])->name('clubFollower');
//Club Activities 
Route::get('club/settings',[
    ClubController::class,
    'clubSettings'
])->name('clubSettings');

Route::post('club/update-settings',[
    ClubController::class,
    'clubDetailsUpdate'
])->name('clubDetailsUpdate');
 
 //Admin panel login/register routes
Route::get('control-panel/admin-login',[
    FrontController::class,
    'adminLogin'
])->name('adminLogin');
 
Route::post('control-panel/confirmAdminLogin',[
    FrontController::class,
    'confirmAdminLogin'
])->name('confirmAdminLogin');
 
Route::post('control-panel/admin/confirmRegister',[
    FrontController::class,
    'confirmSuperAdminRegister'
])->name('confirmSuperAdminRegister');
//Admin panel routes

Route::get('control-panel/admin/serverConfig',[
    AdminSystemManageController::class,
    'serverConfig'
])->name('serverConfig');
 
Route::post('control-panel/admin/saveConfig',[
    AdminPanelController::class,
    'saveConfig'
])->name('saveConfig');

Route::get('control-panel/admin/home',[
    AdminViewController::class,
    'AdminHome'
])->name('AdminHome');
 
Route::get('control-panel/admin/profile',[
    AdminViewController::class,
    'adminProfile'
])->name('adminProfile');
 
Route::post('control-panel/admin/profile/update',[
    AdminPanelController::class,
    'updateAdmin'
])->name('updateAdmin');
 
Route::post('control-panel/admin/profile/passUpdate',[
    AdminPanelController::class,
    'updateAdminPass'
])->name('updateAdminPass');
//Deposit routes 
Route::get('control-panel/admin/pendingDeposit',[
    AdminViewController::class,
    'pendingDeposit'
])->name('pendingDeposit');
 
Route::get('control-panel/admin/paidDeposit',[
    AdminViewController::class,
    'paidDeposit'
])->name('paidDeposit');
 
Route::get('control-panel/admin/unpaidDeposit',[
    AdminViewController::class,
    'unpaidDeposit'
])->name('unpaidDeposit');
 
Route::get('control-panel/admin/acceptDeposit/{id}',[
    AdminPanelController::class,
    'acceptDeposit'
])->name('acceptDeposit');
 
Route::get('control-panel/admin/rejectDeposit/{id}',[
    AdminPanelController::class,
    'rejectDeposit'
])->name('rejectDeposit'); 
 
Route::get('control-panel/admin/returnDeposit/{id}',[
    AdminPanelController::class,
    'returnDeposit'
])->name('returnDeposit');
 
Route::get('control-panel/admin/refundDeposit/{id}',[
    AdminPanelController::class,
    'refundDeposit'
])->name('refundDeposit');

//Withdrawal routes
Route::get('control-panel/admin/checkUserStmt/{id}',[
    AdminViewController::class,
    'checkUserStmt'
])->name('checkUserStmt');
 
Route::get('control-panel/admin/pendingWithdrawal',[
    AdminViewController::class,
    'pendingWithdrawal'
])->name('pendingWithdrawal');

Route::get('control-panel/admin/paidWithdrawal',[
    AdminViewController::class,
    'paidWithdrawal'
])->name('paidWithdrawal');

Route::get('control-panel/admin/unpaidWithdrawal',[
    AdminViewController::class,
    'unpaidWithdrawal'
])->name('unpaidWithdrawal');
 
Route::get('control-panel/admin/processWithdrawRequest',[
    AdminViewController::class,
    'processWithdrawRequest'
])->name('processWithdrawRequest');
 
Route::get('control-panel/admin/acceptWithdrawal/{id}',[
    AdminViewController::class,
    'acceptWithdrawal'
])->name('acceptWithdrawal'); 
 
Route::post('control-panel/admin/confirmWithdrawal',[
    AdminPanelController::class,
    'confirmWithdrawal'
])->name('confirmWithdrawal'); 
 
Route::get('control-panel/admin/processingWithdrawal/{id}',[
    AdminPanelController::class,
    'processingWithdrawal'
])->name('processingWithdrawal');
 
Route::get('control-panel/admin/rejectWithdrawal/{id}',[
    AdminPanelController::class,
    'rejectWithdrawal'
])->name('rejectWithdrawal');
 
Route::get('control-panel/admin/sendToPendingList/{id}',[
    AdminViewController::class,
    'rejToPenWithdraw'
])->name('rejToPenWithdraw');

//Report routes
Route::get('control-panel/admin/customerReport',[
    AdminViewController::class,
    'customerReport'
])->name('customerReport'); 
 
Route::post('control-panel/admin/finalCustomerReport',[
    AdminViewController::class,
    'finalCustomerReport'
])->name('finalCustomerReport'); 
//End Reports routes

//Club Withdrawal routes
Route::get('control-panel/admin/checkClubStmt/{id}',[
    AdminViewController::class,
    'checkClubStmt'
])->name('checkClubStmt');
 
Route::get('control-panel/admin/clubPendingWithdraw',[
    AdminViewController::class,
    'clubPendingWithdraw'
])->name('clubPendingWithdraw');

Route::get('control-panel/admin/clubPaidWithdraw',[
    AdminViewController::class,
    'clubPaidWithdraw'
])->name('clubPaidWithdraw');

Route::get('control-panel/admin/clubUnpaidWithdraw',[
    AdminViewController::class,
    'clubUnpaidWithdraw'
])->name('clubUnpaidWithdraw');
 
Route::get('control-panel/admin/clubProcessWithdrawList',[
    AdminViewController::class,
    'clubProcessWithdrawList'
])->name('clubProcessWithdrawList');
 
Route::get('control-panel/admin/clubAcceptWithdraw/{id}',[
    AdminViewController::class,
    'clubAcceptWithdraw'
])->name('clubAcceptWithdraw'); 
 
Route::post('control-panel/admin/clubConfirmWithdraw',[
    AdminPanelController::class,
    'clubConfirmWithdraw'
])->name('clubConfirmWithdraw'); 
 
Route::get('control-panel/admin/clubProcessWithdraw/{id}',[
    AdminPanelController::class,
    'clubProcessWithdraw'
])->name('clubProcessWithdraw');
 
Route::get('control-panel/admin/clubRejectWithdraw/{id}',[
    AdminPanelController::class,
    'clubRejectWithdraw'
])->name('clubRejectWithdraw');

//User controller routes
 
Route::get('control-panel/admin/activeUser',[
    AdminViewController::class,
    'activeUser'
])->name('activeUser');
 
Route::get('control-panel/admin/searchUser',[
    AdminViewController::class,
    'searchUser'
])->name('searchUser');
 
Route::post('control-panel/admin/user/single/result/',[
    AdminViewController::class,
    'singleUser'
])->name('singleUser');
 
Route::get('control-panel/admin/bannedUser',[
    AdminViewController::class,
    'bannedUser'
])->name('bannedUser');
 
Route::get('control-panel/admin/editUser/{id}',[
    AdminViewController::class,
    'editUser'
])->name('editUser');
 
Route::post('control-panel/admin/updateUser',[
    AdminPanelController::class,
    'updateUser'
])->name('updateUser');
 
Route::get('control-panel/admin/changePassword/{id}',[
    AdminViewController::class,
    'changePassword'
])->name('changePassword');
 
Route::get('control-panel/admin/a2cTransfer/{id}',[
    AdminViewController::class,
    'a2cTransfer'
])->name('a2cTransfer');
 
Route::get('control-panel/admin/a2aTransfer/{id}',[
    AdminViewController::class,
    'a2aTransfer'
])->name('a2aTransfer');
 
Route::post('control-panel/admin/confirmA2CTransfer',[
    AdminPanelController::class,
    'confirmA2CTransfer'
])->name('confirmA2CTransfer');
 
Route::post('control-panel/admin/confirmA2ATransfer',[
    AdminPanelController::class,
    'confirmA2ATransfer'
])->name('confirmA2ATransfer');
 
Route::post('control-panel/admin/changeUserPass',[
    AdminPanelController::class,
    'changeUserPass'
])->name('changeUserPass');
 
Route::get('control-panel/admin/bannedStatus/{id}',[
    AdminViewController::class,
    'bannedStatus'
])->name('bannedStatus');
 
Route::get('control-panel/admin/activeStatus/{id}',[
    AdminViewController::class,
    'activeStatus'
])->name('activeStatus');
 
Route::get('control-panel/admin/deleteUser/{id}',[
    AdminViewController::class,
    'delUser'
])->name('delUser');

//Category controller route
Route::get('control-panel/admin/categoryList',[
    AdminViewController::class,
    'categoryList'
])->name('categoryList');
 
Route::get('control-panel/admin/newCategory',[
    AdminViewController::class,
    'newCategory'
])->name('newCategory');
 
Route::post('control-panel/admin/saveCategory',[
    AdminPanelController::class,
    'saveCategory'
])->name('saveCategory');
 
Route::get('control-panel/admin/editCategory/{id}',[
    AdminViewController::class,
    'editCategory'
])->name('editCategory');
 
Route::post('control-panel/admin/updateCategory',[
    AdminPanelController::class,
    'updateCategory'
])->name('updateCategory');
 
Route::get('control-panel/admin/deleteCategory/{id}',[
    AdminViewController::class,
    'deleteCategory'
])->name('deleteCategory');
 
 //Category controller route
Route::get('control-panel/admin/sliders',[
    AdminViewController::class,
    'sliderList'
])->name('sliderList');
 
Route::get('control-panel/admin/newSlider',[
    AdminViewController::class,
    'newSlider'
])->name('newSlider');
 
Route::post('control-panel/admin/saveSlider',[
    AdminPanelController::class,
    'saveSlider'
])->name('saveSlider');
 
Route::get('control-panel/admin/editSlider/{id}',[
    AdminViewController::class,
    'editSlider'
])->name('editSlider');
 
Route::post('control-panel/admin/updateSlider',[
    AdminPanelController::class,
    'updateSlider'
])->name('updateSlider');
 
Route::get('control-panel/admin/deleteSlider/{id}',[
    AdminViewController::class,
    'deleteSlider'
])->name('deleteSlider');

//Admin system manage controller route
Route::get('control-panel/admin/manageAdmin',[
    AdminSystemManageController::class,
    'manageAdmin'
])->name('manageAdmin');
 
Route::get('control-panel/admin/newAdminProfile',[
    AdminSystemManageController::class,
    'newAdminProfile'
])->name('newAdminProfile');
 
Route::post('control-panel/admin/saveAdminProfile',[
    AdminSystemManageController::class,
    'saveAdminProfile'
])->name('saveAdminProfile');
 
Route::get('control-panel/admin/editAdminProfile/{id}',[
    AdminSystemManageController::class,
    'editAdminProfile'
])->name('editAdminProfile');
 
Route::post('control-panel/admin/updateAdminProfile',[
    AdminSystemManageController::class,
    'updateAdminProfile'
])->name('updateAdminProfile');
 
Route::get('control-panel/admin/deleteAdminProfile/{id}',[
    AdminSystemManageController::class,
    'delAdminProfile'
])->name('delAdminProfile');
 
Route::get('control-panel/admin/inactiveAdminProfile/{id}',[
    AdminSystemManageController::class,
    'inactiveAdminProfile'
])->name('inactiveAdminProfile');
 
Route::get('control-panel/admin/activeAdminProfile/{id}',[
    AdminSystemManageController::class,
    'activeAdminProfile'
])->name('activeAdminProfile');
//Server coin management
 
Route::get('control-panel/admin/serverCoin',[
    AdminBalanceController::class,
    'serverCoin'
])->name('serverCoin');
 
Route::post('control-panel/admin/createServerCoin',[
    AdminBalanceController::class,
    'createServerCoin'
])->name('createServerCoin');
 
Route::get('control-panel/admin/adminCoin',[
    AdminBalanceController::class,
    'adminCoin'
])->name('adminCoin');
 
Route::post('control-panel/admin/createAdminCoin',[
    AdminBalanceController::class,
    'createAdminCoin'
])->name('createAdminCoin');

//bank chanels controller route
Route::get('control-panel/admin/manageBankChanel',[
    BankChanelController::class,
    'manageBankChanel'
])->name('manageBankChanel');
 
Route::get('control-panel/admin/newBankChanel',[
    BankChanelController::class,
    'newBankChanel'
])->name('newBankChanel');
 
Route::post('control-panel/admin/saveBankChanel',[
    BankChanelController::class,
    'saveBankChanel'
])->name('saveBankChanel');
 
Route::get('control-panel/admin/editBankChanel/{id}',[
    BankChanelController::class,
    'editBankChanel'
])->name('editBankChanel');
 
Route::post('control-panel/admin/updateBankChanel',[
    BankChanelController::class,
    'updateBankChanel'
])->name('updateBankChanel');
 
Route::get('control-panel/admin/deleteBankChanel/{id}',[
    BankChanelController::class,
    'deleteBankChanel'
])->name('deleteBankChanel');

//Teams controller route
Route::get('control-panel/admin/teamList',[
    AdminViewController::class,
    'teamList'
])->name('teamList');
 
Route::get('control-panel/admin/newTeam',[
    AdminViewController::class,
    'newTeam'
])->name('newTeam');
 
Route::post('control-panel/admin/saveTeam',[
    AdminPanelController::class,
    'saveTeam'
])->name('saveTeam');
 
Route::get('control-panel/admin/editTeam/{id}',[
    AdminViewController::class,
    'editTeam'
])->name('editTeam');
 
Route::post('control-panel/admin/updateTeam',[
    AdminPanelController::class,
    'updateTeam'
])->name('updateTeam');
 
Route::get('control-panel/admin/deleteTeam/{id}',[
    AdminViewController::class,
    'deleteTeam'
])->name('deleteTeam');

//Tournament controller route
Route::get('control-panel/admin/tournamentList',[
    AdminViewController::class,
    'tournamentList'
])->name('tournamentList');
 
Route::get('control-panel/admin/newTournament',[
    AdminViewController::class,
    'newTournament'
])->name('newTournament');
 
Route::post('control-panel/admin/saveTournament',[
    AdminPanelController::class,
    'saveTournament'
])->name('saveTournament');
 
Route::get('control-panel/admin/editTournament/{id}',[
    AdminViewController::class,
    'editTournament'
])->name('editTournament');
 
Route::post('control-panel/admin/updateTournament',[
    AdminPanelController::class,
    'updateTournament'
])->name('updateTournament');
 
Route::get('control-panel/admin/deleteTournament/{id}',[
    AdminViewController::class,
    'deleteTournament'
])->name('deleteTournament');

//Club controller route
Route::get('control-panel/admin/clubList',[
    AdminViewController::class,
    'clubList'
])->name('clubList');
 
Route::get('control-panel/admin/newClub',[
    AdminViewController::class,
    'newClub'
])->name('newClub');
 
Route::post('control-panel/admin/saveClub',[
    AdminPanelController::class,
    'saveClub'
])->name('saveClub');
 
Route::get('control-panel/admin/editClub/{id}',[
    AdminViewController::class,
    'editClub'
])->name('editClub');
 
Route::post('control-panel/admin/updateClub',[
    AdminPanelController::class,
    'updateClub'
])->name('updateClub');
 
Route::get('control-panel/admin/bannedClub/{id}',[
    AdminViewController::class,
    'bannedClub'
])->name('bannedClub');
 
Route::get('control-panel/admin/activeClub/{id}',[
    AdminViewController::class,
    'activeClub'
])->name('activeClub');
 
Route::get('control-panel/admin/deleteClub/{id}',[
    AdminViewController::class,
    'delClub'
])->name('delClub');


//Match creation controller route
Route::get('control-panel/admin/matchList/{catId}',[
    AdminViewController::class,
    'matchList'
])->name('matchList');
Route::get('control-panel/admin/finishMatchList/{catId}',[
    AdminViewController::class,
    'finishMatchList'
])->name('finishMatchList');
 
Route::get('control-panel/admin/newMatch',[
    AdminViewController::class,
    'newMatch'
])->name('newMatch');
 
 
Route::post('control-panel/admin/saveMatch',[
    AdminPanelController::class,
    'saveMatch'
])->name('saveMatch');
 
Route::get('control-panel/admin/editMatch/{id}',[
    AdminViewController::class,
    'editMatch'
])->name('editMatch');
 
Route::post('control-panel/admin/updateMatch',[
    AdminPanelController::class,
    'updateMatch'
])->name('updateMatch');
 
Route::get('control-panel/admin/deleteMatch/{id}',[
    EventController::class,
    'deleteMatch'
])->name('deleteMatch');

//BetOption controller route
Route::get('control-panel/admin/betOptions',[
    AdminViewController::class,
    'betOptions'
])->name('betOptions');
 
Route::get('control-panel/admin/newBetOption',[
    AdminViewController::class,
    'newBetOption'
])->name('newBetOption');
 
Route::post('control-panel/admin/saveBetOption',[
    AdminPanelController::class,
    'saveBetOption'
])->name('saveBetOption');
 
Route::get('control-panel/admin/editBetOption/{id}',[
    AdminViewController::class,
    'editBetOption'
])->name('editBetOption');
 
Route::post('control-panel/admin/updateBetOption',[
    AdminPanelController::class,
    'updateBetOption'
])->name('updateBetOption');
 
Route::get('control-panel/admin/deleteBetOption/{id}',[
    AdminViewController::class,
    'deleteBetOption'
])->name('deleteBetOption');
 
//BetAnswer controller route
Route::get('control-panel/admin/betAnswer',[
    AdminViewController::class,
    'betAnswer'
])->name('betAnswer');
 
Route::get('control-panel/admin/newBetAnswer',[
    AdminViewController::class,
    'newBetAnswer'
])->name('newBetAnswer');
 
Route::post('control-panel/admin/saveBetAnswer',[
    AdminPanelController::class,
    'saveBetAnswer'
])->name('saveBetAnswer');
 
Route::get('control-panel/admin/editBetAnswer/{id}',[
    AdminViewController::class,
    'editBetAnswer'
])->name('editBetAnswer');
 
Route::post('control-panel/admin/updateBetAnswer',[
    AdminPanelController::class,
    'updateBetAnswer'
])->name('updateBetAnswer');
 
Route::get('control-panel/admin/deleteBetAnswer/{id}',[
    AdminViewController::class,
    'deleteBetAnswer'
])->name('deleteBetAnswer');
 
 

 
//Match Question controller route
Route::get('control-panel/admin/match/liveRoom/{id}',[
    AdminViewController::class,
    'liveRoom'
])->name('liveRoom');
Route::get('control-panel/admin/match/manage/{id}',[
     AdminViewController::class,
     'matchManage'
])->name('matchManage');
Route::get('control-panel/admin/match/unpublishQuestion/{id}',[
    AdminViewController::class,
    'unpublishQuestion'
])->name('unpublishQuestion');
 
Route::get('control-panel/admin/matchBetHistory/{id}',[
    AdminViewController::class,
    'matchBetHistory'
])->name('matchBetHistory');
 
Route::get('control-panel/admin/profitLoss/{id}',[
    AdminViewController::class,
    'profitLoss'
])->name('profitLoss');
 
Route::get('control-panel/admin/questionBetHistory/{matchid}/{quesId}/{betOn}',[
    AdminViewController::class,
    'questionBetHistory'
])->name('questionBetHistory');
 
Route::get('control-panel/admin/returnBets/{id}',[
    AdminPanelController::class,
    'returnBets'
])->name('returnBets');

Route::get('control-panel/admin/betReturn/{matchId}/{qId}',[
    AdminPanelController::class,
    'betReturn'
])->name('betReturn');

 Route::get('control-panel/admin/liveRoom/{id}',[
     AdminViewController::class,
     'liveRoom'
 ])->name('liveRoom');
 
Route::get('control-panel/admin/newMatchQuestion',[
    AdminViewController::class,
    'newMatchQuestion'
])->name('newMatchQuestion');
 
Route::post('control-panel/admin/saveMatchQuestion',[
    AdminPanelController::class,
    'saveMatchQuestion'
])->name('saveMatchQuestion'); 

Route::post('control-panel/admin/fixedSingleUpdate',[
    AdminPanelController::class,
    'fixedSingleUpdate'
])->name('fixedSingleUpdate');
 
Route::post('control-panel/admin/customQuestionUpdate',[
    AdminPanelController::class,
    'customQuestionUpdate'
])->name('customQuestionUpdate');
 
Route::get('control-panel/admin/deleteSingleQuestion/{id}',[
    AdminViewController::class,
    'deleteSingleQuestion'
])->name('deleteSingleQuestion');
 
Route::get('control-panel/admin/deleteCustomQuestion/{id}',[
    AdminViewController::class,
    'deleteCustomQuestion'
])->name('deleteCustomQuestion');
 
  
 
//JS get data controller route 
Route::get('control-panel/admin/getTournament/{id}',[
    AdminViewController::class,
    'getTournament'
])->name('getTournament'); 
 
Route::get('control-panel/admin/getTeam/{id}',[
    AdminViewController::class,
    'getTeam'
])->name('getTeam'); 
 
Route::get('control-panel/admin/getEditTeam/{id}/{teamA}/{teamB}',[
    AdminViewController::class,
    'getEditTeam'
])->name('getEditTeam'); 
 
Route::get('control-panel/admin/getOption/{id}',[
    AdminViewController::class,
    'getOption'
])->name('getOption'); 


Route::get('control-panel/admin/getOptionAnswer/{id}',[
    AdminViewController::class,
    'getOptionAnswer'
])->name('getOptionAnswer');

Route::get('control-panel/admin/getFixedOption/{id}/{qId}',[
    AdminViewController::class,
    'getFixedOption'
])->name('getFixedOption');


Route::get('control-panel/admin/getCustomAnswer/{id}',[
    AdminViewController::class,
    'getCustomAnswer'
])->name('getCustomAnswer');


Route::get('control-panel/admin/getAnswerData/{id}',[
    AdminViewController::class,
    'getAnswerList'
])->name('getAnswerList'); 

Route::get('control-panel/admin/getMatchAnswerData/{id}',[
    AdminViewController::class,
    'getMatchAnswerList'
])->name('getMatchAnswerList'); 


