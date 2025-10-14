<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Models\Event;
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

// Page d'accueil publique
Route::get('/', function () {
    $highlightedEvents = Event::upcoming()
        ->orderBy('start_date')
        ->take(8)
        ->get();

    return view('welcome', [
        'highlightedEvents' => $highlightedEvents,
    ]);
})->name('home');

// Routes d'authentification
require __DIR__.'/auth.php';

// Routes protégées (authentification requise)
Route::middleware(['auth', 'verified'])->group(function () {
    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes pour les événements
    Route::resource('events', EventController::class)->except(['index', 'show']);
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // Vérification d'identité
    Route::get('/identity/verification', [\App\Http\Controllers\IdentityVerificationController::class, 'show'])
        ->name('identity.verification.show');
    Route::post('/identity/verification', [\App\Http\Controllers\IdentityVerificationController::class, 'store'])
        ->name('identity.verification.store');

    // Routes d'administration
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', \App\Http\Controllers\Admin\AdminDashboardController::class)
            ->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::get('users/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])
            ->name('users.export');
    });

    // Inscription aux événements
    Route::post('/events/{event}/register', [EventController::class, 'register'])
        ->name('events.register');
    Route::delete('/events/{event}/cancel', [EventController::class, 'cancelRegistration'])
        ->name('events.cancel-registration');

    // Paiements
    Route::get('/payments/{registration}/pending', [PaymentController::class, 'pending'])
        ->name('payments.pending');
    Route::match(['GET','POST'], '/payments/{registration}/confirm', [PaymentController::class, 'confirm'])
        ->name('payments.confirm');

    // Abonnements organisateur
    Route::get('/subscriptions/plans', [\App\Http\Controllers\SubscriptionsController::class, 'plans'])
        ->name('subscriptions.plans');
    Route::match(['GET','POST'], '/subscriptions/confirm', [\App\Http\Controllers\SubscriptionsController::class, 'confirm'])
        ->name('subscriptions.confirm');

    // Gestion des inscriptions (organisateur)
    Route::get('/events/{event}/attendees', [RegistrationController::class, 'attendees'])
        ->name('events.attendees');

    // Validation manuelle d'une inscription
    Route::post('/registrations/{registration}/validate', [RegistrationController::class, 'validateRegistration'])
        ->name('registrations.validate')
        ->middleware('can:validate,registration');

    // Gestion des billets
    Route::prefix('tickets')->group(function () {
        Route::get('/{code}', [RegistrationController::class, 'show'])
            ->name('registrations.show');
        Route::get('/{code}/download', [RegistrationController::class, 'download'])
            ->name('registrations.download');
    });

    // Scanner de QR codes (organisateur)
    Route::middleware('can:scan,App\Models\Registration')->group(function () {
        Route::get('/scanner', [RegistrationController::class, 'scanner'])
            ->name('scanner');

        // Validation d'un billet via son ID
        Route::post('/registrations/{registration}/validate', [RegistrationController::class, 'validateTicket'])
            ->name('registrations.validate');
    });
});

// Webhook paiement (public)
Route::post('payment/callback', [PaymentController::class, 'callback'])
    ->name('payments.callback');

// Routes publiques pour les événements
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
