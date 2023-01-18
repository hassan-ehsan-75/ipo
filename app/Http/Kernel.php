<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'createCompany' => \App\Http\Middleware\CreateCompanyRole::class,
        'editCompany' => \App\Http\Middleware\EditCompanyRole::class,
        'viewCompany' => \App\Http\Middleware\BrowesCompanyRole::class,
        'editRoles'=>\App\Http\Middleware\EditRoles::class,
        'viewRole'=>\App\Http\Middleware\ViewRole::class,
        'createRole'=>\App\Http\Middleware\CreateRole::class,
        'deleteRole'=>\App\Http\Middleware\DeleteRole::class,
        'viewBank'=>\App\Http\Middleware\ViewBankRole::class,
        'createBank'=>\App\Http\Middleware\createBank::class,
        'updateBank'=>\App\Http\Middleware\UpdateBankRole::class,
        'deleteBank'=>\App\Http\Middleware\DeleteBankRole::class,
        'deleteCompany'=>\App\Http\Middleware\DeleteCompanyRole::class,
        'createStock'=>\App\Http\Middleware\CreateStockRole::class,
        'viewStock'=>\App\Http\Middleware\ViewStockRole::class,
        'updateStock'=>\App\Http\Middleware\UpdateStockRole::class,
        'deleteStock'=>\App\Http\Middleware\DeleteStockRole::class,
        'viewBankBranch'=>\App\Http\Middleware\ViewBankBranchRole::class,
        'createBankBranch'=>\App\Http\Middleware\CreateBankBranchRole::class,
        'updateBankBranch'=>\App\Http\Middleware\UpdateBankBranchRole::class,
        'deleteBankBranch'=>\App\Http\Middleware\DeleteBankBranchRole::class,
        'viewUser'=>\App\Http\Middleware\ViewUserRole::class,
        'createUser'=>\App\Http\Middleware\CreateUserRole::class,
        'updateUser'=>\App\Http\Middleware\UpdateUserRole::class,
        'deleteUser'=>\App\Http\Middleware\DeleteUserRole::class,
        'viewReport'=>\App\Http\Middleware\ViewReportRole::class,
        'viewForm'=>\App\Http\Middleware\ViewFormRole::class,
        'createForm'=>\App\Http\Middleware\CreateFormRole::class,
        'updateForm'=>\App\Http\Middleware\UpdateFormRole::class,
        'deleteForm'=>\App\Http\Middleware\DeleteFormRole::class
    ];
}
