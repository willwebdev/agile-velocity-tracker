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
use App\Helpers\Team;

$router->get('/', function (\Illuminate\Http\Request $request) use ($router) {
    return view('main', [
    	'title' => "Agile velocity tracker",
    	'header' => "Agile velocity tracker",
    	'content' => view('homepage', [
            'error' => $request->get("error")
        ]),
    	'menu' => []
    ]);
});

$router->post('/team/new', function (\Illuminate\Http\Request $request) use ($router) {
    $team = Team::createNew($request->get("team_name"));
    $link = "/team/".$team->getID()."/admin/".$team->getAdminToken();
    
    $mailto = trim($request->get("email"));
    if ($mailto != "") {
        mail(
            $mailto,
            config("emails.new-team-subject"),
            view("emails.new-team", [
                "team_name" => $team->getName(),
                "link" => "http://".$request->server("HTTP_HOST").$link
            ])
        );
    }

    return redirect($link);
});

$router->get('/team/{id}/admin/{token}', function ($id, $token) use ($router) {
    $team = Team::loadByID($id, $token);
    if (!$team) {
        return redirect("/?error=".ERR_TEAM_NOT_FOUND);
    }

    return view('main', [
        'title' => "Agile velocity tracker",
        'header' => "Agile velocity tracker",
        'content' => view('team.admin', [
            'team_id' => $team->getID(),
            'admin_token' => $team->getAdminToken(),
            'team_name' => $team->getName(),
            'scores' => $team->getVelocity()->getScores()
        ]),
        'menu' => []
    ]);
});

$router->post('/calculate-velocity', function (\Illuminate\Http\Request $request) use ($router) {
    $id = $request->get("teamID");
    $token = $request->get("adminToken");
    $team = Team::loadByID($id, $token);
    if (!$team) {
        return redirect("/?error=".ERR_TEAM_NOT_FOUND);
    }

	$v = new Velocity($request->get("scores"));
    $team->setVelocity($v);
    $team->save();
	return $v->toJson();
});


$router->post("/submit-feedback", function (\Illuminate\Http\Request $request) use ($router) {
	$feedback = trim($request->get("feedback"));
	if ($feedback != "") {
		mail(
			config("emails.feedback-mailto"),
			config("emails.feedback-subject"),
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
