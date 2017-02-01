webpackJsonp([5,7],{

/***/ 177:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _vue = __webpack_require__(2);

var _vue2 = _interopRequireDefault(_vue);

var _vuex = __webpack_require__(9);

var _utils = __webpack_require__(49);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//import 'perfect-scrollbar/jquery';


if (_vue2.default.codex.CodexPhpdocPlugin) {
    _vue2.default.use(_vue2.default.codex.CodexPhpdocPlugin);
}
_vue2.default.config.debug = true;

var App = _vue2.default.codex.App.extend({
    name: 'phpdoc',
    // mixins  : [Vue.codex.mixins.layout, Vue.codex.mixins.resize],
    data: function data() {
        return {
            minContentHeight: 0,
            phpdocHeight: 0,
            query: codex.phpdoc.defaultClass ? codex.phpdoc.defaultClass : undefined,
            hashPath: null,
            navigator: null
        };
    },
    beforeMount: function beforeMount() {
        var _this = this;

        // this.navigator = new Navigator()
        var hashPath = _utils.HashPathParser.parse(location.hash);
        if (hashPath.isHashPath()) {
            // do we have a hash path? if so, we set the query by that
            this.query = hashPath.toQuery();
            window.history.replaceState(null, hashPath.toString(), window.location.pathname + hashPath.toString());
        } else if (_vue2.default.codex.phpdoc.defaultClass) {
            // we don't have a hash path? we check for default class for the project and set query by that, then update the hash path
            this.open(_vue2.default.codex.phpdoc.defaultClass);
        }

        window.addEventListener("popstate", function (event) {
            var hashPath = _utils.HashPathParser.parse(location.hash);
            console.log('popstate', window.location);
            if (hashPath.isHashPath()) {
                _this.open(hashPath.toQuery());
            }
        }, false);
    },
    mounted: function mounted() {
        var _this2 = this;

        console.log('phpdoc  APP');
        this.$$ready(function () {
            return _this2.onResizeDocument();
        });
        this.$on('resize', this.onResizeDocument);
        this.$events.$on('phpdoc:type:click', function (type) {
            if (type.isLocal) _this2.open(type.fullName);
        });
        codex.loader.stop();
    },

    methods: {
        // ...mapActions(['toggleSidebar'])
        onResizeDocument: function onResizeDocument() {
            var _this3 = this;

            this.$nextTick(function () {
                var $page = _this3.$$(_this3.$refs.page);
                _this3.phpdocHeight = _this3.minHeights.inner = 0;

                _this3.$nextTick(function () {
                    _this3.phpdocHeight = _this3.minHeights.inner = $page.outerHeight(true) - parseInt($page.css('padding-top')) - parseInt($page.css('padding-bottom'));
                });
            });
        },
        open: function open(query) {
            this.$events.$emit('phpdoc:open', query);
            this.query = query;
            window.history.pushState(null, query, window.location.pathname + "#!/" + query);
        }
    },
    watch: {
        // file(){
        //     this.$nextTick(() => {
        //         this.onResizeDocument();
        //         this.$scroll(this.$refs.header.$el);
        //     })
        // }
    },
    computed: {
        // ...mapGetters(['file'])
    }
});

exports.default = App;


codex.App = App;

console.log('sc phpdoc');

/***/ },

/***/ 2:
/***/ function(module, exports) {

module.exports = Vue;

/***/ },

/***/ 49:
/***/ function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
__export(__webpack_require__(68));
__export(__webpack_require__(73));
var PHPDoc_1 = __webpack_require__(92);
exports.PHPDoc = PHPDoc_1.default;
var FullyQualifiedNameParser_1 = __webpack_require__(91);
exports.FullyQualifiedNameParser = FullyQualifiedNameParser_1.default;
var HashPathParser_1 = __webpack_require__(66);
exports.HashPathParser = HashPathParser_1.default;
var Navigator_1 = __webpack_require__(67);
exports.Navigator = Navigator_1.default;
//# sourceMappingURL=index.js.map

/***/ },

/***/ 597:
/***/ function(module, exports, __webpack_require__) {

__webpack_require__(31);
module.exports = __webpack_require__(177);


/***/ },

/***/ 6:
/***/ function(module, exports) {

module.exports = _;

/***/ },

/***/ 66:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HashPathParser = function () {
    function HashPathParser(hashPath) {
        _classCallCheck(this, HashPathParser);

        this.hashPath = '';
        this.classPath = '';
        this.type = 'class';
        this.method = '';
        this.property = '';
        this.line = 0;
        if (!this.isHashPath()) return;
        var exp = /^\#\!\/(.*?)(?:$|\:{2}(.*)|\!(.*?)(?:\@(\d*)|$))$/gm;
        var matches = [];
        var myArr = void 0;
        while ((myArr = exp.exec(hashPath)) !== null) {
            matches.push(myArr);
        }
        if (matches.length !== 1 || matches[0].length !== 5) throw new Error('not valid url string');
        var m = matches[0];
        this.hashPath = hashPath;
        this.type = 'class';
        if (m[2] !== undefined) {
            this.type = m[2].indexOf('()') !== -1 ? 'method' : 'property';
        }
        if (m[3] !== undefined) {
            this.type = m[3];
        }
        this.classPath = m[1];
        this[this.type] = this.type === 'method' ? m[2].replace('()', '') : m[2];
        this.line = parseInt(m[4]) || 0;
    }

    _createClass(HashPathParser, [{
        key: 'is',
        value: function is(type) {
            return this.type === type;
        }
    }, {
        key: 'isClass',
        value: function isClass() {
            return this.is(HashPathParser.Class);
        }
    }, {
        key: 'isMethod',
        value: function isMethod() {
            return this.is(HashPathParser.Method);
        }
    }, {
        key: 'isProperty',
        value: function isProperty() {
            return this.is(HashPathParser.Property);
        }
    }, {
        key: 'isSource',
        value: function isSource() {
            return this.is(HashPathParser.Source);
        }
    }, {
        key: 'hasLine',
        value: function hasLine() {
            return this.isSource() && this.line > 0;
        }
    }, {
        key: 'isHashPath',
        value: function isHashPath() {
            return location.hash.indexOf('#!/') !== -1;
        }
    }, {
        key: 'getHashPath',
        value: function getHashPath() {
            if (!this.isHashPath()) throw new Error('Current location is not a hashed path');
            return location.hash;
        }
    }, {
        key: 'toQuery',
        value: function toQuery() {
            if (this.isClass()) return this.classPath;
            if (this.isMethod()) return this.classPath + '::' + this.method + '()';
            if (this.isProperty()) return this.classPath + '::' + this.property;
            if (this.isSource()) {
                return this.classPath + '::';
            }
        }
    }, {
        key: 'toString',
        value: function toString() {
            return this.hashPath;
        }
    }], [{
        key: 'parse',
        value: function parse(hashPath) {
            return new HashPathParser(hashPath);
        }
    }]);

    return HashPathParser;
}();

HashPathParser.Class = 'class';
HashPathParser.Method = 'method';
HashPathParser.Property = 'property';
HashPathParser.Source = 'source';
Object.defineProperty(exports, "__esModule", { value: true });
exports.default = HashPathParser;
//# sourceMappingURL=HashPathParser.js.map

/***/ },

/***/ 67:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HashPathParser_1 = __webpack_require__(66);

var Navigator = function () {
    function Navigator() {
        _classCallCheck(this, Navigator);
    }

    _createClass(Navigator, [{
        key: 'parseHashPath',
        value: function parseHashPath(hashPath) {
            return new HashPathParser_1.default(hashPath);
        }
    }, {
        key: 'isHashPath',
        value: function isHashPath() {
            return location.hash.indexOf('#!/') !== -1;
        }
    }, {
        key: 'getHashPath',
        value: function getHashPath() {
            if (!this.isHashPath()) throw new Error('Current location is not a hashed path');
            return location.hash;
        }
    }, {
        key: 'getParsedHashPath',
        value: function getParsedHashPath() {
            return this.parseHashPath(this.getHashPath());
        }
    }, {
        key: 'init',
        value: function init(path) {
            var hashPath = void 0;
            if (path) hashPath = this.parseHashPath(path);else if (this.isHashPath()) hashPath = this.getParsedHashPath();else hashPath = new HashPathParser_1.default('');
        }
    }, {
        key: 'open',
        value: function open() {}
    }]);

    return Navigator;
}();

Object.defineProperty(exports, "__esModule", { value: true });
exports.default = Navigator;
//# sourceMappingURL=Navigator.js.map

/***/ },

/***/ 68:
/***/ function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(_) {

var __awaiter = undefined && undefined.__awaiter || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) {
            try {
                step(generator.next(value));
            } catch (e) {
                reject(e);
            }
        }
        function rejected(value) {
            try {
                step(generator["throw"](value));
            } catch (e) {
                reject(e);
            }
        }
        function step(result) {
            result.done ? resolve(result.value) : new P(function (resolve) {
                resolve(result.value);
            }).then(fulfilled, rejected);
        }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var Vue = __webpack_require__(2);
var api = Vue.codex.api;
function defaultOptions() {
    var defaults = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var project = Vue.codex.project,
        ref = Vue.codex.ref;
    return { params: _.merge({ project: project, ref: ref }, defaults, params) };
}
function getEntities() {
    var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee() {
        return regeneratorRuntime.wrap(function _callee$(_context) {
            while (1) {
                switch (_context.prev = _context.next) {
                    case 0:
                        return _context.abrupt("return", new Promise(function (resolve, reject) {
                            api.get('phpdoc/entities', defaultOptions({ tree: false, full: false }, params)).catch(function (err) {
                                return reject(err);
                            }).then(function (res) {
                                return resolve(res.data);
                            });
                        }));

                    case 1:
                    case "end":
                        return _context.stop();
                }
            }
        }, _callee, this);
    }));
}
exports.getEntities = getEntities;
function getEntity(entity) {
    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee2() {
        return regeneratorRuntime.wrap(function _callee2$(_context2) {
            while (1) {
                switch (_context2.prev = _context2.next) {
                    case 0:
                        if (!(entity === undefined)) {
                            _context2.next = 3;
                            break;
                        }

                        console.trace('entity undefined');
                        throw new Error('entity undefined');

                    case 3:
                        return _context2.abrupt("return", new Promise(function (resolve, reject) {
                            api.get('phpdoc/entity', defaultOptions({ entity: entity }, params)).catch(function (err) {
                                return reject(err);
                            }).then(function (res) {
                                return resolve(res.data);
                            });
                        }));

                    case 4:
                    case "end":
                        return _context2.stop();
                }
            }
        }, _callee2, this);
    }));
}
exports.getEntity = getEntity;
function getMethod(entity, method) {
    var params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee3() {
        return regeneratorRuntime.wrap(function _callee3$(_context3) {
            while (1) {
                switch (_context3.prev = _context3.next) {
                    case 0:
                        return _context3.abrupt("return", new Promise(function (resolve, reject) {
                            api.get('phpdoc/method', defaultOptions({ entity: entity, method: method }, params)).catch(function (err) {
                                return reject(err);
                            }).then(function (res) {
                                return resolve(res.data);
                            });
                        }));

                    case 1:
                    case "end":
                        return _context3.stop();
                }
            }
        }, _callee3, this);
    }));
}
exports.getMethod = getMethod;
function getProperty(entity, property) {
    var params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    return __awaiter(this, void 0, void 0, regeneratorRuntime.mark(function _callee4() {
        return regeneratorRuntime.wrap(function _callee4$(_context4) {
            while (1) {
                switch (_context4.prev = _context4.next) {
                    case 0:
                        return _context4.abrupt("return", new Promise(function (resolve, reject) {
                            api.get('phpdoc/method', defaultOptions({ entity: entity, property: property }, params)).catch(function (err) {
                                return reject(err);
                            }).then(function (res) {
                                return resolve(res.data);
                            });
                        }));

                    case 1:
                    case "end":
                        return _context4.stop();
                }
            }
        }, _callee4, this);
    }));
}
exports.getProperty = getProperty;
//# sourceMappingURL=api.js.map
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(6)))

/***/ },

/***/ 73:
/***/ function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(_) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function removeStartSlash(value) {
    if (value === undefined) {
        return;
    }
    var matches = value.match(/^\\(.*)/);
    if (matches !== null && matches.length === 2) {
        return matches[1];
    }
    return value;
}
exports.removeStartSlash = removeStartSlash;
;
function Type(name) {
    this.type = name;
    this.name = name;
    this.fullName = name;
    this.entities = Vue.codex.store.getters.entities;
    this.isEntity = this.name[0] === '\\';
    this.isPrimitive = this.isEntity === false;
    this.isLocal = false;
    this.isExternal = false;
    this.entity = {};
    var classes = [];
    if (this.isEntity) {
        this.fullName = removeStartSlash(this.name);
        this.name = _.last(this.type.split('\\'));
        this.isExternal = true;
        if (this.entities) {
            this.entity = _.find(this.entities, { full_name: this.type });
            this.isLocal = this.entity !== undefined;
            this.isExternal = !this.isLocal;
        }
        classes.push('phpdoc-type-' + (this.isLocal ? this.entity.type : 'external'));
    } else {
        classes.push('phpdoc-type-simple');
        classes.push('phpdoc-type-simple-' + this.type);
    }
    this.cssClass = classes.join(' ');
}
exports.Type = Type;
function parseFullName(fullName) {
    return parseRef(fullName);
}
exports.parseFullName = parseFullName;
function parseRef(ref) {
    return Query.from(ref);
}
exports.parseRef = parseRef;

var Query = function () {
    function Query(query) {
        _classCallCheck(this, Query);

        this.query = query;
        this.isEntity = false;
        this.isMethod = false;
        this.isProperty = false;
        this.entityName = null;
        this.methodName = null;
        this.propertyName = null;
        if (query.indexOf('::') !== -1) {
            this.entityName = query.split('::')[0];
            if (query.indexOf('()') !== -1) {
                this.methodName = query.split('::')[1].replace('()', '');
                this.isMethod = true;
            } else {
                this.propertyName = query.split('::')[1];
                this.isProperty = true;
            }
        } else {
            this.entityName = query;
            this.isEntity = true;
        }
        if (this.entityName[0] !== '\\') {
            this.entityName = '\\' + this.entityName;
        }
    }

    _createClass(Query, [{
        key: 'toString',
        value: function toString() {
            return this.query;
        }
    }], [{
        key: 'from',
        value: function from(query) {
            return new Query(query);
        }
    }]);

    return Query;
}();

exports.Query = Query;

var Tags = function () {
    function Tags() {
        var tags = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

        _classCallCheck(this, Tags);

        this.tags = tags;
    }

    _createClass(Tags, [{
        key: 'has',
        value: function has(name) {
            return this.get(name) !== undefined;
        }
    }, {
        key: 'get',
        value: function get(name) {
            return _.find(this.tags, { name: name });
        }
    }, {
        key: 'where',
        value: function where(k, v) {
            return _.find(this.tags, _defineProperty({}, k, v));
        }
    }, {
        key: 'exclude',
        value: function exclude(vals) {
            var key = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'name';

            return new Tags(_.filter(this.tags, function (tag) {
                return vals.indexOf(tag[key]) === -1;
            }));
        }
    }, {
        key: 'toArray',
        value: function toArray() {
            return this.tags;
        }
    }, {
        key: 'isEmpty',
        value: function isEmpty() {
            return this.tags.length === 0;
        }
    }, {
        key: 'length',
        get: function get() {
            return this.tags.length;
        }
    }]);

    return Tags;
}();

exports.Tags = Tags;
//# sourceMappingURL=general.js.map
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(6)))

/***/ },

/***/ 9:
/***/ function(module, exports) {

module.exports = Vuex;

/***/ },

/***/ 91:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var FullyQualifiedNameParser = function () {
    function FullyQualifiedNameParser(name) {
        _classCallCheck(this, FullyQualifiedNameParser);

        this.name = '';
        this.entityName = '';
        this.methodName = '';
        this.propertyName = '';
        this.type = 'entity';
        var exp = /^(.*?)(?:$|\:{2}(.*))$/gm;
        var matches = [];
        var myArr = void 0;
        while ((myArr = exp.exec(name)) !== null) {
            matches.push(myArr);
        }
        if (matches.length !== 1 || matches[0].length !== 3) throw new Error('not valid fqn');
        var m = matches[0];
        this.name = name;
        this.type = 'entity';
        if (m[2] !== undefined) {
            this.type = m[2].indexOf('()') !== -1 ? 'method' : 'property';
        }
        this.entityName = m[1];
        this[this.type + 'Name'] = this.type === 'method' ? m[2].replace('()', '') : m[2];
    }

    _createClass(FullyQualifiedNameParser, [{
        key: 'is',
        value: function is(type) {
            return this.type === type;
        }
    }, {
        key: 'isEntity',
        value: function isEntity() {
            return this.is(FullyQualifiedNameParser.Entity);
        }
    }, {
        key: 'isMethod',
        value: function isMethod() {
            return this.is(FullyQualifiedNameParser.Method);
        }
    }, {
        key: 'isProperty',
        value: function isProperty() {
            return this.is(FullyQualifiedNameParser.Property);
        }
    }, {
        key: 'toString',
        value: function toString() {
            return this.name;
        }
    }, {
        key: 'requestApi',
        value: function requestApi() {
            if (this.isEntity()) {
                return Vue.codex.phpdoc.getEntity(this.entityName);
            } else if (this.isMethod()) {
                return Vue.codex.phpdoc.getMethod(this.entityName, this.methodName);
            } else if (this.isProperty()) {
                return Vue.codex.phpdoc.getProperty(this.entityName, this.propertyName);
            }
        }
    }]);

    return FullyQualifiedNameParser;
}();

FullyQualifiedNameParser.Entity = 'entity';
FullyQualifiedNameParser.Method = 'method';
FullyQualifiedNameParser.Property = 'property';
Object.defineProperty(exports, "__esModule", { value: true });
exports.default = FullyQualifiedNameParser;
//# sourceMappingURL=FullyQualifiedNameParser.js.map

/***/ },

/***/ 92:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Navigator_1 = __webpack_require__(67);

var PHPDoc = function () {
    function PHPDoc(vm, $store) {
        _classCallCheck(this, PHPDoc);

        this.vm = vm;
        this.$store = $store;
    }

    _createClass(PHPDoc, [{
        key: "init",
        value: function init() {
            this.nav = new Navigator_1.default();
        }
    }]);

    return PHPDoc;
}();

Object.defineProperty(exports, "__esModule", { value: true });
exports.default = PHPDoc;
//# sourceMappingURL=PHPDoc.js.map

/***/ }

},[597]);
//# sourceMappingURL=codex.page.phpdoc.js.map