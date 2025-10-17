<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BillingController;
use App\Http\Middleware\EnsureActiveSubscription;
use App\Http\Controllers\ReportsController;
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
    
    // Routes pour les événements (organisateur)
    Route::resource('events', EventController::class)
        ->except(['index', 'show'])
        ->middleware(EnsureActiveSubscription::class);
    Route::post('/events/{event}/generate-share', [EventController::class, 'generateShareLink'])
        ->middleware(EnsureActiveSubscription::class)
        ->name('events.generate-share');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/reviews', [\App\Http\Controllers\EventReviewController::class, 'store'])
        ->name('events.reviews.store');

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

    // Facturation / Historique paiements
    Route::get('/billing/history', [BillingController::class, 'history'])
        ->name('billing.history');

    // Exports
    Route::get('/reports/sales.csv', [ReportsController::class, 'exportSalesCsv'])
        ->name('reports.sales.csv');
    Route::get('/reports/sales.pdf', [ReportsController::class, 'exportSalesPdf'])
        ->name('reports.sales.pdf');

    // Gestion des inscriptions (organisateur)
    Route::get('/events/{event}/attendees', [RegistrationController::class, 'attendees'])
        ->name('events.attendees')
        ->middleware(EnsureActiveSubscription::class);

    // Exports des participants (CSV / PDF)
    Route::get('/events/{event}/attendees.csv', [RegistrationController::class, 'exportAttendeesCsv'])
        ->name('events.attendees.export.csv')
        ->middleware(EnsureActiveSubscription::class);
    Route::get('/events/{event}/attendees.pdf', [RegistrationController::class, 'exportAttendeesPdf'])
        ->name('events.attendees.export.pdf')
        ->middleware(EnsureActiveSubscription::class);

    // (supprimé) Ancienne route validateRegistration obsolète

    // Gestion des billets
    Route::prefix('tickets')->group(function () {
        Route::get('/{code}', [RegistrationController::class, 'show'])
            ->name('registrations.show');
        Route::get('/{code}/download', [RegistrationController::class, 'download'])
            ->name('registrations.download');
    });

    // Nouveau: affichage d'un ticket individuel (tickets table)
    Route::get('/ticket/{code}', [TicketController::class, 'show'])
        ->name('tickets.show');

    // Transfert de ticket (propriétaire uniquement)
    Route::post('/ticket/{code}/transfer', [TicketController::class, 'transfer'])
        ->name('tickets.transfer');

    // Scanner de QR codes (organisateur)
    Route::middleware(['can:scan,App\Models\Registration', EnsureActiveSubscription::class])->group(function () {
        Route::get('/scanner', [RegistrationController::class, 'scanner'])
            ->name('scanner');

        // Validation d'un billet via son ID
        Route::post('/registrations/{registration}/validate', [RegistrationController::class, 'validateTicket'])
            ->name('registrations.validate');

        // Validation d'un billet via son code QR
        Route::post('/tickets/{code}/validate', [RegistrationController::class, 'validateTicketByCode'])
            ->name('registrations.validate_by_code');

        // Marquer un billet comme payé (paiement physique encaissé)
        Route::post('/registrations/{registration}/mark-paid', [RegistrationController::class, 'markPaid'])
            ->name('registrations.mark_paid');
    });
});

// Webhook paiement (public)
Route::post('payment/callback', [PaymentController::class, 'callback'])
    ->name('payments.callback');

// Page promo publique d'un événement (aperçu marketing)
Route::get('/promo/{slug}', [\App\Http\Controllers\PromoController::class, 'show'])
    ->name('promo.show');

// Routes publiques pour les événements
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
