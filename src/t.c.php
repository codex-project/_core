<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */

/**
 *
 */
namespace {

    global $loop;
    $loop = new \Radic\BladeExtensions\Helpers\Loop\Loop(null,[]);
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

//        /** @return string[] */
//        public function getEnabledProcessors();
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
        public function getApiData();
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
