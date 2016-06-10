<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/10/16
 * Time: 8:00 PM
 */
namespace Codex\Projects;

use Codex\Contracts\Codex;
use Illuminate\Contracts\View\Factory;

/**
 * Class Generator
 * @package Codex\Projects
 */
class Generator
{
    protected $codex;

    /**
     * @var \Illuminate\Contracts\View\Factory|\Illuminate\View\Factory
     */
    private $view;

    /**
     * Generator constructor.
     *
     * @param $codex
     */
    public function __construct(Codex $codex, Factory $view)
    {
        $this->codex = $codex;
        $this->view = $view;
    }

    protected function registerViewExtension()
    {
        $hasExtension = in_array('stub', $this->view->getExtensions(), true);
        if($hasExtension === false){
            $this->view->addExtension('stub', 'blade');
        }
    }

    public function project($name)
    {
        $docsPath = $this->codex->getDocsPath();

    }

    protected function render($view, array $data = [])
    {
        return view($view, $data)->render();
    }
}
