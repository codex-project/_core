<?php
/**
 * Part of the $author$ PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Addons;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Laradic\Support\Path;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

abstract class AddonServiceProvider extends ServiceProvider
{
    protected $path;

    protected $class;

    protected $treeBuilder;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->treeBuilder = new TreeBuilder();
        $app->booting(function(Application $app){
            /** @var \Codex\Core\Contracts\Codex|\Codex\Core\Codex $codex */
            #$codex = $app->make('codex');
            #$codex->addons()->providers()->put($this->getName(), $this);
            #$codex->addons()->addons()->put($this->getName(), $this);
        });
    }

    #abstract public function config(NodeBuilder $config);

    abstract public function getName();

    public function register()
    {


        return $this->app;
    }

    protected function registerConfig()
    {
        $root = $this->treeBuilder->root($this->getName());
        $this->config($root->children());
        $t    = $this->treeBuilder->buildTree();
        $name = $t->getName();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getClass()
    {
        return $this->class;
    }


}
