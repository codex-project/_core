<?php
namespace Codex\Http\Controllers\Api\V1;

use Codex\Codex;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
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
            return $project->getName();
//            [
//                'name'         => $project->getName(),
//                'display_name' => $project->getDisplayName(),
//                'refs'         => $project->getRefs(),
//                'default_ref'  => $project->getDefaultRef(),
//            ];
        })->toArray());
    }

    public function getDocument()
    {
        $projectSlug      = request('project');
        $documentPathName = request('document');
        $ref              = request('ref', '');
        $render           = request('render', false);
        $original         = request('original', false);
        // project

        try {
            $document = $this->codex->query("{$projectSlug}/{$ref}::{$documentPathName}");
        } catch(CodexException $e){
            return $this->error($e->getMessage());
        }

        // rendered and orignal content
        $responseData = $document->toArray();
        if ( $render ) {
            $responseData[ 'rendered' ] = $document->render();
        }
        if ( $original ) {
            $responseData[ 'original' ] = $document->getOriginalContent();
        }

        return $this->response($responseData);
    }

    public function getDocuments()
    {
        // project
        $projectSlug = request('project');
        if ( false === $this->codex->projects->has($projectSlug) ) {
            return $this->error("Project [{$projectSlug}] does not exist");
        }
        $project = $this->codex->projects->get($projectSlug);

        // ref
        $ref = request('ref', $dref = $project->getDefaultRef());
        if ( $ref === '' ) {
            $ref = $dref;
        }
        if ( false === $project->hasRef($ref) ) {
            return $this->error("Ref [{$ref}] for project [{$project}] does not exist");
        }
        $project->setRef($ref);

        // documents
        $documents = $project->documents->all();
        return $this->response(
            collect($documents)->values()->transform(function (Document $document) {
                return [
                    'lastModified' => $document->getLastModified(),
                    'path'         => $document->getPath(),
                    'pathName'     => $document->getPathName(),
                ];
            })->toArray()
        );
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
        return $this->response($this->codex->menus->getItems()->keys()->toArray());
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
            return $this->error('The project could not be found');
        }
        $project = $codex->projects->get($projectSlug);
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
