<?php
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
