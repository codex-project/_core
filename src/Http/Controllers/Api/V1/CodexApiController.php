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
namespace Codex\Http\Controllers\Api\V1;

use Codex\Codex;
use Codex\Documents\Document;
use Codex\Exception\CodexException;
use Codex\Projects\Project;
use Exception;
use Swagger\Annotations as SWG;

/**
 * This is the class CodexApiController.
 *
 * @package        Codex\Http
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 * @SWG\Swagger(
 *     schemes={'http'},
 *     basePath="/api/v1",
 *     @SWG\Info(
 *      title="Codex API",
 *     description="Codex Api",
 *     license="Copyright 2016 (c) Codex Project - The MIT License - http://codex-project.ninja/license",
 *     version="1.0.0"
 *     )
 * )
 */
class CodexApiController extends ApiController
{
    public function getConfig($key = null)
    {
        try {
            $data = [];
            if ( $key ) {
                $data[ $key ] = config($key);
            }
            foreach ( request('keys', []) as $key ) {
                $data[ $key ] = config($key);
            }
        }
        catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->response($data);
    }

    public function getQuery($query)
    {
        try {
            if($query === '@'){
                return $this->getCodex();
            }
            $data = $this->codex->get($query)->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }
        return $this->response($data);
    }

    public function getCodex()
    {
        try {
            $data = $this->codex->toArray();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    /**
     * getProjects method
     * @return mixed
     * @SWG\Get(
     *     method="get",
     *
     * )
     */
    public function getProjects()
    {
        try {
            $data = $this->codex->get('*')->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    public function getProject($project)
    {
        try {
            $data = $this->codex->get("{$project}")->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    public function getRefs($project)
    {
        try {
            $data = $this->codex->get("{$project}/*")->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    public function getRef($project, $ref)
    {
        try {
            $data = $this->codex->get("{$project}/{$ref}")->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    public function getDocuments($project, $ref)
    {
        try {
            $data = $this->codex->get("{$project}/{$ref}::*")->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        return $this->response($data);
    }

    public function getDocument($project, $ref, $document)
    {
        try {
            $doc  = $this->codex->get("{$project}/{$ref}::{$document}");
            $data = $doc->toArray();
        }
        catch (CodexException $e) {
            return $this->error($e->getMessage());
        }

        if ( request('render', false) == true ) {
            $data[ 'rendered' ] = $doc->render();
        }
        if ( request('original', false) == true ) {
            $data[ 'original' ] = $doc->getOriginalContent();
        }
        return $this->response($data);
    }

    public function getMenus()
    {
        $data = $this->codex->menus->toArray();
        return $this->response($data);
    }

    public function getMenu($menu)
    {
        $menu = $this->codex->menus->get($menu);
        $menu->resolve(request('params', []));
        if ( $menu->hasResolver() ) {
            $menu->resolve(request('params', []));
        }
        $data = $menu->toArray();
        return $this->response($data);
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
