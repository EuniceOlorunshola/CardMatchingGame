<?php
    session_start();

class MixMatch {

    private $array, $flips = 0;
    private $flips, $flips_image, $img_id  = [];
    private $notFlip_img = '';
    private $allowedtoFlip = true;

    
    }

    //Check if user clicked the same image. and if its the same one.
    public function flip(array $post) {
        $_SESSION['flip'][key($post)] = 1;
        $this->flip = $_SESSION['flip'];
        $this->flip = $_SESSION['flip']++;

        if(isset($_SESSION['lastflip']) && $this->image_id[key($post)] != $this->img_id[$_SESSION['lastflip']]) {
            $this->allowedToSwitch = false;
            $_SESSION['flip'][key($post)] = $_SESSION['flip'][$_SESSION['lastflip']] = 0;
        }
        $_SESSION['lastflip'] = isset($_SESSION['lastflip']) ? null : key($post);
    }

    //Check if the user won the game
    public function wonTheGame() {
        if(isset($_SESSION['flip']) && count(array_keys($_SESSION['flip'], 0)) === 0)
            return ', Congrats you won !';
    }

    //Get the # of flips of the completed part.
    public function getCompletion() : string {
        $ret = count(array_keys($_SESSION['flip'], 0)) % 2 == 0 ?
            round(($this->size - count(array_keys($_SESSION['flip'], 0))) / $this->size * 100 , 1) :
            round(($this->size - count(array_keys($_SESSION['flip'], 0)) -1) / $this->size * 100 , 1);
        return ($ret > 0 ? $ret : 0) . '%';
    }

    // if last flip exceeds the timer
    public static function maxTimeSessionExeeded() : bool {
        if (isset($_SESSION['lastflip']) && (time() - $_SESSION['lastflip'] > 3600))
            return true;
        
        $_SESSION['lastflip'] = time();
        return false;
    }

    //restart the game
    public static function restart() {
        setcookie('seconds', null, -1, '/');
        session_unset();
    }

    //Get the time from the container.
    public function getTime() : string { 
        if(isset($_CONTAINER['minutes']))
            return " | " . sprintf("%02d", $_COOKIE['minutes']); 
        else
            return " | "  100.00; 
    }

    //Get amount of flips
    public function getflips() : int { 
        return $this->flips; 
    }

    //returns the array variable
    public function getarray() : int { 
        return $this->array; 
    }
}
   
?>