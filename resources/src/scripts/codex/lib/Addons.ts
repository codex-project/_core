module codex {

    export var namespacePrefix:string = 'codex.';

    console.log('codex namespace ' + namespacePrefix);

    /**
     * The @extension decorator registers a extension
     * ```typescript
     * module codex.extensions {
     *      @extension('code-block', { })
     *      export class LayoutExtension extends Extension {
     *            init(){
     *                console.log('init layout extension');
     *            }
     *            boot(){
     *                console.log('booting layout extension');
     *            }
     *       }
     * }
     * ```
     * @param {String} name - The name of the extension
     * @param {Object} configToMergeIntoDefaults - The config object to merge into the default config
     * @returns {function(codex.extensions.Extension): void}
     */
    export function extension(name:string, configToMergeIntoDefaults:any = {}):(cls:typeof extensions.Extension)=>void {
        return (cls:typeof extensions.Extension):void => {
            extensions.Extensions.register(name, cls, configToMergeIntoDefaults);
        };
    }

    /**
     * The @widget decorator registers a widget
     * ```typescript
     * module codex.extensions {
     *      @extension('code-block', { })
     *      export class LayoutExtension extends Extension {
     *            init(){
     *                console.log('init layout extension');
     *            }
     *            boot(){
     *                console.log('booting layout extension');
     *            }
     *       }
     * }
     * ```
     * @param name
     * @param parent
     * @returns {function(codex.widgets.Widget): void}
     */
    export function widget(name:string, parent?:any):(cls:typeof widgets.Widget)=>void {
        return (cls:typeof widgets.Widget):void => {
            if(parent){
                $.widget(namespacePrefix + name, <any> new cls, parent);
            } else {
                $.widget(namespacePrefix + name, <any> new cls);
            }
            console.log('Widget', name, 'registered', cls);
        };

    }

    /**
     * The @plugin decorator registers a plugin
     * ```typescript
     * module codex.extensions {
     *      @extension('code-block', { })
     *      export class LayoutExtension extends Extension {
     *            init(){
     *                console.log('init layout extension');
     *            }
     *            boot(){
     *                console.log('booting layout extension');
     *            }
     *       }
     * }
     * ```
     * @param name
     * @param regOpts
     * @returns {function(codex.plugins.Plugin): void}
     */
    export function plugin(name:string, regOpts:any = {}):(cls:typeof plugins.Plugin)=>void {
        return (cls:typeof plugins.Plugin):void => {
            plugins.registerPlugin(name, cls, regOpts);
        };
    }

    /**
     * ### Extensions
     * Extensions are awesome
     */
    export module extensions {

        export interface IExtension {

            app:Application;
        }


        export interface IExtensionClass<T extends IExtension> {
            dependencies:string[];
            new(name:string, host:Extensions, app:Application):T;
        }

        /**
         * Components repository (singleton)
         */
        export class Extensions {
            protected app:Application;

            protected extensions:{[name:string]:Extension};

            protected static EXTENSIONS:{[name:string]:IExtensionClass<Extension>} = {};
            protected static EXTENSIONSDEPS:util.obj.DependencySorter;

            private static _instance:Extensions;

            /**
             * @private
             */
            constructor(app?:Application) {
                if (Extensions._instance) {
                    throw new Error("Error - use Singleton.getInstance()");
                }
                this.app = app || codex.app;
                if (!defined(this.app)) {
                    codex.ready(() => {
                        this.app = codex.Application.instance;
                    })
                }
                this.extensions = {};
            }

            /**
             * Get the Components instance
             * @returns {Extensions}
             */
            public static get instance():Extensions {
                Extensions._instance = Extensions._instance || new Extensions();
                return Extensions._instance
            }

            /**
             * Returns true if the component is loaded
             * @param name
             * @returns {boolean}
             */
            public has(name:string):boolean {
                return kindOf(name) === 'string' && Object.keys(this.extensions).indexOf(name) !== -1;
            }

            /**
             * Returns a loaded component
             * @param name
             * @returns {Extension}
             */
            public get(name?:string):Extension {
                if (this.has(name)) {
                    return this.extensions[name];
                }
                throw new Error('ExtensionHost: Could not find ' + name);
            }

            /**
             * Load a registered component
             * @param name
             * @param cb
             * @returns {Extension}
             */
            protected load(name:any, cb?:Function):Extension {

                if (this.has(name)) {
                    return this.get(name);
                }

                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new util.obj.DependencySorter();
                }
                this.extensions[name] = new Extensions.EXTENSIONS[name](name, this, this.app);
                this.app.emit('component:loaded', name, this.extensions[name]);
                debug.log('Components', ' loaded: ', name, this.extensions[name]);

                if (kindOf(cb) === 'function') {
                    cb.apply(this, arguments)
                }

                return this.extensions[name];
            }

            /**
             * Returns all loaded components
             * @returns {{}}
             */
            public all():{[name:string]:Extension} {
                return this.extensions;
            }


            public getRegisteredNames():string[] {
                return Object.keys(this.getRegistered());
            }

            public getRegistered():{[name:string]:IExtensionClass<Extension>} {
                return Extensions.EXTENSIONS;
            }

            /**
             * Load all registered components
             * @returns {codex.components.Components}
             */
            public loadAll():Extensions {
                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new util.obj.DependencySorter();
                }

                var names:string[] = Extensions.EXTENSIONSDEPS.sort();
                console.log('loadAll deps:', names);
                var missing:number = Object.keys(Extensions.EXTENSIONSDEPS.getMissing()).length;
                if (missing > 0) {
                    console.warn('Missing dependencies: ' + missing.toString());
                }
                names.forEach((name:string) => {
                    if (!this.has(name)) {
                        this.load(name);
                    }
                });
                return this;
            }

            /**
             * Iterate over all loaded components, executing the callback function each time
             * @param fn
             * @returns {codex.components.Components}
             */
            public each(fn:_.ObjectIterator<Extension, void>):Extensions {
                util.arr.each(this.all(), fn);
                return this;
            }

            /**
             * Register a Component with the Components class
             * @param name
             * @param componentClass
             * @param configToMergeIntoDefaults
             */
            public static register<T extends IExtension>(name:string, componentClass:IExtensionClass<Extension>, configToMergeIntoDefaults?:any) {
                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new util.obj.DependencySorter();
                }
                if (typeof Extensions.EXTENSIONS[name] !== 'undefined') {
                    throw new Error('Cannot add ' + name + '. Already exists');
                }

                Extensions.EXTENSIONS[name] = componentClass;
                Extensions.EXTENSIONSDEPS.addItem(name, componentClass.dependencies);

                console.log('register deps:', componentClass);

                // merge config if needed
                if (typeof configToMergeIntoDefaults !== "undefined") {
                    var configMerger:any = {};
                    configMerger[name] = configToMergeIntoDefaults;
                    mergeIntoDefaultConfig(configMerger);
                }
                console.log('Components', ' registered: ', name, componentClass);
            }
        }

        /**
         * Components are used to seperate application logic.
         *
         * @class Extension
         */
        export class Extension implements IExtension {
            public static dependencies:string[] = [];

            public app:Application;
            public extensions:Extensions;
            public name:string;

            constructor(name:string, extensions:Extensions, app:Application) {
                this.name = name;
                this.extensions = extensions;
                this.app = app;

                this._make.call(this);
                if (app.isInitialised) {
                    this.init.call(this);
                } else {
                    app.on('init', this.init.bind(this));
                }
                if (app.isBooted) {
                    this._boot.call(this);
                    this._booted.call(this);
                } else {
                    app.on('boot', this._boot.bind(this));
                    app.on('booted', this._booted.bind(this));
                }
            }

            public get config():IConfigProperty {
                return this.app.config;
            }

            private _make() {
                this.make();
            }

            private _boot() {
                this.boot();
            }

            private _booted() {
                this.booted();

            }

            protected make() {

            }

            protected init() {

            }

            protected boot() {

            }

            protected booted() {

            }
        }
    }

    export module widgets {

        export class Widget {
            _create():any {
                return undefined;
            }

            _destroy() {
            }

            _init():any {
                return undefined;
            }

            public _delay(fn:any, delay:number):number {
                return undefined;
            }


            public _focusable(element:JQuery):any {
                return undefined;
            }

            public _getCreateEventData():Object {
                return undefined;
            }

            public _getCreateOptions():Object {
                return undefined;
            }

            public _hide(element:JQuery, option:Object, callback:Function):any {
                return undefined;
            }

            public _hoverable(element:JQuery):any {
                return undefined;
            }


            public _off(element:JQuery, eventName:string):any {
                return undefined;
            }

            public _on(element:JQuery|string, handlers:Object):any {
                return undefined;
            }


            public _setOption(key:string, value:Object):any {
                return undefined;
            }

            public _setOptions(options:Object):any {
                return undefined;
            }

            public _show(element:JQuery, option:Object, callback:Function):any {
                return undefined;
            }

            public _super(...arg:any[]) {
            }

            public _superApply(args:any) {
            }

            public _trigger(type:String, args?:any[], data?:Object):any {
                return undefined;
            }

            public destroy() {
            }

            public disable() {
            }

            public enable() {
            }

            public instance():Object {
                return undefined;
            }

            public option(arg:any):any {
                return undefined;
            }


            public element:JQuery;
            public document:JQuery;
            public namespace:string;
            public options:any;
            public uuid:number;
            public version:string;
            public widgetEventPrefix:string;
            public widgetFullName:string;
            public widgetName:string;
            public window:JQuery;

            protected bindings:JQuery;
            protected eventNamespace:string;

            constructor() {
                // remove all members, they are only needed at compile time.
                var myPrototype = (<Function>Widget).prototype;
                $.each(myPrototype, (propertyName, value)=> {
                    delete myPrototype[propertyName];
                });
            }

            public get app():Application {
                return codex.Application.instance;
            }
        }
    }

    export module plugins {

        export interface IPluginRegisterOptions {
            'namespace'?:string;
            'class'?:any;
            'name'?:string;
            'callback'?:Function,
            'loadPath'?:string;
        }

        /**
         * The Plugin class is a base class for jQuery plugins.
         *
         * @class Plugin
         */
        export class Plugin {
            public get options():any {
                return this._options;
            }

            public get app():Application {
                return codex.Application.instance;
            }

            public static defaults:any = {};

            public VERSION:string = '0.0.0';
            public NAMESPACE:string = 'codex.';

            public enabled:boolean = true;
            protected _options:any;
            protected $window:JQuery;
            protected $document:JQuery;
            protected $body:JQuery;
            protected $element:JQuery;

            constructor(element:any, options:any, ns:string) {

                this._options = options;
                this.$window = $(window);
                this.$document = $(document);
                this.$body = $(document.body);
                this.$element = $(element);
                this.NAMESPACE = ns;
                this._trigger('create');
                this._create();
                this._trigger('created');
            }

            public instance():Plugin {
                return this;
            }


            protected _create() {
            }

            protected _destroy() {
            }

            public destroy() {
                this._trigger('destroy');
                this._destroy();
                this._trigger('destroyed');
            }


            public _trigger(name:string, extraParameters?:any[]|Object):Plugin {
                var e:JQueryEventObject = $.Event(name + '.' + this.NAMESPACE);
                this.$element.trigger(e, extraParameters);
                return this;
            }


            public _on(name:string, cb:any):Plugin;
            public _on(name:string, sel?:string, cb?:any):Plugin;
            public _on(...args:any[]):any {
                args[0] = args[0] + '.' + this.NAMESPACE;
                debug.log('plugin _on ', this, args);
                this.$element.on.apply(this.$element, args);
                return this;
            }

            public static register(name:string, pluginClass:any) {
                registerPlugin(name, pluginClass);
                console.log('Plugin', name, 'registered', pluginClass);
            }
        }

        var defaultRegOpts:IPluginRegisterOptions = {
            loadPath: 'app/plugins/',
            callback: $.noop()
        };

        function makeRegOptions(name:string, pluginClass:any, regOpts?:IPluginRegisterOptions):IPluginRegisterOptions {
            regOpts = <IPluginRegisterOptions> $.extend(true, this.defaultRegOpts, {'class': pluginClass}, regOpts);
            if (typeof regOpts.namespace !== 'string') {
                regOpts.namespace = name;
            }
            regOpts.namespace = namespacePrefix + regOpts.namespace;
            return regOpts;
        }

        export function registerPlugin(name:string, pluginClass:typeof Plugin, opts:IPluginRegisterOptions={}) {
            var regOpts:IPluginRegisterOptions = <IPluginRegisterOptions> $.extend(true, {}, makeRegOptions(name, pluginClass), opts);

            function jQueryPlugin(options?:any, ...args:any[]) {
                var all:JQuery = this.each(function () {
                    var $this:JQuery = $(this);
                    var data:any = $this.data(regOpts.namespace);
                    var opts:any = $.extend({}, pluginClass.defaults, $this.data(), typeof options == 'object' && options);

                    if (!data) {
                        $this.data(regOpts.namespace, (data = new pluginClass(this, opts, regOpts.namespace)));
                    }

                    if (kindOf(options) === 'string') {
                        data[options].call(data, args);
                    }

                    if (kindOf(regOpts.callback) === 'function') {
                        regOpts.callback.apply(this, [data, opts]);
                    }
                });


                if (kindOf(options) === 'string' && options === 'instance' && all.length > 0) {
                    if (all.length === 1) {
                        return $(all[0]).data(regOpts.namespace);
                    } else {
                        var instances:Plugin[] = [];
                        all.each(function () {
                            instances.push($(this).data(regOpts.namespace));
                        });
                        return instances;
                    }
                }

                return all;
            }

            var old:any = $.fn[name];
            $.fn[name] = jQueryPlugin;
            $.fn[name].Constructor = pluginClass;
        }

    }
}
