<?php
namespace Codex\Core\Http\Controllers;

use Codex\Core\Contracts\Codex;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Controller as BaseController;

/**
 * This is the CodexController.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class Controller extends BaseController
{
    /**
     * @var \Codex\Core\Contracts\Codex|\Codex\Core\Factory
     */
    protected $codex;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Codex\Core\Contracts\Codex             $factory
     * @param \Codex\Core\Contracts\Menus\MenuFactory $menus
     * @param \Illuminate\Contracts\View\Factory      $view
     */
    public function __construct(Codex $codex, ViewFactory $view)
    {
        $this->codex = $codex;
        $this->view  = $view;
        $view->share('codex', $codex);
    }
}
