<?php

namespace Providers;

use Src\Provider\AbstractProvider;
use Src\Route;

class RouteProvider extends AbstractProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bind('route', Route::single()->setPrefix($this->app->settings->getRootPath()));

        if ($this->checkPrefix('/api')) {
            $this->app->settings->removeAppMiddleware('csrf');
            $this->app->settings->removeAppMiddleware('specialChars');
            $this->app->settings->removeAppMiddleware('json');

            Route::group('/api', function () {
                require_once __DIR__ . '/../..' . $this->app->settings->getRoutePath() . '/api.php';
            });
            return;
        }

        require_once __DIR__ . '/../..' . $this->app->settings->getRoutePath() . '/web.php';
    }

    private function getUri(): string
    {
        return substr($_SERVER['REQUEST_URI'], strlen($this->app->settings->getRootPath()));
    }

    private function checkPrefix(string $prefix): bool
    {
        $uri = $this->getUri();
        return str_starts_with($uri, $prefix);
    }
}