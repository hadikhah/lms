<?php

namespace Modules\Comment\Providers;
use Modules\Comment\Policies\CommentPolicy;
use Modules\Comment\Models\Comment;
use Modules\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    protected $namespace = "Modules\Comment\Http\Controllers";
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Comments");
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(__DIR__ . "/../Routes/comments_routes.php");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");

        Gate::policy(Comment::class, CommentPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.comments', [
            "icon" => "i-comments",
            "title" => "نظرات",
            "url" => route('comments.index'),
            "permission" => [Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_TEACH]
        ]);
    }
}