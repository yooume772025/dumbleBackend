<?php


$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

if (! file_exists(__DIR__.'/../.env')) {
    if (file_exists(__DIR__.'/../.env.example')) {
        copy(__DIR__.'/../.env.example', __DIR__.'/../.env');
    } else {
        
        file_put_contents(__DIR__.'/../.env', '');
    }

    $key = 'base64:'.base64_encode(random_bytes(32));

    $env = file_get_contents(__DIR__.'/../.env');

    if (strpos($env, 'APP_KEY=') !== false) {
        $env = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $env);
    } else {
        $env .= "\nAPP_KEY=$key";
    }

    if (strpos($env, 'APP_ENV=') !== false) {
        $env = preg_replace('/APP_ENV=.*/', 'APP_ENV=local', $env);
    } else {
        $env .= "\nAPP_ENV=local";
    }

    if (strpos($env, 'APP_DEBUG=') !== false) {
        $env = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=true', $env);
    } else {
        $env .= "\nAPP_DEBUG=true";
    }

    if (strpos($env, 'APP_URL=') !== false) {
        $env = preg_replace('/APP_URL=.*/', 'APP_URL=http://localhost', $env);
    } else {
        $env .= "\nAPP_URL=http://localhost";
    }

    $env .= "\nAPP_INSTALLED=false";

    
    file_put_contents(__DIR__.'/../.env', $env);
}


$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);


return $app;
