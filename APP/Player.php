<?php

/**
 * Created by PhpStorm.
 * User: Elise
 * Date: 2016-11-07
 * Time: 19:41
 *
 * New to install "pidof" --> sudo apt-get pidof
 * kill -STOP pid --> Pause
 * kill -cont pid --> Resume
 *
 * Better way --> kill -STOP $(pidof mplayer)
 */
class Player
{
    private $cmdOutput;
    private $cmdResult;


    /**
     * @return bool true if possible to play the video
     */
    public function play($filePath){
        $play = "/usr/local/bin/mplayer \"{$filePath}\"";
        exec($play, $output, $ret);

        if($ret ==0){
            // Success
            return true;
        }else{
            // Fail
            $this->cmdOutput = $output;
            $this->cmdResult = $ret;
            return false;
        }
    }

}