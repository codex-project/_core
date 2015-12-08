(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define([], function () {
      return (root['packadic'] = factory());
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory();
  } else {
    root['packadic'] = factory();
  }
}(this, function () {

/// <reference path="./../types.d.ts" />
console.groupCollapsed('Packadic pre-init logs');
var packadic;
(function (packadic) {
    var configDefaults = {
        baseUrl: location.origin,
        assetPath: '/assets',
        vendor: {
            material: {
                "input": true,
                "ripples": true,
                "checkbox": true,
                "togglebutton": true,
                "radio": true,
                "arrive": true,
                "autofill": false,
                "withRipples": [".btn:not(.btn-link)", ".card-image", ".navbar a:not(.withoutripple)", ".dropdown-menu a", ".nav-tabs a:not(.withoutripple)", ".withripple"].join(","),
                "inputElements": "input.form-control, textarea.form-control, select.form-control",
                "checkboxElements": ".checkbox > label > input[type=checkbox]",
                "togglebuttonElements": ".togglebutton > label > input[type=checkbox]",
                "radioElements": ".radio > label > input[type=radio]"
            },
            slimscroll: {
                allowPageScroll: false,
                size: '6px',
                color: '#37474f',
                wrapperClass: 'slimScrollDiv',
                railColor: '#607d8b',
                position: 'right',
                height: '200px',
                alwaysVisible: false,
                railVisible: true,
                disableFadeOut: true
            },
            bootstrap: {
                tooltip: {
                    container: 'body',
                    template: '<div class="tooltip tooltip-packadic" role="tooltip"><div class="tooltip-inner"></div></div>',
                    selector: '*[data-toggle="tooltip"]'
                },
                popover: {
                    selector: '*[data-toggle="popover"]'
                }
            }
        }
    };
    function getConfigDefaults() {
        return configDefaults;
    }
    packadic.getConfigDefaults = getConfigDefaults;
    function mergeIntoDefaultConfig(obj) {
        if (obj === void 0) { obj = {}; }
        configDefaults = _.merge(configDefaults, obj);
    }
    packadic.mergeIntoDefaultConfig = mergeIntoDefaultConfig;
    var isReady = false;
    packadic._readyCallbacks = [];
    function ready(fn) {
        if (isReady) {
            fn.apply(fn, [packadic.app]);
        }
        else {
            packadic._readyCallbacks.push(fn);
        }
    }
    packadic.ready = ready;
    function callReadyCallbacks(app) {
        if (isReady) {
            return;
        }
        packadic._readyCallbacks.forEach(function (fn) {
            fn.apply(fn, [app]);
        });
        isReady = true;
    }
    packadic.callReadyCallbacks = callReadyCallbacks;
})(packadic || (packadic = {}));
var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var packadic;
(function (packadic) {
    packadic.namespacePrefix = 'packadic.';
    console.log('packadic namespace ' + packadic.namespacePrefix);
    function extension(name, configToMergeIntoDefaults) {
        if (configToMergeIntoDefaults === void 0) { configToMergeIntoDefaults = {}; }
        return function (cls) {
            extensions.Extensions.register(name, cls, configToMergeIntoDefaults);
        };
    }
    packadic.extension = extension;
    function directive(name, isElementDirective) {
        if (isElementDirective === void 0) { isElementDirective = false; }
        return function (cls) {
            var definition = {
                isLiteral: false,
                twoWay: false,
                acceptStatement: false,
                deep: false
            };
            var obj = new cls();
            var proto = Object.getPrototypeOf(obj);
            Object.getOwnPropertyNames(obj).forEach(function (defName) {
                definition[defName] = obj[defName];
            });
            Object.getOwnPropertyNames(proto).forEach(function (method) {
                if (['constructor'].indexOf(method) > -1)
                    return;
                var desc = Object.getOwnPropertyDescriptor(proto, method);
                if (typeof desc.value === 'function') {
                    definition[method] = proto[method];
                }
                else if (typeof desc.set === 'function') {
                    Object.defineProperty(definition, method, desc);
                }
                else if (typeof desc.get === 'function') {
                    Object.defineProperty(definition, method, desc);
                }
            });
            console.log('@directive ', name, definition, proto);
            if (isElementDirective) {
                Vue.elementDirective(name, definition);
            }
            else {
                Vue.directive(name, definition);
            }
        };
    }
    packadic.directive = directive;
    function filter(name) {
        return function (target, propertyKey, descriptor) {
            name = name || propertyKey;
            var originalMethod = descriptor.value;
            descriptor.value = function () {
                var args = [];
                for (var _i = 0; _i < arguments.length; _i++) {
                    args[_i - 0] = arguments[_i];
                }
                console.log("The method args are: " + JSON.stringify(args));
                var result = originalMethod.apply(this, args);
                console.log("The return value is: " + result);
                return result;
            };
            Vue.filter(name, target);
            return descriptor;
        };
    }
    packadic.filter = filter;
    function component(name) {
        return function (cls) {
            var options = {
                props: {},
                methods: {},
                computed: {}
            };
            if (cls.hasOwnProperty('replace'))
                options.replace = cls.replace;
            if (cls.hasOwnProperty('template'))
                options.template = cls.template;
            var obj = new cls();
            var proto = Object.getPrototypeOf(obj);
            if (proto.hasOwnProperty('__props__')) {
                options.props = proto.__props__;
            }
            Object.getOwnPropertyNames(obj).forEach(function (name) {
                var type = null;
                var t = typeof obj[name];
                if (t === 'string') {
                    type = String;
                }
                else if (t === 'number') {
                    type = Number;
                }
                else if (t === 'boolean') {
                    type = Boolean;
                }
                options.props[name] = { type: type, 'default': obj[name] };
            });
            if (proto.hasOwnProperty('__events__'))
                options.events = proto.__events__;
            if (proto.hasOwnProperty('__hooks__'))
                Object.keys(proto.__hooks__).forEach(function (name) {
                    options[name] = proto.__hooks__[name];
                });
            Object.getOwnPropertyNames(proto).forEach(function (method) {
                if (['constructor'].indexOf(method) > -1)
                    return;
                var desc = Object.getOwnPropertyDescriptor(proto, method);
                if (typeof desc.value === 'function')
                    options.methods[method] = proto[method];
                else if (typeof desc.set === 'function')
                    options.computed[method] = {
                        get: desc.get,
                        set: desc.set
                    };
                else if (typeof desc.get === 'function')
                    options.computed[method] = desc.get;
            });
            if (name === 'modal') {
                console.log('!component cls', cls);
                console.log('!component obj', obj);
                console.log('!component proto', proto);
                console.log('!component options', options);
            }
            Vue.component(name, options);
        };
    }
    packadic.component = component;
    function widget(name, parent) {
        return function (cls) {
            if (parent) {
                $.widget(packadic.namespacePrefix + name, new cls, parent);
            }
            else {
                $.widget(packadic.namespacePrefix + name, new cls);
            }
            console.log('Widget', name, 'registered', cls);
        };
    }
    packadic.widget = widget;
    function plugin(name, regOpts) {
        if (regOpts === void 0) { regOpts = {}; }
        return function (cls) {
            plugins.registerPlugin(name, cls, regOpts);
        };
    }
    packadic.plugin = plugin;
    var extensions;
    (function (extensions_1) {
        var Extensions = (function () {
            function Extensions(app) {
                var _this = this;
                if (Extensions._instance) {
                    throw new Error("Error - use Singleton.getInstance()");
                }
                this.app = app || packadic.app;
                if (!packadic.defined(this.app)) {
                    packadic.ready(function () {
                        _this.app = packadic.Application.instance;
                    });
                }
                this.extensions = {};
            }
            Object.defineProperty(Extensions, "instance", {
                get: function () {
                    Extensions._instance = Extensions._instance || new Extensions();
                    return Extensions._instance;
                },
                enumerable: true,
                configurable: true
            });
            Extensions.prototype.has = function (name) {
                return packadic.kindOf(name) === 'string' && Object.keys(this.extensions).indexOf(name) !== -1;
            };
            Extensions.prototype.get = function (name) {
                if (this.has(name)) {
                    return this.extensions[name];
                }
                throw new Error('ExtensionHost: Could not find ' + name);
            };
            Extensions.prototype.load = function (name, cb) {
                if (this.has(name)) {
                    return this.get(name);
                }
                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new packadic.util.obj.DependencySorter();
                }
                this.extensions[name] = new Extensions.EXTENSIONS[name](name, this, this.app);
                this.app.emit('component:loaded', name, this.extensions[name]);
                packadic.debug.log('Components', ' loaded: ', name, this.extensions[name]);
                if (packadic.kindOf(cb) === 'function') {
                    cb.apply(this, arguments);
                }
                return this.extensions[name];
            };
            Extensions.prototype.all = function () {
                return this.extensions;
            };
            Extensions.prototype.getRegisteredNames = function () {
                return Object.keys(this.getRegistered());
            };
            Extensions.prototype.getRegistered = function () {
                return Extensions.EXTENSIONS;
            };
            Extensions.prototype.loadAll = function () {
                var _this = this;
                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new packadic.util.obj.DependencySorter();
                }
                var names = Extensions.EXTENSIONSDEPS.sort();
                console.log('loadAll deps:', names);
                var missing = Object.keys(Extensions.EXTENSIONSDEPS.getMissing()).length;
                if (missing > 0) {
                    console.warn('Missing dependencies: ' + missing.toString());
                }
                names.forEach(function (name) {
                    if (!_this.has(name)) {
                        _this.load(name);
                    }
                });
                return this;
            };
            Extensions.prototype.each = function (fn) {
                packadic.util.arr.each(this.all(), fn);
                return this;
            };
            Extensions.register = function (name, componentClass, configToMergeIntoDefaults) {
                if (typeof Extensions.EXTENSIONSDEPS === 'undefined') {
                    Extensions.EXTENSIONSDEPS = new packadic.util.obj.DependencySorter();
                }
                if (typeof Extensions.EXTENSIONS[name] !== 'undefined') {
                    throw new Error('Cannot add ' + name + '. Already exists');
                }
                Extensions.EXTENSIONS[name] = componentClass;
                Extensions.EXTENSIONSDEPS.addItem(name, componentClass.dependencies);
                console.log('register deps:', componentClass);
                if (typeof configToMergeIntoDefaults !== "undefined") {
                    var configMerger = {};
                    configMerger[name] = configToMergeIntoDefaults;
                    packadic.mergeIntoDefaultConfig(configMerger);
                }
                console.log('Components', ' registered: ', name, componentClass);
            };
            Extensions.EXTENSIONS = {};
            return Extensions;
        })();
        extensions_1.Extensions = Extensions;
        var Extension = (function () {
            function Extension(name, extensions, app) {
                this.name = name;
                this.extensions = extensions;
                this.app = app;
                this._make.call(this);
                if (app.isInitialised) {
                    this.init.call(this);
                }
                else {
                    app.on('init', this.init.bind(this));
                }
                if (app.isBooted) {
                    this._boot.call(this);
                    this._booted.call(this);
                }
                else {
                    app.on('boot', this._boot.bind(this));
                    app.on('booted', this._booted.bind(this));
                }
            }
            Object.defineProperty(Extension.prototype, "config", {
                get: function () {
                    return this.app.config;
                },
                enumerable: true,
                configurable: true
            });
            Extension.prototype._make = function () {
                this.make();
            };
            Extension.prototype._boot = function () {
                this.boot();
            };
            Extension.prototype._booted = function () {
                this.booted();
            };
            Extension.prototype.make = function () {
            };
            Extension.prototype.init = function () {
            };
            Extension.prototype.boot = function () {
            };
            Extension.prototype.booted = function () {
            };
            Extension.dependencies = [];
            return Extension;
        })();
        extensions_1.Extension = Extension;
    })(extensions = packadic.extensions || (packadic.extensions = {}));
    var directives;
    (function (directives) {
        var Directive = (function () {
            function Directive() {
                var myPrototype = Directive.prototype;
                $.each(myPrototype, function (propertyName, value) {
                    delete myPrototype[propertyName];
                });
            }
            Object.defineProperty(Directive.prototype, "$el", {
                get: function () {
                    return $(this.el);
                },
                enumerable: true,
                configurable: true
            });
            Directive.prototype.$set = function (exp, val) {
            };
            Directive.prototype.$delete = function (key) { };
            Directive.prototype.set = function (value) { };
            Directive.prototype.on = function (event, handler) { };
            Directive.prototype.bind = function () {
            };
            Directive.prototype.unbind = function () {
            };
            Directive.prototype.update = function (newValue, oldValue) {
            };
            return Directive;
        })();
        directives.Directive = Directive;
        var ElementDirective = (function (_super) {
            __extends(ElementDirective, _super);
            function ElementDirective() {
                _super.apply(this, arguments);
            }
            return ElementDirective;
        })(Directive);
        directives.ElementDirective = ElementDirective;
    })(directives = packadic.directives || (packadic.directives = {}));
    var filters;
    (function (filters_1) {
        function FilterCollection(excludedFunctions) {
            if (excludedFunctions === void 0) { excludedFunctions = []; }
            return function (target) {
                var proto = Object.getPrototypeOf(target);
                var filters = {};
                Object.getOwnPropertyNames(proto).forEach(function (method) {
                    if (['constructor'].concat(excludedFunctions).indexOf(method) > -1) {
                        return;
                    }
                    var desc = Object.getOwnPropertyDescriptor(proto, method);
                    if (typeof desc.value === 'function') {
                        Vue.filter(method, proto[method]);
                    }
                });
            };
        }
        filters_1.FilterCollection = FilterCollection;
    })(filters = packadic.filters || (packadic.filters = {}));
    var components;
    (function (components) {
        var Component = (function () {
            function Component() {
            }
            Component.prototype.$add = function (key, val) {
            };
            Component.prototype.$addChild = function (options, constructor) {
            };
            Component.prototype.$after = function (target, cb) {
            };
            Component.prototype.$appendTo = function (target, cb) {
            };
            Component.prototype.$before = function (target, cb) {
            };
            Component.prototype.$broadcast = function (event) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
            };
            Component.prototype.$compile = function (el) {
                return function () {
                };
            };
            Component.prototype.$delete = function (key) {
            };
            Component.prototype.$destroy = function (remove) {
            };
            Component.prototype.$dispatch = function (event) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
            };
            Component.prototype.$emit = function (event) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
            };
            Component.prototype.$eval = function (text) {
            };
            Component.prototype.$get = function (exp) {
            };
            Component.prototype.$interpolate = function (text) {
            };
            Component.prototype.$log = function (path) {
            };
            Component.prototype.$mount = function (el) {
            };
            Component.prototype.$nextTick = function (fn) {
            };
            Component.prototype.$off = function (event, fn) {
            };
            Component.prototype.$on = function (event, fn) {
            };
            Component.prototype.$once = function (event, fn) {
            };
            Component.prototype.$remove = function (cb) {
            };
            Component.prototype.$set = function (exp, val) {
            };
            Component.prototype.$watch = function (exp, cb, options) {
            };
            return Component;
        })();
        components.Component = Component;
        function lifecycleHook(hook) {
            return function (cls, name, desc) {
                if ([
                    'created', 'beforeCompile', 'compiled', 'ready', 'attached', 'detached', 'beforeDestroy', 'destroyed'
                ].indexOf(hook) == -1)
                    throw new Error('Unknown Lifecyle Hook: ' + hook);
                if (!cls.hasOwnProperty('__hooks__'))
                    cls.__hooks__ = {};
                cls.__hooks__[name] = cls[name];
                desc.value = void 0;
                return desc;
            };
        }
        components.lifecycleHook = lifecycleHook;
        function eventHook(hook) {
            return function (cls, name, desc) {
                if (!cls.hasOwnProperty('__events__'))
                    cls.__events__ = {};
                cls.__events__[name] = cls[name];
                desc.value = void 0;
                return desc;
            };
        }
        components.eventHook = eventHook;
        function prop(options) {
            return function (cls, name) {
                if (!cls.hasOwnProperty('__props__'))
                    cls.__props__ = {};
                cls.__props__[name] = options;
            };
        }
        components.prop = prop;
    })(components = packadic.components || (packadic.components = {}));
    var widgets;
    (function (widgets) {
        var Widget = (function () {
            function Widget() {
                var myPrototype = Widget.prototype;
                $.each(myPrototype, function (propertyName, value) {
                    delete myPrototype[propertyName];
                });
            }
            Widget.prototype._create = function () {
                return undefined;
            };
            Widget.prototype._destroy = function () {
            };
            Widget.prototype._init = function () {
                return undefined;
            };
            Widget.prototype._delay = function (fn, delay) {
                return undefined;
            };
            Widget.prototype._focusable = function (element) {
                return undefined;
            };
            Widget.prototype._getCreateEventData = function () {
                return undefined;
            };
            Widget.prototype._getCreateOptions = function () {
                return undefined;
            };
            Widget.prototype._hide = function (element, option, callback) {
                return undefined;
            };
            Widget.prototype._hoverable = function (element) {
                return undefined;
            };
            Widget.prototype._off = function (element, eventName) {
                return undefined;
            };
            Widget.prototype._on = function (element, handlers) {
                return undefined;
            };
            Widget.prototype._setOption = function (key, value) {
                return undefined;
            };
            Widget.prototype._setOptions = function (options) {
                return undefined;
            };
            Widget.prototype._show = function (element, option, callback) {
                return undefined;
            };
            Widget.prototype._super = function () {
                var arg = [];
                for (var _i = 0; _i < arguments.length; _i++) {
                    arg[_i - 0] = arguments[_i];
                }
            };
            Widget.prototype._superApply = function (args) {
            };
            Widget.prototype._trigger = function (type, args, data) {
                return undefined;
            };
            Widget.prototype.destroy = function () {
            };
            Widget.prototype.disable = function () {
            };
            Widget.prototype.enable = function () {
            };
            Widget.prototype.instance = function () {
                return undefined;
            };
            Widget.prototype.option = function (arg) {
                return undefined;
            };
            Object.defineProperty(Widget.prototype, "app", {
                get: function () {
                    return packadic.Application.instance;
                },
                enumerable: true,
                configurable: true
            });
            return Widget;
        })();
        widgets.Widget = Widget;
    })(widgets = packadic.widgets || (packadic.widgets = {}));
    var plugins;
    (function (plugins) {
        var Plugin = (function () {
            function Plugin(element, options, ns) {
                this.VERSION = '0.0.0';
                this.NAMESPACE = 'packadic.';
                this.enabled = true;
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
            Object.defineProperty(Plugin.prototype, "options", {
                get: function () {
                    return this._options;
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Plugin.prototype, "app", {
                get: function () {
                    return packadic.Application.instance;
                },
                enumerable: true,
                configurable: true
            });
            Plugin.prototype.instance = function () {
                return this;
            };
            Plugin.prototype._create = function () {
            };
            Plugin.prototype._destroy = function () {
            };
            Plugin.prototype.destroy = function () {
                this._trigger('destroy');
                this._destroy();
                this._trigger('destroyed');
            };
            Plugin.prototype._trigger = function (name, extraParameters) {
                var e = $.Event(name + '.' + this.NAMESPACE);
                this.$element.trigger(e, extraParameters);
                return this;
            };
            Plugin.prototype._on = function () {
                var args = [];
                for (var _i = 0; _i < arguments.length; _i++) {
                    args[_i - 0] = arguments[_i];
                }
                args[0] = args[0] + '.' + this.NAMESPACE;
                packadic.debug.log('plugin _on ', this, args);
                this.$element.on.apply(this.$element, args);
                return this;
            };
            Plugin.register = function (name, pluginClass) {
                registerPlugin(name, pluginClass);
                console.log('Plugin', name, 'registered', pluginClass);
            };
            Plugin.defaults = {};
            return Plugin;
        })();
        plugins.Plugin = Plugin;
        var defaultRegOpts = {
            loadPath: 'app/plugins/',
            callback: $.noop()
        };
        function makeRegOptions(name, pluginClass, regOpts) {
            regOpts = $.extend(true, this.defaultRegOpts, { 'class': pluginClass }, regOpts);
            if (typeof regOpts.namespace !== 'string') {
                regOpts.namespace = name;
            }
            regOpts.namespace = packadic.namespacePrefix + regOpts.namespace;
            return regOpts;
        }
        function registerPlugin(name, pluginClass, opts) {
            if (opts === void 0) { opts = {}; }
            var regOpts = $.extend(true, {}, makeRegOptions(name, pluginClass), opts);
            function jQueryPlugin(options) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
                var all = this.each(function () {
                    var $this = $(this);
                    var data = $this.data(regOpts.namespace);
                    var opts = $.extend({}, pluginClass.defaults, $this.data(), typeof options == 'object' && options);
                    if (!data) {
                        $this.data(regOpts.namespace, (data = new pluginClass(this, opts, regOpts.namespace)));
                    }
                    if (packadic.kindOf(options) === 'string') {
                        data[options].call(data, args);
                    }
                    if (packadic.kindOf(regOpts.callback) === 'function') {
                        regOpts.callback.apply(this, [data, opts]);
                    }
                });
                if (packadic.kindOf(options) === 'string' && options === 'instance' && all.length > 0) {
                    if (all.length === 1) {
                        return $(all[0]).data(regOpts.namespace);
                    }
                    else {
                        var instances = [];
                        all.each(function () {
                            instances.push($(this).data(regOpts.namespace));
                        });
                        return instances;
                    }
                }
                return all;
            }
            var old = $.fn[name];
            $.fn[name] = jQueryPlugin;
            $.fn[name].Constructor = pluginClass;
        }
        plugins.registerPlugin = registerPlugin;
    })(plugins = packadic.plugins || (packadic.plugins = {}));
})(packadic || (packadic = {}));
/**
 * The application class
 */
var packadic;
(function (packadic) {
    var $body = $('body');
    function EventHook(hook) {
        return function (cls, name, desc) {
            console.log('EventHook(' + hook + ')', cls, name, desc);
            desc.value = void 0;
            return desc;
        };
    }
    packadic.EventHook = EventHook;
    var Application = (function (_super) {
        __extends(Application, _super);
        function Application(options) {
            _super.call(this, options);
            this.data = {};
            this.timers = { construct: null, init: null, boot: null };
            this._loaded = {};
            this._events = new EventEmitter2({
                wildcard: true,
                delimiter: ':',
                maxListeners: 1000,
                newListener: true
            });
            $body.data('packadic', this);
            var self = this;
            packadic.app = this;
            Application.defaults = packadic.getConfigDefaults();
            this.timers.construct = new Date;
            this.isInitialised = false;
            this.isBooted = false;
        }
        Object.defineProperty(Application.prototype, "extensions", {
            get: function () {
                return packadic.extensions.Extensions.instance;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(Application, "instance", {
            get: function () {
                if (typeof Application._instance === "undefined") {
                    Application._instance = new Application();
                    packadic.app = Application._instance;
                }
                return Application._instance;
            },
            enumerable: true,
            configurable: true
        });
        Application.prototype.init = function (opts) {
            var _this = this;
            if (opts === void 0) { opts = {}; }
            if (this.isInitialised) {
                return;
            }
            else {
                this.isInitialised = true;
            }
            this.emit('pre-init');
            console.groupEnd();
            this.timers.init = new Date;
            if (this.DEBUG) {
                this.debug.enable();
                this.debug.setStartDate(this.timers.construct);
                console.groupCollapsed('DEBUG: init');
            }
            this._config = new packadic.ConfigObject($.extend({}, Application.defaults, opts));
            this.config = packadic.ConfigObject.makeProperty(this._config);
            var styles = JSON.parse(packadic.util.str.unquote($('head').css('font-family'), "'"));
            ['breakpoints', 'containers'].forEach(function (name) {
                $.each(styles['style'][name], function (key, val) {
                    styles['style'][name][key] = parseInt(val);
                });
            });
            this.config.merge(styles);
            this.extensions.loadAll();
            this.extensions.each(function (comp) {
                _this[comp.name] = comp;
            });
            packadic.registerHelperPlugins();
            packadic.callReadyCallbacks(this);
            this.emit('init', this);
            if (this.DEBUG)
                console.groupEnd();
            return this;
        };
        Application.prototype.boot = function () {
            var _this = this;
            var defer = packadic.util.promise.create();
            if (!this.isInitialised) {
                throw new Error('Calling boot before init is not acceptable');
            }
            if (this.isBooted) {
                setTimeout(function () {
                    defer.resolve(_this);
                }, 100);
                return defer.promise;
            }
            if (this.DEBUG)
                console.groupCollapsed('DEBUG: boot');
            $(function () {
                _this.$mount('html');
                _this.emit('boot', _this);
                _this.timers.boot = new Date;
                if (!packadic.isTouchDevice()) {
                    $body.tooltip(_this.config('vendor.bootstrap.tooltip'));
                }
                $body.popover(_this.config('vendor.bootstrap.popover'));
                $.material.options = _this.config('vendor.material');
                $.material.init();
                _this.isBooted = true;
                _this.emit('booted', _this);
                if (_this.DEBUG)
                    console.groupEnd();
                defer.resolve(_this);
            });
            return defer.promise;
        };
        Object.defineProperty(Application.prototype, "debug", {
            get: function () {
                return packadic.debug;
            },
            enumerable: true,
            configurable: true
        });
        Application.prototype.getAssetPath = function (path, prefixBaseUrl) {
            if (path === void 0) { path = ''; }
            if (prefixBaseUrl === void 0) { prefixBaseUrl = true; }
            path = packadic.util.str.startsWith(path, '/') ? path : '/' + path;
            return (prefixBaseUrl ? this.config('baseUrl') : '') + this.config('assetPath') + path;
        };
        Application.prototype.mergeData = function (newData) {
            var _this = this;
            if (newData === void 0) { newData = {}; }
            Object.keys(newData).forEach(function (key) {
                if (typeof _this.$get(key) !== 'undefined') {
                    _this.$set(key, newData[key]);
                }
                else {
                    _this.$add(key, newData[key]);
                }
            });
        };
        Application.prototype.load = function (type, path, bower, pathSuffix) {
            if (bower === void 0) { bower = false; }
            if (pathSuffix === void 0) { pathSuffix = ''; }
            var defer = packadic.util.promise.create();
            path = packadic.util.str.endsWith(path, '.' + type) ? path : path + '.' + type;
            var fullPath = this.getAssetPath((bower ? 'bower_components/' : 'scripts/') + path) + pathSuffix;
            this._loaded[fullPath] = true;
            System.import(fullPath).then(function () {
                var args = [];
                for (var _i = 0; _i < arguments.length; _i++) {
                    args[_i - 0] = arguments[_i];
                }
                defer.resolve(args);
            });
            return defer.promise;
        };
        Application.prototype.loadJS = function (path, bower) {
            if (bower === void 0) { bower = false; }
            return this.load('js', path, bower);
        };
        Application.prototype.loadCSS = function (path, bower) {
            if (bower === void 0) { bower = false; }
            return this.load('css', path, bower, '!css');
        };
        Application.prototype.on = function (event, listener) {
            if (event === 'init' && this.isInitialised && listener(this)) {
                return;
            }
            this._events.on(event, listener);
            return this;
        };
        Application.prototype.once = function (event, listener) {
            this._events.once(event, listener);
            return this;
        };
        Application.prototype.off = function (event, listener) {
            this._events.off(event, listener);
            return this;
        };
        Application.prototype.emit = function (event) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            if (this.DEBUG) {
                this.debug.logEvent(event, args);
            }
            this._events.emit(event, args);
            return this;
        };
        Application.prototype.booted = function (fn) {
            if (this.isBooted) {
                fn([this]);
            }
            else {
                this.once('booted', fn);
            }
        };
        return Application;
    })(Vue);
    packadic.Application = Application;
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var ConfigObject = (function () {
        function ConfigObject(obj) {
            this.allDelimiters = {};
            this.addDelimiters('config', '<%', '%>');
            this.data = obj || {};
        }
        ConfigObject.makeProperty = function (config) {
            var cf = function (prop) {
                return config.get(prop);
            };
            cf.get = config.get.bind(config);
            cf.set = config.set.bind(config);
            cf.unset = config.unset.bind(config);
            cf.merge = config.merge.bind(config);
            cf.raw = config.raw.bind(config);
            cf.process = config.process.bind(config);
            return cf;
        };
        ConfigObject.prototype.unset = function (prop) {
            prop = prop.split('.');
            var key = prop.pop();
            var obj = packadic.util.obj.objectGet(this.data, ConfigObject.getPropString(prop.join('.')));
            delete obj[key];
        };
        ConfigObject.getPropString = function (prop) {
            return Array.isArray(prop) ? prop.map(this.escape).join('.') : prop;
        };
        ConfigObject.escape = function (str) {
            return str.replace(/\./g, '\\.');
        };
        ConfigObject.prototype.raw = function (prop) {
            if (prop) {
                return packadic.util.obj.objectGet(this.data, ConfigObject.getPropString(prop));
            }
            else {
                return this.data;
            }
        };
        ConfigObject.prototype.get = function (prop) {
            return this.process(this.raw(prop));
        };
        ConfigObject.prototype.set = function (prop, value) {
            packadic.util.obj.objectSet(this.data, ConfigObject.getPropString(prop), value);
            return this;
        };
        ConfigObject.prototype.merge = function (obj) {
            this.data = _.merge(this.data, obj);
            return this;
        };
        ConfigObject.prototype.process = function (raw) {
            var self = this;
            return packadic.util.obj.recurse(raw, function (value) {
                if (typeof value !== 'string') {
                    return value;
                }
                var matches = value.match(ConfigObject.propStringTmplRe);
                var result;
                if (matches) {
                    result = self.get(matches[1]);
                    if (result != null) {
                        return result;
                    }
                }
                return self.processTemplate(value, { data: self.data });
            });
        };
        ConfigObject.prototype.addDelimiters = function (name, opener, closer) {
            var delimiters = this.allDelimiters[name] = {};
            delimiters.opener = opener;
            delimiters.closer = closer;
            var a = delimiters.opener.replace(/(.)/g, '\\$1');
            var b = '([\\s\\S]+?)' + delimiters.closer.replace(/(.)/g, '\\$1');
            delimiters.lodash = {
                evaluate: new RegExp(a + b, 'g'),
                interpolate: new RegExp(a + '=' + b, 'g'),
                escape: new RegExp(a + '-' + b, 'g')
            };
        };
        ConfigObject.prototype.setDelimiters = function (name) {
            var delimiters = this.allDelimiters[name in this.allDelimiters ? name : 'config'];
            _.templateSettings = delimiters.lodash;
            return delimiters;
        };
        ConfigObject.prototype.processTemplate = function (tmpl, options) {
            if (!options) {
                options = {};
            }
            var delimiters = this.setDelimiters(options.delimiters);
            var data = Object.create(options.data || this.data || {});
            var last = tmpl;
            try {
                while (tmpl.indexOf(delimiters.opener) >= 0) {
                    tmpl = _.template(tmpl)(data);
                    if (tmpl === last) {
                        break;
                    }
                    last = tmpl;
                }
            }
            catch (e) {
            }
            return tmpl.toString().replace(/\r\n|\n/g, '\n');
        };
        ConfigObject.propStringTmplRe = /^<%=\s*([a-z0-9_$]+(?:\.[a-z0-9_$]+)*)\s*%>$/i;
        return ConfigObject;
    })();
    packadic.ConfigObject = ConfigObject;
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var StyleStuff = (function () {
        function StyleStuff() {
            this._styles = {};
        }
        StyleStuff.prototype.addMSC = function (name, variant) {
            if (variant === void 0) { variant = '500'; }
            if (typeof name === 'string') {
                if (variant !== '500') {
                    name += variant.toString();
                }
                this._styles[name.toString()] = 'color: ' + packadic.util.material.color(name.toString(), variant);
            }
            else {
                name.forEach(function (n) {
                    this.addMSC(n, variant);
                }.bind(this));
            }
            return this;
        };
        StyleStuff.prototype.addFont = function (name, ff) {
            this._styles[name] = 'font-family: ' + ff;
            return this;
        };
        StyleStuff.prototype.add = function (name, val) {
            if (typeof val === 'string') {
                this._styles[name] = val;
            }
            else {
                var css = '';
                val.forEach(function (v) {
                    if (typeof this._styles[v] === 'string') {
                        css += this._styles[v] + ';';
                    }
                    else {
                        css += v + ';';
                    }
                }.bind(this));
                this._styles[name] = css;
            }
            return this;
        };
        StyleStuff.prototype.all = function () {
            return this._styles;
        };
        StyleStuff.prototype.get = function (name) {
            return this._styles[name];
        };
        StyleStuff.prototype.has = function (name) {
            return typeof this._styles[name] === 'string';
        };
        return StyleStuff;
    })();
    packadic.StyleStuff = StyleStuff;
    var Debug = (function () {
        function Debug() {
            this.matcher = /\[style\=([\w\d\_\-\,]*?)\](.*?)\[style\]/g;
            this.start = new Date;
            this.styles = new StyleStuff();
            this.enabled = false;
            for (var i = 8; i < 30; i++) {
                this.styles.add('fs' + i.toString(), 'font-size: ' + i.toString() + 'px');
            }
            this.styles
                .add('bold', 'font-weight:bold')
                .add('code-box', 'background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1); line-height: 18px')
                .addMSC(Object.keys(packadic.util.material.colors))
                .addFont('code', '"Source Code Pro", "Courier New", Courier, monospace')
                .addFont('arial', 'Arial, Helvetica, sans-serif')
                .addFont('verdana', 'Verdana, Geneva, sans-serif');
        }
        Debug.prototype.printTitle = function () {
            this.out('[style=orange,fs25]Packadic Framework[style] [style=yellow]1.0.0[style]');
        };
        Debug.prototype.log = function () {
            var args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                args[_i - 0] = arguments[_i];
            }
            var elapsedTime = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = packadic.util.num.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]): '].concat(args));
        };
        Debug.prototype.logEvent = function (eventName) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var elapsedTime = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = packadic.util.num.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]):[style=teal,fs10]EVENT[style]([style=blue,fs8]' + eventName + '[style]): '].concat(args));
        };
        Debug.prototype.out = function (message) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var self = this;
            var applyArgs = [];
            applyArgs.push(message.replace(this.matcher, '%c$2%c'));
            var matched;
            while ((matched = this.matcher.exec(message)) !== null) {
                var css = '';
                matched[1].split(',').forEach(function (style) {
                    css += self.styles.get(style) + ';';
                });
                applyArgs.push(css);
                applyArgs.push('');
            }
            if (this.enabled) {
                console.log.apply(console, applyArgs.concat(args));
            }
        };
        Debug.prototype.enable = function () {
            if (this.enabled) {
                return;
            }
            this.enabled = true;
            this.printTitle();
        };
        Debug.prototype.isEnabled = function () {
            return this.enabled;
        };
        Debug.prototype.setStartDate = function (start) {
            this.start = start;
            return this;
        };
        return Debug;
    })();
    packadic.Debug = Debug;
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var kindsOf = {};
    'Number String Boolean Function RegExp Array Date Error'.split(' ').forEach(function (k) {
        kindsOf['[object ' + k + ']'] = k.toLowerCase();
    });
    var nativeTrim = String.prototype.trim;
    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '&#x2F;'
    };
    function kindOf(value) {
        if (value == null) {
            return String(value);
        }
        return kindsOf[kindsOf.toString.call(value)] || 'object';
    }
    packadic.kindOf = kindOf;
    function def(val, def) {
        return defined(val) ? val : def;
    }
    packadic.def = def;
    function defined(obj) {
        return !_.isUndefined(obj);
    }
    packadic.defined = defined;
    function cre(name) {
        if (!defined(name)) {
            name = 'div';
        }
        return $(document.createElement(name));
    }
    packadic.cre = cre;
    function getViewPort() {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return {
            width: e[a + 'Width'],
            height: e[a + 'Height']
        };
    }
    packadic.getViewPort = getViewPort;
    function isTouchDevice() {
        try {
            document.createEvent("TouchEvent");
            return true;
        }
        catch (e) {
            return false;
        }
    }
    packadic.isTouchDevice = isTouchDevice;
    function getRandomId(length) {
        if (!_.isNumber(length)) {
            length = 15;
        }
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }
    packadic.getRandomId = getRandomId;
    function getTemplate(name) {
        if (!defined(window['JST'][name])) {
            throw new Error('Template [' + name + '] not found');
        }
        return window['JST'][name];
    }
    packadic.getTemplate = getTemplate;
    function getClipboard() {
        var defer = packadic.util.promise.create();
        var app = packadic.Application.instance;
        if (defined(packadic.Clipboard)) {
            defer.resolve(packadic.Clipboard);
        }
        else {
            app.on('init', function () {
                app.loadJS('zeroclipboard/dist/ZeroClipboard', true).then(function (z) {
                    var Clipboard = z[0];
                    Clipboard.config({ swfPath: app.getAssetPath('bower_components/zeroclipboard/dist/ZeroClipboard.swf') });
                    defer.resolve(Clipboard);
                });
            });
        }
        return defer.promise;
    }
    packadic.getClipboard = getClipboard;
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var storage;
    (function (storage) {
        storage.bags = {};
        function hasBag(name) {
            return typeof storage.bags[name] !== 'undefined';
        }
        storage.hasBag = hasBag;
        function createBag(name, provider) {
            if (hasBag(name)) {
                throw new Error('StorageBag ' + name + ' already exists');
            }
            return storage.bags[name] = new StorageBag(provider);
        }
        storage.createBag = createBag;
        function getBag(name) {
            if (!hasBag(name)) {
                throw new Error('StorageBag ' + name + ' does not exist');
            }
            return storage.bags[name];
        }
        storage.getBag = getBag;
        var StorageBag = (function () {
            function StorageBag(provider) {
                this.provider = provider;
            }
            StorageBag.prototype.on = function (callback) {
                this.provider.onStoreEvent(callback);
            };
            StorageBag.prototype.set = function (key, val, options) {
                var options = _.merge({ json: false, expires: false }, options);
                if (options.json) {
                    val = JSON.stringify(val);
                }
                if (options.expires) {
                    var now = Math.floor((Date.now() / 1000) / 60);
                    this.provider.setItem(key + ':expire', now + options.expires);
                }
                this.provider.setItem(key, val);
            };
            StorageBag.prototype.get = function (key, options) {
                var options = _.merge({ json: false, def: null }, options);
                if (!packadic.defined(key)) {
                    return options.def;
                }
                if (_.isString(this.provider.getItem(key))) {
                    if (_.isString(this.provider.getItem(key + ':expire'))) {
                        var now = Math.floor((Date.now() / 1000) / 60);
                        var expires = parseInt(this.provider.getItem(key + ':expire'));
                        if (now > expires) {
                            this.del(key);
                            this.del(key + ':expire');
                        }
                    }
                }
                var val = this.provider.getItem(key);
                if (!packadic.defined(val) || packadic.defined(val) && val == null) {
                    return options.def;
                }
                if (options.json) {
                    return JSON.parse(val);
                }
                return val;
            };
            StorageBag.prototype.del = function (key) {
                this.provider.removeItem(key);
            };
            StorageBag.prototype.clear = function () {
                this.provider.clear();
            };
            StorageBag.prototype.getSize = function (key) {
                return this.provider.getSize(key);
            };
            return StorageBag;
        })();
        storage.StorageBag = StorageBag;
        var LocalStorage = (function () {
            function LocalStorage() {
            }
            Object.defineProperty(LocalStorage.prototype, "length", {
                get: function () {
                    return window.localStorage.length;
                },
                enumerable: true,
                configurable: true
            });
            LocalStorage.prototype.getSize = function (key) {
                key = key || false;
                if (key) {
                    return ((window.localStorage[x].length * 2) / 1024 / 1024).toFixed(2);
                }
                else {
                    var total = 0;
                    for (var x in window.localStorage) {
                        total += (window.localStorage[x].length * 2) / 1024 / 1024;
                    }
                    return total.toFixed(2);
                }
            };
            LocalStorage.prototype.onStoreEvent = function (callback) {
                if (window.addEventListener) {
                    window.addEventListener("storage", callback, false);
                }
                else {
                    window.attachEvent("onstorage", callback);
                }
            };
            LocalStorage.prototype.clear = function () {
                window.localStorage.clear();
            };
            LocalStorage.prototype.getItem = function (key) {
                return window.localStorage.getItem(key);
            };
            LocalStorage.prototype.key = function (index) {
                return window.localStorage.key(index);
            };
            LocalStorage.prototype.removeItem = function (key) {
                window.localStorage.removeItem(key);
            };
            LocalStorage.prototype.setItem = function (key, data) {
                window.localStorage.setItem(key, data);
            };
            return LocalStorage;
        })();
        storage.LocalStorage = LocalStorage;
        var SessionStorage = (function () {
            function SessionStorage() {
            }
            Object.defineProperty(SessionStorage.prototype, "length", {
                get: function () {
                    return window.sessionStorage.length;
                },
                enumerable: true,
                configurable: true
            });
            SessionStorage.prototype.getSize = function (key) {
                key = key || false;
                if (key) {
                    return ((window.sessionStorage[x].length * 2) / 1024 / 1024).toFixed(2);
                }
                else {
                    var total = 0;
                    for (var x in window.sessionStorage) {
                        total += (window.sessionStorage[x].length * 2) / 1024 / 1024;
                    }
                    return total.toFixed(2);
                }
            };
            SessionStorage.prototype.onStoreEvent = function (callback) {
                if (window.addEventListener) {
                    window.addEventListener("storage", callback, false);
                }
                else {
                    window.attachEvent("onstorage", callback);
                }
            };
            SessionStorage.prototype.clear = function () {
                window.sessionStorage.clear();
            };
            SessionStorage.prototype.getItem = function (key) {
                return window.sessionStorage.getItem(key);
            };
            SessionStorage.prototype.key = function (index) {
                return window.sessionStorage.key(index);
            };
            SessionStorage.prototype.removeItem = function (key) {
                window.sessionStorage.removeItem(key);
            };
            SessionStorage.prototype.setItem = function (key, data) {
                window.sessionStorage.setItem(key, data);
            };
            return SessionStorage;
        })();
        storage.SessionStorage = SessionStorage;
        var CookieStorage = (function () {
            function CookieStorage() {
                this.cookieRegistry = [];
            }
            Object.defineProperty(CookieStorage.prototype, "length", {
                get: function () {
                    return this.keys().length;
                },
                enumerable: true,
                configurable: true
            });
            CookieStorage.prototype.getSize = function (key) {
                key = key || false;
                if (key) {
                    return ((window.sessionStorage[x].length * 2) / 1024 / 1024).toFixed(2);
                }
                else {
                    var total = 0;
                    for (var x in window.sessionStorage) {
                        total += (window.sessionStorage[x].length * 2) / 1024 / 1024;
                    }
                    return total.toFixed(2);
                }
            };
            CookieStorage.prototype.listenCookieChange = function (cookieName, callback) {
                var _this = this;
                setInterval(function () {
                    if (_this.hasItem(cookieName)) {
                        if (_this.getItem(cookieName) != _this.cookieRegistry[cookieName]) {
                            _this.cookieRegistry[cookieName] = _this.getItem(cookieName);
                            return callback();
                        }
                    }
                    else {
                        _this.cookieRegistry[cookieName] = _this.getItem(cookieName);
                    }
                }, 100);
            };
            CookieStorage.prototype.onStoreEvent = function (callback) {
                var _this = this;
                this.keys().forEach(function (name) {
                    _this.listenCookieChange(name, callback);
                });
            };
            CookieStorage.prototype.clear = function () {
                var _this = this;
                this.keys().forEach(function (name) {
                    _this.removeItem(name);
                });
            };
            CookieStorage.prototype.key = function (index) {
                return this.keys()[index];
            };
            CookieStorage.prototype.getItem = function (sKey) {
                if (!sKey) {
                    return null;
                }
                return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
            };
            CookieStorage.prototype.setItem = function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
                if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
                    return;
                }
                var sExpires = "";
                if (vEnd) {
                    switch (vEnd.constructor) {
                        case Number:
                            sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
                            break;
                        case String:
                            sExpires = "; expires=" + vEnd;
                            break;
                        case Date:
                            sExpires = "; expires=" + vEnd.toUTCString();
                            break;
                    }
                }
                document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
                return;
            };
            CookieStorage.prototype.removeItem = function (key, sPath, sDomain) {
                if (!this.hasItem(key)) {
                    return false;
                }
                document.cookie = encodeURIComponent(key) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
                return true;
            };
            CookieStorage.prototype.hasItem = function (sKey) {
                if (!sKey) {
                    return false;
                }
                return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
            };
            CookieStorage.prototype.keys = function () {
                var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
                for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) {
                    aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
                }
                return aKeys;
            };
            return CookieStorage;
        })();
        storage.CookieStorage = CookieStorage;
        if (typeof window.localStorage !== 'undefined') {
            createBag('local', new LocalStorage());
        }
        if (typeof window.sessionStorage !== 'undefined') {
            createBag('session', new SessionStorage());
        }
        if (typeof window.document.cookie !== 'undefined') {
            createBag('cookie', new CookieStorage());
        }
    })(storage = packadic.storage || (packadic.storage = {}));
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    function highlight(code, lang, wrap, wrapPre) {
        if (wrap === void 0) { wrap = false; }
        if (wrapPre === void 0) { wrapPre = false; }
        if (!packadic.defined(hljs)) {
            console.warn('Cannot call highlight function in packadic.plugins, hljs is not defined');
            return;
        }
        var defer = packadic.util.promise.create();
        var highlighted;
        if (lang && hljs.getLanguage(lang)) {
            highlighted = hljs.highlight(lang, code).value;
        }
        else {
            highlighted = hljs.highlightAuto(code).value;
        }
        if (wrap) {
            highlighted = '<code class="hljs">' + highlighted + '</code>';
        }
        if (wrapPre) {
            highlighted = '<pre>' + highlighted + '</pre>';
        }
        defer.resolve(highlighted);
        return defer.promise;
    }
    packadic.highlight = highlight;
    function makeSlimScroll(el, opts) {
        if (opts === void 0) { opts = {}; }
        var $el = typeof (el) === 'string' ? $(el) : el;
        $el.each(function () {
            if ($(this).attr("data-initialized")) {
                return;
            }
            var height;
            if ($(this).attr("data-height")) {
                height = $(this).attr("data-height");
            }
            else {
                height = $(this).css('height');
            }
            var o = packadic.app.config('vendor.slimscroll');
            $(this).slimScroll(_.merge(o, {
                color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : o.color),
                wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : o.wrapperClass),
                railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : o.railColor),
                height: height,
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : o.alwaysVisible),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : o.railVisible)
            }, opts));
            $(this).attr("data-initialized", "1");
        });
    }
    packadic.makeSlimScroll = makeSlimScroll;
    function destroySlimScroll(el) {
        var $el = typeof (el) === 'string' ? $(el) : el;
        $el.each(function () {
            if ($(this).attr("data-initialized") === "1") {
                $(this).removeAttr("data-initialized");
                $(this).removeAttr("style");
                var attrList = {};
                if ($(this).attr("data-handle-color")) {
                    attrList["data-handle-color"] = $(this).attr("data-handle-color");
                }
                if ($(this).attr("data-wrapper-class")) {
                    attrList["data-wrapper-class"] = $(this).attr("data-wrapper-class");
                }
                if ($(this).attr("data-rail-color")) {
                    attrList["data-rail-color"] = $(this).attr("data-rail-color");
                }
                if ($(this).attr("data-always-visible")) {
                    attrList["data-always-visible"] = $(this).attr("data-always-visible");
                }
                if ($(this).attr("data-rail-visible")) {
                    attrList["data-rail-visible"] = $(this).attr("data-rail-visible");
                }
                $(this).slimScroll({
                    wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                    destroy: true
                });
                var the = $(this);
                $.each(attrList, function (key, value) {
                    the.attr(key, value);
                });
            }
        });
    }
    packadic.destroySlimScroll = destroySlimScroll;
    function registerHelperPlugins() {
        if (packadic.kindOf($.fn.prefixedData) === 'function') {
            return;
        }
        $.fn.prefixedData = function (prefix) {
            var origData = $(this).first().data();
            var data = {};
            for (var p in origData) {
                var pattern = new RegExp("^" + prefix + "[A-Z]+");
                if (origData.hasOwnProperty(p) && pattern.test(p)) {
                    var shortName = p[prefix.length].toLowerCase() + p.substr(prefix.length + 1);
                    data[shortName] = origData[p];
                }
            }
            return data;
        };
        $.fn.removeAttributes = function () {
            return this.each(function () {
                var attributes = $.map(this.attributes, function (item) {
                    return item.name;
                });
                var img = $(this);
                $.each(attributes, function (i, item) {
                    img.removeAttr(item);
                });
            });
        };
        $.fn.ensureClass = function (clas, has) {
            if (has === void 0) { has = true; }
            var $this = $(this);
            if (has === true && $this.hasClass(clas) === false) {
                $this.addClass(clas);
            }
            else if (has === false && $this.hasClass(clas) === true) {
                $this.removeClass(clas);
            }
            return this;
        };
        $.fn.onClick = function () {
            var args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                args[_i - 0] = arguments[_i];
            }
            var $this = $(this);
            return $this.on.apply($this, [packadic.isTouchDevice() ? 'touchend' : 'click'].concat(args));
        };
    }
    packadic.registerHelperPlugins = registerHelperPlugins;
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        var JSON;
        (function (JSON) {
            var old_json = JSON;
            function stringify(obj) {
                return old_json.stringify(obj, function (key, value) {
                    if (value instanceof Function || typeof value == 'function') {
                        return value.toString();
                    }
                    if (value instanceof RegExp) {
                        return '_PxEgEr_' + value;
                    }
                    return value;
                });
            }
            JSON.stringify = stringify;
            function parse(str, date2obj) {
                var iso8061 = date2obj ? /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/ : false;
                return old_json.parse(str, function (key, value) {
                    var prefix;
                    if (typeof value != 'string') {
                        return value;
                    }
                    if (value.length < 8) {
                        return value;
                    }
                    prefix = value.substring(0, 8);
                    if (iso8061 && value.match(iso8061)) {
                        return new Date(value);
                    }
                    if (prefix === 'function') {
                        return eval('(' + value + ')');
                    }
                    if (prefix === '_PxEgEr_') {
                        return eval(value.slice(8));
                    }
                    return value;
                });
            }
            JSON.parse = parse;
            function clone(obj, date2obj) {
                return parse(stringify(obj), date2obj);
            }
            JSON.clone = clone;
        })(JSON = util.JSON || (util.JSON = {}));
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        util.str = s;
        util.arr = _;
        util.openWindowDefaults = {
            width: 600,
            height: 600
        };
        function openWindow(opts) {
            if (opts === void 0) { opts = {}; }
            opts = $.extend({}, util.openWindowDefaults, opts);
            var win = window.open('', '', 'width=' + opts.width + ', height=' + opts.height);
            if (packadic.defined(opts.content)) {
                win.document.body.innerHTML = opts.content;
            }
            return win;
        }
        util.openWindow = openWindow;
        function codeIndentFix(str) {
            var fix = function (code, leading) {
                if (leading === void 0) { leading = true; }
                var txt = code;
                if (leading) {
                    txt = txt.replace(/^[\r\n]+/, "").replace(/\s+$/g, "");
                }
                if (/^\S/gm.test(txt)) {
                    return code;
                }
                var mat, str, re = /^[\t ]+/gm, len, min = 1e3;
                while (mat = re.exec(txt)) {
                    len = mat[0].length;
                    if (len < min) {
                        min = len;
                        str = mat[0];
                    }
                }
                if (min == 1e3)
                    return code;
                return txt.replace(new RegExp("^" + str, 'gm'), "");
            };
            return fix(str);
        }
        util.codeIndentFix = codeIndentFix;
        function preCodeIndentFix(el) {
            return codeIndentFix(el.textContent);
        }
        util.preCodeIndentFix = preCodeIndentFix;
        var num;
        (function (num) {
            function round(value, places) {
                var multiplier = Math.pow(10, places);
                return (Math.round(value * multiplier) / multiplier);
            }
            num.round = round;
        })(num = util.num || (util.num = {}));
        function makeString(object) {
            if (object == null)
                return '';
            return '' + object;
        }
        util.makeString = makeString;
        function defaultToWhiteSpace(characters) {
            if (characters == null)
                return '\\s';
            else if (characters.source)
                return characters.source;
            else
                return '[' + util.str.escapeRegExp(characters) + ']';
        }
        util.defaultToWhiteSpace = defaultToWhiteSpace;
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        var material;
        (function (material) {
            var materialColors = {
                'red': {
                    '50': '#ffebee',
                    '100': '#ffcdd2',
                    '200': '#ef9a9a',
                    '300': '#e57373',
                    '400': '#ef5350',
                    '500': '#f44336',
                    '600': '#e53935',
                    '700': '#d32f2f',
                    '800': '#c62828',
                    '900': '#b71c1c',
                    'a100': '#ff8a80',
                    'a200': '#ff5252',
                    'a400': '#ff1744',
                    'a700': '#d50000',
                },
                'pink': {
                    '50': '#fce4ec',
                    '100': '#f8bbd0',
                    '200': '#f48fb1',
                    '300': '#f06292',
                    '400': '#ec407a',
                    '500': '#e91e63',
                    '600': '#d81b60',
                    '700': '#c2185b',
                    '800': '#ad1457',
                    '900': '#880e4f',
                    'a100': '#ff80ab',
                    'a200': '#ff4081',
                    'a400': '#f50057',
                    'a700': '#c51162',
                },
                'purple': {
                    '50': '#f3e5f5',
                    '100': '#e1bee7',
                    '200': '#ce93d8',
                    '300': '#ba68c8',
                    '400': '#ab47bc',
                    '500': '#9c27b0',
                    '600': '#8e24aa',
                    '700': '#7b1fa2',
                    '800': '#6a1b9a',
                    '900': '#4a148c',
                    'a100': '#ea80fc',
                    'a200': '#e040fb',
                    'a400': '#d500f9',
                    'a700': '#aa00ff',
                },
                'deep-purple': {
                    '50': '#ede7f6',
                    '100': '#d1c4e9',
                    '200': '#b39ddb',
                    '300': '#9575cd',
                    '400': '#7e57c2',
                    '500': '#673ab7',
                    '600': '#5e35b1',
                    '700': '#512da8',
                    '800': '#4527a0',
                    '900': '#311b92',
                    'a100': '#b388ff',
                    'a200': '#7c4dff',
                    'a400': '#651fff',
                    'a700': '#6200ea',
                },
                'indigo': {
                    '50': '#e8eaf6',
                    '100': '#c5cae9',
                    '200': '#9fa8da',
                    '300': '#7986cb',
                    '400': '#5c6bc0',
                    '500': '#3f51b5',
                    '600': '#3949ab',
                    '700': '#303f9f',
                    '800': '#283593',
                    '900': '#1a237e',
                    'a100': '#8c9eff',
                    'a200': '#536dfe',
                    'a400': '#3d5afe',
                    'a700': '#304ffe',
                },
                'blue': {
                    '50': '#e3f2fd',
                    '100': '#bbdefb',
                    '200': '#90caf9',
                    '300': '#64b5f6',
                    '400': '#42a5f5',
                    '500': '#2196f3',
                    '600': '#1e88e5',
                    '700': '#1976d2',
                    '800': '#1565c0',
                    '900': '#0d47a1',
                    'a100': '#82b1ff',
                    'a200': '#448aff',
                    'a400': '#2979ff',
                    'a700': '#2962ff',
                },
                'light-blue': {
                    '50': '#e1f5fe',
                    '100': '#b3e5fc',
                    '200': '#81d4fa',
                    '300': '#4fc3f7',
                    '400': '#29b6f6',
                    '500': '#03a9f4',
                    '600': '#039be5',
                    '700': '#0288d1',
                    '800': '#0277bd',
                    '900': '#01579b',
                    'a100': '#80d8ff',
                    'a200': '#40c4ff',
                    'a400': '#00b0ff',
                    'a700': '#0091ea',
                },
                'cyan': {
                    '50': '#e0f7fa',
                    '100': '#b2ebf2',
                    '200': '#80deea',
                    '300': '#4dd0e1',
                    '400': '#26c6da',
                    '500': '#00bcd4',
                    '600': '#00acc1',
                    '700': '#0097a7',
                    '800': '#00838f',
                    '900': '#006064',
                    'a100': '#84ffff',
                    'a200': '#18ffff',
                    'a400': '#00e5ff',
                    'a700': '#00b8d4',
                },
                'teal': {
                    '50': '#e0f2f1',
                    '100': '#b2dfdb',
                    '200': '#80cbc4',
                    '300': '#4db6ac',
                    '400': '#26a69a',
                    '500': '#009688',
                    '600': '#00897b',
                    '700': '#00796b',
                    '800': '#00695c',
                    '900': '#004d40',
                    'a100': '#a7ffeb',
                    'a200': '#64ffda',
                    'a400': '#1de9b6',
                    'a700': '#00bfa5',
                },
                'green': {
                    '50': '#e8f5e9',
                    '100': '#c8e6c9',
                    '200': '#a5d6a7',
                    '300': '#81c784',
                    '400': '#66bb6a',
                    '500': '#4caf50',
                    '600': '#43a047',
                    '700': '#388e3c',
                    '800': '#2e7d32',
                    '900': '#1b5e20',
                    'a100': '#b9f6ca',
                    'a200': '#69f0ae',
                    'a400': '#00e676',
                    'a700': '#00c853',
                },
                'light-green': {
                    '50': '#f1f8e9',
                    '100': '#dcedc8',
                    '200': '#c5e1a5',
                    '300': '#aed581',
                    '400': '#9ccc65',
                    '500': '#8bc34a',
                    '600': '#7cb342',
                    '700': '#689f38',
                    '800': '#558b2f',
                    '900': '#33691e',
                    'a100': '#ccff90',
                    'a200': '#b2ff59',
                    'a400': '#76ff03',
                    'a700': '#64dd17',
                },
                'lime': {
                    '50': '#f9fbe7',
                    '100': '#f0f4c3',
                    '200': '#e6ee9c',
                    '300': '#dce775',
                    '400': '#d4e157',
                    '500': '#cddc39',
                    '600': '#c0ca33',
                    '700': '#afb42b',
                    '800': '#9e9d24',
                    '900': '#827717',
                    'a100': '#f4ff81',
                    'a200': '#eeff41',
                    'a400': '#c6ff00',
                    'a700': '#aeea00',
                },
                'yellow': {
                    '50': '#fffde7',
                    '100': '#fff9c4',
                    '200': '#fff59d',
                    '300': '#fff176',
                    '400': '#ffee58',
                    '500': '#ffeb3b',
                    '600': '#fdd835',
                    '700': '#fbc02d',
                    '800': '#f9a825',
                    '900': '#f57f17',
                    'a100': '#ffff8d',
                    'a200': '#ffff00',
                    'a400': '#ffea00',
                    'a700': '#ffd600',
                },
                'amber': {
                    '50': '#fff8e1',
                    '100': '#ffecb3',
                    '200': '#ffe082',
                    '300': '#ffd54f',
                    '400': '#ffca28',
                    '500': '#ffc107',
                    '600': '#ffb300',
                    '700': '#ffa000',
                    '800': '#ff8f00',
                    '900': '#ff6f00',
                    'a100': '#ffe57f',
                    'a200': '#ffd740',
                    'a400': '#ffc400',
                    'a700': '#ffab00',
                },
                'orange': {
                    '50': '#fff3e0',
                    '100': '#ffe0b2',
                    '200': '#ffcc80',
                    '300': '#ffb74d',
                    '400': '#ffa726',
                    '500': '#ff9800',
                    '600': '#fb8c00',
                    '700': '#f57c00',
                    '800': '#ef6c00',
                    '900': '#e65100',
                    'a100': '#ffd180',
                    'a200': '#ffab40',
                    'a400': '#ff9100',
                    'a700': '#ff6d00',
                },
                'deep-orange': {
                    '50': '#fbe9e7',
                    '100': '#ffccbc',
                    '200': '#ffab91',
                    '300': '#ff8a65',
                    '400': '#ff7043',
                    '500': '#ff5722',
                    '600': '#f4511e',
                    '700': '#e64a19',
                    '800': '#d84315',
                    '900': '#bf360c',
                    'a100': '#ff9e80',
                    'a200': '#ff6e40',
                    'a400': '#ff3d00',
                    'a700': '#dd2c00',
                },
                'brown': {
                    '50': '#efebe9',
                    '100': '#d7ccc8',
                    '200': '#bcaaa4',
                    '300': '#a1887f',
                    '400': '#8d6e63',
                    '500': '#795548',
                    '600': '#6d4c41',
                    '700': '#5d4037',
                    '800': '#4e342e',
                    '900': '#3e2723',
                },
                'grey': {
                    '50': '#fafafa',
                    '100': '#f5f5f5',
                    '200': '#eeeeee',
                    '300': '#e0e0e0',
                    '400': '#bdbdbd',
                    '500': '#9e9e9e',
                    '600': '#757575',
                    '700': '#616161',
                    '800': '#424242',
                    '900': '#212121',
                },
                'blue-grey': {
                    '50': '#eceff1',
                    '100': '#cfd8dc',
                    '200': '#b0bec5',
                    '300': '#90a4ae',
                    '400': '#78909c',
                    '500': '#607d8b',
                    '600': '#546e7a',
                    '700': '#455a64',
                    '800': '#37474f',
                    '900': '#263238',
                    '1000': '#11171a',
                }
            };
            material.colors = materialColors;
            function color(name, variant, prefixHexSymbol) {
                if (variant === void 0) { variant = '500'; }
                if (prefixHexSymbol === void 0) { prefixHexSymbol = true; }
                if (typeof material.colors[name] === 'object' && typeof material.colors[name][variant] === 'string') {
                    return prefixHexSymbol ? material.colors[name][variant] : material.colors[name][variant].replace('#', '');
                }
                throw new Error('Could not find color [' + name + '] variant [' + variant + '] in materials.color()');
            }
            material.color = color;
        })(material = util.material || (util.material = {}));
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        var obj;
        (function (obj_1) {
            function getParts(str) {
                return str.replace(/\\\./g, '\uffff').split('.').map(function (s) {
                    return s.replace(/\uffff/g, '.');
                });
            }
            obj_1.getParts = getParts;
            function objectGet(obj, parts, create) {
                if (typeof parts === 'string') {
                    parts = getParts(parts);
                }
                var part;
                while (typeof obj === 'object' && obj && parts.length) {
                    part = parts.shift();
                    if (!(part in obj) && create) {
                        obj[part] = {};
                    }
                    obj = obj[part];
                }
                return obj;
            }
            obj_1.objectGet = objectGet;
            function objectSet(obj, parts, value) {
                parts = getParts(parts);
                var prop = parts.pop();
                obj = objectGet(obj, parts, true);
                if (obj && typeof obj === 'object') {
                    return (obj[prop] = value);
                }
            }
            obj_1.objectSet = objectSet;
            function objectExists(obj, parts) {
                parts = getParts(parts);
                var prop = parts.pop();
                obj = objectGet(obj, parts);
                return typeof obj === 'object' && obj && prop in obj;
            }
            obj_1.objectExists = objectExists;
            function recurse(value, fn, fnContinue) {
                function recurse(value, fn, fnContinue, state) {
                    var error;
                    if (state.objs.indexOf(value) !== -1) {
                        error = new Error('Circular reference detected (' + state.path + ')');
                        error.path = state.path;
                        throw error;
                    }
                    var obj, key;
                    if (fnContinue && fnContinue(value) === false) {
                        return value;
                    }
                    else if (packadic.kindOf(value) === 'array') {
                        return value.map(function (item, index) {
                            return recurse(item, fn, fnContinue, {
                                objs: state.objs.concat([value]),
                                path: state.path + '[' + index + ']',
                            });
                        });
                    }
                    else if (packadic.kindOf(value) === 'object') {
                        obj = {};
                        for (key in value) {
                            obj[key] = recurse(value[key], fn, fnContinue, {
                                objs: state.objs.concat([value]),
                                path: state.path + (/\W/.test(key) ? '["' + key + '"]' : '.' + key),
                            });
                        }
                        return obj;
                    }
                    else {
                        return fn(value);
                    }
                }
                return recurse(value, fn, fnContinue, { objs: [], path: '' });
            }
            obj_1.recurse = recurse;
            function copyObject(object) {
                var objectCopy = {};
                for (var key in object) {
                    if (object.hasOwnProperty(key)) {
                        objectCopy[key] = object[key];
                    }
                }
                return objectCopy;
            }
            obj_1.copyObject = copyObject;
            function dotize(obj, prefix) {
                if (!obj || typeof obj != "object") {
                    if (prefix) {
                        var newObj = {};
                        newObj[prefix] = obj;
                        return newObj;
                    }
                    else
                        return obj;
                }
                var newObj = {};
                function recurse(o, p, isArrayItem) {
                    for (var f in o) {
                        if (o[f] && typeof o[f] === "object") {
                            if (Array.isArray(o[f]))
                                newObj = recurse(o[f], (p ? p : "") + (isNumber(f) ? "[" + f + "]" : "." + f), true);
                            else {
                                if (isArrayItem)
                                    newObj = recurse(o[f], (p ? p : "") + "[" + f + "]");
                                else
                                    newObj = recurse(o[f], (p ? p + "." : "") + f);
                            }
                        }
                        else {
                            if (isArrayItem || isNumber(f))
                                newObj[p + "[" + f + "]"] = o[f];
                            else
                                newObj[(p ? p + "." : "") + f] = o[f];
                        }
                    }
                    if (isEmptyObj(newObj))
                        return obj;
                    return newObj;
                }
                function isNumber(f) {
                    return !isNaN(parseInt(f));
                }
                function isEmptyObj(obj) {
                    for (var prop in obj) {
                        if (obj.hasOwnProperty(prop))
                            return false;
                    }
                    return true;
                }
                return recurse(obj, prefix);
            }
            obj_1.dotize = dotize;
            function applyMixins(derivedCtor, baseCtors) {
                baseCtors.forEach(function (baseCtor) {
                    Object.getOwnPropertyNames(baseCtor.prototype).forEach(function (name) {
                        derivedCtor.prototype[name] = baseCtor.prototype[name];
                    });
                });
            }
            obj_1.applyMixins = applyMixins;
            var DependencySorter = (function () {
                function DependencySorter() {
                    this.items = [];
                    this.dependencies = {};
                    this.dependsOn = {};
                    this.missing = {};
                    this.circular = {};
                    this.hits = {};
                    this.sorted = {};
                }
                DependencySorter.prototype.add = function (items) {
                    var _this = this;
                    Object.keys(items).forEach(function (name) {
                        _this.addItem(name, items[name]);
                    });
                };
                DependencySorter.prototype.addItem = function (name, deps) {
                    if (typeof deps === 'undefined') {
                        deps = deps || [];
                    }
                    else if (typeof deps === 'string') {
                        deps = deps.toString().split(/,\s?/);
                    }
                    this.setItem(name, deps);
                };
                DependencySorter.prototype.setItem = function (name, deps) {
                    var _this = this;
                    this.items.push(name);
                    deps.forEach(function (dep) {
                        _this.items.push(dep);
                        if (!_this.dependsOn[dep]) {
                            _this.dependsOn[dep] = {};
                        }
                        _this.dependsOn[dep][name] = name;
                        _this.hits[dep] = 0;
                    });
                    this.items = _.uniq(this.items);
                    this.dependencies[name] = deps;
                    this.hits[name] = 0;
                };
                DependencySorter.prototype.sort = function () {
                    var _this = this;
                    this.sorted = [];
                    var hasChanged = true;
                    while (this.sorted.length < this.items.length && hasChanged) {
                        hasChanged = false;
                        Object.keys(this.dependencies).forEach(function (item) {
                            if (_this.satisfied(item)) {
                                _this.setSorted(item);
                                _this.removeDependents(item);
                                hasChanged = true;
                            }
                            _this.hits[item]++;
                        });
                    }
                    return this.sorted;
                };
                DependencySorter.prototype.satisfied = function (name) {
                    var _this = this;
                    var pass = true;
                    this.getDependents(name).forEach(function (dep) {
                        if (_this.isSorted(dep)) {
                            return;
                        }
                        if (!_this.exists(name)) {
                            _this.setMissing(name, dep);
                            if (pass) {
                                pass = false;
                            }
                        }
                        if (_this.hasDependents(dep)) {
                            if (pass) {
                                pass = false;
                            }
                        }
                        else {
                            _this.setFound(name, dep);
                        }
                        if (_this.isDependent(name, dep)) {
                            _this.setCircular(name, dep);
                            if (pass) {
                                pass = false;
                            }
                        }
                    });
                    return pass;
                };
                DependencySorter.prototype.setSorted = function (item) {
                    this.sorted.push(item);
                };
                DependencySorter.prototype.exists = function (item) {
                    return this.items.indexOf(item) !== -1;
                };
                DependencySorter.prototype.removeDependents = function (item) {
                    delete this.dependencies[item];
                };
                DependencySorter.prototype.setCircular = function (item, item2) {
                    this.circular[item] = this.circular[item] || {};
                    this.circular[item][item2] = item2;
                };
                DependencySorter.prototype.setMissing = function (item, item2) {
                    this.missing[item] = this.missing[item] || {};
                    this.missing[item][item2] = item2;
                };
                DependencySorter.prototype.setFound = function (item, item2) {
                    if (typeof this.missing[item] !== 'undefined') {
                        delete this.missing[item][item2];
                        if (Object.keys(this.missing[item]).length > 0) {
                            delete this.missing[item];
                        }
                    }
                };
                DependencySorter.prototype.isSorted = function (item) {
                    return typeof this.sorted[item] !== 'undefined';
                };
                DependencySorter.prototype.requiredBy = function (item) {
                    return typeof this.dependsOn[item] !== 'undefined' ? this.dependsOn[item] : [];
                };
                DependencySorter.prototype.isDependent = function (item, item2) {
                    return typeof this.dependsOn[item] !== 'undefined' && typeof this.dependsOn[item][item2] !== 'undefined';
                };
                DependencySorter.prototype.hasDependents = function (item) {
                    return typeof this.dependencies[item] !== 'undefined';
                };
                DependencySorter.prototype.hasMissing = function (item) {
                    return typeof this.missing[item] !== 'undefined';
                };
                DependencySorter.prototype.isMissing = function (dep) {
                    var _this = this;
                    var missing = false;
                    Object.keys(this.missing).forEach(function (item) {
                        var deps = _this.missing[item];
                        if (deps.indexOf(dep) !== -1) {
                            missing = true;
                        }
                    });
                    return missing;
                };
                DependencySorter.prototype.hasCircular = function (item) {
                    return typeof this.circular[item] !== 'undefined';
                };
                DependencySorter.prototype.isCircular = function (dep) {
                    var _this = this;
                    var circular = false;
                    Object.keys(this.circular).forEach(function (item) {
                        var deps = _this.circular[item];
                        if (deps.indexOf(dep) !== -1) {
                            circular = true;
                        }
                    });
                    return circular;
                };
                DependencySorter.prototype.getDependents = function (item) {
                    return this.dependencies[item];
                };
                DependencySorter.prototype.getMissing = function (str) {
                    if (typeof str === 'string') {
                        return this.missing[str];
                    }
                    return this.missing;
                };
                DependencySorter.prototype.getCircular = function (str) {
                    if (typeof str === 'string') {
                        return this.circular[str];
                    }
                    return this.circular;
                };
                DependencySorter.prototype.getHits = function (str) {
                    if (typeof str === 'string') {
                        return this.hits[str];
                    }
                    return this.hits;
                };
                return DependencySorter;
            })();
            obj_1.DependencySorter = DependencySorter;
        })(obj = util.obj || (util.obj = {}));
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Christian Speckner
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
'use strict';
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        var promise;
        (function (promise) {
            function create() {
                return new Deferred(DispatchDeferred);
            }
            promise.create = create;
            function when(value) {
                if (value instanceof Promise) {
                    return value;
                }
                return create().resolve(value).promise;
            }
            promise.when = when;
            function DispatchDeferred(closure) {
                setTimeout(closure, 0);
            }
            var PromiseState;
            (function (PromiseState) {
                PromiseState[PromiseState["Pending"] = 0] = "Pending";
                PromiseState[PromiseState["ResolutionInProgress"] = 1] = "ResolutionInProgress";
                PromiseState[PromiseState["Resolved"] = 2] = "Resolved";
                PromiseState[PromiseState["Rejected"] = 3] = "Rejected";
            })(PromiseState || (PromiseState = {}));
            var Client = (function () {
                function Client(_dispatcher, _successCB, _errorCB) {
                    this._dispatcher = _dispatcher;
                    this._successCB = _successCB;
                    this._errorCB = _errorCB;
                    this.result = new Deferred(_dispatcher);
                }
                Client.prototype.resolve = function (value, defer) {
                    var _this = this;
                    if (typeof (this._successCB) !== 'function') {
                        this.result.resolve(value);
                        return;
                    }
                    if (defer) {
                        this._dispatcher(function () { return _this._dispatchCallback(_this._successCB, value); });
                    }
                    else {
                        this._dispatchCallback(this._successCB, value);
                    }
                };
                Client.prototype.reject = function (error, defer) {
                    var _this = this;
                    if (typeof (this._errorCB) !== 'function') {
                        this.result.reject(error);
                        return;
                    }
                    if (defer) {
                        this._dispatcher(function () { return _this._dispatchCallback(_this._errorCB, error); });
                    }
                    else {
                        this._dispatchCallback(this._errorCB, error);
                    }
                };
                Client.prototype._dispatchCallback = function (callback, arg) {
                    var result, then, type;
                    try {
                        result = callback(arg);
                        this.result.resolve(result);
                    }
                    catch (err) {
                        this.result.reject(err);
                        return;
                    }
                };
                return Client;
            })();
            var Deferred = (function () {
                function Deferred(_dispatcher) {
                    this._dispatcher = _dispatcher;
                    this._stack = [];
                    this._state = PromiseState.Pending;
                    this.promise = new Promise(this);
                }
                Deferred.prototype._then = function (successCB, errorCB) {
                    if (typeof (successCB) !== 'function' && typeof (errorCB) !== 'function') {
                        return this.promise;
                    }
                    var client = new Client(this._dispatcher, successCB, errorCB);
                    switch (this._state) {
                        case PromiseState.Pending:
                        case PromiseState.ResolutionInProgress:
                            this._stack.push(client);
                            break;
                        case PromiseState.Resolved:
                            client.resolve(this._value, true);
                            break;
                        case PromiseState.Rejected:
                            client.reject(this._error, true);
                            break;
                    }
                    return client.result.promise;
                };
                Deferred.prototype.resolve = function (value) {
                    if (this._state !== PromiseState.Pending) {
                        return this;
                    }
                    return this._resolve(value);
                };
                Deferred.prototype._resolve = function (value) {
                    var _this = this;
                    var type = typeof (value), then, pending = true;
                    try {
                        if (value !== null &&
                            (type === 'object' || type === 'function') &&
                            typeof (then = value.then) === 'function') {
                            if (value === this.promise) {
                                throw new TypeError('recursive resolution');
                            }
                            this._state = PromiseState.ResolutionInProgress;
                            then.call(value, function (result) {
                                if (pending) {
                                    pending = false;
                                    _this._resolve(result);
                                }
                            }, function (error) {
                                if (pending) {
                                    pending = false;
                                    _this._reject(error);
                                }
                            });
                        }
                        else {
                            this._state = PromiseState.ResolutionInProgress;
                            this._dispatcher(function () {
                                _this._state = PromiseState.Resolved;
                                _this._value = value;
                                var i, stackSize = _this._stack.length;
                                for (i = 0; i < stackSize; i++) {
                                    _this._stack[i].resolve(value, false);
                                }
                                _this._stack.splice(0, stackSize);
                            });
                        }
                    }
                    catch (err) {
                        if (pending) {
                            this._reject(err);
                        }
                    }
                    return this;
                };
                Deferred.prototype.reject = function (error) {
                    if (this._state !== PromiseState.Pending) {
                        return this;
                    }
                    return this._reject(error);
                };
                Deferred.prototype._reject = function (error) {
                    var _this = this;
                    this._state = PromiseState.ResolutionInProgress;
                    this._dispatcher(function () {
                        _this._state = PromiseState.Rejected;
                        _this._error = error;
                        var stackSize = _this._stack.length, i = 0;
                        for (i = 0; i < stackSize; i++) {
                            _this._stack[i].reject(error, false);
                        }
                        _this._stack.splice(0, stackSize);
                    });
                    return this;
                };
                return Deferred;
            })();
            var Promise = (function () {
                function Promise(_deferred) {
                    this._deferred = _deferred;
                }
                Promise.prototype.then = function (successCB, errorCB) {
                    return this._deferred._then(successCB, errorCB);
                };
                Promise.prototype.otherwise = function (errorCB) {
                    return this._deferred._then(undefined, errorCB);
                };
                Promise.prototype.always = function (errorCB) {
                    return this._deferred._then(errorCB, errorCB);
                };
                return Promise;
            })();
        })(promise = util.promise || (util.promise = {}));
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
var packadic;
(function (packadic) {
    var util;
    (function (util) {
        var version;
        (function (version_1) {
            var expr = {};
            expr.SEMVER_SPEC_VERSION = '2.0.0';
            var MAX_LENGTH = 256;
            var MAX_SAFE_INTEGER = Number.MAX_VALUE || 9007199254740991;
            var re = expr.re = [];
            var src = expr.src = [];
            var R = 0;
            var NUMERICIDENTIFIER = R++;
            src[NUMERICIDENTIFIER] = '0|[1-9]\\d*';
            var NUMERICIDENTIFIERLOOSE = R++;
            src[NUMERICIDENTIFIERLOOSE] = '[0-9]+';
            var NONNUMERICIDENTIFIER = R++;
            src[NONNUMERICIDENTIFIER] = '\\d*[a-zA-Z-][a-zA-Z0-9-]*';
            var MAINVERSION = R++;
            src[MAINVERSION] = '(' + src[NUMERICIDENTIFIER] + ')\\.' +
                '(' + src[NUMERICIDENTIFIER] + ')\\.' +
                '(' + src[NUMERICIDENTIFIER] + ')';
            var MAINVERSIONLOOSE = R++;
            src[MAINVERSIONLOOSE] = '(' + src[NUMERICIDENTIFIERLOOSE] + ')\\.' +
                '(' + src[NUMERICIDENTIFIERLOOSE] + ')\\.' +
                '(' + src[NUMERICIDENTIFIERLOOSE] + ')';
            var PRERELEASEIDENTIFIER = R++;
            src[PRERELEASEIDENTIFIER] = '(?:' + src[NUMERICIDENTIFIER] +
                '|' + src[NONNUMERICIDENTIFIER] + ')';
            var PRERELEASEIDENTIFIERLOOSE = R++;
            src[PRERELEASEIDENTIFIERLOOSE] = '(?:' + src[NUMERICIDENTIFIERLOOSE] +
                '|' + src[NONNUMERICIDENTIFIER] + ')';
            var PRERELEASE = R++;
            src[PRERELEASE] = '(?:-(' + src[PRERELEASEIDENTIFIER] +
                '(?:\\.' + src[PRERELEASEIDENTIFIER] + ')*))';
            var PRERELEASELOOSE = R++;
            src[PRERELEASELOOSE] = '(?:-?(' + src[PRERELEASEIDENTIFIERLOOSE] +
                '(?:\\.' + src[PRERELEASEIDENTIFIERLOOSE] + ')*))';
            var BUILDIDENTIFIER = R++;
            src[BUILDIDENTIFIER] = '[0-9A-Za-z-]+';
            var BUILD = R++;
            src[BUILD] = '(?:\\+(' + src[BUILDIDENTIFIER] +
                '(?:\\.' + src[BUILDIDENTIFIER] + ')*))';
            var FULL = R++;
            var FULLPLAIN = 'v?' + src[MAINVERSION] +
                src[PRERELEASE] + '?' +
                src[BUILD] + '?';
            src[FULL] = '^' + FULLPLAIN + '$';
            var LOOSEPLAIN = '[v=\\s]*' + src[MAINVERSIONLOOSE] +
                src[PRERELEASELOOSE] + '?' +
                src[BUILD] + '?';
            var LOOSE = R++;
            src[LOOSE] = '^' + LOOSEPLAIN + '$';
            var GTLT = R++;
            src[GTLT] = '((?:<|>)?=?)';
            var XRANGEIDENTIFIERLOOSE = R++;
            src[XRANGEIDENTIFIERLOOSE] = src[NUMERICIDENTIFIERLOOSE] + '|x|X|\\*';
            var XRANGEIDENTIFIER = R++;
            src[XRANGEIDENTIFIER] = src[NUMERICIDENTIFIER] + '|x|X|\\*';
            var XRANGEPLAIN = R++;
            src[XRANGEPLAIN] = '[v=\\s]*(' + src[XRANGEIDENTIFIER] + ')' +
                '(?:\\.(' + src[XRANGEIDENTIFIER] + ')' +
                '(?:\\.(' + src[XRANGEIDENTIFIER] + ')' +
                '(?:' + src[PRERELEASE] + ')?' +
                src[BUILD] + '?' +
                ')?)?';
            var XRANGEPLAINLOOSE = R++;
            src[XRANGEPLAINLOOSE] = '[v=\\s]*(' + src[XRANGEIDENTIFIERLOOSE] + ')' +
                '(?:\\.(' + src[XRANGEIDENTIFIERLOOSE] + ')' +
                '(?:\\.(' + src[XRANGEIDENTIFIERLOOSE] + ')' +
                '(?:' + src[PRERELEASELOOSE] + ')?' +
                src[BUILD] + '?' +
                ')?)?';
            var XRANGE = R++;
            src[XRANGE] = '^' + src[GTLT] + '\\s*' + src[XRANGEPLAIN] + '$';
            var XRANGELOOSE = R++;
            src[XRANGELOOSE] = '^' + src[GTLT] + '\\s*' + src[XRANGEPLAINLOOSE] + '$';
            var LONETILDE = R++;
            src[LONETILDE] = '(?:~>?)';
            var TILDETRIM = R++;
            src[TILDETRIM] = '(\\s*)' + src[LONETILDE] + '\\s+';
            re[TILDETRIM] = new RegExp(src[TILDETRIM], 'g');
            var tildeTrimReplace = '$1~';
            var TILDE = R++;
            src[TILDE] = '^' + src[LONETILDE] + src[XRANGEPLAIN] + '$';
            var TILDELOOSE = R++;
            src[TILDELOOSE] = '^' + src[LONETILDE] + src[XRANGEPLAINLOOSE] + '$';
            var LONECARET = R++;
            src[LONECARET] = '(?:\\^)';
            var CARETTRIM = R++;
            src[CARETTRIM] = '(\\s*)' + src[LONECARET] + '\\s+';
            re[CARETTRIM] = new RegExp(src[CARETTRIM], 'g');
            var caretTrimReplace = '$1^';
            var CARET = R++;
            src[CARET] = '^' + src[LONECARET] + src[XRANGEPLAIN] + '$';
            var CARETLOOSE = R++;
            src[CARETLOOSE] = '^' + src[LONECARET] + src[XRANGEPLAINLOOSE] + '$';
            var COMPARATORLOOSE = R++;
            src[COMPARATORLOOSE] = '^' + src[GTLT] + '\\s*(' + LOOSEPLAIN + ')$|^$';
            var COMPARATOR = R++;
            src[COMPARATOR] = '^' + src[GTLT] + '\\s*(' + FULLPLAIN + ')$|^$';
            var COMPARATORTRIM = R++;
            src[COMPARATORTRIM] = '(\\s*)' + src[GTLT] +
                '\\s*(' + LOOSEPLAIN + '|' + src[XRANGEPLAIN] + ')';
            re[COMPARATORTRIM] = new RegExp(src[COMPARATORTRIM], 'g');
            var comparatorTrimReplace = '$1$2$3';
            var HYPHENRANGE = R++;
            src[HYPHENRANGE] = '^\\s*(' + src[XRANGEPLAIN] + ')' +
                '\\s+-\\s+' +
                '(' + src[XRANGEPLAIN] + ')' +
                '\\s*$';
            var HYPHENRANGELOOSE = R++;
            src[HYPHENRANGELOOSE] = '^\\s*(' + src[XRANGEPLAINLOOSE] + ')' +
                '\\s+-\\s+' +
                '(' + src[XRANGEPLAINLOOSE] + ')' +
                '\\s*$';
            var STAR = R++;
            src[STAR] = '(<|>)?=?\\s*\\*';
            for (var i = 0; i < R; i++) {
                if (!re[i])
                    re[i] = new RegExp(src[i]);
            }
            function parse(version, loose) {
                if (version instanceof SemVer)
                    return version;
                if (typeof version !== 'string')
                    return null;
                if (version.length > MAX_LENGTH)
                    return null;
                var r = loose ? re[LOOSE] : re[FULL];
                if (!r.test(version))
                    return null;
                try {
                    return new SemVer(version, loose);
                }
                catch (er) {
                    return null;
                }
            }
            function valid(version, loose) {
                var v = parse(version, loose);
                return v ? v.version : null;
            }
            function clean(version, loose) {
                var s = parse(version.trim().replace(/^[=v]+/, ''), loose);
                return s ? s.version : null;
            }
            var SemVer = (function () {
                function SemVer(version, loose) {
                    if (version instanceof SemVer) {
                        if (version.loose === loose)
                            return version;
                        else
                            version = version.version;
                    }
                    else if (typeof version !== 'string') {
                        throw new TypeError('Invalid Version: ' + version);
                    }
                    if (version.length > MAX_LENGTH)
                        throw new TypeError('version is longer than ' + MAX_LENGTH + ' characters');
                    if (!(this instanceof SemVer))
                        return new SemVer(version, loose);
                    this.loose = loose;
                    var m = version.trim().match(loose ? re[LOOSE] : re[FULL]);
                    if (!m)
                        throw new TypeError('Invalid Version: ' + version);
                    this.raw = version;
                    this.major = +m[1];
                    this.minor = +m[2];
                    this.patch = +m[3];
                    if (this.major > MAX_SAFE_INTEGER || this.major < 0)
                        throw new TypeError('Invalid major version');
                    if (this.minor > MAX_SAFE_INTEGER || this.minor < 0)
                        throw new TypeError('Invalid minor version');
                    if (this.patch > MAX_SAFE_INTEGER || this.patch < 0)
                        throw new TypeError('Invalid patch version');
                    if (!m[4])
                        this.prerelease = [];
                    else
                        this.prerelease = m[4].split('.').map(function (id) {
                            if (/^[0-9]+$/.test(id)) {
                                var num = +id;
                                if (num >= 0 && num < MAX_SAFE_INTEGER)
                                    return num;
                            }
                            return id;
                        });
                    this.build = m[5] ? m[5].split('.') : [];
                    this.format();
                }
                SemVer.prototype.format = function () {
                    this.version = this.major + '.' + this.minor + '.' + this.patch;
                    if (this.prerelease.length)
                        this.version += '-' + this.prerelease.join('.');
                    return this.version;
                };
                SemVer.prototype.inspect = function () {
                    return '<SemVer "' + this + '">';
                };
                SemVer.prototype.toString = function () {
                    return this.version;
                };
                SemVer.prototype.compare = function (other) {
                    if (!(other instanceof SemVer))
                        other = new SemVer(other, this.loose);
                    return this.compareMain(other) || this.comparePre(other);
                };
                SemVer.prototype.compareMain = function (other) {
                    if (!(other instanceof SemVer))
                        other = new SemVer(other, this.loose);
                    return compareIdentifiers(this.major, other.major) ||
                        compareIdentifiers(this.minor, other.minor) ||
                        compareIdentifiers(this.patch, other.patch);
                };
                SemVer.prototype.comparePre = function (other) {
                    if (!(other instanceof SemVer))
                        other = new SemVer(other, this.loose);
                    if (this.prerelease.length && !other.prerelease.length)
                        return -1;
                    else if (!this.prerelease.length && other.prerelease.length)
                        return 1;
                    else if (!this.prerelease.length && !other.prerelease.length)
                        return 0;
                    var i = 0;
                    do {
                        var a = this.prerelease[i];
                        var b = other.prerelease[i];
                        if (a === undefined && b === undefined)
                            return 0;
                        else if (b === undefined)
                            return 1;
                        else if (a === undefined)
                            return -1;
                        else if (a === b)
                            continue;
                        else
                            return compareIdentifiers(a, b);
                    } while (++i);
                };
                SemVer.prototype.inc = function (release, identifier) {
                    switch (release) {
                        case 'premajor':
                            this.prerelease.length = 0;
                            this.patch = 0;
                            this.minor = 0;
                            this.major++;
                            this.inc('pre', identifier);
                            break;
                        case 'preminor':
                            this.prerelease.length = 0;
                            this.patch = 0;
                            this.minor++;
                            this.inc('pre', identifier);
                            break;
                        case 'prepatch':
                            this.prerelease.length = 0;
                            this.inc('patch', identifier);
                            this.inc('pre', identifier);
                            break;
                        case 'prerelease':
                            if (this.prerelease.length === 0)
                                this.inc('patch', identifier);
                            this.inc('pre', identifier);
                            break;
                        case 'major':
                            if (this.minor !== 0 || this.patch !== 0 || this.prerelease.length === 0)
                                this.major++;
                            this.minor = 0;
                            this.patch = 0;
                            this.prerelease = [];
                            break;
                        case 'minor':
                            if (this.patch !== 0 || this.prerelease.length === 0)
                                this.minor++;
                            this.patch = 0;
                            this.prerelease = [];
                            break;
                        case 'patch':
                            if (this.prerelease.length === 0)
                                this.patch++;
                            this.prerelease = [];
                            break;
                        case 'pre':
                            if (this.prerelease.length === 0)
                                this.prerelease = [0];
                            else {
                                var i = this.prerelease.length;
                                while (--i >= 0) {
                                    if (typeof this.prerelease[i] === 'number') {
                                        this.prerelease[i]++;
                                        i = -2;
                                    }
                                }
                                if (i === -1)
                                    this.prerelease.push(0);
                            }
                            if (identifier) {
                                if (this.prerelease[0] === identifier) {
                                    if (isNaN(this.prerelease[1]))
                                        this.prerelease = [identifier, 0];
                                }
                                else
                                    this.prerelease = [identifier, 0];
                            }
                            break;
                        default:
                            throw new Error('invalid increment argument: ' + release);
                    }
                    this.format();
                    return this;
                };
                return SemVer;
            })();
            version_1.SemVer = SemVer;
            function inc(version, release, loose, identifier) {
                if (typeof (loose) === 'string') {
                    identifier = loose;
                    loose = undefined;
                }
                try {
                    return new SemVer(version, loose).inc(release, identifier).version;
                }
                catch (er) {
                    return null;
                }
            }
            function diff(version1, version2) {
                if (eq(version1, version2)) {
                    return null;
                }
                else {
                    var v1 = parse(version1);
                    var v2 = parse(version2);
                    if (v1.prerelease.length || v2.prerelease.length) {
                        for (var key in v1) {
                            if (key === 'major' || key === 'minor' || key === 'patch') {
                                if (v1[key] !== v2[key]) {
                                    return 'pre' + key;
                                }
                            }
                        }
                        return 'prerelease';
                    }
                    for (var key in v1) {
                        if (key === 'major' || key === 'minor' || key === 'patch') {
                            if (v1[key] !== v2[key]) {
                                return key;
                            }
                        }
                    }
                }
            }
            var numeric = /^[0-9]+$/;
            function compareIdentifiers(a, b) {
                var anum = numeric.test(a);
                var bnum = numeric.test(b);
                if (anum && bnum) {
                    a = +a;
                    b = +b;
                }
                return (anum && !bnum) ? -1 :
                    (bnum && !anum) ? 1 :
                        a < b ? -1 :
                            a > b ? 1 :
                                0;
            }
            function rcompareIdentifiers(a, b) {
                return compareIdentifiers(b, a);
            }
            function major(a, loose) {
                return new SemVer(a, loose).major;
            }
            function minor(a, loose) {
                return new SemVer(a, loose).minor;
            }
            function patch(a, loose) {
                return new SemVer(a, loose).patch;
            }
            function compare(a, b, loose) {
                return new SemVer(a, loose).compare(b);
            }
            function compareLoose(a, b) {
                return compare(a, b, true);
            }
            function rcompare(a, b, loose) {
                return compare(b, a, loose);
            }
            function sort(list, loose) {
                return list.sort(function (a, b) {
                    return expr.compare(a, b, loose);
                });
            }
            function rsort(list, loose) {
                return list.sort(function (a, b) {
                    return expr.rcompare(a, b, loose);
                });
            }
            function gt(a, b, loose) {
                return compare(a, b, loose) > 0;
            }
            function lt(a, b, loose) {
                return compare(a, b, loose) < 0;
            }
            function eq(a, b, loose) {
                return compare(a, b, loose) === 0;
            }
            function neq(a, b, loose) {
                return compare(a, b, loose) !== 0;
            }
            function gte(a, b, loose) {
                return compare(a, b, loose) >= 0;
            }
            function lte(a, b, loose) {
                return compare(a, b, loose) <= 0;
            }
            function cmp(a, op, b, loose) {
                var ret;
                switch (op) {
                    case '===':
                        if (typeof a === 'object')
                            a = a.version;
                        if (typeof b === 'object')
                            b = b.version;
                        ret = a === b;
                        break;
                    case '!==':
                        if (typeof a === 'object')
                            a = a.version;
                        if (typeof b === 'object')
                            b = b.version;
                        ret = a !== b;
                        break;
                    case '':
                    case '=':
                    case '==':
                        ret = eq(a, b, loose);
                        break;
                    case '!=':
                        ret = neq(a, b, loose);
                        break;
                    case '>':
                        ret = gt(a, b, loose);
                        break;
                    case '>=':
                        ret = gte(a, b, loose);
                        break;
                    case '<':
                        ret = lt(a, b, loose);
                        break;
                    case '<=':
                        ret = lte(a, b, loose);
                        break;
                    default:
                        throw new TypeError('Invalid operator: ' + op);
                }
                return ret;
            }
            var Comparator = (function () {
                function Comparator(comp, loose) {
                    if (comp instanceof Comparator) {
                        if (comp.loose === loose)
                            return comp;
                        else
                            comp = comp.value;
                    }
                    if (!(this instanceof Comparator))
                        return new Comparator(comp, loose);
                    this.loose = loose;
                    this.parse(comp);
                    if (this.semver === ANY)
                        this.value = '';
                    else
                        this.value = this.operator + this.semver.version;
                }
                Comparator.prototype.parse = function (comp) {
                    var r = this.loose ? re[COMPARATORLOOSE] : re[COMPARATOR];
                    var m = comp.match(r);
                    if (!m)
                        throw new TypeError('Invalid comparator: ' + comp);
                    this.operator = m[1];
                    if (this.operator === '=')
                        this.operator = '';
                    if (!m[2])
                        this.semver = ANY;
                    else
                        this.semver = new SemVer(m[2], this.loose);
                };
                Comparator.prototype.inspect = function () {
                    return '<SemVer Comparator "' + this + '">';
                };
                Comparator.prototype.toString = function () {
                    return this.value;
                };
                Comparator.prototype.test = function (version) {
                    if (this.semver === ANY)
                        return true;
                    if (typeof version === 'string')
                        version = new SemVer(version, this.loose);
                    return cmp(version, this.operator, this.semver, this.loose);
                };
                return Comparator;
            })();
            version_1.Comparator = Comparator;
            var ANY = {};
            var VersionRange = (function () {
                function VersionRange(range, loose) {
                    if ((range instanceof VersionRange) && range.loose === loose)
                        return range;
                    if (!(this instanceof VersionRange))
                        return new VersionRange(range, loose);
                    this.loose = loose;
                    this.raw = range;
                    this.set = range.split(/\s*\|\|\s*/).map(function (range) {
                        return this.parseRange(range.trim());
                    }, this).filter(function (c) {
                        return c.length;
                    });
                    if (!this.set.length) {
                        throw new TypeError('Invalid SemVer Range: ' + range);
                    }
                    this.format();
                }
                VersionRange.prototype.inspect = function () {
                    return '<SemVer Range "' + this.range + '">';
                };
                VersionRange.prototype.format = function () {
                    this.range = this.set.map(function (comps) {
                        return comps.join(' ').trim();
                    }).join('||').trim();
                    return this.range;
                };
                VersionRange.prototype.toString = function () {
                    return this.range;
                };
                VersionRange.prototype.parseRange = function (range) {
                    var loose = this.loose;
                    range = range.trim();
                    var hr = loose ? re[HYPHENRANGELOOSE] : re[HYPHENRANGE];
                    range = range.replace(hr, hyphenReplace);
                    range = range.replace(re[COMPARATORTRIM], comparatorTrimReplace);
                    range = range.replace(re[TILDETRIM], tildeTrimReplace);
                    range = range.replace(re[CARETTRIM], caretTrimReplace);
                    range = range.split(/\s+/).join(' ');
                    var compRe = loose ? re[COMPARATORLOOSE] : re[COMPARATOR];
                    var set = range.split(' ').map(function (comp) {
                        return parseComparator(comp, loose);
                    }).join(' ').split(/\s+/);
                    if (this.loose) {
                        set = set.filter(function (comp) {
                            return !!comp.match(compRe);
                        });
                    }
                    set = set.map(function (comp) {
                        return new Comparator(comp, loose);
                    });
                    return set;
                };
                VersionRange.prototype.test = function (version) {
                    if (!version)
                        return false;
                    if (typeof version === 'string')
                        version = new SemVer(version, this.loose);
                    for (var i = 0; i < this.set.length; i++) {
                        if (testSet(this.set[i], version))
                            return true;
                    }
                    return false;
                };
                return VersionRange;
            })();
            version_1.VersionRange = VersionRange;
            function toComparators(range, loose) {
                return new VersionRange(range, loose).set.map(function (comp) {
                    return comp.map(function (c) {
                        return c.value;
                    }).join(' ').trim().split(' ');
                });
            }
            function parseComparator(comp, loose) {
                comp = replaceCarets(comp, loose);
                comp = replaceTildes(comp, loose);
                comp = replaceXRanges(comp, loose);
                comp = replaceStars(comp, loose);
                return comp;
            }
            function isX(id) {
                return !id || id.toLowerCase() === 'x' || id === '*';
            }
            function replaceTildes(comp, loose) {
                return comp.trim().split(/\s+/).map(function (comp) {
                    return replaceTilde(comp, loose);
                }).join(' ');
            }
            function replaceTilde(comp, loose) {
                var r = loose ? re[TILDELOOSE] : re[TILDE];
                return comp.replace(r, function (_, M, m, p, pr) {
                    var ret;
                    if (isX(M))
                        ret = '';
                    else if (isX(m))
                        ret = '>=' + M + '.0.0 <' + (+M + 1) + '.0.0';
                    else if (isX(p))
                        ret = '>=' + M + '.' + m + '.0 <' + M + '.' + (+m + 1) + '.0';
                    else if (pr) {
                        if (pr.charAt(0) !== '-')
                            pr = '-' + pr;
                        ret = '>=' + M + '.' + m + '.' + p + pr +
                            ' <' + M + '.' + (+m + 1) + '.0';
                    }
                    else
                        ret = '>=' + M + '.' + m + '.' + p +
                            ' <' + M + '.' + (+m + 1) + '.0';
                    return ret;
                });
            }
            function replaceCarets(comp, loose) {
                return comp.trim().split(/\s+/).map(function (comp) {
                    return replaceCaret(comp, loose);
                }).join(' ');
            }
            function replaceCaret(comp, loose) {
                var r = loose ? re[CARETLOOSE] : re[CARET];
                return comp.replace(r, function (_, M, m, p, pr) {
                    var ret;
                    if (isX(M))
                        ret = '';
                    else if (isX(m))
                        ret = '>=' + M + '.0.0 <' + (+M + 1) + '.0.0';
                    else if (isX(p)) {
                        if (M === '0')
                            ret = '>=' + M + '.' + m + '.0 <' + M + '.' + (+m + 1) + '.0';
                        else
                            ret = '>=' + M + '.' + m + '.0 <' + (+M + 1) + '.0.0';
                    }
                    else if (pr) {
                        if (pr.charAt(0) !== '-')
                            pr = '-' + pr;
                        if (M === '0') {
                            if (m === '0')
                                ret = '>=' + M + '.' + m + '.' + p + pr +
                                    ' <' + M + '.' + m + '.' + (+p + 1);
                            else
                                ret = '>=' + M + '.' + m + '.' + p + pr +
                                    ' <' + M + '.' + (+m + 1) + '.0';
                        }
                        else
                            ret = '>=' + M + '.' + m + '.' + p + pr +
                                ' <' + (+M + 1) + '.0.0';
                    }
                    else {
                        if (M === '0') {
                            if (m === '0')
                                ret = '>=' + M + '.' + m + '.' + p +
                                    ' <' + M + '.' + m + '.' + (+p + 1);
                            else
                                ret = '>=' + M + '.' + m + '.' + p +
                                    ' <' + M + '.' + (+m + 1) + '.0';
                        }
                        else
                            ret = '>=' + M + '.' + m + '.' + p +
                                ' <' + (+M + 1) + '.0.0';
                    }
                    return ret;
                });
            }
            function replaceXRanges(comp, loose) {
                return comp.split(/\s+/).map(function (comp) {
                    return replaceXRange(comp, loose);
                }).join(' ');
            }
            function replaceXRange(comp, loose) {
                comp = comp.trim();
                var r = loose ? re[XRANGELOOSE] : re[XRANGE];
                return comp.replace(r, function (ret, gtlt, M, m, p, pr) {
                    var xM = isX(M);
                    var xm = xM || isX(m);
                    var xp = xm || isX(p);
                    var anyX = xp;
                    if (gtlt === '=' && anyX)
                        gtlt = '';
                    if (xM) {
                        if (gtlt === '>' || gtlt === '<') {
                            ret = '<0.0.0';
                        }
                        else {
                            ret = '*';
                        }
                    }
                    else if (gtlt && anyX) {
                        if (xm)
                            m = 0;
                        if (xp)
                            p = 0;
                        if (gtlt === '>') {
                            gtlt = '>=';
                            if (xm) {
                                M = +M + 1;
                                m = 0;
                                p = 0;
                            }
                            else if (xp) {
                                m = +m + 1;
                                p = 0;
                            }
                        }
                        else if (gtlt === '<=') {
                            gtlt = '<';
                            if (xm)
                                M = +M + 1;
                            else
                                m = +m + 1;
                        }
                        ret = gtlt + M + '.' + m + '.' + p;
                    }
                    else if (xm) {
                        ret = '>=' + M + '.0.0 <' + (+M + 1) + '.0.0';
                    }
                    else if (xp) {
                        ret = '>=' + M + '.' + m + '.0 <' + M + '.' + (+m + 1) + '.0';
                    }
                    return ret;
                });
            }
            function replaceStars(comp, loose) {
                return comp.trim().replace(re[STAR], '');
            }
            function hyphenReplace($0, from, fM, fm, fp, fpr, fb, to, tM, tm, tp, tpr, tb) {
                if (isX(fM))
                    from = '';
                else if (isX(fm))
                    from = '>=' + fM + '.0.0';
                else if (isX(fp))
                    from = '>=' + fM + '.' + fm + '.0';
                else
                    from = '>=' + from;
                if (isX(tM))
                    to = '';
                else if (isX(tm))
                    to = '<' + (+tM + 1) + '.0.0';
                else if (isX(tp))
                    to = '<' + tM + '.' + (+tm + 1) + '.0';
                else if (tpr)
                    to = '<=' + tM + '.' + tm + '.' + tp + '-' + tpr;
                else
                    to = '<=' + to;
                return (from + ' ' + to).trim();
            }
            function testSet(set, version) {
                for (var i = 0; i < set.length; i++) {
                    if (!set[i].test(version))
                        return false;
                }
                if (version.prerelease.length) {
                    for (var i = 0; i < set.length; i++) {
                        if (set[i].semver === ANY)
                            continue;
                        if (set[i].semver.prerelease.length > 0) {
                            var allowed = set[i].semver;
                            if (allowed.major === version.major &&
                                allowed.minor === version.minor &&
                                allowed.patch === version.patch)
                                return true;
                        }
                    }
                    return false;
                }
                return true;
            }
            function satisfies(version, range, loose) {
                try {
                    range = new VersionRange(range, loose);
                }
                catch (er) {
                    return false;
                }
                return range.test(version);
            }
            function maxSatisfying(versions, range, loose) {
                return versions.filter(function (version) {
                    return satisfies(version, range, loose);
                }).sort(function (a, b) {
                    return rcompare(a, b, loose);
                })[0] || null;
            }
            function validRange(range, loose) {
                try {
                    return new VersionRange(range, loose).range || '*';
                }
                catch (er) {
                    return null;
                }
            }
            function ltr(version, range, loose) {
                return outside(version, range, '<', loose);
            }
            function gtr(version, range, loose) {
                return outside(version, range, '>', loose);
            }
            function outside(version, range, hilo, loose) {
                version = new SemVer(version, loose);
                range = new VersionRange(range, loose);
                var gtfn, ltefn, ltfn, comp, ecomp;
                switch (hilo) {
                    case '>':
                        gtfn = gt;
                        ltefn = lte;
                        ltfn = lt;
                        comp = '>';
                        ecomp = '>=';
                        break;
                    case '<':
                        gtfn = lt;
                        ltefn = gte;
                        ltfn = gt;
                        comp = '<';
                        ecomp = '<=';
                        break;
                    default:
                        throw new TypeError('Must provide a hilo val of "<" or ">"');
                }
                if (satisfies(version, range, loose)) {
                    return false;
                }
                for (var i = 0; i < range.set.length; ++i) {
                    var comparators = range.set[i];
                    var high = null;
                    var low = null;
                    comparators.forEach(function (comparator) {
                        if (comparator.semver === ANY) {
                            comparator = new Comparator('>=0.0.0');
                        }
                        high = high || comparator;
                        low = low || comparator;
                        if (gtfn(comparator.semver, high.semver, loose)) {
                            high = comparator;
                        }
                        else if (ltfn(comparator.semver, low.semver, loose)) {
                            low = comparator;
                        }
                    });
                    if (high.operator === comp || high.operator === ecomp) {
                        return false;
                    }
                    if ((!low.operator || low.operator === comp) &&
                        ltefn(version, low.semver)) {
                        return false;
                    }
                    else if (low.operator === ecomp && ltfn(version, low.semver)) {
                        return false;
                    }
                }
                return true;
            }
        })(version = util.version || (util.version = {}));
    })(util = packadic.util || (packadic.util = {}));
})(packadic || (packadic = {}));
(function () {
    packadic.debug = new packadic.Debug();
    packadic.ready(function (app) {
        console.log('init app systemjs', app);
        System.config({
            defaultJSExtensions: true,
            map: {
                css: app.getAssetPath('scripts/systemjs/css-plugin.js'),
                'jquery-fake': app.getAssetPath('scripts/systemjs/jquery-fake-plugin.js')
            },
            meta: {
                '*.css': {
                    loader: 'css'
                },
                'jquery': { format: 'global', exports: '$', loader: 'jquery-fake' },
                '*codemirror.js': { format: 'global', exports: 'CodeMirror' },
                '*highlightjs/highlight.pack*.js': { format: 'global', exports: 'hljs' },
                '*prism/prism*.js': { format: 'global', exports: 'Prism' }
            }
        });
    });
}.call(this));

return packadic;

}));
