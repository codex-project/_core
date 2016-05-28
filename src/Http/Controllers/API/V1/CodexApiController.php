<?php
namespace Codex\Core\Http\Controllers\API\V1;

use Codex\Core\Http\Controllers\Controller;

class CodexApiController extends ApiController
{
    public function projects($project = null)
    {
        if($project === null) {
            $data = $this->codex->projects->toArray();
        } else {
            $data = $this->codex->projects->get($project)->toArray();
        }
        return response()->json($data);
    }

    public function documents($project, $document = null)
    {
        $project = $this->codex->projects->get($project);
        $documents = $project->documents;

        if($document === null) {
            $data = $documents->all();
        } else {
            $data = $documents->get($document);
        }
        return response()->json($data);
    }
}
