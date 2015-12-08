<?php
namespace Docit\Core\Http\ViewComposers;

use Docit\Core\Factory;
use Docit\Core\Project;
use Illuminate\Contracts\View\View;

/**
 * This is the ProjectsMenus.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ProjectMenusComposer
{
    protected $factory;

    /** Instantiates the class
     *
     * @param \Docit\Core\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * compose
     *
     * @param \Illuminate\Contracts\View\View|\Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $data = $view->getData();
        $view->with([
            'projectRefList' => $this->getRefList($data[ 'project' ]),
            'projectsList'   => $this->getProjectList(),
            'projectName'    => $data[ 'project' ]->getName(),
            'projectRef'            => $data[ 'project' ]->getRef()
        ]);
    }

    protected function getRefList(Project $project)
    {
        $list = [ ];
        foreach ($project->getSortedRefs() as $ref) {
            $list[ $ref ] = $project->url(null, $ref);
        }

        return $list;
    }

    protected function getProjectList()
    {
        $list = [ ];
        foreach ($this->factory->getProjects() as $project) {
            $list[ (string)$project->config('display_name') ] = $project->url();
        }

        return $list;
    }
}
