<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

abstract class AddonServiceProvider extends ServiceProvider
{
    protected $name;

    protected $depends;

    protected $treeBuilder;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->treeBuilder = new TreeBuilder();
        $app->booting(function(Application $app){
            Addons::register($this);
        });
    }

    public function register()
    {
        return $this->app;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDepends()
    {
        return $this->depends;
    }




}
