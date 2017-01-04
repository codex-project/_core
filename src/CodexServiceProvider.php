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


namespace Codex;

use Codex\Dev\Dev;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexDocumentController;
use Codex\Log\Writer;
use Codex\Menus\ProjectsMenuResolver;
use Codex\Menus\RefsMenuResolver;
use Codex\Menus\SidebarMenuResolver;
use Codex\Support\Traits\CodexProviderTrait;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Filesystem\FilesystemAdapter;
use Laradic\ServiceProvider\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;
use Monolog\Logger as Monolog;

/**
 * This is the class CodexServiceProvider.
 *
 * @package        Codex\Core
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 */
class CodexServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $configFiles = [ 'codex' ];

    protected $viewDirs = [
        'views' => 'codex',
        'stubs' => 'codex-stubs',
    ];

    protected $assetDirs = [
        'assets'     => 'codex',
        'dev/assets' => 'codex-dev',
    ];

    protected $providers = [
        \Radic\BladeExtensions\BladeExtensionsServiceProvider::class,
    ];

    protected $findCommands = [ 'Console' ];

    protected $bindings = [
        'fs'                      => \Laradic\Filesystem\Filesystem::class,
        'codex.menus'             => Menus\Menus::class,
        'codex.menu'              => Menus\Menu::class,
        'codex.projects'          => Projects\Projects::class,
        'codex.project'           => Projects\Project::class,
        'codex.refs'              => Projects\Refs::class,
        'codex.ref'               => Projects\Ref::class,
        'codex.documents'         => Documents\Documents::class,
        'codex.document'          => Documents\Document::class,
        'codex.project.generator' => Projects\ProjectGenerator::class,
        'codex.theme'             => Theme::class,
    ];

    protected $singletons = [
        'codex.addons' => Addons\Addons::class,
    ];

    protected $shared = [
        'codex' => Codex::class,
    ];

    protected $aliases = [
        'codex.log' => Contracts\Log\Log::class,
    ];

    /** @var Addons\Addons */
    protected $addons;

    public function boot()
    {
        $app = parent::boot();

        $this->bootBladeDirectives();

        return $app;
    }

    public function booting()
    {
        Dev::getInstance()->startMeasure('boot');
        $this->bootMenus();
        $this->bootTheme();
        Dev::getInstance()->stopMeasure('boot');
    }

    public function register()
    {
        $app = parent::register();

        $app->register(\Codex\Dev\DevServiceProvider::class);

        $this->registerLogger();

        $this->registerDefaultFilesystem();

        $this->registerCodex();

        $this->registerAddons();

        $this->registerJavascriptData();

        if ($this->config->get('codex.http.enabled', false)) {
            $this->registerHttp();
        }

        return $app;
    }

    public function bootTheme()
    {

        $theme = $this->codex()->theme;

        $assetPath = asset('vendor/codex');
        $theme
            ->reset()
//            ->addStylesheet('fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400|Raleway:300,400,600|Source+Code+Pro')
//            ->addStylesheet('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')//" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            ->addStylesheet('codex', $assetPath . '/styles/codex.css')
            ->addStylesheet('codex.theme', $assetPath . '/styles/themes/codex-default.css', [ 'codex' ]);

        $ext = config('app.debug') ? '.js' : '.min.js';
        $theme
            ->addJavascript('jquery', $assetPath . '/vendor/jquery/jquery' . $ext)
            ->addJavascript('lodash', $assetPath . '/vendor/lodash/lodash' . $ext)
            ->addJavascript('radic.util', $assetPath . '/vendor/radic.util/radic.util' . $ext)
            ->addJavascript('vue', $assetPath . '/vendor/vue/vue' . $ext)
            ->addJavascript('vuex', $assetPath . '/vendor/vuex/vuex' . $ext, [ 'vue' ])
            ->addJavascript('wowjs', $assetPath . '/vendor/wowjs/wow' . $ext)
            ->addJavascript('manifest', $assetPath . '/js/manifest.js')
            ->addJavascript('prismjs', $assetPath . '/vendor/prismjs/prism.js')
            ->addJavascript('prismjs.autoloader', $assetPath . '/vendor/prismjs/plugins/autoloader/prism-autoloader', [ 'prismjs' ])
            ->addJavascript('prismjs.autolinker', $assetPath . '/vendor/prismjs/plugins/autolinker/prism-autolinker', [ 'prismjs' ])
            ->addJavascript('prismjs.linenumbers', $assetPath . '/vendor/prismjs/plugins/line-numbers/prism-line-numbers', [ 'prismjs' ])
            ->addJavascript('prismjs.removeinitfeed', $assetPath . '/vendor/prismjs/plugins/remove-initial-line-feed/prism-remove-initial-line-feed', [ 'prismjs' ])
            ->addJavascript('prismjs.showlanguage', $assetPath . '/vendor/prismjs/plugins/show-language/prism-show-language', [ 'prismjs' ])
            ->addJavascript('vendor', $assetPath . '/js/vendor.js', [ 'vue', 'vuex', 'jquery', 'prismjs', 'radic.util' ])
            ->addJavascript('codex', $assetPath . '/js/codex.js', [ 'vendor' ]);

        $this->codexHook('controller:welcome', function ($controller) use ($assetPath) {
            $this->codex()->theme->addJavascript('codex.page.welcome', $assetPath . '/js/codex.page.welcome.js', [ 'codex' ])
                ->addScript('init', <<<EOT
var app = new codex.App({
    el: '#app'
})
EOT
                );
        });
        $this->codexHook('controller:document', function ($controller) use ($assetPath) {
            $this->codex()->theme->addJavascript('codex.page.document', $assetPath . '/js/codex.page.document.js', [ 'codex' ])
                ->addScript('init', <<<EOT
var app = new codex.App({
    el: '#app'
})
EOT
                );
        });

        $this->codexHook('controller:error', function ($controller, $what, \Exception $e) use ($assetPath) {
            $this->codex()->theme->addJavascript('codex.page.document', $assetPath . '/js/codex.page.document.js', [ 'codex' ])
                ->addScript('init', <<<EOT
var app = new codex.App({
    el: '#app'
})
EOT
                );
        });
    }


    public function bootMenus()
    {
        $codex = $this->codex();

        # Menus

        # Plugins
        $this->addons->plugins->run();

        $codex->menus->add('sidebar')
            ->setResolver(SidebarMenuResolver::class)
            ->setView($codex->view('menus.sidebar'));

        $codex->menus->add('projects')
            ->setResolver(ProjectsMenuResolver::class)
            ->setView($codex->view('menus.header'));

        $codex->menus->add('refs')
            ->setResolver(RefsMenuResolver::class)
            ->setView($codex->view('menus.header'));

        $this->codexHook('controller:document', function ($controller, Document $document, Codex $codex, $project, $ref) {
            $codex->theme->pushContentToStack('nav', $codex->view('document'), function ($view) use ($codex, $document) {
                return $codex->menus->get('refs')->render($document->getRef());
            });
            $codex->theme->pushContentToStack('nav', [ $codex->view('document'), $codex->view('error') ], function ($view) use ($codex, $document) {
                return $codex->menus->get('projects')->render($document->getProject());
            });
        });
    }

    /**
     * registerLogger method
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return \Codex\Log\Writer
     */
    protected function registerLogger()
    {
        $this->app->instance('codex.log', $log = new Writer(
            new Monolog($this->app->environment()),
            $this->app[ 'events' ]
        ));
        $log->setEnabled($this->config[ 'codex.log' ]);
        $log->useFiles($this->config[ 'codex.paths.log' ]);
        $log->useChromePHP();
        $log->useFirePHP();
        return $log;
    }

    protected function registerCodex()
    {
        Codex::registerExtension('codex', 'menus', 'codex.menus');
        Codex::registerExtension('codex', 'theme', 'codex.theme');
        Codex::registerExtension('codex', 'projects', 'codex.projects');
        Codex::registerExtension('codex.project', 'refs', 'codex.refs');
        Codex::registerExtension('codex.ref', 'documents', 'codex.documents');
    }

    protected function registerDefaultFilesystem()
    {
        $this->app->make('filesystem')->extend('codex-local', function (LaravelApplication $app, array $config = []) {
            $flysystemAdapter    = new Filesystem\Local($config[ 'root' ]);
            $flysystemFilesystem = new Flysystem($flysystemAdapter);
            return new FilesystemAdapter($flysystemFilesystem);
        });
    }

    protected function registerHttp()
    {
        $this->app->register(Http\HttpServiceProvider::class);
    }

    protected function bootBladeDirectives()
    {
        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade = $this->app[ 'view' ]->getEngineResolver()->resolve('blade')->getCompiler();
        //Register the Starting Tag
        $blade->directive('spaceless', function () {
            return '<?php ob_start() ?>';
        });
        //Register the Ending Tag
        $blade->directive('endspaceless', function () {
            return "<?php echo preg_replace('/>\\s+</', '><', ob_get_clean()); ?>";
        });
    }

    protected function registerJavascriptData()
    {
        $this->codexHook('controller:view', function (CodexDocumentController $controller, $view, Codex $codex, Projects\Project $project, Documents\Document $document) {
            /** @var Codex $codex */
            $theme = $codex->theme;
            $theme->set('codex', $c = $codex->config()->only('display_name', 'macros', 'links', 'document', 'default_project')->toArray());
            $theme->set('project', [
                'name'         => $project->getName(),
                'display_name' => $project->getDisplayName(),
            ]);
//            $theme->set('document', collect($document->toArray())->forget('content'));
//            $theme->set('theme', $theme->toArray());
            $theme->set('apiUrl', url('api'));
            $theme->set('debug', config('app.debug', false));
        });
    }

    protected function registerAddons()
    {
        $this->app->instance('codex.addons', $this->addons = Addons\Addons::getInstance());
        $this->addons->setManifestPath($this->app[ 'config' ][ 'codex.paths.manifest' ]);
        $this->addons->resolveAndRegisterDirectory(__DIR__ . '/Processors');
        $this->addons->resolveAndRegisterAddons();
    }
}
