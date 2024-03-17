<?php

require_once 'Player.class.php';

class Game {
    private $players = array();

    public function addPlayer($username) {
        $player = new Player($username);
        $this->players[$username] = $player;
    }

    public function getPlayer($username) {
        if (isset($this->players[$username])) {
            return $this->players[$username];
        } else {
            return null;
        }
    }

    public function getAllPlayers() {
        return $this->players;
    }
}

?>
