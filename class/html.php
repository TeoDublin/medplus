<?php 
class html{
    public function alert($message){
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
}
