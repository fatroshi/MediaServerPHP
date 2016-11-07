<?php

/**
 * Created by PhpStorm.
 * User: Elise
 * Date: 02/10/16
 * Time: 22:43
 */


include_once ("Database.php");
include_once("Media.php");
include_once ("Player.php");

class Controller {

    private $database;
    private $media;
    private $player;

    function __construct() {
        $this->database = new Database();                                       // Connect to the database
        $this->media = new Media();
        $this->player = new Player();
    }

    public function download($url){
        $this->media->setUrl($url);
    }

    public function saveItem(){
        $type = "mp4";
        $path = $this->media->getFilePath();
        $status = 0;
        $name = $this->media->getRealFileName();
        $thumbnail = $this->media->getThumbnailPath();

        $sql = "INSERT INTO Items (FileType, Path, Status, FileName, Thumbnail) values ('{$type}','{$path}',{$status},'{$name}','{$thumbnail}')";

        $conn = $this->database->getConnection();
        if($conn->query($sql) === true){
            return true;
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }

    }

    public function getAllItems(){

        $output = "";
        $sql = "SELECT * FROM Items";

        $conn = $this->database->getConnection();
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                $filePath = $row['Path'];
                $status = $row['Status'];
                $fileName = $row['FileName'];
                $thumbnail = $row['Thumbnail'];

                $output .="<div class=\"col-sm-6 col-md-4\">";
                    $output .="<div class=\"thumbnail\">";
                    $output .="<img src=\"{$thumbnail}\" alt=\"{$filePath}\">";
                        $output .="<div class=\"caption\">";
                            $output .="<h5>{$fileName}</h5>";
                        $output .="</div>";
                    $output .="</div>";
                $output .="</div>";
            }
        } else {
            //return "No records found";
        }

        return $output;
    }


    public function play($pathToFile){
        $this->player->play($pathToFile);
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }




    /**
     * Get logged in user
     */
    public function getUser(){
        $this->user->getUser();
    }


    /**
     * Delete record by id
     * @param $id of the record
     * @param $table where the record is stored
     */
    public function delete($id, $table){
        $this->database->delete($id,$table);
    }

    /**
     * Redirect user to another page
     * @param $newURL
     */
    public function redirect($newURL){
        header("Location: " . $newURL);
        die();
    }

    /**
     * Get the last inserted record
     * @return mixed
     */
    public function insertId(){
        // Get last inserted id
        return $this->database->getConnection()->insert_id;
    }

    /**
     * Display data in an array
     * @param $array
     */
    public function var_dump($array){
        echo "<pre>";
        print_r($array); // or var_dump($data);
        echo "</pre>";
    }

    /**
     * Check if the user exists, and that the authentication returns true.
     * @param $username
     * @param $password
     * @return bool true if the user- password data is correct
     */
    public function login($username, $password){
        return $this->user->login($username,$password);
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param Database $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }


}
