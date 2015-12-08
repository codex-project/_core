<?php
namespace Docit\Core\Http\Controllers;

/**
 * This is the DocitController.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class DocitController extends Controller
{
    /**
     * Redirect to the default project and version.
     *
     * @return Redirect
     */
    public function index()
    {
        return redirect(route('docit.document', [
            'projectSlug' => $this->factory->config('default_project')
        ]));
    }

    /**
     * Render the documentation page for the given project and version.
     *
     * @param string      $projectSlug
     * @param string|null $ref
     * @param string      $path
     * @return $this
     */
    public function document($projectSlug, $ref = null, $path = '')
    {
        $project = $this->factory->getProject($projectSlug);

        if (is_null($ref)) {
            $ref = $project->getDefaultRef();
        }
        $project->setRef($ref);

        $document   = $project->getDocument($path);
        $content    = $document->render();
        $breadcrumb = $document->getBreadcrumb();


        $this->view->composer($document->attr('view'), $this->factory->config('projects_menus_view_composer'));

        return  $this->view->make($document->attr('view'), compact('project', 'document', 'content', 'breadcrumb'));
    }
}
