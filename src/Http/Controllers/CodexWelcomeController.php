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

class CodexWelcomeController extends CodexController
{
    public function getIndex()
    {
        $this->hookPoint('controller:welcome');

        return $this->view->make($this->codex->view('welcome'));
    }
}
