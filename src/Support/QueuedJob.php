<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 6/10/16
 * Time: 12:48 AM
 */

namespace Codex\Support;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class QueuedJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;
}
