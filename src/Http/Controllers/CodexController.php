<?php
namespace Codex\Core\Http\Controllers;

use Codex\Core\Contracts\Codex;
use Codex\Core\Exception\DocumentNotFoundException;
use Codex\Core\Exception\ProjectNotFoundException;
use Codex\Core\Traits\HookableTrait;
use Illuminate\Contracts\View\Factory as View;

/**
 * This is the CodexController.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class CodexController extends Controller
{
    use HookableTrait;

    /**
     * CodexController constructor.
     *
     * @param \Codex\Core\Contracts\Codex|\Codex\Core\Codex $codex
     * @param \Illuminate\Contracts\View\Factory            $view
     */
    public function __construct(Codex $codex, View $view)
    {
        $this->hookPoint('controller:construct');
        parent::__construct($codex, $view);
        $this->hookPoint('controller:constructed');
    }


    /**
     * Redirect to the default project and version.
     *
     * @return Redirect
     */
    public function index()
    {
        $this->hookPoint('controller:index');

        return redirect(route('codex.document', [
            'projectSlug' => $this->codex->config('default_project'),
        ]));
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
    public function document($projectSlug, $ref = null, $path = '')
    {
        # get project
        if ( !$this->codex->projects->has($projectSlug) ) {
            throw ProjectNotFoundException::in($this)->project($projectSlug)->toHttpException();
        }
        $project = $this->codex->projects->get($projectSlug);

        # get ref (version)
        if ( is_null($ref) ) {
            $ref = $project->getDefaultRef();
        }
        $project->setRef($ref);
        $path = $path === '' ? 'index' : $path;

        # get document
        if ( !$project->documents->has($path) ) {
            throw DocumentNotFoundException::document($path)->inProject($project)->toHttpException();
        }

        $document = $project->documents->get($path);
        $res      = $this->hookPoint('controller:document', [ $this, $project, $document ]);

        # prepare view
        $content    = $document->render();
        $breadcrumb = $document->getBreadcrumb();

        $this->view->share('project', $project);

        return $this->view->make($document->attr('view'), compact('project', 'document', 'content', 'breadcrumb'));
    }

    public function markdown()
    {
        if ( !request()->has('code') ) {
            return abort(500, 'You did not provide the [code]');
        }
        $code = request()->get('code');
    }
}
