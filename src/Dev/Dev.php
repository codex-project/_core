<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Dev;

use Codex\Support\Bench;
use Codex\Support\Extendable;

/**
 * This is the class DevHelper.
 *
 * @package        Codex\Helpers
 * @author         Robin Radic
 */
class Dev extends Extendable
{
    /** @var \Codex\Support\Bench */
    protected $bench;

    /** @var bool */
    protected $startedBench;

    /** @var Dev */
    protected static $instance;

    /**
     * Theme constructor.
     *
     * @param \Codex\Contracts\Codex|\Codex\Codex $parent
     */
    protected function __construct()
    {
        $this->setContainer(app());
        $this->bench        = new Bench();
        $this->startedBench = false;
    }

    /**
     * getInstance method
     * @return \Codex\Dev\Dev
     */
    public static function getInstance()
    {
        if ( ! isset(static::$instance) )
        {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function isEnabled()
    {
        return config('codex.dev.enabled', false) === true;
    }

    public function enable()
    {
        config([ 'codex.dev.enabled' => true ]);
    }

    public function disable()
    {
        config([ 'codex.dev.enabled' => true ]);
    }

    #
    # Debugbar

    /**
     * canDebugbar method
     * @return bool
     */
    public function canDebugbar()
    {
        return $this->isEnabled() && config('codex.dev.debugbar', false) && $this->app->bound('debugbar') && $this->app->make('debugbar')->isEnabled();
    }

    /**
     * Returns the Debugbar instance
     *
     * @return \Barryvdh\Debugbar\LaravelDebugbar
     */
    protected function debugbar()
    {
        return $this->app->make('debugbar');
    }

    public function addMessage($message, $label = 'info')
    {
        if ( $this->canDebugbar() )
        {
            $this->debugbar()->addMessage($message, $label);
        }
        return $this;
    }

    /**
     * startMeasure method
     *
     * @param      $name
     * @param null $label
     *
     * @return $this
     */
    public function startMeasure($name, $label = null)
    {
        if ( $this->canDebugbar() )
        {
            $this->debugbar()->startMeasure($name, $label);
        }

        return $this;
    }

    /**
     * stopMeasure method
     *
     * @param $name
     *
     * @return $this
     */
    public function stopMeasure($name)
    {
        if ( $this->canDebugbar() )
        {
            $this->debugbar()->stopMeasure($name);
        }
        return $this;
    }


    #
    # Benchmark

    /**
     * startBenchmark method
     */
    public function startBenchmark()
    {
        if ( $this->startedBench === false && $this->canBenchmark() )
        {
            $this->startedBench = true;
            $this->bench->start();
        }
    }

    /**
     * canBenchmark method
     * @return bool
     */
    public function canBenchmark()
    {
        return $this->isEnabled() && config('codex.dev.benchmark');
    }

    /**
     * benchmark method
     *
     * @param $id
     */
    public function benchmark($id)
    {
        if ( $this->canBenchmark() )
        {
            $this->startBenchmark();
            $this->bench->mark($id);
        }
    }

    /**
     * stopBenchmark method
     *
     * @param bool $addToDebugbar
     */
    public function stopBenchmark($addToDebugbar = true)
    {
        if ( $this->startedBench === true && $this->canBenchmark() )
        {
            $this->bench->stop();
            $this->startedBench = false;
            if ( $addToDebugbar === true && $this->canDebugbar() )
            {
                $this->debugbar()->addMessage($stats = $this->bench->getStats(), 'debug');
                $this->debugbar()->addMessage($marks = $this->bench->getMarks(), 'debug');
                $this->debugbar()->addMeasure('benchmark overall', $stats['start'], $stats['stop']);

                foreach ( $marks as $i => $mark )
                {
                    $stop = isset($marks[ $i + 1 ]) ? $marks[ $i + 1 ][ 'microtime' ] : $stats[ 'stop' ];

                    $this->debugbar()->addMeasure("benchmark({$i}): {$mark['id']}", $mark[ 'microtime' ], $stop);
                }
            }
        }
    }


}