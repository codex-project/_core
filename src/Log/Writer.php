<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Core\Log;

use Codex\Core\Contracts\Log;
use Illuminate\Log\Writer as BaseWriter;
use Monolog\Formatter\ChromePHPFormatter;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * This is the class Logger.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class Writer extends BaseWriter implements Log
{
    public function __construct(\Monolog\Logger $monolog, \Illuminate\Contracts\Events\Dispatcher $dispatcher)
    {
        parent::__construct($monolog, $dispatcher);
    }

    public function useCodex($path, $level = 'debug')
    {
        $this->useFiles($path, $level);
        #$this->useChromePHP($level);
        $this->useFirePHP($level);
    }

    /**
     * Register a file log handler.
     *
     * @param  string $path
     * @param  string $level
     *
     * @return void
     */
    public function useChromePHP($level = 'debug')
    {
        $this->monolog->pushHandler($handler = new ChromePHPHandler($this->parseLevel($level)));
        $handler->setFormatter($formatter = new ChromePHPFormatter());
    }

    public function useFirePHP($level = 'debug')
    {
        $this->monolog->pushHandler($handler = new FirePHPHandler($this->parseLevel($level)));
    }


}
