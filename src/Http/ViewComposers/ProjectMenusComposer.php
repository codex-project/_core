<?php
namespace Codex\Core\Http\ViewComposers;

use Codex\Core\Factory;
use Codex\Core\Project;
use Illuminate\Contracts\View\View;

/**
 * This is the ProjectsMenus.
 *
 * @package        Codex\Core
 * @author         Codex Dev Team
 * @copyright      Copyright (c) 2015, Codex
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ProjectMenusComposer
{
    protected $factory;

    /** Instantiates the class
     *
     * @param \Codex\Core\Factory $factory
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
            $name = (string)$project->config('display_name');
            if(strpos($name, ' :: ') !== false){
                $names = explode(' :: ', $name);
                $name = array_shift($names);
                array_set($list, "{$name}.". implode('.', $names), $project->url());
            }
            else
            {
                $list[$name] = $project->url();
            }

        }

        return $list;
    }
}
