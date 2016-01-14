

/**
 * The application class
 */

module codex {

    import DeferredInterface = codex.util.promise.DeferredInterface;
    import PromiseInterface = codex.util.promise.PromiseInterface;

    var $body:JQuery = $('body');


    export interface IApplication {

    }

    export function EventHook(hook:string) {
        return (cls:any, name:string, desc:PropertyDescriptor):PropertyDescriptor => {
            console.log('EventHook(' + hook + ')', cls, name, desc);
            desc.value = void 0;
            return desc;
        }
    }

    /**
     * The Application class is the main class initialising and booting all other components, plugins, etc
     *
     * ```typescript
     * var app:codex.Application = codex.Application.instance
     * app.DEBUG = true;
     * app.init({
     *      customConfigVariable: 'asdf'
     * });
     * app.boot().then(function(app:codex.Application){
     *     // Application booted
     *     $('someElement').superDuperPlugin({
     *
     *     });
     * });
     * ```
     */
    export class Application  implements IApplication  {


        /**
         * Default configuration values, these will be set after initial construction using getConfigDefaults()
         */
        public static defaults:any;

        protected static _instance:Application;


        /**
         * If true, the debug log will be enabled, with some other additions as well
         */
        public DEBUG:boolean;

        /**
         * @private
         */
        protected _events:EventEmitter2;

        /**
         * The configuration repository
         */
        public config:IConfigProperty;

        /**
         * @private
         */
        protected _config:IConfig;

        public isInitialised:boolean;
        public isBooted:boolean;

        public timers:any = {construct: null, init: null, boot: null};

        public get extensions():extensions.Extensions {
            return extensions.Extensions.instance;
        }

        constructor(options?: {}) {

            this._events = new EventEmitter2({
                wildcard: true,
                delimiter: ':',
                maxListeners: 1000,
                newListener: true
            });
            $body.data('codex', this);
            var self:Application = this;
            codex.app = this;



            Application.defaults = getConfigDefaults();

            this.timers.construct = new Date;
            this.isInitialised = false;
            this.isBooted = false;

        }

        /**
         * @returns {Application}
         */
        public static get instance() {
            if (typeof Application._instance === "undefined") {
                Application._instance = new Application();
                codex.app = Application._instance;
            }
            return Application._instance;
        }

        public init(opts:any = {}):Application {
            if (this.isInitialised) {
                return;
            } else {
                this.isInitialised = true;
            }
            this.emit('pre-init');
            console.groupEnd();

            this.timers.init = new Date;
            //Vue.config.debug = this.DEBUG;
            if (this.DEBUG) {
                this.debug.enable();
                this.debug.setStartDate(this.timers.construct);
                console.groupCollapsed('DEBUG: init');
            }

            this._config = new ConfigObject($.extend({}, Application.defaults, opts));
            this.config = ConfigObject.makeProperty(this._config);

            // get the stylesheet data from the head. also parse all int stuff
            var styles:any = JSON.parse(util.str.unquote($('head').css('font-family'), "'"));
            ['breakpoints', 'containers'].forEach((name:string) => {
                $.each(styles['style'][name], (key:string, val:string) => {
                    styles['style'][name][key] = parseInt(val);
                });
            });
            this.config.merge(styles);


            this.extensions.loadAll();

            this.extensions.each((comp:codex.extensions.Extension) => {
                this[comp.name] = comp;
            });

            registerHelperPlugins();

            callReadyCallbacks(this);

            this.emit('init', this);
            if(this.DEBUG) console.groupEnd();
            return this;
        }

        public boot():PromiseInterface<Application> {
            var defer:DeferredInterface<Application> = util.promise.create();
            if(!this.isInitialised){
                throw new Error('Calling boot before init is not acceptable');
            }
            if (this.isBooted) {
                setTimeout(() => {
                    defer.resolve(this);
                }, 100);
                return defer.promise;
            }
            if(this.DEBUG) console.groupCollapsed('DEBUG: boot');

            $(() => {
                this.emit('boot', this);

                this.timers.boot = new Date;
                if (!isTouchDevice()) {
                    $body.tooltip(this.config('vendor.bootstrap.tooltip'));
                }
                $body.popover(this.config('vendor.bootstrap.popover'));
                $.material.options = this.config('vendor.material');
                $.material.init();
                this.isBooted = true;
                this.emit('booted', this);
                if(this.DEBUG) console.groupEnd();
                defer.resolve(this);
            });
            return defer.promise;
        }



        public get debug():Debug {
            return debug;
        }

        public getAssetPath(path:string = '', prefixBaseUrl:boolean = true):string {
            path = util.str.startsWith(path, '/') ? path : '/' + path;
            return (prefixBaseUrl ? this.config('baseUrl') : '') + this.config('assetPath') + path;
        }


        /****************************/
        // Events
        /****************************/

        public on(event:string, listener:Function):Application {
            if(event === 'init' && this.isInitialised && listener(this)){
                return;
            }

            this._events.on(event, listener);
            return this;
        }

        public once(event:string, listener:Function):Application {
            this._events.once(event, listener);
            return this;
        }

        public off(event:string, listener:Function):Application {
            this._events.off(event, listener);
            return this;
        }

        public emit(event:string, ...args:any[]):Application {
            if (this.DEBUG) {
                this.debug.logEvent(event, args);
            }
            this._events.emit(event, args);
            return this;
        }


        public booted(fn:Function) {
            if (this.isBooted) {
                fn([this]);
            } else {
                this.once('booted', fn);
            }
        }
    }


}
