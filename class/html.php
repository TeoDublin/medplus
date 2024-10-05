<?php 
class Html{
    public function alert($message){
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
}
