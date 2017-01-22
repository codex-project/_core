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
namespace Codex\Log;

use Codex\Contracts\Log\Log;
use Illuminate\Log\Writer as BaseWriter;
use Monolog\Formatter\ChromePHPFormatter;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * This is the class Logger.
 *
 * @package        Codex\Core
 * @author         Codex Project
 * @copyright      Copyright (c) 2015, Codex Project. All rights reserved
 */
class Writer extends BaseWriter implements Log
{
    protected $enabled;

    public function __construct(\Monolog\Logger $monolog, \Illuminate\Contracts\Events\Dispatcher $dispatcher)
    {
        parent::__construct($monolog, $dispatcher);
        $this->enabled = true;
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

    protected function writeLog($level, $message, $context)
    {
        if ($this->enabled) {
            parent::writeLog($level, $message, $context);
        }
    }

    /**
     * Set the enabled value
     *
     * @param mixed $enabled
     *
     * @return Writer
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
}
