<?php 
class Delete {
    private $table;

    public function from(string $table){
        $this->table = $table;
        return $this;
    }

    public function where($where){
        $query = "DELETE FROM {$this->table} WHERE {$where}";
        $this->log($query);
        SQL()->query($query);
    }

    private function log($query){
        $dir = __DIR__ . '/../../archive/logs';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $log = [
            'datetime' => date('Y-m-d H:i:s'),
            'table' => $this->table,
            'query' => $query,
            'trace' => $trace
        ];

        $file = $dir . '/delete_' . date('Y-m-d') . '.log';

        file_put_contents(
            $file,
            json_encode($log, JSON_PRETTY_PRINT) . PHP_EOL,
            FILE_APPEND
        );
    }
}