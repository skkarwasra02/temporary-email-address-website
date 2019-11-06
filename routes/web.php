<?php
use Illuminate\Support\Facades\Mail;

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

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

// Admin panel routes
// Login routes
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/admin/login', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {
    // GET routes
    Route::get('/admin', 'Admin\DashboardController@dashboard')->name('dashboard');

    Route::get('/admin/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');

    Route::get('/admin/domains', 'Admin\DomainsController@showDomains')->name('domains');

    Route::get('/admin/domains/delete', 'Admin\DomainsController@deleteDomain');

    Route::get('/admin/mails', 'Admin\MailsController@showMails')->name('mails');

    Route::get('/admin/accounts', 'Admin\AccountsController@showAccounts');

    Route::get('/admin/accounts/delete/account/id/{account_id}', 'Admin\AccountsController@deleteAccountById');

    Route::get('/admin/sentmails', 'Admin\SentMailsController@showSentMails')->name('sentmails');

    Route::get('/admin/abuse-reports', 'Admin\AbuseReportsController@showReports')->name('abuse_reports');

    Route::get('/admin/advertising', 'Admin\AdvertisingController@showAdvertisingPage');

    Route::get('/admin/advertising/delete', 'Admin\AdvertisingController@deleteAd');

    Route::get('/admin/support', 'Admin\SupportController@showSupportPage');

    Route::get('/admin/support/resolve/{support_id}/{resolve}', 'Admin\SupportController@changeResolveStatus');

    Route::get('/admin/support/delete/{support_id}', 'Admin\SupportController@deleteSupportRequest');

    Route::get('/admin/cron-jobs', 'Admin\CronController@showCronJobs')->name('cron_jobs');

    Route::get('/admin/settings', 'Admin\SettingsController@showSettings');

    Route::get('/admin/profile', 'Admin\ProfileController@showProfileSetting');

    // POST routes
    Route::post('/admin/domains/add', 'Admin\DomainsController@addDomain');

    Route::post('/admin/domains/edit', 'Admin\DomainsController@editDomain');

    Route::post('/admin/advertising/add', 'Admin\AdvertisingController@addAd');

    Route::post('/admin/advertising/edit', 'Admin\AdvertisingController@editAd');

    Route::post('/admin/cron-jobs/edit', 'Admin\CronController@editCron');

    Route::post('/admin/settings/save', 'Admin\SettingsController@saveSettings');

    Route::post('/admin/profile', 'Admin\ProfileController@updateProfileSetting');

});

// Main site GET routes
Route::get('/', 'InboxController@main')->name('main');

Route::get('/random', 'InboxController@random')->name('random');

Route::get('/inbox/{file_name?}', 'InboxController@inbox')->name('inbox');

Route::get('/inbox/download/mail/{file_name}', 'InboxController@downloadMailPage');

Route::get('/inbox/download/attachment/{file_name}/{name}', 'InboxController@downloadAttachmentPage');

Route::get('/inbox/delete/mail/{file_name}', 'InboxController@deleteMail');

Route::get('/compose', 'ComposeController@showComposePage')->name('compose');

Route::get('/report', 'ComposeController@reportPage')->name('report');

Route::get('/add-domain', 'AddDomainController@showPage')->name('add-domain');

Route::get('/contact-us', 'SupportController@showPage')->name('support');

Route::get('/test', function() {
    $ct = file_get_contents("C:\Users\DELL\Downloads\a.eml");
    dd($ct);
    //\App\Models\Domain::validateDomain("domain1.com");
});

// Main site POST routes

Route::post('/inbox/download/mail/{file_name}', 'InboxController@downloadMail');

Route::post('/inbox/download/attachment/{file_name}/{name}', 'InboxController@downloadAttachment');

Route::post('/compose/send', 'ComposeController@send');

Route::post('/compose/upload', 'ComposeController@upload');

Route::post('/compose/upload/delete', 'ComposeController@deleteUpload');

Route::post('/report', 'ComposeController@report');

Route::post('/add-domain', 'AddDomainController@checkMX');

Route::post('/contact-us/new', 'SupportController@newSupportRequest');
