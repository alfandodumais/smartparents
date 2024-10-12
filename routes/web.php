<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\VideoController as UserVideoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShareLinkController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;

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

// Public routes
Route::get('/', [UserVideoController::class, 'index'])->name('videos.index');
Route::get('/video/{video}', [UserVideoController::class, 'show'])->name('videos.show');
Route::get('/download/{video}', [UserVideoController::class, 'download'])->name('videos.download');

// Middleware for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/purchase/{video}', [PaymentController::class, 'purchase'])->name('purchase');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending', [UserDashboardController::class, 'pending'])->name('pending');
    
    // Payment routes for Midtrans
    Route::post('/payment/{video}', [MidtransController::class, 'createPayment'])->name('payment.create');
    Route::post('/payment/notification', [MidtransController::class, 'handleNotification'])->name('payment.notification');

});

// Admin-specific routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Video Management
    Route::resource('videos', VideoController::class);

    // User Management
    Route::resource('users', UserController::class)->except(['create', 'edit']); // CRUD untuk users
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Edit user
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update'); // Update user role

    // Transaction Management
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Generate Share Link
    Route::post('videos/{video}/generate-link', [VideoController::class, 'generateLink'])->name('videos.generateLink');
});

// Share Link Access
Route::get('/share/{token}', [ShareLinkController::class, 'access'])->name('share.link');

// Auth Routes
require __DIR__.'/auth.php';
