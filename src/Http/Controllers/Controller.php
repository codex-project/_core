<?php
namespace Codex\Core\Http\Controllers;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Menus\MenuFactory;
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
    protected $factory;

    /**
     * @var \Codex\Core\Contracts\Menus\MenuFactory|\Codex\Core\Menus\MenuFactory
     */
    protected $menus;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Codex\Core\Contracts\Codex             $factory
     * @param \Codex\Core\Contracts\Menus\MenuFactory $menus
     * @param \Illuminate\Contracts\View\Factory      $view
     */
    public function __construct(Codex $factory, MenuFactory $menus, ViewFactory $view)
    {
        $this->factory = $factory;
        $this->menus = $menus;
        $this->view = $view;
    }
}
