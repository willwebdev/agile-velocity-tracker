<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Helpers\Velocity;

$router->get('/', function () use ($router) {
    return view('main', [
    	'title' => "Agile velocity tracker",
    	'header' => "Agile velocity tracker",
    	'content' => view('form'),
    	'menu' => []
    ]);
});

$router->post('/calculate-velocity', function (\Illuminate\Http\Request $request) use ($router) {
	$v = new Velocity(explode(",", $request->get("scores")));
	return '{
		"average": '.$v->getAverage().',
		"variance": '.$v->getVariance().'
	}';
});


$router->get('/legal', function () use ($router) {
    return view('main', [
    	'title' => 'Terms and privacy policy',
    	'header' => 'Terms and privacy policy',
    	'content' => view('legal'),
    	'menu' => []
    ]);
});
