<?php
namespace Codex\Http\Controllers;

use Codex\Codex;
use Codex\Support\Traits\HookableTrait;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Controller ;

/**
 * This is the CodexController.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
abstract class CodexController extends Controller
{
    use HookableTrait;

    /**
     * @var \Codex\Codex
     */
    protected $codex;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Codex\Codex                         $codex
     * @param \Illuminate\Contracts\View\Factory|\Illuminate\View\Factory $view
     */
    public function __construct(Codex $codex, ViewFactory $view)
    {
        $this->hookPoint('controller:construct', [ $codex, $view ]);
        $this->codex = $codex;
        $this->view  = $view;
        $view->share('codex', $codex);
        $this->hookPoint('controller:constructed', [ $codex, $view ]);
    }

}
