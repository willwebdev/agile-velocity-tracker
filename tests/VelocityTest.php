<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Helpers\Velocity;

class VelocityTest extends TestCase
{
    public function test6SprintSlice() {
        $v = new Velocity([1,2,3,4,5,6]);
        $this->assertEquals($v->getMax(), 6);
        $this->assertEquals($v->getMin(), 1);

        $v = new Velocity([1,2,3,4,5,6,7]);
        $this->assertEquals($v->getMax(), 7);
        $this->assertEquals($v->getMin(), 2);

        $v = new Velocity([1,2,3,4,5,6,7,8,9]);
        $this->assertEquals($v->getMax(), 9);
        $this->assertEquals($v->getMin(), 4);
    }

    public function testAverage()
    {
        $v = new Velocity([66]);
        $this->assertEquals($v->getAverage(), 66);

        $v = new Velocity([1,2,3]);
        $this->assertEquals($v->getAverage(), 2);

        $v = new Velocity([4,8,9]);
        $this->assertEquals($v->getAverage(), 7);
    }

    public function testVariance() {
        $v = new Velocity([1]);
        $this->assertEquals($v->getVariance(), 0);

        $v = new Velocity([1,2,3]);
        $this->assertEquals($v->getVariance(), 0.81649658092772603);

        $v = new Velocity([100,1000,100000]);
        $this->assertEquals($v->getVariance(), 46882.619380747063);
    }

    public function testMinMax() {
        $v = new Velocity([3,4,5,6,7,99]);
        $this->assertEquals($v->getMin(), 3);
        $this->assertEquals($v->getMax(), 99);

        $v = new Velocity([4]);
        $this->assertEquals($v->getMin(), 4);
        $this->assertEquals($v->getMax(), 4);

        $v = new Velocity([7,4,3,1,9,7,8,8]); // unordered
        $this->assertEquals($v->getMin(), 1);
        $this->assertEquals($v->getMax(), 9);
    }

    public function testToJson() {
        $json = 
'{
    "average": 25.5,
    "variance": 6.576473218983,
    "min": 18,
    "max": 35
}';
        $v = new Velocity([18,21,35,28]);
        $this->assertEquals($v->toJson(), $json);
    }
}
