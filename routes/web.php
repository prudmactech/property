<?php

use App\Http\Controllers\Auth\MyWelcomeController;
use App\Http\Controllers\LanguageController;
use App\Services\MPesaHelper;
use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;

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
    //if SHOW_WELCOME_PAGE is true
    if (config('app.show_landing_page')) {
        return view('web.index');
    }
    return redirect('/login');
});
Route::get('/symlink', function () {
    $target = '/home/ojajejar/rms.ojajejar.com/storage/app/public';
    $shortcut = '/home/ojajejar/rms.ojajejar.com/rentals/storage';
    symlink($target, $shortcut);

    return 'Symlink created';
});

Route::get('/stk', function () {
//    $phone = '254717160344';
//    $amount = '100000000000000';
//    $reference = 'test lease';
//    return MPesaHelper::stkPush($phone, $amount, $reference);
//    return MPesaHelper::generateAccessToken();
});

Route::get('/sms', function () {
    return \App\Helpers\TextSMSGateway::sendSms('254717160344', 'Hello from RMS');
});
//Route::get('/registerUrls', function () {
//    return MPesaHelper::registerURLS();
//});

//Language Routes
Route::get('lang/{lang}', [LanguageController::class, 'changeLanguage'])->name('lang.switch');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('tenant')) {
        return redirect('/portal');
    }
    if ($user->hasRole('landlord')) {
        return redirect('/landlord');
    }
    //if user has role is admin or staff
    if ($user->hasAnyRole(['admin', 'staff'])) {
        return redirect('/admin');
    }


    return redirect('/admin');
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/notifications', function () {
    $user = auth()->user();
    if ($user->hasRole('tenant')) {
        return redirect()->route('tenant.notifications');
    }
    if ($user->hasRole('landlord')) {
        return redirect()->route('landlord.notifications');
    }
    return redirect()->route('admin.notifications');
})
    ->middleware(['auth'])
    ->name('notifications');


require __DIR__ . '/auth.php';
require __DIR__ . '/landlord.php';
require __DIR__ . '/tenant.php';
require __DIR__ . '/admin.php';

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [MyWelcomeController::class, 'savePassword']);
});
