<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/10/16
 * Time: 12:46 AM
 */

namespace Codex\Support;


use Illuminate\Bus\Queueable;


abstract class Job
{
    use Queueable;
}
