<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Next\Exception;

use Codex\Core\Next\Projects\Project;

class ProjectNotFoundException extends CodexException
{
    /**
     * project method
     *
     * @param $project
     *
     * @return static
     */
    public function project($project)
    {
        //$ex = static::in($project instanceof Project ? $project : get_called_class());
        if ( $project instanceof Project ) {
            $project = $project->getName();
        }

        return $ex->because("Could not find project [{$project}]");
    }

}
