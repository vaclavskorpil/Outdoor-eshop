<?php


namespace services;


class Log
{
    static function write_line($log_msg)
    {
        $log_filename = "logs";
        if (!file_exists($log_filename)) {
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/debug.log';
        file_put_contents($log_file_data, time() . "  " . $log_msg . "\n", FILE_APPEND);

    }

}
