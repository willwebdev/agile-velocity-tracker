<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Helpers\Team;

class TeamTest extends TestCase
{
    public function testXXX() {   
        $load = function($fp) { return "HELLO WORLD"; };
        $save = function($fp, $d) { return true; };
        
        $t = new Team(1, "name");
        $t->setPersistenceFunctions($load, $save);

        $this->assertEquals(1, 1);
    }

    public function testGenerateID() {
        $t = new Team();

        for ($i = 1; $i <= 5; $i++) {
            $t->generateID();
            $arr []= $t->getID();
            sleep(1);
        }

        $this->assert
    }
}
