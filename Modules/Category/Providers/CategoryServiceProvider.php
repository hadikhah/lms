<?php

namespace Modules\Category\Providers;

use Database\Seeders\DatabaseSeeder;
use Modules\Category\Database\Seeders\CategorySeeder;
use Modules\Category\Models\Category;
use Modules\Category\Policies\CategoryPolicy;
use Modules\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Categories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__, "/../lang");
        DatabaseSeeder::$seeders[] = CategorySeeder::class;
        Gate::policy(Category::class, CategoryPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.categories', [
            "icon"       => "i-categories",
            "title"      => "دسته بندی ها",
            "url"        => route('categories.index'),
            "permission" => Permission::PERMISSION_MANAGE_CATEGORIES
        ]);
    }
}
