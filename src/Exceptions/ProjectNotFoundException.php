<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Core\Exceptions;


use Codex\Core\Project;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectNotFoundException extends \FileNotFoundException
{
    public static function project($project)
    {
        if ( $project instanceof Project )
        {
            $project = $project->getName();
        }

        return new static("Could not find project [{$project}]");
    }
    public function toHttpException()
    {
        return new NotFoundHttpException($this->getMessage());
    }
}