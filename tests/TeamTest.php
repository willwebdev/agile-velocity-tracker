<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Helpers\Team;
use App\Helpers\Velocity;

class TeamTest extends TestCase
{
    // wrap each test in a transaction, and roll it back (abort the transaction) after the test is complete
    use DatabaseTransactions;

    public function testCreateNew() {   
        $t = Team::createNew("TEST");

        $this->assertEquals($t->getName(), "TEST");
        $this->assertNotEmpty($t->getID());
        $this->assertNotEmpty($t->getAdminToken());

        $this->assertEquals(get_class($t->getVelocity()), "App\Helpers\Velocity");
        $this->assertEquals($t->getVelocity()->getScores(), []);

        $this->seeInDatabase("teams", ["id" => $t->getID()]);
    }

    public function testLoadByIDWithIncorrectID() {
        $t = Team::loadByID("wrong-team-id", "wrong-admin-token");
        $this->assertNull($t);
    }

    public function testLoadByIDWithCorrectAdminToken() {
        $t = Team::createNew("TEST");
        $t2 = Team::loadByID($t->getID(), $t->getAdminToken());

        $this->assertNotNull($t2);
        $this->assertEquals($t2->getID(), $t->getID());
    }

    public function testLoadByIDWithIncorrectAdminToken() {
        $t = Team::createNew("TEST");
        $t2 = Team::loadByID($t->getID(), "wrong-admin-token");

        $this->assertNull($t2);
    }

    public function testSave() {
        // create (this inserts into DB)
        $t = Team::createNew("TEST");

        // update
        $t->setName("JIMBO");
        $t->setAdminToken("JONES");
        $t->setVelocity(new Velocity([99, 101, 777]));
        $t->save();

        // check all the fields updated under the same ID
        $t2 = Team::loadByID($t->getID(), $t->getAdminToken());
        $this->assertEquals($t2->getName(), "JIMBO");
        $this->assertEquals($t2->getAdminToken(), "JONES");
        $this->assertEquals($t2->getVelocity()->getScores(), [99, 101, 777]);
    }

    public function testSaveWithNewID() {
        // create (this inserts into DB)
        $t = Team::createNew("TEST");
        $originalID = $t->getID();
        $originalToken = $t->getAdminToken();

        // update WITH NEW ID
        $t->setName("JIMBO");
        $t->setAdminToken("JONES");
        $t->setVelocity(new Velocity([99, 101, 777]));
        $t->generateID();
        $t->save();
        $newID = $t->getID();

        $this->seeInDatabase("teams", ["id" => $originalID]);
        $this->seeInDatabase("teams", ["id" => $newID]);

        // check the row under the original ID hasn't changed
        $t2 = Team::loadByID($originalID, $originalToken);
        $this->assertEquals($t2->getName(), "TEST");
        $this->assertEquals($t2->getVelocity()->getScores(), []);

        // check the new ID has the updates
        $t3 = Team::loadByID($t->getID(), $t->getAdminToken());
        $this->assertEquals($t3->getName(), "JIMBO");
        $this->assertEquals($t3->getVelocity()->getScores(), [99, 101, 777]);
    }
}
