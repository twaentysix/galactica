<?php

class Player {
    private $username;
    private $resources = array('wood' => 100, 'stone' => 100, 'gold' => 100);
    private $buildings = array('farm' => 1, 'mine' => 1, 'townhall' => 1);
    private $researches = array('agriculture' => 1, 'mining' => 1, 'economy' => 1);

    public function __construct($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getResources() {
        return $this->resources;
    }

    public function getBuildings() {
        return $this->buildings;
    }

    public function getResearches() {
        return $this->researches;
    }
}

?>
