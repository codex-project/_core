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
namespace {

    require_once __DIR__ . '/../../../../bootstrap/autoload.php';
    require_once __DIR__ . '/../../../../bootstrap/app.php';
}

namespace C {

    class Codex
    {
        /**
         * get method
         *
         * @param $query
         *
         * @return string[]|\C\Contracts\Project|\C\Contracts\Ref|\C\Contracts\Document|mixed
         */
        public function get($query)
        {
        }

        /** @return string[] */
        public function getProjects()
        {
            return [new Project, new Project];
        }

        /** @return \C\Contracts\Project */
        public function getProject($name)
        {
            return new Project;
        }

        /** @return \C\Contracts\Menus\MenuFactory */
        public function getMenus()
        {
            return new Menus\MenuFactory();
        }

        /** @return \C\Addons\AddonManager */
        public function getAddonManager()
        {
            return Addons\AddonManager::getInstance();
        }

        /** @return \C\Theme */
        public function getTheme()
        {
            return new Theme;
        }
    }

    class Project implements Contracts\Project
    {
        /**
         * public function getVersions();
         *
         * public function getBranches();
         *
         * /** @return string[]
         */
        public function getRefs()
        {
            return [ new Ref($this), new Ref($this) ];
        }

        /** @return \C\Contracts\Ref */
        public function getRef($name)
        {
            return new Ref($this);
        }

        /** @return string */
        public function getName()
        {
            // TODO: Implement getName() method.
        }

        /** @return string */
        public function getDisplayName()
        {
            // TODO: Implement getDisplayName() method.
        }

        /** @return string */
        public function getDescription()
        {
            // TODO: Implement getDescription() method.
        }

        /** @return string[] */
        public function getEnabledProcessors()
        {
            // TODO: Implement getEnabledProcessors() method.
        }
    }

    class Ref implements Contracts\Ref
    {
        /** @type Project */
        protected $project;

        /**
         * Ref constructor.
         *
         * @param $project
         */
        public function __construct($project)
        {
            $this->project = $project;
        }


        /** @return string[] */
        public function getDocuments()
        {
            return [ new Document($this), new Document($this) ];
        }

        /** @return \C\Contracts\Document */
        public function getDocument($name)
        {
            return new Document($this);
        }

        /** @return \C\Contracts\Project */
        public function getProject()
        {
            return $this->project;
        }
    }

    class Document implements Contracts\Document
    {
        /** @type \C\Contracts\Ref */
        protected $ref;

        /**
         * Document constructor.
         *
         * @param \C\Contracts\Ref $ref
         */
        public function __construct(\C\Contracts\Ref $ref)
        {
            $this->ref = $ref;
        }


        /** @return \C\Contracts\Project */
        public function getProject()
        {
            return $this->ref->getProject();
        }

        /** @return \C\Contracts\Ref */
        public function getRef()
        {
            return $this->ref;
        }

        /** @return string */
        public function render()
        {
            // TODO: Implement render() method.
        }
    }

    class Theme extends \Codex\Theme
    {

    }
}
namespace C\Contracts {

    interface Project
    {
        /**
         * public function getVersions();
         *
         * public function getBranches();
         *
         * /** @return string[]
         */
        public function getRefs();

        /** @return \C\Contracts\Ref */
        public function getRef($name);

        /** @return string */
        public function getName();

        /** @return string */
        public function getDisplayName();

        /** @return string */
        public function getDescription();

        /** @return string[] */
        public function getEnabledProcessors();
    }

    interface Ref
    {
        /** @return string[] */
        public function getDocuments();

        /** @return \C\Contracts\Document */
        public function getDocument($name);

        /** @return \C\Contracts\Project */
        public function getProject();
    }

    interface Document
    {
        /** @return \C\Contracts\Project */
        public function getProject();

        /** @return \C\Contracts\Ref */
        public function getRef();

        /** @return string */
        public function render();
    }

    interface Bootable
    {
    }

    interface Extendable
    {
    }

    interface Hookable
    {
    }

    interface Observable
    {
    }

    interface Sortable
    {
    }

    interface Dependable
    {
    }

    interface ExposesApiData
    {
    }
}
namespace C\Contracts\Addons {

    use Codex\Addons\Annotations\AbstractAnnotation;
    use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

    interface AddonManager
    {
        /** @return static */
        public static function getInstance();

        /** @return PluginRepository */
        public function getPluginRepository();

        /** @return ProcessorRepository */
        public function getProcessorRepository();

        /** @return HookRepository */
        public function getHookRepository();

        /** @return \C\Addons\Addon */
        public function get($name);

        public function add($name, $item = null);
    }

    interface Repository
    {
        public function get($name);

        public function add(ClassFileInfo $file, AbstractAnnotation $annotation);
    }

    /**
     * @method \C\Addons\Plugin get($name)
     */
    interface PluginRepository extends Repository
    {
    }

    /**
     * @method \C\Addons\Processor get($name)
     */
    interface ProcessorRepository extends Repository
    {
    }

    /**
     * @method \C\Addons\Hook get($name)
     */
    interface HookRepository extends Repository
    {
        public function create($hookPoint, \Closure $handler);
    }
}
namespace C\Contracts\Menus {

    interface Node
    {

    }

    class Menu extends \Codex\Menus\Node
    {
    }

    interface MenuFactory
    {
        /** @return Menu */
        public function get($id);
    }
}
namespace C\Contracts\Support {

    interface Sortable
    {
    }

    interface Dependable
    {
    }
}
namespace C\Support {

    trait HydrateClassPropertiesTrait
    {
        public function hydrate(array $vars = [])
        {
            foreach ( get_class_vars(get_class($this)) as $var => $val ) {
                if ( array_key_exists($var, $vars) ) {
                    $this->{$var} = $vars[ $var ];
                }
            }
        }
    }

    /** Nested array collection helper for multi-dimensional arrays. Supports dot notation */
    class MultiDimensionalCollection extends \Codex\Support\Collection
    {
    }

    class Sorter implements \C\Contracts\Support\Sortable
    {

    }

//    class Version extends Version


    interface Extendable
    {

    }
}

namespace C\Addons {

    use C\Support\HydrateClassPropertiesTrait;
    use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

    interface AddonManager
    {
        /** @return static */
        public static function getInstance();

        /** @return \C\Addons\Repositories\PluginRepository */
        public function getPluginRepository();

        /** @return \C\Addons\Repositories\ProcessorRepository */
        public function getProcessorRepository();

        /** @return \C\Addons\Repositories\HookRepository */
        public function getHookRepository();

        /** @return Addon */
        public function get($name);

        public function add($name, $item = null);
    }

    interface AddonResolver
    {

        /**
         * Search file for matching addon annotations and automaticly resolve and add them into their collections
         *
         * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo $classFileInfo
         *
         * @return ResolvedAddon[]
         */
        public function resolveAnnotations(ClassFileInfo $classFileInfo);

        /**
         * Scan a file and resolve annotations
         *
         * @param $filePath
         *
         * @return ResolvedAddon[]
         */
        public function scanAndResolveFile($filePath);

        /**
         * scanAndResolveDirectory method
         *
         * @param $path
         *
         * @return ResolvedAddon[]
         */
        public function scanAndResolveDirectory($path);

        /**
         * @return \Doctrine\Common\Annotations\AnnotationReader
         */
        public function getReader();

        /**
         * @return \Laradic\AnnotationScanner\Factory
         */
        public function getScanner();
    }

    interface ResolvedAddon
    {

        /**
         * Check if the resolved is $type
         *
         * @param $type
         *
         * @return bool
         */
        public function is($type);

        /**
         * hasMethod method
         * @return bool
         */
        public function hasMethod();

        /**
         * hasProperty method
         * @return bool
         */
        public function hasProperty();

        /**
         * @return mixed
         */
        public function getMethod();

        /**
         * Set the method value
         *
         * @param mixed $method
         *
         * @return static
         */
        public function setMethod($method);

        /**
         * @return mixed
         */
        public function getProperty();

        /**
         * Set the property value
         *
         * @param mixed $property
         *
         * @return static
         */
        public function setProperty($property);

        /**
         * @return \Laradic\AnnotationScanner\Scanner\ClassFileInfo
         */
        public function getClassFileInfo();

        /**
         * @return string
         */
        public function getType();

        /**
         * getAnnotation method
         * @return \Codex\Addons\Annotations\AbstractAnnotation|mixed
         */
        public function getAnnotation();

    }

    class Manifest extends \C\Support\MultiDimensionalCollection
    {
        protected $manifestPath;

        /** @return static */
        public function load()
        {
            $manifest    = file_get_contents($this->manifestPath);
            $this->items = json_decode($manifest, true);
            return $this;
        }

        /**
         * @param int $options
         *
         * @return static
         */
        public function save($options = JSON_UNESCAPED_SLASHES)
        {
            $manifest = json_encode($this->items, $options);
            file_put_contents($this->manifestPath, $manifest);
            return $this;
        }

        /**
         * @return mixed
         */
        public function getManifestPath()
        {
            return $this->manifestPath;
        }

        /**
         * Set the manifestPath value
         *
         * @param mixed $manifestPath
         *
         * @return Manifest
         */
        public function setManifestPath($manifestPath)
        {
            $this->manifestPath = $manifestPath;
            return $this;
        }


    }

    /**
     * @method string getName()
     * @method string isReplace()
     * @method string getDescription()
     */
    abstract class Addon
    {
        public $name;

        public $replace = false;

        public $description = '';

        public function __call($name, $params = [])
        {
            if ( starts_with($name, 'get') ) {
                $property = strtolower(str_remove_left('get', $name));
                if ( property_exists($this, $property) ) {
                    return $this->{$property};
                }
            }
            throw new \BadMethodCallException("Method [{$name}] does not exist");
        }

    }

    /**
     * @method string[] getRequires()
     */
    class Plugin extends Addon
    {
        use HydrateClassPropertiesTrait;

        public $requires = [];
    }

    /**
     * @method int getPriority()
     * @method string|null getConfig()
     * @method string getMethod()
     * @method string[] getAfter()
     * @method string[] getBefore()
     * @method string[] getDepends()
     * @method boolean getPlugin()
     */
    class Processor extends Addon
    {
        use HydrateClassPropertiesTrait;

        public $priority = 10;

        public $config;

        public $method = 'handle';

        public $after = [];

        public $before = [];

        public $depends = [];

        public $plugin = false;
    }

    /**
     * @method boolean getPlugin()
     */
    class Hook extends Addon
    {
        use HydrateClassPropertiesTrait;

        public $plugin = false;
    }
}
namespace C\Addons\Annotations {

    use Doctrine\Common\Annotations\Annotation\Required;

    class AbstractAnnotation
    {

        /**
         * @Required()
         * @var string
         */
        public $name;

        /**
         * @var string|bool
         */
        public $replace = false;

        /**
         * @var string
         */
        public $description;
    }
}
namespace C\Addons\Repositories {

    use C\Support\HydrateClassPropertiesTrait;
    use Codex\Addons\Annotations\AbstractAnnotation;
    use Laradic\AnnotationScanner\Scanner\ClassFileInfo;

    interface AbstractRepository
    {
        public function get($name);

        public function add(ClassFileInfo $file, AbstractAnnotation $annotation);
    }

    /**
     * @method \C\Addons\Plugin get($name)
     */
    interface PluginRepository extends AbstractRepository
    {
        /**
         * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo                              $file
         * @param \Codex\Addons\Annotations\AbstractAnnotation|\Codex\Addons\Annotations\Plugin $annotation
         */
        public function add(ClassFileInfo $file, AbstractAnnotation $annotation);
    }

    /**
     * @method \C\Addons\Processor get($name)
     */
    interface ProcessorRepository extends AbstractRepository
    {
        /**
         * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo                                 $file
         * @param \Codex\Addons\Annotations\AbstractAnnotation|\Codex\Addons\Annotations\Processor $annotation
         */
        public function add(ClassFileInfo $file, AbstractAnnotation $annotation);
    }

    /**
     * @method \C\Addons\Hook get($name)
     */
    interface HookRepository extends AbstractRepository
    {
        public function create($hookPoint, \Closure $handler);

        /**
         * @param \Laradic\AnnotationScanner\Scanner\ClassFileInfo                            $file
         * @param \Codex\Addons\Annotations\AbstractAnnotation|\Codex\Addons\Annotations\Hook $annotation
         */
        public function add(ClassFileInfo $file, AbstractAnnotation $annotation);
    }
}

namespace C\Menus {

    class MenuFactory implements \C\Contracts\Menus\MenuFactory
    {
        /** @return \C\Contracts\Menus\Menu */
        public function get($id)
        {
            return new Menu();
        }
    }

    class Menu extends Node implements \Codex\Contracts\Menus\Menu
    {
        public function getId()
        {
            return 'id';
        }
    }

    class Node
    {
    }
}
namespace C\Exception {

    abstract class Exception extends \Exception
    {
    }

    class CodexException extends Exception
    {
    }

    class ProjectNotFoundException extends Exception
    {
    }
}
namespace {

    use C\Codex;

    /** @var \C\Codex $c */
    $c = new Codex();

# Getting projects, refs, documents and document
    $ps = $c->getProjects();
    $p  = $c->getProject($ps[ 0 ]);

    $refs = $p->getRefs();
    $ref  = $p->getRef($refs[ 0 ]);

    $docs = $ref->getDocuments();
    $doc  = $ref->getDocument($docs[ 0 ]);

    $doc->render();

    $c->get('codex/master::getting-started/installation');

# Menus
    $versions = $c->getMenus()->get('versions')->getId();


# Addons
    $addons   = \C\Addons\AddonManager::getInstance();
    $addons   = $c->getAddonManager();

    $addons->get('phpdoc');
    $processor = $addons->getProcessorRepository()->get('phpdoc');
    $processor->getMethod();

    $addons->getHookRepository()->create('project.constructed', function (\C\Project $project) {
        echo $project->getEnabledProcessors()[ 0 ];
    });
}
