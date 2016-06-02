<?php
/**
 * Part of the Codex Project PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Exception;

use Codex\Documents\Document;
use Codex\Projects\Project;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentNotFoundException extends \Exception
{
    public static function document($document)
    {
        if ( $document instanceof Document ) {
            $document = $document->getName();
        }
        return new static("Could not find document [{$document}]");
    }

    public function inProject($project)
    {
        if ( $project instanceof Project ) {
            $project = $project->getName();
        }
        $this->message .= " in project [{$project}]";

        return $this;
    }

    public function toHttpException()
    {
        return new NotFoundHttpException($this->getMessage());
    }
}
