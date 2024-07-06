<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\HTMLMin;

use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the htmlmin service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMinServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\View\Compilers\CompilerInterface|null
     */
    protected $previousCompiler;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/htmlmin.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('htmlmin.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('htmlmin');
        }

        $this->mergeConfigFrom($source, 'htmlmin');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHtmlMinifier();
        $this->registerHTMLMin();
    }

    /**
     * Register the css minifier class.
     *
     * @return void
     */
    protected function registerCssMinifier()
    {
        $this->app->singleton('htmlmin.css', function () {
            return new CssMinifier();
        });

        $this->app->alias('htmlmin.css', CssMinifier::class);
    }

    /**
     * Register the js minifier class.
     *
     * @return void
     */
    protected function registerJsMinifier()
    {
        $this->app->singleton('htmlmin.js', function () {
            return new JsMinifier();
        });

        $this->app->alias('htmlmin.js', JsMinifier::class);
    }

    /**
     * Register the html minifier class.
     *
     * @return void
     */
    protected function registerHtmlMinifier()
    {
        $this->app->singleton('htmlmin.html', function (Container $app) {
            return new HtmlMinifier();
        });

        $this->app->alias('htmlmin.html', HtmlMinifier::class);
    }

    /**
     * Register the htmlmin class.
     *
     * @return void
     */
    protected function registerHTMLMin()
    {
        $this->app->singleton('htmlmin', function (Container $app) {
            $html = $app['htmlmin.html'];

            return new HTMLMin($html);
        });

        $this->app->alias('htmlmin', HTMLMin::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'htmlmin',
            'htmlmin.html',
        ];
    }
}
