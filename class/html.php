<?php 
class Html{
    public function alert(string $message):void{
        echo "<script>(function(){ alert('{$message}');})();</script>";
    }
    public function table(array $params):void{
        $table_class=$params['class']?implode(' ',$params['class']):'';
        echo '<table class="table table-striped '.$table_class.'">';
        echo '<thead><tr><th scope="col">#</th>';
        foreach ($params['thead'] as $col) {
            echo '<th scope="col">'.$col.'</th>';
        }
        echo '</thead><tbody>';
        foreach ($params['tbody']  as $row) {
            echo '<tr><th scope="row">'.$row['id'].'</th>';
            unset($row['id']);
            foreach($row as $td)echo "<td>{$td}</td>";
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}
