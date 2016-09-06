<?php
namespace Codex\Http\Controllers\Api\V1;

use Codex\Codex;
use Codex\Http\Controllers\Controller;
use Codex\Projects\Project;
use Codex\Projects\Ref;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends Controller
{
    /** @var \Codex\Codex */
    protected $codex;

    /** @var \Codex\Addons\Factory */
    protected $addons;

    /** @var \Codex\Projects\Projects */
    protected $projects;

    /** @var \Codex\Menus\Menus */
    protected $menus;

    /** @var Project */
    protected $project;

    /** @var  Ref */
    protected $ref;

    /**
     * ApiController constructor.
     *
     * @param \Codex\Codex                       $codex
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(Codex $codex, ViewFactory $view)
    {
        parent::__construct($codex, $view);
        $this->codex    = $codex;
        $this->addons   = $this->codex->addons;
        $this->projects = $this->codex->projects;
        $this->menus    = $this->codex->menus;
    }

    protected function resolveRef($projectSlug, $ref = null)
    {
        if ( !$this->projects->has($projectSlug) ) {
            return $this->error('Project does not exist', Response::HTTP_BAD_REQUEST);
        }
        $this->project = $this->projects->get($projectSlug);

        $this->ref = $this->project->refs->get($ref);

        return $this->ref;
    }

    protected function response($data = [ ])
    {
        if ( $data instanceof Arrayable && !$data instanceof JsonSerializable ) {
            $data = $data->toArray();
        }
        return response()->json([ 'success' => true, 'message' => '', 'data' => $data ]);
    }

    protected function error($message, $code = 500)
    {
        return response()->json([ 'success' => false, 'message' => $message, 'data' => [ ] ], $code);
    }

}
