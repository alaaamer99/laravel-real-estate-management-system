<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RentPropertyController;
use App\Http\Controllers\RentPartnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // مسارات العقارات
    Route::resource('properties', PropertyController::class);
    Route::post('properties/{property}/upload-images', [PropertyController::class, 'uploadImages'])->name('property.images.upload');
    Route::get('properties/{property}/download-images', [PropertyController::class, 'downloadAllImages'])->name('property.images.download');
    Route::delete('property-images/{image}', [PropertyController::class, 'deleteImage'])->name('property.images.delete');
    
    // مسارات أنواع العقارات
    Route::resource('property-types', PropertyTypeController::class);
    
    // مسارات المسوقين
    Route::resource('partners', PartnerController::class);
    
    // مسارات الإيجارات
    Route::resource('rent-properties', RentPropertyController::class);
    Route::delete('rent-properties/{rentProperty}/remove-image', [RentPropertyController::class, 'removeImage'])->name('rent-properties.remove-image');
    Route::get('rent-properties/{rentProperty}/download-images', [RentPropertyController::class, 'downloadAllImages'])->name('rent-property.images.download');
    Route::get('rent-properties/{rentProperty}/download-image/{imageName}', [RentPropertyController::class, 'downloadImage'])->name('rent-property.image.download');
    Route::resource('rent-partners', RentPartnerController::class);
    
    // مسارات المستخدمين (للمدير فقط)
    Route::resource('users', UserController::class);
    
    // مسارات التقارير (للمدير فقط)
    Route::prefix('reports')->name('reports.')->middleware('admin')->group(function () {
        Route::get('/todo', [ReportsController::class, 'todoReports'])->name('todo');
        Route::get('/dashboard', [ReportsController::class, 'dashboard'])->name('dashboard');
        Route::get('/data-quality', [ReportsController::class, 'dataQuality'])->name('data-quality');
        Route::get('/partners', [ReportsController::class, 'partnersReport'])->name('partners');
        Route::get('/rentals', [ReportsController::class, 'rentalsReport'])->name('rentals');
        Route::get('/alerts', [ReportsController::class, 'alerts'])->name('alerts');
        
        // Alerts actions
        Route::post('/alerts/{id}/read', [ReportsController::class, 'markAlertAsRead'])->name('alerts.read');
        Route::delete('/alerts/{id}', [ReportsController::class, 'deleteAlert'])->name('alerts.delete');
        Route::post('/alerts/read-all', [ReportsController::class, 'markAllAlertsAsRead'])->name('alerts.read-all');
        Route::delete('/alerts/clear-old', [ReportsController::class, 'clearOldAlerts'])->name('alerts.clear-old');
        Route::get('/alerts/count', [ReportsController::class, 'getAlertsCount'])->name('alerts.count');
        Route::post('/alerts/settings', [ReportsController::class, 'saveAlertsSettings'])->name('alerts.settings');
        
        // Export routes
        Route::get('/export/dashboard', [ReportsController::class, 'exportDashboard'])->name('export.dashboard');
        Route::get('/export/data-quality', [ReportsController::class, 'exportDataQuality'])->name('export.data-quality');
        Route::get('/export/partners', [ReportsController::class, 'exportPartners'])->name('export.partners');
        Route::get('/export/rentals', [ReportsController::class, 'exportRentals'])->name('export.rentals');
        Route::get('/export/alerts', [ReportsController::class, 'exportAlerts'])->name('export.alerts');
    });
});

require __DIR__.'/auth.php';
