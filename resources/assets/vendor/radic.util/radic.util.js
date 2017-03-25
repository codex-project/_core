(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('lodash')) :
    typeof define === 'function' && define.amd ? define(['exports', 'lodash'], factory) :
    (factory((global.radic = global.radic || {}, global.radic.util = global.radic.util || {}),global._));
}(this, (function (exports,lodash) { 'use strict';

function getParts(str) {
    return str.replace(/\\\./g, '\uffff').split('.').map(function (s) {
        return s.replace(/\uffff/g, '.');
    });
}
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
function objectSet(obj, parts, value) {
    parts = getParts(parts);
    var prop = parts.pop();
    obj = objectGet(obj, parts, true);
    if (obj && typeof obj === 'object') {
        return (obj[prop] = value);
    }
}
function objectExists(obj, parts) {
    parts = getParts(parts);
    var prop = parts.pop();
    obj = objectGet(obj, parts);
    return typeof obj === 'object' && obj && prop in obj;
}
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
        else if (typeof value === 'array') {
            return value.map(function (item, index) {
                return recurse(item, fn, fnContinue, {
                    objs: state.objs.concat([value]),
                    path: state.path + '[' + index + ']',
                });
            });
        }
        else if (typeof value === 'object') {
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
function copyObject(object) {
    var objectCopy = {};
    for (var key in object) {
        if (object.hasOwnProperty(key)) {
            objectCopy[key] = object[key];
        }
    }
    return objectCopy;
}
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
                    newObj = recurse(o[f], (p ? p : "") + (isNumber$$1(f) ? "[" + f + "]" : "." + f), true);
                else {
                    if (isArrayItem)
                        newObj = recurse(o[f], (p ? p : "") + "[" + f + "]");
                    else
                        newObj = recurse(o[f], (p ? p + "." : "") + f);
                }
            }
            else {
                if (isArrayItem || isNumber$$1(f))
                    newObj[p + "[" + f + "]"] = o[f];
                else
                    newObj[(p ? p + "." : "") + f] = o[f];
            }
        }
        if (isEmptyObj(newObj))
            return obj;
        return newObj;
    }
    function isNumber$$1(f) {
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
var StringType = (function () {
    function StringType(value) {
        this.value = value;
    }
    StringType.prototype.toString = function () {
        return this.value;
    };
    StringType.prototype.valueOf = function () {
        return this.value;
    };
    StringType.all = function () {
        var _this = this;
        return Object.getOwnPropertyNames(this).filter(function (item) {
            if (['length', 'name', 'prototype'].indexOf(item) === -1 && typeof _this[item] === 'object') {
                return true;
            }
        }).map(function (item) { return _this[item]; });
    };
    return StringType;
}());
function applyMixins(derivedCtor, baseCtors) {
    baseCtors.forEach(function (baseCtor) {
        Object.getOwnPropertyNames(baseCtor.prototype).forEach(function (name) {
            derivedCtor.prototype[name] = baseCtor.prototype[name];
        });
    });
}
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
        this.items = lodash.uniq(this.items);
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
}());

var __extends = (undefined && undefined.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var Config = (function () {
    function Config(obj) {
        this.allDelimiters = {};
        this.addDelimiters('config', '<%', '%>');
        this.defaults = obj || {};
        this.data = lodash.cloneDeep(this.defaults);
    }
    Config.prototype.unset = function (prop) {
        prop = prop.split('.');
        var key = prop.pop();
        var obj = objectGet(this.data, Config.getPropString(prop.join('.')));
        delete obj[key];
    };
    Config.prototype.has = function (prop) {
        return prop ? objectExists(this.data, Config.getPropString(prop)) : true;
    };
    Config.prototype.raw = function (prop) {
        if (prop) {
            return objectGet(this.data, Config.getPropString(prop));
        }
        else {
            return this.data;
        }
    };
    Config.prototype.get = function (prop, defaultReturnValue) {
        if (defaultReturnValue === void 0) { defaultReturnValue = undefined; }
        return this.has(prop) ? this.process(this.raw(prop)) : defaultReturnValue;
    };
    Config.prototype.set = function (prop, value) {
        objectSet(this.data, Config.getPropString(prop), value);
        return this;
    };
    Config.prototype.merge = function () {
        var args = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            args[_i] = arguments[_i];
        }
        if (args.length === 1) {
            this.data = lodash.merge(this.data, args[0]);
        }
        else {
            var prop = args[0];
            this.set(prop, lodash.merge(this.raw(prop), args[1]));
        }
        return this;
    };
    Config.prototype.process = function (raw) {
        var self = this;
        return recurse(raw, function (value) {
            if (typeof value !== 'string') {
                return value;
            }
            var matches = value.match(Config.propStringTmplRe);
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
    Config.prototype.addDelimiters = function (name, opener, closer) {
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
    Config.prototype.setDelimiters = function (name) {
        var delimiters = this.allDelimiters[name in this.allDelimiters ? name : 'config'];
        return delimiters;
    };
    Config.prototype.processTemplate = function (tmpl, options) {
        if (!options) {
            options = {};
        }
        var delimiters = this.setDelimiters(options.delimiters);
        var data = Object.create(options.data || this.data || {});
        var last = tmpl;
        try {
            while (tmpl.indexOf(delimiters.opener) >= 0) {
                tmpl = lodash.template(tmpl)(data);
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
    Config.makeProperty = function (config) {
        var cf = function (prop) {
            return config.get(prop);
        };
        cf.get = config.get.bind(config);
        cf.set = config.set.bind(config);
        cf.unset = config.unset.bind(config);
        cf.merge = config.merge.bind(config);
        cf.raw = config.raw.bind(config);
        cf.process = config.process.bind(config);
        cf.has = config.has.bind(config);
        return cf;
    };
    Config.getPropString = function (prop) {
        return Array.isArray(prop) ? prop.map(this.escape).join('.') : prop;
    };
    Config.escape = function (str) {
        return str.replace(/\./g, '\\.');
    };
    Config.prototype.toString = function () {
        return this.raw();
    };
    return Config;
}());
Config.propStringTmplRe = /^<%=\s*([a-z0-9_$]+(?:\.[a-z0-9_$]+)*)\s*%>$/i;
var PersistentConfig = (function (_super) {
    __extends(PersistentConfig, _super);
    function PersistentConfig(obj, persistenceFilePath) {
        var _this = _super.call(this, obj) || this;
        _this.load();
        return _this;
    }
    PersistentConfig.prototype.save = function () {
    };
    PersistentConfig.prototype.load = function () {
    };
    PersistentConfig.prototype.unset = function (prop) {
        _super.prototype.unset.call(this, prop);
        this.save();
        return this;
    };
    PersistentConfig.prototype.merge = function () {
        var args = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            args[_i] = arguments[_i];
        }
        _super.prototype.merge.call(this, args);
        this.save();
        return this;
    };
    PersistentConfig.prototype.set = function (prop, value) {
        _super.prototype.set.call(this, prop, value);
        this.save();
        return this;
    };
    return PersistentConfig;
}(Config));

var getCallerFile = function getCallerFile(_position) {
    if (_position === void 0) { _position = 2; }
    var oldPrepareStackTrace = Error['prepareStackTrace'];
    Error['prepareStackTrace'] = function (err, stack) {
        return stack;
    };
    var stack = new Error().stack;
    Error['prepareStackTrace'] = oldPrepareStackTrace;
    var position = _position ? _position : 2;
    return stack[position] ? stack[position].getFileName() : undefined;
};
function inspect() {
    var args = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        args[_i] = arguments[_i];
    }
    args.forEach(function (arg) { return console.dir(arg, { colors: true, depth: 5, showHidden: true }); });
}

var round = function round(value, places) {
    var multiplier = Math.pow(10, places);
    return (Math.round(value * multiplier) / multiplier);
};
var makeString = function makeString(object) {
    if (object == null)
        return '';
    return '' + object;
};
var defaultToWhiteSpace = function defaultToWhiteSpace(characters) {
    if (characters == null)
        return '\\s';
    else if (characters.source)
        return characters.source;
    else
        return '[' + lodash.escapeRegExp(characters) + ']';
};
var kindsOf = {};
'Number String Boolean Function RegExp Array Date Error'.split(' ').forEach(function (k) {
    kindsOf['[object ' + k + ']'] = k.toLowerCase();
});
var kindOf = function kindOf(value) {
    if (value == null) {
        return String(value);
    }
    return kindsOf[kindsOf.toString.call(value)] || 'object';
};
var def = function def(val, def) {
    return defined(val) ? val : def;
};
var defined = function defined(obj) {
    return lodash.isUndefined(obj);
};
var getRandomId = function getRandomId(length) {
    if (lodash.isNumber(length)) {
        length = 15;
    }
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
};
var guid = function guid() {
    return guidSeg() + guidSeg() + '-' + guidSeg() + '-' + guidSeg() + '-' +
        guidSeg() + '-' + guidSeg() + guidSeg() + guidSeg();
};
function guidSeg() {
    return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
}
function isLength(value, lengths) {
    lengths = lengths.length === 1 && kindOf(lengths[0]) === 'array' ? lengths[0] : lengths;
    var vLen;
    if (value.length)
        vLen = value.length;
    else if (isFinite(value))
        vLen = parseInt(value);
    else
        return [false];
    var lens = [];
    lengths.map(function (val) { return parseInt(val); }).forEach(function (len) { return lens[len] = vLen === len; });
    return lens;
}
var isAnyLength = function (value) {
    var lengths = [];
    for (var _i = 1; _i < arguments.length; _i++) {
        lengths[_i - 1] = arguments[_i];
    }
    return isLength(value, lengths).indexOf(true) !== -1;
};
var isAllLength = function (value) {
    var lengths = [];
    for (var _i = 1; _i < arguments.length; _i++) {
        lengths[_i - 1] = arguments[_i];
    }
    return isLength(value, lengths).indexOf(false) === -1;
};

var old_json = JSON;
var stringify = function stringify(obj) {
    return old_json.stringify(obj, function (key, value) {
        if (value instanceof Function || typeof value == 'function') {
            return value.toString();
        }
        if (value instanceof RegExp) {
            return '_PxEgEr_' + value;
        }
        return value;
    });
};
var parse = function parse(str, date2obj) {
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
};
var clone = function clone(obj, date2obj) {
    return parse(stringify(obj), date2obj);
};

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
var colors = materialColors;
var color = function color(name, variant, prefixHexSymbol) {
    if (variant === void 0) { variant = '500'; }
    if (prefixHexSymbol === void 0) { prefixHexSymbol = true; }
    if (typeof colors[name] === 'object' && typeof colors[name][variant] === 'string') {
        return prefixHexSymbol ? colors[name][variant] : colors[name][variant].replace('#', '');
    }
    throw new Error('Could not find color [' + name + '] variant [' + variant + '] in materials.color()');
};

var __extends$1 = (undefined && undefined.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var Storage = (function () {
    function Storage() {
    }
    Storage.hasBag = function (name) {
        return typeof Storage.bags[name] !== 'undefined';
    };
    Storage.createBag = function (name, storageType) {
        if (Storage.hasBag(name)) {
            throw new Error('StorageBag ' + name + ' already exists');
        }
        return Storage.bags[name] = new StorageBag(Storage.make(name, storageType));
    };
    Storage.getBag = function (name) {
        if (!Storage.hasBag(name)) {
            throw new Error('StorageBag ' + name + ' does not exist');
        }
        return Storage.bags[name];
    };
    Storage.getOrCreateBag = function (name, storageType) {
        if (!Storage.hasBag(name)) {
            return Storage.createBag(name, storageType);
        }
        return Storage.getBag(name);
    };
    Storage.make = function (name, storageType) {
        if (storageType === 'cookie')
            return new CookieStorage(name);
        if (storageType === 'local')
            return new LocalStorage(name);
        if (storageType === 'session')
            return new SessionStorage(name);
        throw new Error('Storage provider could not be maked. ... ?');
    };
    Storage.isSupportedProvider = function (provider) {
        if (provider instanceof LocalStorage) {
            return window.localStorage !== undefined;
        }
        if (provider instanceof SessionStorage) {
            return window.localStorage !== undefined;
        }
        if (provider instanceof CookieStorage) {
            return window.document.cookie !== undefined;
        }
    };
    return Storage;
}());
Storage.bags = {};
var StorageBag = (function () {
    function StorageBag(provider, options) {
        if (options === void 0) { options = {}; }
        this.options = {
            json: true
        };
        this.provider = provider;
        lodash.merge(this.options, options);
    }
    StorageBag.prototype.on = function (callback) {
        this.provider.onStoreEvent(callback);
    };
    StorageBag.prototype.set = function (key, val, options) {
        options = lodash.merge({ json: true, expires: false }, options);
        if (options.json) {
            val = JSON.stringify(val);
        }
        if (options.expires) {
            var now = Math.floor((Date.now() / 1000) / 60);
            this.provider.setItem(key + ':expire', now + options.expires);
        }
        this.provider.setItem(key, val);
    };
    StorageBag.prototype.get = function (key, defaultReturn, options) {
        if (defaultReturn === void 0) { defaultReturn = null; }
        options = lodash.merge({ json: this.options.json, default: defaultReturn }, options);
        if (!key) {
            return options.default;
        }
        if (lodash.isString(this.provider.getItem(key))) {
            if (lodash.isString(this.provider.getItem(key + ':expire'))) {
                var now = Math.floor((Date.now() / 1000) / 60);
                var expires = parseInt(this.provider.getItem(key + ':expire'));
                if (now > expires) {
                    this.del(key);
                    this.del(key + ':expire');
                }
            }
        }
        var val = this.provider.getItem(key);
        if (!val || val !== undefined && val == null) {
            return options.default;
        }
        if (options.json) {
            return JSON.parse(val);
        }
        return val;
    };
    StorageBag.prototype.has = function (key) {
        return this.provider.hasItem(key);
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
}());
var BaseStorageProvider = (function () {
    function BaseStorageProvider(name) {
        this.name = name;
    }
    return BaseStorageProvider;
}());
var LocalStorage = (function (_super) {
    __extends$1(LocalStorage, _super);
    function LocalStorage() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    LocalStorage.prototype.hasItem = function (key) {
        return window.localStorage.getItem(key) !== null;
    };
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
            window['attachEvent']("onstorage", callback);
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
}(BaseStorageProvider));
var SessionStorage = (function (_super) {
    __extends$1(SessionStorage, _super);
    function SessionStorage() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    SessionStorage.prototype.hasItem = function (key) {
        return window.sessionStorage.getItem(key) !== null;
    };
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
            window['attachEvent']("onstorage", callback);
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
}(BaseStorageProvider));
var CookieStorage = (function (_super) {
    __extends$1(CookieStorage, _super);
    function CookieStorage() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.cookieRegistry = [];
        return _this;
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
}(BaseStorageProvider));

exports.Config = Config;
exports.PersistentConfig = PersistentConfig;
exports.getCallerFile = getCallerFile;
exports.inspect = inspect;
exports.round = round;
exports.makeString = makeString;
exports.defaultToWhiteSpace = defaultToWhiteSpace;
exports.kindOf = kindOf;
exports.def = def;
exports.defined = defined;
exports.getRandomId = getRandomId;
exports.guid = guid;
exports.guidSeg = guidSeg;
exports.isAnyLength = isAnyLength;
exports.isAllLength = isAllLength;
exports.isLength = isAnyLength;
exports.stringify = stringify;
exports.parse = parse;
exports.clone = clone;
exports.colors = colors;
exports.color = color;
exports.StringType = StringType;
exports.DependencySorter = DependencySorter;
exports.getParts = getParts;
exports.objectExists = objectExists;
exports.objectGet = objectGet;
exports.objectSet = objectSet;
exports.copyObject = copyObject;
exports.applyMixins = applyMixins;
exports.recurse = recurse;
exports.dotize = dotize;
exports.Storage = Storage;
exports.StorageBag = StorageBag;
exports.BaseStorageProvider = BaseStorageProvider;
exports.LocalStorage = LocalStorage;
exports.SessionStorage = SessionStorage;
exports.CookieStorage = CookieStorage;

Object.defineProperty(exports, '__esModule', { value: true });

})));
