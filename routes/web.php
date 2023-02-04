<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\ImpersonateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/docs/{file?}', [DocsController::class, 'index'])->name('docs.index');

Route::get('template', function(){

    $contents = View::make('template', ['includeNav' => false ]);
    $response = Response::make($contents, 200);
    $response->withHeaders([
        'Content-type' => 'text/html',
        'Content-Disposition' => 'attachment; filename=\'template.html\''
    ]);
    return $response;
});

Route::get('/laravel-welcome', function () {
    return view('welcome', [
        'includeNav' => false,
    ]);
})->name('welcome');

Route::get('/team-landing', function () {

    if(isset(app()['team'])){
        return File::get(public_path() . '/docs/' . $file . '.html');
    }

})->name('welcome');

Route::get('/', function () {
    $path =  isset(app()['team']) ? str_replace(url(''), '', app()['team']->landing_page_url) : '/laravel-welcome';

    $query_string = '';

    $uri = explode('?', request()->server('REQUEST_URI'));

    if (count($uri) > 1) {
        $query_string = $uri[1];
    }

    parse_str($query_string, $_GET);

    return view('iframes::'.config('iframes.theme').'.guest-iframe', [
        'iframeSource' => $path,
        '$_GET' => $query_string,
    ]);
})->name('home');


$authMiddleware = config('jetstream.guard')
? 'auth:'.config('jetstream.guard')
: 'auth';

Route::group(['middleware' => [$authMiddleware, 'has_team', 'verified', config('jetstream.auth_session')]], function () {
    Route::get('/impersonate/take/{id}/{guardName?}', [ImpersonateController::class, 'take'])->name('impersonate');
    Route::get(
        '/impersonate/leave',
        [\Lab404\Impersonate\Controllers\ImpersonateController::class, 'leave']
    )->name('impersonate.leave');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
  
    if (config('auto_route.active')) {
        Route::any(config('auto_route.route_prefix') . '/{path}', function () {
           $view = str_replace(config('auto_route.route_prefix') . '/', config('auto_route.root_dir') . '/', request()->path());
           
           if(View::exists($view)) {
               $contents = View::make($view);
               $response = Response::make($contents, 200);
               foreach(config('auto_route.headers') as $key => $value) {
                   if(Str::contains($view, $key)){
                       $response->withHeaders($value);
                   }
               }
               return $response;
           }

            return abort(404);
        })
            ->where('path', '(.*)')
            ->middleware(config('auto_route.middleware'))
            ->name('auto_route');
    }

});
