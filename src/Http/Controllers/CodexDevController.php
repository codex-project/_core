<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Http\Controllers;

use Codex\Codex;
use Illuminate\Contracts\View\Factory as View;

/**
 * This is the CodexController.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class CodexDevCodexController extends CodexController
{

    /**
     * CodexController constructor.
     *
     * @param \Codex\Codex $codex
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(Codex $codex, View $view)
    {
        parent::__construct($codex, $view);
    }

    public function getLogs()
    {
        $logs = [];
        $logFiles = app('fs')->globule(storage_path('logs') . '/*.log');
        $file = fopen($logFiles[0], 'r+');
        fseek($file, -300, SEEK_END);
    }
}
