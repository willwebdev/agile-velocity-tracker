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
    die(env("APP_ENV"));

    return view('main', [
    	'title' => "Agile velocity tracker",
    	'header' => "Agile velocity tracker",
    	'content' => view('homepage'),
    	'menu' => []
    ]);
});

$router->post('/calculate-velocity', function (\Illuminate\Http\Request $request) use ($router) {
	$v = new Velocity($request->get("scores"));
	return $v->toJson();
});


$router->post("/submit-feedback", function (\Illuminate\Http\Request $request) use ($router) {
	$feedback = trim($request->get("feedback"));
	if ($feedback != "") {
		mail(
			config("feedback.mailto"),
			config("feedback.subject"),
			$feedback
		);
	}
	return redirect("/feedback-received");
});

$router->get("/feedback-received", function () use ($router) {
	return view('main', [
    	'title' => "Feedback received",
    	'header' => "Feedback received",
    	'content' => view('feedback-received'),
    	'menu' => []
    ]);
});

$router->get('/legal', function () use ($router) {
    return view('main', [
    	'title' => 'Terms and privacy policy',
    	'header' => 'Terms and privacy policy',
    	'content' => view('legal'),
    	'menu' => []
    ]);
});
