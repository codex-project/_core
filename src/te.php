<?php

namespace te {


    class Codex
    {
        public function toArray()
        {
            /** @var \Codex\Codex $this */
            return [
                'projects' => $this->projects->getItems()->map(function (\Codex\Projects\Project $project) {
                    return array_add($project->toArray(), 'refs', $project->refs->toArray());
                }),
                'menus'    => $this->menus->toArray(),
            ];
        }
    }

    class Projects
    {
        public function toArray()
        {
            /** @var \Codex\Projects\Projects $this */
            return $this->getItems()->map(function (\Codex\Projects\Project $project) {
                return [ 'name' => $project->getName(), 'displayName' => $project->getDisplayName() ];
            });
        }
    }

    class Project
    {
        public function toArray()
        {
            /** @var \Codex\Projects\Project $this */
            return [
                'name'        => $this->getName(),
                'displayName' => $this->getDisplayName(),
            ];
        }
    }

    class Refs
    {
        public function toArray()
        {
            /** @var \Codex\Projects\Refs $this */
            return [
                'default' => $this->getDefaultName(),
                'items'   => $this->getItems()->map(function (\Codex\Projects\Ref $ref) {
                    return $ref->getName();
                })->toArray(),
            ];
        }
    }

    class Ref
    {
        public function toArray()
        {
            /** @var \Codex\Projects\Ref $this */
            return [
                'name'      => $this->getName(),
                'config'    => $this->getConfig(),
                'isBranch'  => $this->isBranch(),
                'isVersion' => $this->isVersion(),
            ];
        }

    }

    class Documents
    {
        public function toArray()
        {
            /** @var \Codex\Documents\Documents $this */
            return $this->getItems()->map(function (\Codex\Documents\Document $document) {
                return $document->getName();
            })->toArray();
        }
    }

    class Document
    {
        public function toArray()
        {
            /** @var \Codex\Documents\Document $this */
            return [
                'name'       => $this->getName(),
                'pathName'   => $this->getPathName(),
                'processed'  => $this->getProcessed(),
                'content'    => $this->render(),
                'attributes' => $this->getAttributes(),
            ];
        }
    }
}

