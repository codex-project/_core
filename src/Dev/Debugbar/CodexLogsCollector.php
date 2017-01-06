<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Dev\Debugbar;

use Barryvdh\Debugbar\DataCollector\LogsCollector;

class CodexLogsCollector extends LogsCollector
{
    public function getLogsFile()
    {
        return storage_path(config('codex.paths.log'));
    }

    public function getLogs($logFileContent)
    {
        $pattern = '/\[(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2})\] (\w*)\.(\w*): ([\w\.]*)\s(.*)/';
        preg_match_all($pattern, $logFileContent, $matches);
        $log = [];
        foreach ($matches[ 0 ] as $i => $match) {
            $log[] = [
                'date'     => $matches[ 1 ][ $i ],
                'time'     => $matches[ 2 ][ $i ],
                'env'      => $matches[ 3 ][ $i ],
                'level'    => $matches[ 4 ][ $i ],
                'event'    => $matches[ 5 ][ $i ],
                'data'     => json_decode($matches[ 6 ][ $i ], true),
                'data_raw' => $matches[ 6 ][ $i ],
            ];
        }
//        codex('dev')->dev->canBenchmark()
        return $log;
    }


    /**
     * get logs apache in app/storage/logs
     * only 24 last of current day
     *
     * @param string $path
     *
     * @return array
     */
    public function getStorageLogs($path)
    {
        if (!file_exists($path)) {
            return;
        }

        //Load the latest lines, guessing about 15x the number of log entries (for stack traces etc)
        $file = implode("", $this->tailFile($path, $this->lines));

        foreach ($this->getLogs($file) as $log) {
            $data    = var_export($log[ 'data' ], true);
            $message = "[{$log['date']} {$log['time']}] {$log['env']}.{$log['level']} {$log['event']}: \n {$data}";
            $this->addMessage($message, $log[ 'level' ], false);
        }
    }
}
