<?php
/**
 * Part of the Docit PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Docit\Core;

use Docit\Support\Filesystem;
use Docit\Support\Path;
use Docit\Support\StubGenerator;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * This is the ProjectGenerator.
 *
 * @package        Docit\Core
 * @author         Docit Dev Team
 * @copyright      Copyright (c) 2015, Docit
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ProjectGenerator extends StubGenerator
{
    protected $stubPath;

    protected $destPath;

    /**
     * @inheritDoc
     */
    public function __construct(BladeCompiler $compiler, Filesystem $files)
    {
        parent::__construct($compiler, $files);
        $this->stubPath = Path::join(__DIR__, '..', 'resources', 'stubs');
    }


    public function generateProject($name, $displayName)
    {

        $this->generate($this->stubPath, $this->destPath, [
            'config.php.stub' => 'config.php',
            'index.md.stub'   => 'master/index.md',
            'menu.yml.stub'   => 'master/menu.yml'
        ], [
            'name'        => $name,
            'displayName' => $displayName,
            'config'      => array_dot(config('docit')),
            'open'        => '<?php',
            'stubPath'    => $this->stubPath,
            'destPath'    => $this->destPath,
        ]);
    }

    /**
     * get stubPath value
     *
     * @return string
     */
    public function getStubPath()
    {
        return $this->stubPath;
    }

    /**
     * Set the stubPath value
     *
     * @param string $stubPath
     * @return ProjectGenerator
     */
    public function setStubPath($stubPath)
    {
        $this->stubPath = $stubPath;

        return $this;
    }

    /**
     * get destPath value
     *
     * @return mixed
     */
    public function getDestPath()
    {
        return $this->destPath;
    }

    /**
     * Set the destPath value
     *
     * @param mixed $destPath
     * @return ProjectGenerator
     */
    public function setDestPath($destPath)
    {
        $this->destPath = $destPath;

        return $this;
    }
}
