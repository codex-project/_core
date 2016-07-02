<?php
namespace Codex\Http\Controllers;

use Codex\Codex;
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
abstract class Controller extends BaseController
{
    /**
     * @var \Codex\Contracts\Codex|\Codex\Codex
     */
    protected $codex;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Codex\Contracts\Codex|\Codex\Codex                         $codex
     * @param \Illuminate\Contracts\View\Factory|\Illuminate\View\Factory $view
     */
    public function __construct(Codex $codex, ViewFactory $view)
    {
        $this->codex = $codex;
        $this->view  = $view;
        $view->share('codex', $codex);
    }


}
