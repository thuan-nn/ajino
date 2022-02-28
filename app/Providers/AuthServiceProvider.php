<?php

namespace App\Providers;

use App\Enums\PermissionType;
use App\Models\Admin;
use App\Models\CompanyTour;
use App\Models\Job;
use App\Models\MailHistory;
use App\Models\MailTemplate;
use App\Models\Menu;
use App\Models\Menulink;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Taxonomy;
use App\Models\Visitor;
use App\Models\VisitorFileSetting;
use App\Policies\AdminPolicy;
use App\Policies\CompanyTourPolicy;
use App\Policies\JobPolicy;
use App\Policies\MailHistoryPolicy;
use App\Policies\MailTemplatePolicy;
use App\Policies\MenuLinkPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TaxonomyPolicy;
use App\Policies\VisitorFileSettingPolicy;
use App\Policies\VisitorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Admin::class              => AdminPolicy::class,
        Menu::class               => MenuPolicy::class,
        Permission::class         => PermissionPolicy::class,
        Role::class               => RolePolicy::class,
        Menulink::class           => MenuLinkPolicy::class,
        Post::class               => PostPolicy::class,
        Taxonomy::class           => TaxonomyPolicy::class,
        Job::class                => JobPolicy::class,
        Visitor::class            => VisitorPolicy::class,
        CompanyTour::class        => CompanyTourPolicy::class,
        Setting::class            => SettingPolicy::class,
        MailHistory::class        => MailHistoryPolicy::class,
        MailTemplate::class       => MailTemplatePolicy::class,
        VisitorFileSetting::class => VisitorFileSettingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-company-tour', function (Admin $admin) {
            return $admin->hasAnyPermission([PermissionType::UPDATE_COMPANY_TOUR]);
        });
    }
}
