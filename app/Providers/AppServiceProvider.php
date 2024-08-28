<?php

namespace App\Providers;

use App\Models\Audience;
use App\Models\CommerceItem;
use App\Models\Commision;
use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\Notice;
use App\Models\Permission;
use App\Models\ProductLine;
use App\Models\Provider;
use App\Models\ProviderUser;
use App\Models\RoleInvitation;
use App\Models\Setting;
use App\Models\SettingProvider;
use App\Models\User;
use App\Observers\CommerceItemObserver;
use App\Observers\CommissionObserver;
use App\Observers\CompanyObserver;
use App\Observers\CompanyPaymentObserver;
use App\Observers\ProductLineObserver;
use App\Observers\ProviderUserObserver;
use App\Models\Role;
use App\Observers\AudienceObserver;
use App\Observers\NoticeObserver;
use App\Observers\PermissionObserver;
use App\Observers\ProviderObserver;
use App\Observers\RoleObserver;
use App\Observers\SettingObserver;
use App\Observers\SettingProviderObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\PermissionRole;
use App\Observers\PermissionRoleObserver;
use App\Observers\RoleInvitationObserver;
use App\Models\Contact;
use App\Models\ClientValidation;
use App\Models\Department;
use App\Observers\ContactObserver;
use App\Observers\ClientValidationObserver;
use App\Observers\DepartmentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Audience::observe(AudienceObserver::class);
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        Notice::observe(NoticeObserver::class);
        Provider::observe(ProviderObserver::class);
        ProviderUser::observe(ProviderUserObserver::class);
        SettingProvider::observe(SettingProviderObserver::class);
        Company::observe(CompanyObserver::class);
        CompanyPayment::observe(CompanyPaymentObserver::class);
        ProductLine::observe(ProductLineObserver::class);
        CommerceItem::observe(CommerceItemObserver::class);
        Setting::observe(SettingObserver::class);
        User::observe(UserObserver::class);
        RoleInvitation::observe(RoleInvitationObserver::class);
        Contact::observe(ContactObserver::class);
        ClientValidation::observe(ClientValidationObserver::class);
        Department::observe(DepartmentObserver::class);
    }
}
