<?php

namespace Laracore\Core;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laracore\Core\Framework\Contracts\Frontend\VueRouter as VueRouterContract;
use Laracore\Core\Framework\Frontend\VueRouter;
use Laracore\Core\Framework\Contracts\Frontend\Sidebar as SidebarContract;
use Laracore\Core\Framework\Frontend\Sidebar;
use Laracore\Core\Framework\Contracts\Frontend\Model as ModelContract;
use Laracore\Core\Framework\Frontend\Model;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //加载artisan commands
        $this->commands([
            \Laracore\Core\App\Console\InstallCommand::class,
            \Laracore\Core\App\Console\UninstallCommand::class,
        ]);
        //迁移文件配置
        $this->loadMigrationsFrom(__DIR__.'/Databases/migrations');
        //配置路由
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        //视图
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'core');
        // 发布配置文件
        $this->publishes([
            __DIR__.'/Config/core.php' => config_path('core.php'),
        ], 'core:config');
        //发布视图
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/core'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->initConfig();
        $this->bind();
    }

    /**
     * [initConfig 初始化常用配置]
     * @return [type] [description]
     */
    public function initConfig()
    {
        //设置 user 模型位置
        config(['auth.providers.users.model' => App\Models\User::class]);
    }
    /**
     * [bind 绑定实例]
     */
    public function bind()
    {
        $this->app->bind(VueRouterContract::class, function () {
            return new VueRouter();
        });
        $this->app->bind(SidebarContract::class, function () {
            return new Sidebar();
        });
        $this->app->bind(ModelContract::class, Model::class);
    }
}
