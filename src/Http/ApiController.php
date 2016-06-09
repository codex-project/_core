<?php
namespace Codex\Http;

use Codex\Contracts\Codex;
use Codex\Projects\Project;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ApiController extends Controller
{
    /** @var \Codex\Codex */
    protected $codex;

    /** @var \Codex\Addons\Addons */
    protected $addons;

    /** @var \Codex\Projects\Projects */
    protected $projects;

    /** @var \Codex\Menus\Menus */
    protected $menus;

    /** @var Project */
    protected $project;

    /**
     * ApiController constructor.
     *
     * @param \Codex\Codex                       $codex
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(Codex $codex, ViewFactory $view)
    {
        parent::__construct($codex, $view);
        $this->codex = codex();
        $this->addons = $this->codex->addons;
        $this->projects = $this->codex->projects;
        $this->menus = $this->codex->menus;
    }

    protected function resolveProject($projectSlug, $ref = null)
    {

        if ( !$this->projects->has($projectSlug) )
        {
            return response()->json('Project does not exist', 404);
        }
        $project = $this->projects->get($projectSlug);

        if ( is_null($ref) )
        {
            $ref = $project->getDefaultRef();
        }
        $project->setRef($ref);

        return $this->project = $project;
    }

    protected function response(array $data = [ ])
    {
        return response()->json([ 'success' => true, 'message' => '', 'data' => $data ]);
    }

    protected function error($message)
    {
        return response()->json([ 'success' => false, 'message' => $message, 'data' => [ ] ]);
    }

}