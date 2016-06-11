<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/10/16
 * Time: 8:00 PM
 */
namespace Codex\Projects;

use Codex\Contracts\Codex;
use Codex\Support\Extendable;
use Illuminate\Contracts\View\Factory;
use Sebwite\Filesystem\Filesystem;

/**
 * Class Generator
 * @package Codex\Projects
 */
class ProjectGenerator extends Extendable
{
    /** @var \Codex\Contracts\Codex  */
    protected $codex;

    /** @var \Illuminate\Contracts\View\Factory  */
    protected $view;

    /** @var \Sebwite\Filesystem\Filesystem  */
    protected $fs;

    protected $vars = [
        'open' => "<?php \n",
    ];

    protected $name;

    protected $views = [
        'config' => 'codex-stubs::config',
        'index' => 'codex-stubs::index',
        'menu' => 'codex-stubs::menu'
    ];

    /**
     * ProjectGenerator constructor.
     *
     * @param \Codex\Contracts\Codex|\Codex\Codex             $codex
     * @param \Illuminate\Contracts\View\Factory|\Illuminate\View\Factory $view
     * @param \Sebwite\Filesystem\Filesystem     $fs
     */
    public function __construct(Codex $codex, Factory $view, Filesystem $fs)
    {
        $this->codex = $codex;
        $this->view  = $view;
        $this->fs    = $fs;
        $this->registerViewExtension();
        $this->hookPoint('projects:generator:constructed');
    }

    protected function registerViewExtension()
    {
        $hasExtension = in_array('stub', $this->view->getExtensions(), true);
        if ( $hasExtension === false ) {
            $this->view->addExtension('stub', 'blade');
        }
    }

    public function set($key, $value = null)
    {
        if($value === null){
            $this->vars = $key;
        } else {
            data_set($this->vars, $key, $value);
        }
        return $this;
    }

    public function merge(array $data)
    {
        $this->vars = array_replace($this->vars, $data);
        return $this;
    }

    /**
     * @param $name
     *
     * @return ProjectGenerator
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setView($name, $view)
    {
        $this->views[$name] = $view;
        return $this;
    }

    public function generate()
    {
        $this->fs->ensureDirectory($projectPath = path_join(config('codex.paths.docs'), $this->name, 'master'));
        $this->renderTo('config.php', $this->views['config'], []);
        $this->renderTo('master/menu.yml', $this->views['menu'], []);
        $this->renderTo('master/index.md', $this->views['index'], []);

    }

    protected function renderTo($dest, $view, array $data = [ ])
    {
        $this->fs->put(path_join(config('codex.paths.docs'), $this->name, $dest), $this->render($view, $data));
    }

    protected function render($view, array $data = [ ])
    {
        $data = array_merge($this->vars, $data);
        return view($view, $data)->render();
    }
}
