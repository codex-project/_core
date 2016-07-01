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

use Closure;
use Codex\Dev\Debugbar\CodexSimpleCollector;
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
        return $this->isEnabled() && config('codex.dev.debugbar', false);
    }

    public function hasDebugbar()
    {
        return $this->app->bound('debugbar') && $this->app->make('debugbar')->isEnabled() === true && $this->app->isBooted();
    }

    /**
     * Returns the Debugbar instance
     *
     * @param \Closure $cb
     *
     * @return static
     */
    protected function debugbar(Closure $cb)
    {
        if ( $this->canDebugbar() )
        {
            if ( $this->hasDebugbar() )
            {
                call_user_func($cb, $this->app->make('debugbar'));
            }
            else
            {
                $this->app->booted(function ($app) use ($cb)
                {
                    call_user_func($cb, $app->make('debugbar'));
                });
            }
        }
        return $this;
    }

    public function addMessage($message, $label = 'info')
    {
        $this->debugbar(function ($debugbar) use ($message, $label)
        {
            /** @var \Barryvdh\Debugbar\LaravelDebugBar $debugbar */
            $debugbar->addMessage($message, $label);
        });

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
        $this->debugbar(function ($debugbar) use ($name, $label)
        {
            /** @var \Barryvdh\Debugbar\LaravelDebugBar $debugbar */
            $debugbar->startMeasure($name, $label);
        });

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
        $this->debugbar(function ($debugbar) use ($name)
        {
            /** @var \Barryvdh\Debugbar\LaravelDebugBar $debugbar */
            $debugbar->stopMeasure($name);
        });
        return $this;
    }

    public function data(Closure $cb)
    {
        $this->debugbar(function ($debugbar) use ($cb)
        {
            /** @var \Barryvdh\Debugbar\LaravelDebugBar $debugbar */
            call_user_func($cb, $this->getCollector()->data());
        });
    }

    /**
     * setData method
     *
     * @param string|array $key
     * @param mixed        $value
     */
    public function setData($key, $value = null)
    {
        $this->data(function ($data) use ($key, $value)
        {
            /** @var \Codex\Support\Collection $data */
            $data->set($key, $value);
        });
    }

    /**
     * getCollector method
     * @return CodexSimpleCollector
     */
    public function getCollector()
    {
        return $this->app->make('codex.dev.debugbar.collector');
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
            if ( $addToDebugbar === true )
            {
                $this->debugbar(function ($debugbar)
                {
                    $debugbar->addMessage($stats = $this->bench->getStats(), 'debug');
                    $debugbar->addMessage($marks = $this->bench->getMarks(), 'debug');
                    $debugbar->addMeasure('benchmark overall', $stats[ 'start' ], $stats[ 'stop' ]);

                    foreach ( $marks as $i => $mark )
                    {
                        if ( $mark[ 'id' ] === '-' )
                        {
                            continue;
                        }
                        $stop = isset($marks[ $i + 1 ]) ? $marks[ $i + 1 ][ 'microtime' ] : $stats[ 'stop' ];

                        $debugbar->addMeasure("benchmark({$i}): {$mark['id']}", $mark[ 'microtime' ], $stop);
                    }
                });
            }
        }
    }


}