<?php

use App\Helpers\Velocity;

class ApiTest extends TestCase
{
	/*
     * disabled until it's worth investing in mocking...
     *
    public function testCalculateVelocityEndpoint() {
		$json = 
'{
    "average": 25.5,
    "variance": 6.576473218983,
    "min": 18,
    "max": 35
}';
		$this->post("/calculate-velocity", ["scores" => [18,21,35,28]]);
		$this->assertEquals($this->response->getContent(), $json);
	}
    */
}