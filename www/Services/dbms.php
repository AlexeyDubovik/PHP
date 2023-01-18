<?php

function Connect_DB(){
    $DB_settings = parse_ini_file("ini/db.ini", true);
    if(empty($DB_settings)) {
        return null;
    } else {
        try {
            $param = "mysql:";
            foreach ($DB_settings['mysql'] as $key => $value) {
                $param .= $key . "=" . $value . ";";
            }
            return new PDO(
                $param,
                $DB_settings['user']['login'],
                $DB_settings['user']['password'],
                [
                    PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ]
            );
        } catch (PDOException $ex) {
            global $_LOG_DIR;
            $message = "[" . date("Y-m-d H:i:s") . "] [" . $ex->getMessage() . "]";
            if (!is_file($_LOG_DIR)) {
                file_put_contents($_LOG_DIR, $message);
            }
            else {
                error_log($message . "\n", 3, $_LOG_DIR);
            }
            return null;
        }
    }
}
?>
