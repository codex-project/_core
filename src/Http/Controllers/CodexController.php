<?php
namespace Codex\Http\Controllers;

use Codex\Codex;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Support\Traits\HookableTrait;
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
     * @param \Codex\Codex $codex
     * @param \Illuminate\Contracts\View\Factory $view
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

        #codex()->addons->getManifest()->load()->set('asdf.a', 'asdf')->save();
        codex('addons');

        return redirect(route('codex.document', [
            'projectSlug' => $this->codex->config('default_project'),
        ]));
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

        $ref = $ref ?: '!';
        $path = $path ?: '!';

        try {
            /** @var Document $document */
            $document = $codex->get("{$projectSlug}/{$ref}::{$path}");
        }
        catch(CodexException $e){
            return $codex->error('Whoops', $e->getMessage(), 404);
        }

        // share project in views
        $project = $document->getProject();
        $ref = $document->getRef();
        $this->view->share(compact('project', 'ref'));

        $content = $document->render();
        $breadcrumb = $document->getBreadcrumb();

        $res = $this->hookPoint('controller:document', [ $document, $codex, $project, $ref ]);
        if ( $res ) {
            return $res;
        }

        #
        # prepare view
        #
        $view = $this->view->make($document->attr('view'), compact('project', 'document', 'content', 'breadcrumb', 'ref'));

        $res = $this->hookPoint('controller:view', [ $view, $codex, $project, $document, $ref ]);
        if ( $res ) {
            return $res;
        }

        return $view;
    }

    public function markdown()
    {
        if ( !request()->has('code') ) {
            return abort(500, 'You did not provide the [code]');
        }
        $code = request()->get('code');
    }

}
