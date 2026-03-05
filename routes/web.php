<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Departments
    Route::resource('departments', DepartmentController::class);

    // Users
    Route::resource('users', UserController::class);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/check', [PurchaseRequestController::class, 'checkNotifications'])->name('notifications.check');
    Route::get('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Purchase Requests
    Route::get('purchase-requests/rejected', [PurchaseRequestController::class, 'rejected'])->name('purchase-requests.rejected');
    Route::get('purchase-requests/drafts', [PurchaseRequestController::class, 'drafts'])->name('purchase-requests.drafts');
    Route::get('purchase-requests/approvals', [PurchaseRequestController::class, 'approvalQueue'])
        ->middleware('role:operational_manager|general_manager|superadmin')
        ->name('purchase-requests.approvals');
    Route::resource('purchase-requests', PurchaseRequestController::class);






    Route::post('purchase-requests/{item}/approve', [PurchaseRequestController::class, 'approveItem'])->name('purchase-requests.approve-item');
    Route::post('purchase-requests/{item}/reject', [PurchaseRequestController::class, 'rejectItem'])->name('purchase-requests.reject-item');
    Route::post('purchase-requests/{item}/send-note', [PurchaseRequestController::class, 'sendValidationNote'])->name('purchase-requests.send-note');
    Route::post('purchase-requests/{item}/revise', [PurchaseRequestController::class, 'reviseItem'])->name('purchase-requests.revise-item');
    Route::get('purchase-requests/{purchaseRequest}/preview', [PurchaseRequestController::class, 'preview'])->name('purchase-requests.preview');
    Route::get('purchase-requests/{purchaseRequest}/export', [PurchaseRequestController::class, 'export'])->name('purchase-requests.export');
    Route::post('purchase-requests/{item}/update-status', [PurchaseRequestController::class, 'updateItemStatus'])->name('purchase-requests.update-item-status');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // Superadmin Settings
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/settings/general', [\App\Http\Controllers\SettingController::class, 'general'])->name('settings.general');
        Route::post('/settings/general', [\App\Http\Controllers\SettingController::class, 'updateGeneral'])->name('settings.update-general');
        Route::resource('uoms', \App\Http\Controllers\UomController::class);
        Route::resource('purposes', \App\Http\Controllers\PurposeController::class);
    });

});

require __DIR__.'/auth.php';
