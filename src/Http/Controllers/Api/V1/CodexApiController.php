<?php
namespace Codex\Http\Controllers\Api\V1;

use Codex\Codex;
use Codex\Projects\Project;

class CodexApiController extends ApiController
{
    public function getProject()
    {
        $project = request('project');
        if ( false === $this->codex->projects->has($project) ) {
            return $this->error("Project [{$project}] does not exist");
        }
        return $this->response($this->codex->projects->get($project)->toArray());
    }

    public function getProjects()
    {
        return $this->response($this->codex->projects->query()->transform(function (Project $project) {
            return [
                'name'         => $project->getName(),
                'display_name' => $project->getDisplayName(),
                'refs'         => $project->getRefs(),
                'default_ref'  => $project->getDefaultRef(),
            ];
        })->toArray());
    }

    public function getDocument()
    {
        $projectSlug = request('project');
        $document    = request('document');

        if ( false === $this->codex->projects->has($projectSlug) ) {
            return $this->error("Project [{$projectSlug}] does not exist");
        }
        $project = $this->codex->projects->get($projectSlug);
        $ref     = request('ref', $dref = $project->getDefaultRef());
        if($ref === ''){
            $ref = $dref;
        }
        if ( false === $project->hasRef($ref) ) {
            return $this->error("Ref [{$ref}] for project [{$project}] does not exist");
        }
        $project->setRef($ref);
        if ( false === $project->documents->has($document) ) {
            return $this->error("Document [{$document}] does not exist in project [{$project}]");
        }
        return $this->response($project->documents->get($document)->toArray());
    }

    public function getDocuments()
    {
        $projectSlug = request('project');

        if ( false === $this->codex->projects->has($projectSlug) ) {
            return $this->error("Project [{$projectSlug}] does not exist");
        }
        $project = $this->codex->projects->get($projectSlug);
        $ref     = request('ref', $dref = $project->getDefaultRef());
        if($ref === ''){
            $ref = $dref;
        }
        if ( false === $project->hasRef($ref) ) {
            return $this->error("Ref [{$ref}] for project [{$project}] does not exist");
        }
        $project->setRef($ref);
        $documents = $project->documents->all();
        return $this->response(collect($documents)->toArray());
    }

    public function getMenu()
    {
        $id = request('id');
        if ( false === $this->codex->menus->has($id) ) {
            return $this->error("Menu [{$id}] does not exist");
        }
        return $this->response($this->codex->menus->get($id)->toArray());
    }

    public function getMenus()
    {
        return $this->response($this->codex->menus->toArray());
    }

    /**
     * Render the documentation page for the given project and version.
     *
     * @param string      $projectSlug
     * @param string|null $ref
     * @param string      $path
     *
     * @return $this
     */
    public function getRenderedDocument($projectSlug, $ref = null, $path = '')
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
        $document   = $project->documents->get($path);
        $content    = $document->render();
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
