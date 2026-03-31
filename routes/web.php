<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\Admin\CompatibilityRuleController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RelationshipController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\SimpleRelationshipController;
use App\Http\Controllers\Admin\CategoryController;

// Public routes (accessible without login)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/configurator');
    }
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/configurator');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected Configurator Routes (require login)
Route::middleware(['auth'])->group(function () {
    Route::prefix('configurator')->group(function () {
        Route::get('/', [ConfiguratorController::class, 'index'])->name('configurator.index');
        Route::get('/machine/{id}', [ConfiguratorController::class, 'show'])->name('configurator.show');
        Route::post('/validate', [ConfiguratorController::class, 'validateConfiguration'])->name('configurator.validate');
        Route::post('/quote', [ConfiguratorController::class, 'generateQuote'])->name('configurator.quote');
        Route::get('/quote/{id}/pdf', [ConfiguratorController::class, 'exportPdf'])->name('configurator.export-pdf');
        Route::post('/save', [ConfiguratorController::class, 'saveConfiguration'])->name('configurator.save');
        Route::get('/load/{configurationNumber}', [ConfiguratorController::class, 'loadConfiguration'])->name('configurator.load');
        
        // Comparison routes
        Route::get('/compare', [ConfiguratorController::class, 'compare'])->name('configurator.compare');
        Route::post('/compare/data', [ConfiguratorController::class, 'getComparisonData'])->name('configurator.compare.data');
        Route::get('/machine-details/{machineId}', [ConfiguratorController::class, 'getMachineDetails']);
        
        // Saved configurations management
        Route::get('/configurations', [ConfiguratorController::class, 'savedConfigurations'])->name('admin.configurations.index');
        Route::get('/configurations/{configuration}', [ConfiguratorController::class, 'showSavedConfiguration'])->name('admin.configurations.show');
    });

    // Admin Routes (require both auth and admin role)
    // Admin Routes (require both auth and admin role)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Resource routes
    Route::resource('machines', MachineController::class)->names('admin.machines');
    Route::resource('components', ComponentController::class)->names('admin.components');
    Route::resource('rules', CompatibilityRuleController::class)->names('admin.rules');
    Route::resource('quotes', QuoteController::class)->names('admin.quotes');
    Route::resource('users', UserController::class)->names('admin.users');
    
    // Additional quote routes
    Route::post('/quotes/{quote}/status', [QuoteController::class, 'updateStatus'])->name('admin.quotes.status');
    Route::get('/quotes/{quote}/pdf', [QuoteController::class, 'exportPdf'])->name('admin.quotes.export-pdf');
    
    // ===== RELATIONSHIP MANAGEMENT ROUTES =====
    Route::prefix('relationships')->name('admin.relationships.')->group(function () {
    Route::get('/', [SimpleRelationshipController::class, 'index'])->name('index');
    Route::get('/create', [SimpleRelationshipController::class, 'create'])->name('create');
    Route::post('/', [SimpleRelationshipController::class, 'store'])->name('store');
    Route::get('/{simpleRelationship}', [SimpleRelationshipController::class, 'show'])->name('show');
    Route::get('/{simpleRelationship}/edit', [SimpleRelationshipController::class, 'edit'])->name('edit');
    Route::put('/{simpleRelationship}', [SimpleRelationshipController::class, 'update'])->name('update');
    Route::delete('/{simpleRelationship}', [SimpleRelationshipController::class, 'destroy'])->name('destroy');
    });
    // Categories management
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    // Provider Management
    Route::prefix('providers')->name('admin.providers.')->group(function () {
        Route::get('/', [RelationshipController::class, 'providers'])->name('index');
        Route::get('/specializations', [RelationshipController::class, 'providerSpecializations'])->name('specializations');
    });
    
    // Partner Management
    Route::prefix('partners')->name('admin.partners.')->group(function () {
        Route::get('/', [RelationshipController::class, 'partners'])->name('index');
        Route::get('/services', [RelationshipController::class, 'partnerServices'])->name('services');
    });
    
    // Organization Management
    Route::resource('organizations', OrganizationController::class)->names('admin.organizations');
});
});