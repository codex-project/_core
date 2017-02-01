webpackJsonp([3,7],{

/***/ 121:
/***/ function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(37)();
// imports


// module
exports.push([module.i, "\n.collapse.is-fullwidth {\n  width: 100%;\n}\n", ""]);

// exports


/***/ },

/***/ 124:
/***/ function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(37)();
// imports


// module
exports.push([module.i, "\n.collapse-item .card-header {\n  cursor: pointer;\n}\n.collapse-item .card-header-icon {\n  transition: transform .377s ease;\n}\n.collapse-item .card-content {\n  padding-top: 0;\n  padding-bottom: 0;\n  overflow: hidden;\n}\n.collapse-item .card-content-box {\n  padding-top: 20px;\n  padding-bottom: 20px;\n}\n.collapse-item.is-active > .card-header > .card-header-icon {\n  -ms-transform: rotate(90deg);\n      transform: rotate(90deg);\n}\n", ""]);

// exports


/***/ },

/***/ 14:
/***/ function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
__export(__webpack_require__(47));
__export(__webpack_require__(46));
var loader_1 = __webpack_require__(48);
exports.Loader = loader_1.default;
var md5_1 = __webpack_require__(40);
exports.md5 = md5_1.default;
//# sourceMappingURL=index.js.map

/***/ },

/***/ 176:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.App = exports.store = undefined;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _vue = __webpack_require__(2);

var _vue2 = _interopRequireDefault(_vue);

var _document = __webpack_require__(252);

var _document2 = _interopRequireDefault(_document);

var _lodash = __webpack_require__(6);

var _vueBulmaCollapse = __webpack_require__(492);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

Object.keys(_document2.default).forEach(function (key) {
    return _vue2.default.component(key, _document2.default[key]);
});

var _Vuex = Vuex,
    mapGetters = _Vuex.mapGetters,
    mapActions = _Vuex.mapActions,
    Store = _Vuex.Store;
var store = exports.store = new Store({});
_vue2.default.use(_vue2.default.codex.CodexPlugin, { store: store });

var App = exports.App = _vue2.default.extend({
    store: store,

    components: {
        Collapse: _vueBulmaCollapse.Collapse,
        CollapseItem: _vueBulmaCollapse.Item
    },
    mixins: [_vue2.default.codex.mixins.layout, _vue2.default.codex.mixins.resize],
    data: function data() {
        return {
            minHeights: { page: 0, inner: 0, app: 0 },
            sidenavs: {
                opened: '',
                right: true,
                width: 300
            }
        };
    },
    beforeMount: function beforeMount() {
        // do not show menu on mobile by default. The user has to click the menu icon first
        if (this.isBreakpointDown('md')) {
            this.closeSidebar();
        }
    },
    mounted: function mounted() {
        var _this = this;

        this.$$ready(function () {
            _this.onResize();
            _this.$nextTick(function () {
                return _vue2.default.codex.loader.stop();
            });
        });
        this.$on('resize', this.onResize);
        this.$events.$on('sidebar:open-sub-menu', this.onResize);
    },

    methods: _extends({}, mapActions(['toggleSidebar', 'closeSidebar', 'openSidebar', 'hideSidebar', 'showSidebar']), {
        showSidenav: function showSidenav(name) {
            this.sidenavs.opened = name;
        },
        hideSidenav: function hideSidenav() {
            this.sidenavs.opened = '';
        },
        isSidenav: function isSidenav(name) {
            return this.sidenavs.opened === name;
        },
        sidenavTransition: function sidenavTransition(_ref) {
            var el = _ref.el,
                style = _ref.style,
                cb = _ref.cb;

            this.$$(el).velocity('stop');
            this.$$(el).velocity(style, {
                duration: 300,
                queue: false,
                easing: 'easeOutQuad',
                complete: cb
            });
        },
        onResize: function onResize() {
            // Do not set heights when dealing with non-desktop devices
            if (this.isBreakpointDown('md')) return;
            var $page = this.$$(this.$refs.page);
            var heights = {
                header: this.$refs.header.$$el.outerHeight(true),
                footer: this.$refs.footer.$$el.outerHeight(true),
                viewPort: this.getViewPort().height
            };
            this.minHeights.page = heights.viewPort - heights.header - heights.footer;
            this.minHeights.inner = this.minHeights.page - (parseInt($page.css('padding-top')) + parseInt($page.css('padding-bottom')));
        }
    }),
    computed: _extends({}, mapGetters(['sidebar']), {
        $sidebarInner: function $sidebarInner() {
            return this.$$(this.$refs.sidebar.$el.children[0]);
        },
        $contentInner: function $contentInner() {
            return this.$$(this.$refs.content.$el.children[0]);
        },
        sidebarInnerHeight: function sidebarInnerHeight() {
            return this.$sidebarInner.outerHeight();
        },
        contentInnerHeight: function contentInnerHeight() {
            return this.$contentInner.outerHeight();
        },
        classes: function classes() {
            return {
                'sidebar-hidden': this.sidebar.hidden,
                'sidebar-closed': this.sidebar.closed
            };
        }
    })
});

exports.default = App;


_vue2.default.codex.App = App;

/***/ },

/***/ 2:
/***/ function(module, exports) {

module.exports = Vue;

/***/ },

/***/ 201:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
//
//
//
//
//
//

exports.default = {
  props: {
    isFullwidth: Boolean,
    accordion: Boolean
  },

  computed: {
    $collapseItems: function $collapseItems() {
      return this.$children.filter(function (child) {
        return child._isCollapseItem;
      });
    }
  },

  methods: {
    openByIndex: function openByIndex(index) {
      if (this.accordion) {
        this.$collapseItems.forEach(function (item, i) {
          if (i !== index) {
            item.isActived = false;
          }
        });
      }
    }
  }

};

/***/ },

/***/ 202:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _animejs = __webpack_require__(182);

var _animejs2 = _interopRequireDefault(_animejs);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    selected: Boolean,
    title: {
      type: String,
      required: true
    }
  },

  data: function data() {
    return {
      isActived: this.selected
    };
  },
  created: function created() {
    this._isCollapseItem = true;
  },
  mounted: function mounted() {
    this.$on('open', this.$parent.openByIndex);
    if (this.isActived) {
      this.$emit('open', this.index);
    }
  },
  beforeDestroy: function beforeDestroy() {
    if (this.anime && this.targets) {
      _animejs2.default.remove(this.targets);
    }
    this.$off('open', this.$parent.openByIndex);
  },


  computed: {
    index: function index() {
      return this.$parent.$collapseItems.indexOf(this);
    }
  },

  methods: {
    toggle: function toggle() {
      if (this.isActived = !this.isActived) {
        this.$emit('open', this.index);
      }
    },
    getAnime: function getAnime(targets) {
      if (this.anime) return this.anime;
      return this.anime = (0, _animejs2.default)({ targets: targets });
    },
    cancel: function cancel() {
      this.anime.pause();
    },
    before: function before(targets) {
      if (!this.targets) this.targets = targets;
      targets.removeAttribute('style');
    },
    enter: function enter(targets, done) {
      var height = targets.scrollHeight;
      targets.style.height = 0;
      targets.style.opacity = 0;
      this.getAnime(targets).play({
        targets: targets,
        duration: 377,
        easing: 'easeOutExpo',
        opacity: [0, 1],
        height: height,
        complete: function complete() {
          targets.removeAttribute('style');
          done();
        }
      });
    },
    leave: function leave(targets, complete) {
      this.getAnime(targets).play({
        targets: targets,
        duration: 377,
        easing: 'easeOutExpo',
        opacity: [1, 0],
        height: 0,
        complete: complete
      });
    }
  }
}; //
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/***/ },

/***/ 205:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; //
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var _vuex = __webpack_require__(9);

var _mixins = __webpack_require__(39);

//    import Prism from 'prismjs'

exports.default = {
    name: 'c-content',
    mixins: [_mixins.resize, _mixins.layout],
    props: {
        html: { type: String },
        minHeight: Number
    },
    data: function data() {
        return { innerStyle: {} };
    },
    mounted: function mounted() {
        var _this = this;

        this.isMd = this.isBreakpointUp('md');
        this.$on('resize', function () {
            _this.isMd = _this.isBreakpointUp('md');
            _this.updateInnerStyle();
        });

        this.$nextTick(function () {
            _this.prismHighlightAll();
            _this.updateInnerStyle();
        });
    },

    watch: {
        html: function html() {
            var _this2 = this;

            this.$nextTick(function () {
                _this2.prismHighlightAll();
            });
        },
        minHeight: function minHeight() {
            var _this3 = this;

            this.$nextTick(function () {
                _this3.updateInnerStyle();
            });
        }
    },
    computed: _extends({}, (0, _vuex.mapGetters)(['sidebar']), {
        outerStyle: function outerStyle() {
            if (!this.minHeight) return {};
            return { 'min-height': parseInt(this.minHeight) + 'px' };
        }
    }),
    methods: {
        prismHighlightAll: function prismHighlightAll() {
            if (window['Prism'] !== undefined) {
                window['Prism'].highlightAll();
            }
        },
        updateInnerStyle: function updateInnerStyle() {
            if (!this.minHeight) {
                this.innerStyle = {};
                return;
            }
            var outerHeight = 0;
            if (this.$slots.breadcrumb && this.$slots.breadcrumb.length > 0) {
                outerHeight = this.$$(this.$slots.breadcrumb[0].elm).outerHeight(true);
            }
            this.innerStyle = { 'min-height': parseInt(this.minHeight - outerHeight) + 'px' };
        }
    }
};

/***/ },

/***/ 206:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; //
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var _vuex = __webpack_require__(9);

var _transitions = __webpack_require__(90);

var _utils = __webpack_require__(14);

var _vue = __webpack_require__(2);

var _vue2 = _interopRequireDefault(_vue);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
    name: 'c-sidebar-item',
    props: {
        item: { type: Object },
        hasChildren: { type: Boolean, default: false },
        id: { type: String, default: (0, _utils.getRandomId)() },
        href: { type: String, default: 'javascript:;' },
        icon: String,
        title: String
    },
    data: function data() {
        return {
            open: false,
            active: false,
            link: 'javascript:;'
        };
    },
    mounted: function mounted() {
        var _this = this;

        if (!this.hasChildren) this.link = this.href;

        this.$events.$on('sidebar:close-all-sub-menus', function () {
            _this.closeSubMenu();
        });
        this.$events.$on('sidebar:close-other-sub-menus', function (sidebarItem) {
            if (_this.isChild(sidebarItem)) return;
            _this.closeSubMenu();
        });
        this.$events.$on('sidebar:active', function () {
            _this.active = false;
        });
    },

    computed: {
        subMenuStyle: function subMenuStyle() {
            return { 'display': this.open ? 'block' : 'none' };
        }
    },
    watch: {},
    methods: _extends({}, _transitions.slide, {
        handleLinkClick: function handleLinkClick() {
            var _this2 = this;

            if (this.hasChildren) {
                this.toggleSubMenu();
            }
            var slideDuration = 300;
            setTimeout(function () {
                var scrollOffset = 200;
                var scrollTo = _this2.$$el.offset().top;
                _this2.$scroll(scrollTo - scrollOffset, 400);
            }, slideDuration + 1);
        },
        setActive: function setActive() {
            this.$events.$emit('sidebar:active', this);
            this.active = true;
        },
        openSubMenu: function openSubMenu() {
            if (this.hasChildren === false) return;
            this.$events.$emit('sidebar:close-other-sub-menus', this);
            this.open = true;
            this.$events.$emit('sidebar:open-sub-menu', this);
        },
        closeSubMenu: function closeSubMenu() {
            if (this.hasChildren === false) return;
            this.open = false;
            this.$events.$emit('sidebar:close-sub-menu', this);
        },
        toggleSubMenu: function toggleSubMenu() {
            if (this.hasChildren === false) return;
            if (this.open) this.closeSubMenu();else this.openSubMenu();
        },
        isTopLevel: function isTopLevel() {
            return this.$parent.$options.name !== this.$options.name;
        },
        getParents: function getParents() {
            if (this.isTopLevel()) return [];
            var isTopLevel = false;
            var current = this;
            var parents = [];
            while (isTopLevel === false) {
                parents.push(current.$parent);
                isTopLevel = current.$parent.isTopLevel();
                current = current.$parent;
            }
            return parents;
        },
        isChild: function isChild(sidebarItem) {
            var _this3 = this;

            return sidebarItem.getParents().filter(function (item) {
                return item.$vnode.key === _this3.$vnode.key;
            }).length === 1;
        },
        setActiveAndOpenParents: function setActiveAndOpenParents() {
            this.getParents().reverse().forEach(function (parent) {
                parent.openSubMenu();
            });
            this.setActive();
        }
    })
};

/***/ },

/***/ 207:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; //
//
//
//
//
//
//
//
//
//

//https://github.com/chinchang/hint.css
//    import tooltip from '../../components/tooltip.vue'


var _vuex = __webpack_require__(9);

//    import resize from 'mixins/resize';
exports.default = {
    name: 'c-sidebar',
    components: {},
    props: { items: Array, minHeight: Number, active: String },
    computed: _extends({}, (0, _vuex.mapGetters)(['sidebar']), {
        innerStyle: function innerStyle() {
            if (!this.minHeight) return {};
            return { 'min-height': parseInt(this.minHeight) + 'px' };
        }
    }),
    mounted: function mounted() {
        if (this.active) {
            this.resolveActive(this.$children);
        }
    },

    watch: {},
    methods: _extends({}, (0, _vuex.mapActions)(['toggleSidebar', 'closeSidebar', 'openSidebar', 'hideSidebar', 'showSidebar']), {
        resolveActive: function resolveActive(sidebarItems) {
            var _this = this;

            sidebarItems.forEach(function (sidebarItem) {
                if (sidebarItem.href === _this.active) {
                    sidebarItem.setActiveAndOpenParents();
                } else if (sidebarItem.$children.length > 0) {
                    _this.resolveActive(sidebarItem.$children);
                }
            });
        }
    })
};

/***/ },

/***/ 252:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var cContent = __webpack_require__(497);
exports.cContent = cContent;
var cSidebar = __webpack_require__(499);
exports.cSidebar = cSidebar;
var cSidebarItem = __webpack_require__(498);
exports.cSidebarItem = cSidebarItem;
//# sourceMappingURL=index.js.map

/***/ },

/***/ 39:
/***/ function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
var resize_1 = __webpack_require__(64);
exports.resize = resize_1.default;
var layout_1 = __webpack_require__(45);
exports.layout = layout_1.default;
__export(__webpack_require__(65));
//# sourceMappingURL=index.js.map

/***/ },

/***/ 40:
/***/ function(module, exports, __webpack_require__) {

"use strict";


function md5cycle(x, k) {
    var a = x[0],
        b = x[1],
        c = x[2],
        d = x[3];
    a = ff(a, b, c, d, k[0], 7, -680876936);
    d = ff(d, a, b, c, k[1], 12, -389564586);
    c = ff(c, d, a, b, k[2], 17, 606105819);
    b = ff(b, c, d, a, k[3], 22, -1044525330);
    a = ff(a, b, c, d, k[4], 7, -176418897);
    d = ff(d, a, b, c, k[5], 12, 1200080426);
    c = ff(c, d, a, b, k[6], 17, -1473231341);
    b = ff(b, c, d, a, k[7], 22, -45705983);
    a = ff(a, b, c, d, k[8], 7, 1770035416);
    d = ff(d, a, b, c, k[9], 12, -1958414417);
    c = ff(c, d, a, b, k[10], 17, -42063);
    b = ff(b, c, d, a, k[11], 22, -1990404162);
    a = ff(a, b, c, d, k[12], 7, 1804603682);
    d = ff(d, a, b, c, k[13], 12, -40341101);
    c = ff(c, d, a, b, k[14], 17, -1502002290);
    b = ff(b, c, d, a, k[15], 22, 1236535329);
    a = gg(a, b, c, d, k[1], 5, -165796510);
    d = gg(d, a, b, c, k[6], 9, -1069501632);
    c = gg(c, d, a, b, k[11], 14, 643717713);
    b = gg(b, c, d, a, k[0], 20, -373897302);
    a = gg(a, b, c, d, k[5], 5, -701558691);
    d = gg(d, a, b, c, k[10], 9, 38016083);
    c = gg(c, d, a, b, k[15], 14, -660478335);
    b = gg(b, c, d, a, k[4], 20, -405537848);
    a = gg(a, b, c, d, k[9], 5, 568446438);
    d = gg(d, a, b, c, k[14], 9, -1019803690);
    c = gg(c, d, a, b, k[3], 14, -187363961);
    b = gg(b, c, d, a, k[8], 20, 1163531501);
    a = gg(a, b, c, d, k[13], 5, -1444681467);
    d = gg(d, a, b, c, k[2], 9, -51403784);
    c = gg(c, d, a, b, k[7], 14, 1735328473);
    b = gg(b, c, d, a, k[12], 20, -1926607734);
    a = hh(a, b, c, d, k[5], 4, -378558);
    d = hh(d, a, b, c, k[8], 11, -2022574463);
    c = hh(c, d, a, b, k[11], 16, 1839030562);
    b = hh(b, c, d, a, k[14], 23, -35309556);
    a = hh(a, b, c, d, k[1], 4, -1530992060);
    d = hh(d, a, b, c, k[4], 11, 1272893353);
    c = hh(c, d, a, b, k[7], 16, -155497632);
    b = hh(b, c, d, a, k[10], 23, -1094730640);
    a = hh(a, b, c, d, k[13], 4, 681279174);
    d = hh(d, a, b, c, k[0], 11, -358537222);
    c = hh(c, d, a, b, k[3], 16, -722521979);
    b = hh(b, c, d, a, k[6], 23, 76029189);
    a = hh(a, b, c, d, k[9], 4, -640364487);
    d = hh(d, a, b, c, k[12], 11, -421815835);
    c = hh(c, d, a, b, k[15], 16, 530742520);
    b = hh(b, c, d, a, k[2], 23, -995338651);
    a = ii(a, b, c, d, k[0], 6, -198630844);
    d = ii(d, a, b, c, k[7], 10, 1126891415);
    c = ii(c, d, a, b, k[14], 15, -1416354905);
    b = ii(b, c, d, a, k[5], 21, -57434055);
    a = ii(a, b, c, d, k[12], 6, 1700485571);
    d = ii(d, a, b, c, k[3], 10, -1894986606);
    c = ii(c, d, a, b, k[10], 15, -1051523);
    b = ii(b, c, d, a, k[1], 21, -2054922799);
    a = ii(a, b, c, d, k[8], 6, 1873313359);
    d = ii(d, a, b, c, k[15], 10, -30611744);
    c = ii(c, d, a, b, k[6], 15, -1560198380);
    b = ii(b, c, d, a, k[13], 21, 1309151649);
    a = ii(a, b, c, d, k[4], 6, -145523070);
    d = ii(d, a, b, c, k[11], 10, -1120210379);
    c = ii(c, d, a, b, k[2], 15, 718787259);
    b = ii(b, c, d, a, k[9], 21, -343485551);
    x[0] = add32(a, x[0]);
    x[1] = add32(b, x[1]);
    x[2] = add32(c, x[2]);
    x[3] = add32(d, x[3]);
}
function cmn(q, a, b, x, s, t) {
    a = add32(add32(a, q), add32(x, t));
    return add32(a << s | a >>> 32 - s, b);
}
function ff(a, b, c, d, x, s, t) {
    return cmn(b & c | ~b & d, a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t) {
    return cmn(b & d | c & ~d, a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t) {
    return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t) {
    return cmn(c ^ (b | ~d), a, b, x, s, t);
}
function md51(s) {
    var txt = '';
    var n = s.length,
        state = [1732584193, -271733879, -1732584194, 271733878],
        i;
    for (i = 64; i <= s.length; i += 64) {
        md5cycle(state, md5blk(s.substring(i - 64, i)));
    }
    s = s.substring(i - 64);
    var tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (i = 0; i < s.length; i++) {
        tail[i >> 2] |= s.charCodeAt(i) << (i % 4 << 3);
    }tail[i >> 2] |= 0x80 << (i % 4 << 3);
    if (i > 55) {
        md5cycle(state, tail);
        for (i = 0; i < 16; i++) {
            tail[i] = 0;
        }
    }
    tail[14] = n * 8;
    md5cycle(state, tail);
    return state;
}
function md5blk(s) {
    var md5blks = [],
        i;
    for (i = 0; i < 64; i += 4) {
        md5blks[i >> 2] = s.charCodeAt(i) + (s.charCodeAt(i + 1) << 8) + (s.charCodeAt(i + 2) << 16) + (s.charCodeAt(i + 3) << 24);
    }
    return md5blks;
}
var hex_chr = '0123456789abcdef'.split('');
function rhex(n) {
    var s = '',
        j = 0;
    for (; j < 4; j++) {
        s += hex_chr[n >> j * 8 + 4 & 0x0F] + hex_chr[n >> j * 8 & 0x0F];
    }return s;
}
function hex(x) {
    for (var i = 0; i < x.length; i++) {
        x[i] = rhex(x[i]);
    }return x.join('');
}
function md5(s) {
    return hex(md51(s));
}
function add32(a, b) {
    return a + b & 0xFFFFFFFF;
}
Object.defineProperty(exports, "__esModule", { value: true });
exports.default = md5;
//# sourceMappingURL=md5.js.map

/***/ },

/***/ 45:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var utils_1 = __webpack_require__(14);
Object.defineProperty(exports, "__esModule", { value: true });
exports.default = {
    data: function data() {
        return { isMd: false };
    },
    created: function created() {
        this.isMd = this.isBreakpointUp('md');
    },

    methods: {
        getViewPort: utils_1.getViewPort,
        getElementHeight: utils_1.getElementHeight,
        getBreakpoints: function getBreakpoints() {
            return Object.keys(Vue.codex.breakpoints);
        },
        getBreakpoint: function getBreakpoint(breakpoint) {
            return parseInt(Vue.codex.breakpoints[breakpoint]);
        },
        isBreakpointUp: function isBreakpointUp(breakpoint) {
            if (typeof breakpoint === 'string') breakpoint = this.getBreakpoint(breakpoint);
            return parseInt(this.getViewPort().width) >= parseInt(breakpoint);
        },
        isBreakpointDown: function isBreakpointDown(breakpoint) {
            if (typeof breakpoint === 'string') breakpoint = this.getBreakpoint(breakpoint);
            return parseInt(this.getViewPort().width) <= parseInt(breakpoint);
        }
    }
};
//# sourceMappingURL=layout.js.map

/***/ },

/***/ 46:
/***/ function(module, exports, __webpack_require__) {

"use strict";


function createBodyClickListener(fn) {
    var isListening = false;
    function start(cb) {
        window.addEventListener('click', _onclick, true);
        window.addEventListener('keyup', _onescape, true);
        isListening = true;
        if (typeof cb === 'function') cb();
    }
    function stop(cb) {
        window.removeEventListener('click', _onclick, true);
        window.removeEventListener('keyup', _onescape, true);
        isListening = false;
        if (typeof cb === 'function') cb();
    }
    function _onclick(e) {
        e.preventDefault();
        if (typeof fn === 'function') fn(e);
        stop();
    }
    function _onescape(e) {
        if (e.keyCode === 27) _onclick(e);
    }
    return {
        start: start, stop: stop,
        get isListening() {
            return isListening;
        }
    };
}
exports.createBodyClickListener = createBodyClickListener;
//# sourceMappingURL=body-click-listener.js.map

/***/ },

/***/ 47:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var lodash_1 = __webpack_require__(6);
function getRandomId(length) {
    if (lodash_1.isNumber(length)) {
        length = 15;
    }
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}
exports.getRandomId = getRandomId;
function load(vNodeContext, cb) {
    if (document.readyState === 'complete') {
        vNodeContext.$nextTick(function () {
            return cb();
        });
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            return cb();
        });
    }
}
exports.load = load;
function getViewPort() {
    var e = window,
        a = 'inner';
    if (!('innerWidth' in window)) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return {
        width: e[a + 'Width'],
        height: e[a + 'Height']
    };
}
exports.getViewPort = getViewPort;
function isTouchDevice() {
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }
}
exports.isTouchDevice = isTouchDevice;
function getElementHeight(element) {
    if (!element['getClientRects']().length) {
        return element.offsetHeight;
    }
    var rect = element.getBoundingClientRect();
    if (rect.width || rect.height) {
        return rect.bottom - rect.top;
    }
    return 0;
}
exports.getElementHeight = getElementHeight;
function listen(target, eventType, callback) {
    if (target.addEventListener) {
        target.addEventListener(eventType, callback, false);
        return {
            remove: function remove() {
                target.removeEventListener(eventType, callback, false);
            }
        };
    } else if (target.attachEvent) {
        target.attachEvent("on" + eventType, callback);
        return {
            remove: function remove() {
                target.detachEvent("on" + eventType, callback);
            }
        };
    }
}
exports.listen = listen;
function getScroll(w, top) {
    var ret = w["page" + (top ? 'Y' : 'X') + "Offset"];
    var method = "scroll" + (top ? 'Top' : 'Left');
    if (typeof ret !== 'number') {
        var d = w.document;
        ret = d.documentElement[method];
        if (typeof ret !== 'number') {
            ret = d.body[method];
        }
    }
    return ret;
}
exports.getScroll = getScroll;
function getOffset(element) {
    var elm = element;
    var top = elm.offsetTop;
    var left = elm.offsetLeft;
    while (elm.offsetParent !== null) {
        elm = elm.offsetParent;
        top += elm.offsetTop;
        left += elm.offsetLeft;
    }
    return {
        top: top,
        left: left
    };
}
exports.getOffset = getOffset;
function cssTransitions() {
    if (typeof document === 'undefined') return false;
    var style = document.documentElement.style;
    return style['webkitTransition'] !== undefined || style['MozTransition'] !== undefined || style['OTransition'] !== undefined || style['MsTransition'] !== undefined || style.transition !== undefined;
}
exports.cssTransitions = cssTransitions;
function escapeHash(hash) {
    return hash.replace(/(:|\.|\[|\]|,|=)/g, "\\$1");
}
exports.escapeHash = escapeHash;
function registerJqueryHelpers($) {
    if ($.fn.prefixedData !== undefined) {
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
    $.fn.ensureClass = function (clas) {
        var has = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

        var $this = $(this);
        if (has === true && $this.hasClass(clas) === false) {
            $this.addClass(clas);
        } else if (has === false && $this.hasClass(clas) === true) {
            $this.removeClass(clas);
        }
        return this;
    };
    $.fn.onClick = function () {
        var $this = $(this);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        return $this.on.apply($this, [isTouchDevice() ? 'touchend' : 'click'].concat(args));
    };
}
exports.registerJqueryHelpers = registerJqueryHelpers;
function parseBool(val) {
    return val === true || val === 1 || val === 'true' || val === '1';
}
exports.parseBool = parseBool;
function setCookie(k, v) {
    Vue.cookie.set(k, JSON.stringify(v));
}
exports.setCookie = setCookie;
function getCookie(k) {
    return JSON.parse(Vue.cookie.get(k));
}
exports.getCookie = getCookie;
function getRefInParents(ref, parent) {
    if (parent.$root === parent) return false;
    if (parent.$refs[ref] !== undefined) {
        return parent.$refs[ref];
    }
    return getRefInParents(ref, parent.$parent);
}
exports.getRefInParents = getRefInParents;
//# sourceMappingURL=general.js.map

/***/ },

/***/ 48:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Loader = function () {
    function Loader(loaderId, bodyLoadingClass, loaderClassSuffix) {
        _classCallCheck(this, Loader);

        this.loaderId = loaderId;
        this.bodyLoadingClass = bodyLoadingClass;
        this.loaderClassSuffix = loaderClassSuffix;
        this.isLoading = false;
    }

    _createClass(Loader, [{
        key: 'start',
        value: function start() {
            this.getLoaderElement();
            if (!this.bodyClass.contains(this.bodyLoadingClass)) {
                this.bodyClass.add(this.bodyLoadingClass);
            }
        }
    }, {
        key: 'stop',
        value: function stop() {
            this.bodyClass.remove(this.bodyLoadingClass);
        }
    }, {
        key: 'getLoaderElement',
        value: function getLoaderElement() {
            var container = document.getElementById(this.loaderId);
            var loader = void 0;
            if (!container) {
                container = document.createElement('div');
                container.setAttribute('id', this.loaderId);
                document.body.appendChild(container);
                loader = document.createElement('div');
                loader.classList.add('loader');
                loader.classList.add('loader-' + this.loaderClassSuffix);
            } else {
                loader = container.children[0];
            }
            return container;
        }
    }, {
        key: 'bodyClass',
        get: function get() {
            return document.body.classList;
        }
    }]);

    return Loader;
}();

Object.defineProperty(exports, "__esModule", { value: true });
exports.default = Loader;
//# sourceMappingURL=loader.js.map

/***/ },

/***/ 493:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* styles */
__webpack_require__(589)

/* script */
__vue_exports__ = __webpack_require__(201)

/* template */
var __vue_template__ = __webpack_require__(544)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "/home/radic/codex-theme/node_modules/vue-bulma-collapse/src/Collapse.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-18b56265", __vue_options__)
  } else {
    hotAPI.reload("data-v-18b56265", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] Collapse.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 494:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* styles */
__webpack_require__(592)

/* script */
__vue_exports__ = __webpack_require__(202)

/* template */
var __vue_template__ = __webpack_require__(568)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "/home/radic/codex-theme/node_modules/vue-bulma-collapse/src/Item.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-84a8326a", __vue_options__)
  } else {
    hotAPI.reload("data-v-84a8326a", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] Item.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 497:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(205)

/* template */
var __vue_template__ = __webpack_require__(567)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "/home/radic/codex-theme/src/components/document/content.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-83ae7a68", __vue_options__)
  } else {
    hotAPI.reload("data-v-83ae7a68", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] content.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 498:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(206)

/* template */
var __vue_template__ = __webpack_require__(560)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "/home/radic/codex-theme/src/components/document/sidebar-item.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4811cfbe", __vue_options__)
  } else {
    hotAPI.reload("data-v-4811cfbe", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] sidebar-item.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 499:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(207)

/* template */
var __vue_template__ = __webpack_require__(569)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "/home/radic/codex-theme/src/components/document/sidebar.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-86411fa2", __vue_options__)
  } else {
    hotAPI.reload("data-v-86411fa2", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] sidebar.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 544:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('div', {
    staticClass: "collapse is-fullwidth"
  }, [_vm._t("default")])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-18b56265", module.exports)
  }
}

/***/ },

/***/ 560:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('li', {
    class: {
      'open': _vm.open, 'active': _vm.active
    }
  }, [_vm._h('a', {
    attrs: {
      "id": _vm.id,
      "href": _vm.link
    },
    on: {
      "click": function($event) {
        _vm.handleLinkClick()
      }
    }
  }, [(_vm.icon) ? _vm._h('i', {
    class: _vm.icon
  }) : _vm._e(), " ", _vm._h('span', {
    staticClass: "title"
  }, [_vm._s(_vm.title)]), " ", (_vm.hasChildren) ? _vm._h('span', {
    staticClass: "arrow"
  }) : _vm._e()]), " ", (_vm.hasChildren) ? _vm._h('transition', {
    attrs: {
      "css": false
    },
    on: {
      "enter": _vm.slideEnter,
      "leave": _vm.slideLeave
    }
  }, [(_vm.hasChildren) ? _vm._h('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.open),
      expression: "open"
    }],
    staticClass: "sub-menu"
  }, [_vm._t("default")]) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-4811cfbe", module.exports)
  }
}

/***/ },

/***/ 567:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('div', {
    staticClass: "c-content",
    style: (_vm.outerStyle)
  }, [_vm._t("breadcrumb"), " ", (_vm.html) ? _vm._h('article', {
    staticClass: "document"
  }, [_vm._h('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.html)
    }
  })]) : _vm._h('article', {
    staticClass: "document",
    style: (_vm.innerStyle)
  }, [_vm._t("default")]), " "])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-83ae7a68", module.exports)
  }
}

/***/ },

/***/ 568:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('div', {
    staticClass: "card collapse-item",
    class: {
      'is-fullwidth': _vm.$parent.isFullwidth, 'is-active': _vm.isActived
    }
  }, [_vm._h('header', {
    staticClass: "card-header touchable",
    attrs: {
      "role": "tab",
      "aria-expanded": _vm.selected ? 'true' : 'fase'
    },
    on: {
      "click": _vm.toggle
    }
  }, [_vm._h('h3', {
    staticClass: "card-header-title"
  }, [_vm._s(_vm.title)]), " ", _vm._m(0)]), " ", _vm._h('transition', {
    attrs: {
      "name": "collapsed-fade",
      "css": false,
      "appear": ""
    },
    on: {
      "before-appear": _vm.before,
      "appear": _vm.enter,
      "appear-cancel": _vm.cancel,
      "before-enter": _vm.before,
      "enter": _vm.enter,
      "enter-cancel": _vm.cancel,
      "leave": _vm.leave,
      "leave-cancel": _vm.cancel
    }
  }, [_vm._h('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.isActived),
      expression: "isActived"
    }],
    staticClass: "card-content"
  }, [_vm._h('div', {
    staticClass: "card-content-box"
  }, [_vm._t("default")])])])])
},staticRenderFns: [function (){var _vm=this;
  return _vm._h('span', {
    staticClass: "card-header-icon"
  }, [_vm._h('i', {
    staticClass: "fa fa-angle-right"
  })])
}]}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-84a8326a", module.exports)
  }
}

/***/ },

/***/ 569:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('aside', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.sidebar.hidden === false),
      expression: "sidebar.hidden === false"
    }],
    staticClass: "c-sidebar"
  }, [_vm._h('nav', {
    ref: "inner",
    staticClass: "sidebar-inner",
    style: (_vm.innerStyle)
  }, [_vm._h('ul', [_vm._t("default")])])])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-86411fa2", module.exports)
  }
}

/***/ },

/***/ 589:
/***/ function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(121);
if(typeof content === 'string') content = [[module.i, content, '']];
// add the styles to the DOM
var update = __webpack_require__(44)(content, {});
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(true) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept(121, function() {
			var newContent = __webpack_require__(121);
			if(typeof newContent === 'string') newContent = [[module.i, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ },

/***/ 592:
/***/ function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(124);
if(typeof content === 'string') content = [[module.i, content, '']];
// add the styles to the DOM
var update = __webpack_require__(44)(content, {});
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(true) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept(124, function() {
			var newContent = __webpack_require__(124);
			if(typeof newContent === 'string') newContent = [[module.i, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ },

/***/ 596:
/***/ function(module, exports, __webpack_require__) {

__webpack_require__(31);
module.exports = __webpack_require__(176);


/***/ },

/***/ 6:
/***/ function(module, exports) {

module.exports = _;

/***/ },

/***/ 64:
/***/ function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(_) {

var vuex_1 = __webpack_require__(9);
Object.defineProperty(exports, "__esModule", { value: true });
exports.default = {
    mixins: [],
    data: function data() {
        return {
            resize: 0
        };
    },

    computed: vuex_1.mapGetters(['heights']),
    mounted: function mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy: function beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },

    methods: _.merge(vuex_1.mapActions(['updateHeights']), {
        handleResize: function handleResize(event) {
            var _this = this;

            if (this.resize) clearTimeout(this.resize);
            this.resize = setTimeout(function () {
                _this.$emit('resize');
            }, 50);
        }
    })
};
//# sourceMappingURL=resize.js.map
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(6)))

/***/ },

/***/ 65:
/***/ function(module, exports, __webpack_require__) {

"use strict";


exports.scrollable = {
    props: {
        scrollable: Boolean,
        maxHeight: Number,
        height: Number,
        minHeight: Number
    },
    mounted: function mounted() {
        var classList = this.$el.classList;
        if (this.scrollable) {
            if (!classList.contains('scrollable')) {
                classList.add('scrollable');
            }
        }
    },

    computed: {
        scrollStyle: function scrollStyle() {
            var style = {};
            if (this.scrollable) {
                if (this.height) {
                    style['height'] = parseInt(this.height) + 'px';
                } else {
                    if (this.minHeight) {
                        style['minHeight'] = parseInt(this.minHeight) + 'px';
                    }
                    if (this.maxHeight) {
                        style['maxHeight'] = parseInt(this.maxHeight) + 'px';
                    }
                }
            }
            return style;
        }
    }
};
//# sourceMappingURL=scrollable.js.map

/***/ },

/***/ 9:
/***/ function(module, exports) {

module.exports = Vuex;

/***/ },

/***/ 90:
/***/ function(module, exports, __webpack_require__) {

"use strict";


exports.slide = {
    slideEnter: function slideEnter(el, done) {
        this.$$(el).slideDown({
            duration: 300,
            done: done
        });
    },
    slideLeave: function slideLeave(el, done) {
        this.$$(el).slideUp({
            duration: 300,
            done: done
        });
    }
};
function cSlide() {
    var duration = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;

    return {
        slideEnter: function slideEnter(el, done) {
            this.$$(el).slideDown({
                duration: duration,
                done: done
            });
        },
        slideLeave: function slideLeave(el, done) {
            this.$$(el).slideUp({
                duration: duration,
                done: done
            });
        }
    };
}
exports.cSlide = cSlide;
exports.fade = {
    fadeEnter: function fadeEnter(el, done) {
        this.$$(el).fadeIn({
            duration: 300,
            done: done
        });
    },
    fadeLeave: function fadeLeave(el, done) {
        this.$$(el).fadeOut({
            duration: 300,
            done: done
        });
    }
};
//# sourceMappingURL=transitions.js.map

/***/ }

},[596]);
//# sourceMappingURL=codex.page.document.js.map