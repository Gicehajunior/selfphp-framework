<pre class="text-white mb-0" style="font-family: 'Fira Code', monospace; font-size: 0.9rem; margin: 0; padding: 0; background: transparent; border: none;">
&lt;?php

    /**
    * SelfPhp Framework v1.3.0
    * AltoRouter Integration
    * @author Giceha Junior
    */

    use SelfPhp\Route;
    use App\Http\Auth\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\HomeController;
    use App\Http\Middleware\AuthMiddleware;

    // GET Routes
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
    Route::get('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'signup']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/404', [AuthController::class, 'notFoundErrorPage']);

    // POST Routes
    Route::post('/login', [AuthController::class, 'login_user']);
    Route::post('/register', [AuthController::class, 'signup_user']);
</pre>