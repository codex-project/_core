<?php
namespace Codex\Http\Controllers;

use Codex\Contracts\Codex;
use Codex\Traits\HookableTrait;
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
     * @param \Codex\Contracts\Codex|\Codex\Codex $codex
     * @param \Illuminate\Contracts\View\Factory  $view
     */
    public function __construct(Codex $codex, View $view)
    {
        $this->hookPoint('controller:construct', [ $codex, $view ]);
        parent::__construct($codex, $view);
        $this->hookPoint('controller:constructed', [ $codex, $view ]);
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
        /** @var Codex $codex */
        $codex = $this->codex;

        // get project
        if ( false === $codex->projects->has($projectSlug) )
        {
            return $codex->error('Not found', 'The project could not be found', 404);
        }
        $project = $codex->projects->get($projectSlug);


        // share project in views
        $this->view->share('project', $project);

        // get ref (version)
        if ( null === $ref )
        {
            $ref = $project->getDefaultRef();
        }
        if ( false === $project->hasRef($ref) )
        {
            return $codex->error('Not found', 'The version could not be found', 404);
        }
        $project->setRef($ref);
        $path = $path === '' ? $project->config('index') : $path;


        // get document
        if ( false === $project->documents->has($path) )
        {
            return $codex->error('Not found', 'The document could not be found', 404);
        }
        $document   = $project->documents->get($path);
        $content    = $document->render();
        $breadcrumb = $document->getBreadcrumb();

        $res = $this->hookPoint('controller:document', [ $document, $codex, $project ]);
        if ( $res )
        {
            return $res;
        }


        // prepare view
        $view = $this->view->make($document->attr('view'), compact('project', 'document', 'content', 'breadcrumb'));

        $res = $this->hookPoint('controller:view', [ $view, $codex, $project, $document ]);
        if ( $res )
        {
            return $res;
        }

        $this->dbg();
        return $view;
    }

    public function dbg()
    {
        if ( app()->bound('debugbar') )
        {
            $d = app('debugbar');
            $c = $this->codex;
            $d->addMessage($c->config());
        }
    }

    public function markdown()
    {
        if ( ! request()->has('code') )
        {
            return abort(500, 'You did not provide the [code]');
        }
        $code = request()->get('code');
    }

}
