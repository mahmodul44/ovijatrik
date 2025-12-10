<?php

use App\Models\MoneyReceipt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanAccountController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\FalseReceiptController;
use App\Http\Controllers\MoneyReceiptController;
use App\Http\Controllers\MemberReceiptController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\ProjectExpenseController;
use App\Http\Controllers\ExpenseCategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('admin.newdashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('about', AboutController::class);
        Route::resource('gallery', GalleryController::class);
        Route::resource('project', ProjectController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('subcategory', SubCategoryController::class);
        Route::resource('expensecategory', ExpenseCategoryController::class);
        Route::resource('moneyreceipt', MoneyReceiptController::class);
        Route::resource('expense', ExpenseController::class);
        Route::resource('report', ReportController::class);
        Route::resource('user', UserController::class);
        Route::resource('member', MemberController::class);
        Route::resource('mytransaction', MyTransactionController::class);
        Route::resource('transfer', TransferController::class);
        Route::resource('memberreceipt', MemberReceiptController::class);
        Route::resource('projectexpense', ProjectExpenseController::class);
        Route::resource('employee', EmployeeController::class);
        Route::resource('account', AccountController::class);
        Route::resource('loanaccount', LoanAccountController::class);
        Route::resource('salary', SalaryController::class);
        Route::resource('falsereceipt', FalseReceiptController::class);
    });

/* About */
Route::get('/about/missionvission',[AboutController::class,'missionVission'])->name('about.missionvission');   
Route::put('/about/missionvissionstore/{id}',[AboutController::class,'missionVissionStore'])->name('about.missionvissionstore'); 
Route::get('/about/basicsetting',[AboutController::class,'basicSetting'])->name('about.basicsetting');   
Route::put('/about/basicsetting/basicsettingupdate/{id}', 
    [AboutController::class,'basicSettingUpdate'])
    ->name('about.basicsettingupdate');


// web.php

Route::post('/employee/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employee.toggleStatus');    
Route::get('/get-subcategories/{category_id}', [CategoryController::class, 'getSubcategories']);
Route::get('/member-search', [MoneyReceiptController::class, 'memberSearch'])->name('member.search');
Route::get('/invoice-download/{mr_id}', [MoneyReceiptController::class, 'invoiceDownload'])->name('moneyreceipt.invoicedownload');
Route::get('/admin/moneyreceiptpending', [MoneyReceiptController::class, 'moneyreceiptpendingList'])->name('moneyreceipt.moneyreceiptpending');
Route::post('/admin/moneyreceipt-approve', [MoneyReceiptController::class, 'moneyreceiptApprove'])->name('moneyreceipt.moneyreceiptapprove');
Route::post('/admin/moneyreceipt-decline', [MoneyReceiptController::class, 'moneyreceiptDecline'])
     ->name('moneyreceipt.moneyreceiptdecline');
Route::get('/admin/moneyreceipt/show/{id}', [MoneyReceiptController::class, 'show'])->name('moneyreceipt.show');

/* False Receipt Start  
Route::get('/admin/falsereceipt/invoice-preview/{id}', [MoneyReceiptController::class, 'flaseInvoice'])->name('falsereceipt.invoice-preview');  
Route::get('/admin/falsereceipt/index', [MoneyReceiptController::class, 'falsereceiptIndex'])->name('falsereceipt.index');     
Route::get('/admin/falsereceipt/create', [MoneyReceiptController::class, 'falsereceiptCreate'])->name('falsereceipt.create');     
Route::post('/admin/falsereceipt/store', [MoneyReceiptController::class, 'falseReceiptstore'])->name('falsereceipt.store');     
Route::delete('/admin/falsereceipt/destroy/{id}', [MoneyReceiptController::class, 'falsereceiptDelete'])->name('falsereceipt.destroy');     

Route::get('/admin/falsereceipt/edit/{id}', [MoneyReceiptController::class, 'flasereceiptEdit'])->name('falsereceipt.falsereceiptedit');
 False Receipt END */

Route::get('/admin/memberreceiptpending', [MemberReceiptController::class, 'memberreceiptpendingList'])->name('memberreceipt.memberreceiptpending');
Route::post('/admin/memberreceipt-approve', [MemberReceiptController::class, 'memberreceiptApprove'])->name('memberreceipt.memberreceiptapprove');
Route::post('/admin/memberreceipt-decline', [MemberReceiptController::class, 'memberreceiptDecline'])
     ->name('memberreceipt.memberreceiptdecline');
Route::get('/invoice-preview/{mr_id}', [MemberReceiptController::class, 'invoiceDownload'])->name('memberreceipt.invoicedownload');
Route::get('/member/fiscal-info/{id}', [MemberReceiptController::class, 'getFiscalInfo'])->name('member.fiscal.info');

Route::post('/get-project-ledger', [ProjectExpenseController::class, 'getProjectLedger']);

Route::get('/project-search', [ProjectController::class, 'projectSearch'])->name('project.search');
Route::post('/admin/project/{project}/images/ajax-store', [ProjectController::class, 'imageStore'])->name('projectimages.store');
Route::delete('/admin/project/images/{image}', [ProjectController::class, 'ajaxDelete'])->name('project.images.ajaxDelete');
// project wise ledger total
Route::get('/project-wise-total/{project_id}', [ProjectController::class, 'projectWiseTotal']);

Route::get('/expense-search', [ExpenseController::class, 'expenseSearch'])->name('expense.search');
Route::get('/admin/member-pending', [MemberController::class, 'memberPending'])->name('member.pendinglist');
Route::get('/admin/user-pending', [UserController::class, 'userPending'])->name('user.pendinglist');
Route::get('/admin/expensepending', [ExpenseController::class, 'expensePendinglist'])->name('expense.expensepending');
Route::post('/admin/expense-approve', [ExpenseController::class, 'expenseApprove'])->name('expense.approveexpense');
Route::post('/admin/expense-decline', [ExpenseController::class, 'expenseDecline'])
     ->name('expense.expensedecline');
Route::get('/admin/expense/preview/{id}', [ExpenseController::class, 'expensePreview'])->name('expense.preview');       
Route::get('/admin/expense/show/{id}', [ExpenseController::class, 'show'])->name('expense.show');     

// Project wise expense
Route::get('/admin/projectexpensepending', [ProjectExpenseController::class, 'expensePendinglist'])->name('projectexpense.projectexpensepending');
Route::post('/admin/project-expense-approve', [ProjectExpenseController::class, 'projectexpenseApprove'])->name('projectexpense.approveprojectexpense');
Route::post('/admin/project-expense-decline', [ProjectExpenseController::class, 'projectexpenseDecline'])
     ->name('projectexpense.projectexpensedecline');
Route::get('/admin/projectexpense/preview/{id}', [ProjectExpenseController::class, 'expensePreview'])->name('projectexpense.preview');       
Route::get('/admin/projectexpense/show/{id}', [ProjectExpenseController::class, 'show'])->name('projectexpense.show');   

// web.php
Route::post('/admin/approve-user', [UserController::class, 'approveUser'])->name('users.approve');

/* transfer */
Route::get('/admin/transferpending', [TransferController::class, 'transferPendinglist'])->name('transfer.transferpending');
Route::get('/admin/transfer-preview/{id}',[TransferController::class,'transferPreview'])->name('transfer.transferPreview');
Route::post('/admin/transfer-approve', [TransferController::class, 'transferapprove'])->name('transfer.transferapprove');
Route::post('/admin/transfer-decline', [TransferController::class, 'transferDecline'])
     ->name('transfer.transferdecline');

/* salary */
Route::get('/admin/salarypendinglist', [SalaryController::class, 'salarypendingList'])->name('salary.salarypendinglist');
Route::post('/admin/salaryapprove', [SalaryController::class, 'salaryApprove'])->name('salary.salaryapprove');
Route::post('/admin/salarydecline/{id}', [SalaryController::class, 'salaryDecline'])
    ->name('salary.salarydecline');

/* Loan Apply and Loan Payment */
Route::get('/admin/loanapply', [LoanAccountController::class, 'loanApply'])->name('loan.loanapply');  
Route::get('/admin/loan/loancreate', [LoanAccountController::class, 'loanCreate'])->name('loan.loancreate');     
Route::post('/admin/loan/loanstore', [LoanAccountController::class, 'loanStore'])->name('loan.loanstore');     
Route::post('/get-loanaccount-ledger',[LoanAccountController::class,'getloanaccountLedger']);
Route::get('/project-total/{project_id}', [LoanAccountController::class, 'projectTotal']);
Route::get('/admin/loan/loanpending', [LoanAccountController::class, 'loanPending'])->name('loan.loanpending');     
Route::get('/admin/loan-preview/{id}', [LoanAccountController::class, 'loanPreview'])->name('loan.preview');
Route::post('/admin/loan-approve/{id}', [LoanAccountController::class, 'approve'])->name('loan.approve');
Route::post('/admin/loan-decline/{id}', [LoanAccountController::class, 'declineLoan'])->name('loan.decline');
Route::get('/admin/loan/loanedit/{id}', [LoanAccountController::class, 'loanEdit'])->name('loan.loanedit');
Route::put('/admin/loan/loanupdate/{id}', 
    [LoanAccountController::class,'loanUpdate'])
    ->name('loan.loanupdate');
/* report */
Route::get('/admin/project-wise',[ReportController::class,'projectWise'])->name('report.project-wise');
Route::get('/admin/project-wise-search',[ReportController::class,'projectWiseSearch'])->name('report.project-wise-search');
Route::get('/admin/member-wise',[ReportController::class,'memberWise'])->name('report.member-wise');
Route::get('/admin/member-wise-search',[ReportController::class,'memberWiseSearch'])->name('report.member-wise-search');
Route::get('/admin/account-wise',[ReportController::class,'accountWise'])->name('report.account-wise');
Route::get('/admin/account-wise-search',[ReportController::class,'accountWiseSearch'])->name('report.account-wise-search');
Route::get('admin/account-ledger',[AccountController::class,'accountLedger'])->name('report.account-ledger');
Route::get('/admin/date-wise-account',[ReportController::class,'dateWiseAccount'])->name('report.date-wise-account');
Route::get('/admin/date-wise-account-details',[ReportController::class,'dateWiseAccountDetails'])->name('report.date-wise-account-details');



Route::put('/project/{id}/complete', [ProjectController::class, 'complete'])->name('project.complete');
Route::get('/project/complete-projectlist', [ProjectController::class, 'completeProjectlist'])->name('project.completeprojectlist');
Route::put('/project/{id}/reverse', [ProjectController::class, 'reverseProject'])->name('project.reverse');
Route::post('/project/save-link/{id}', [ProjectController::class, 'saveLink'])
     ->name('project.save_link');


Route::get('/mytansaction/report',[MyTransactionController::class,'myReport'])->name('mytransaction.report');
Route::get('/mytansaction/reportview',[MyTransactionController::class,'myReportView'])->name('mytransaction.reportview');

});

// Wildcard route for Vue router support
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
