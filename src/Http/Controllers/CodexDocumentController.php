<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Http\Controllers;

use Codex\Codex;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Exception\DocumentNotFoundException;
use Codex\Exception\ProjectNotFoundException;
use Codex\Exception\RefNotFoundException;
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
class CodexDocumentController extends CodexController
{
    /**
     * Redirect to the default project and version.
     *
     * @return Redirect
     */
    public function getIndex()
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
     * @param string      $projectSlug
     * @param string|null $ref
     * @param string      $path
     *
     * @return $this
     */
    public function getDocument($projectSlug = null, $ref = null, $path = '')
    {
        if ( $projectSlug === null ) {
            $projectSlug = $this->codex->config('default_project');
        }
        /** @var Codex $codex */
        $codex = $this->codex;

        $ref  = $ref ?: '!';
        $path = $path ?: '!';

        try {
            /** @var Document $document */
            $document = $codex->get("{$projectSlug}/{$ref}::{$path}");
        }
        catch (DocumentNotFoundException $e) {
            $ref = $codex->get("{$projectSlug}/{$ref}");
            $this->view->share('ref', $ref);
            $this->view->share('project', $ref->getProject());
            return $this->notFound('document', $e);
        }
        catch (RefNotFoundException $e){
            $project = $codex->get($projectSlug);
            $this->view->share('project', $project);
            return $this->notFound('ref', $e);
        }
        catch(ProjectNotFoundException $e){
            return $this->notFound('project', $e);
        }

        // share project in views
        $project = $document->getProject();
        $ref     = $document->getRef();
        $content    = $document->render();
        $breadcrumb = $document->getBreadcrumb();

        $this->view->share(compact('project', 'ref', 'document'));
//        $res = $this->hookPoint('controller:document', [ $document ]);
        $res = $this->hookPoint('controller:document', [ $document, $codex, $project, $ref ]);
        if ( $res ) {
            return $res;
        }

        #
        # prepare view
        #
        $view = $this->view->make($document->attr('view'), compact('document', 'content', 'breadcrumb'));

        return $view;
    }

    protected function notFound($what, \Exception $e)
    {
        $this->hookPoint('controller:error', [$what,$e]);
        return $this->codex->error('Oops, couldnt find that ' . $what, $e->getMessage(), 404);
    }
    public function getDocumentNotFound()
    {

    }
}
