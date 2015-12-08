<?php
namespace Docit\Core\Http\Controllers;

use Docit\Core\Contracts\Factory;
use Docit\Core\Contracts\Menus\MenuFactory;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * This is the DocitController.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class Controller extends BaseController
{
    /**
     * @var \Docit\Core\Contracts\Factory|\Docit\Core\Factory
     */
    protected $factory;

    /**
     * @var \Docit\Core\Contracts\Menus\MenuFactory|\Docit\Core\Menus\MenuFactory
     */
    protected $menus;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Docit\Core\Contracts\Factory           $factory
     * @param \Docit\Core\Contracts\Menus\MenuFactory $menus
     * @param \Illuminate\Contracts\View\Factory       $view
     */
    public function __construct(Factory $factory, MenuFactory $menus, ViewFactory $view)
    {
        $this->factory = $factory;
        $this->menus = $menus;
        $this->view = $view;
    }
}
