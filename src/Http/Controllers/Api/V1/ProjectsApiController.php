<?php

namespace Codex\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProjectsApiController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = [ ];
        foreach ( $this->codex->projects->all() as $project ) {
            $projects[] = [
                'name'         => $project->getName(),
                'display_name' => $project->getDisplayName(),
            ];
        }
        return $this->response($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->error('Not implemented');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->error('Not implemented');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $name
     *
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $projects = $this->codex->projects;
        if ( false === $projects->has($name) ) {
            return $this->error('Could not find project: ' . (string)$name);
        }
        $project = $projects->get($name);
        return $this->response($project->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->error('Not implemented');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->error('Not implemented');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->error('Not implemented');
    }
}
