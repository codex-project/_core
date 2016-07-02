<?php
namespace Codex\Http\Controllers\Api\V1;

use Codex\Codex;
use Codex\Http\Controllers\Api\V1\ApiController;

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


    /**
     * Render the documentation page for the given project and version.
     *
     * @param string $projectSlug
     * @param string|null $ref
     * @param string $path
     *
     * @return $this
     */
    public function document($projectSlug, $ref = null, $path = '')
    {
        /** @var Codex $codex */
        $codex = $this->codex;

        #
        # get project
        #
        if ( false === $codex->projects->has($projectSlug) ) {
            return $codex->error('Not found', 'The project could not be found', 404);
        }
        $project = $codex->projects->get($projectSlug);

        // share project in views
        $this->view->share('project', $project);

        #
        # get ref (version)
        #
        if ( null === $ref ) {
            $ref = $project->getDefaultRef();
        }
        if ( false === $project->hasRef($ref) ) {
            return $codex->error('Not found', 'The version could not be found', 404);
        }
        $project->setRef($ref);
        $path = $path === '' ? $project->config('index') : $path;

        #
        # get document
        #
        if ( false === $project->documents->has($path) ) {
            return $codex->error('Not found', 'The document could not be found', 404);
        }
        $document = $project->documents->get($path);
        $content = $document->render();
        $breadcrumb = $document->getBreadcrumb();

        $res = $this->hookPoint('controller:document', [ $document, $codex, $project ]);
        if ( $res ) {
            return $res;
        }

        #
        # prepare view
        #
        $view = $this->view->make($document->attr('view'), compact('project', 'document', 'content', 'breadcrumb'));

        $res = $this->hookPoint('controller:view', [ $view, $codex, $project, $document ]);
        if ( $res ) {
            return $res;
        }

        return $view;
    }
}
