<?php

namespace App\Helpers;

class Team {
    protected $_name;
    protected $_id;
    protected $_token;
    protected $_velocity;

    public static function createNew($name) {
        $obj = new Team(null, $name);
        $obj->generateID();
        $obj->generateAdminToken();
        $obj->setVelocity(new Velocity([]));
        $obj->save();
        return $obj;
    }

    public static function loadByID($id, $adminToken) {
        $obj = new Team($id);
        if ($obj->load() && $obj->getAdminToken() == $adminToken) {
            return $obj;
        } else {
            return null;
        }
    }

    public function __construct($id = "", $name = "") {
        $this->_id = $id;
        $this->_name = $name;
    }

    public function generateID() {
        $this->_id = uniqid();
    }

    public function generateAdminToken() {
        $this->_token = md5(time());
    }

    public function getID() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getAdminToken() {
        return $this->_token;
    }

    public function serialize() {
        return implode("\n", [
            $this->getID(),
            $this->getAdminToken(),
            $this->getName(),
            implode(",", $this->getVelocity()->getScores())
        ]);
    }

    public function unserialize($data) {
        $data = explode("\n", $data);
        $this->_token = $data[1];
        $this->_name = $data[2];
        $this->_velocity = new Velocity(explode(",", $data[3]));
    }

    public function save() {
        file_put_contents($this->getDataFilePath(), $this->serialize());
    }

    public function load() {
        $filePath = $this->getDataFilePath();
        if (!file_exists($filePath)) {
            return false;
        }

        $data = file_get_contents($filePath);
        if (!$data) {
            return false;
        }

        $this->unserialize($data);
        return true;
    }

    public function setVelocity($vel) {
        $this->_velocity = $vel;
    }

    public function getVelocity() {
        return $this->_velocity;
    }

    public function getDataFilePath() {
        return $this->getDataDirectory()."/".$this->getID().".txt";
    }

    public function getDataDirectory() {
        return getcwd()."/../resources/data";
    }
}