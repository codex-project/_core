<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Exception;

use Codex\Projects\Project;

class ProjectNotFoundException extends CodexException
{
    /**
     * project method
     *
     * @param $project
     *
     * @return static
     */
    public static function project($project)
    {
        //$ex = static::in($project instanceof Project ? $project : get_called_class());
        if ( $project instanceof Project ) {
            $project = $project->getName();
        }

        return static::because("Could not find project [{$project}]");
    }

}
