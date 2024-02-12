<?php

namespace Modules\Category\Providers;

use Database\Seeders\DatabaseSeeder;
use Modules\Category\Database\Seeders\CategorySeeder;
use Modules\Category\Models\Category;
use Modules\Category\Policies\CategoryPolicy;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\CategoryRepositoryInterface;
use Modules\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->loadRoutesFrom(__DIR__ . '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Categories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__, "/../lang");
        DatabaseSeeder::$seeders[] = CategorySeeder::class;
        Gate::policy(Category::class, CategoryPolicy::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        config()->set('sidebar.items.categories', [
            "icon"       => "i-categories",
            "title"      => "دسته بندی ها",
            "url"        => route('categories.index'),
            "permission" => Permission::PERMISSION_MANAGE_CATEGORIES
        ]);
    }
}
