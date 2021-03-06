<?php

namespace App\Helpers;

class Team {
    const TABLE_NAME = "teams";

    protected $_name;
    protected $_id;
    protected $_isNew;
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
        $this->_isNew = true;
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

    public function getVelocity() {
        return $this->_velocity;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setAdminToken($token) {
        $this->_token = $token;
    }

    public function setVelocity($vel) {
        $this->_velocity = $vel;
    }

    public function save() {
        if ($this->_isNew) {
            app("db")->insert("INSERT INTO ".self::TABLE_NAME." (
                    id,
                    token,
                    name,
                    scores,
                    created_at
                ) VALUES (
                    '{$this->_id}',
                    '{$this->_token}',
                    '{$this->_name}',
                    '".implode(",", $this->getVelocity()->getScores())."',
                    NOW()
            )");
            $this->_isNew = false;
        } else {
            app("db")->update("UPDATE ".self::TABLE_NAME." SET
                token = '{$this->_token}',
                name = '{$this->_name}',
                scores = '".implode(",", $this->getVelocity()->getScores())."',
                updated_at = NOW()
            WHERE id = '{$this->_id}'");
        }
    }

    public function load() {
        $this->_isNew = false;
        $rows = app("db")->select("SELECT * FROM ".self::TABLE_NAME." WHERE id='{$this->_id}'");
        if (!$rows) {
            return false;
        }

        // avoid creating empty single item arrays
        $scores = [];
        if ($rows[0]->scores != "") {
            $scores = explode(",", $rows[0]->scores);
        }

        $this->_token = $rows[0]->token;
        $this->_name = $rows[0]->name;
        $this->setVelocity(new Velocity($scores));
        return true;
    }
}