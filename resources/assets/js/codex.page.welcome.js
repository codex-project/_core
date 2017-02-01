webpackJsonp([4,7],{

/***/ 128:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/fa-puzzle-piece-140x140-37474f.png";

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

/***/ 179:
/***/ function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

__webpack_require__(471);

__webpack_require__(470);

__webpack_require__(467);

__webpack_require__(468);

__webpack_require__(469);

__webpack_require__(472);

__webpack_require__(473);

__webpack_require__(128);

__webpack_require__(466);

__webpack_require__(465);

var _vue = __webpack_require__(2);

var _vue2 = _interopRequireDefault(_vue);

var _welcome = __webpack_require__(255);

var _welcome2 = _interopRequireDefault(_welcome);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var codex = window.codex;

Object.keys(_welcome2.default).forEach(function (key) {
    return _vue2.default.component(key, _welcome2.default[key]);
});
var wow = new WOW({
    mobile: false
});
wow.init();

var _Vuex = Vuex,
    mapGetters = _Vuex.mapGetters,
    mapActions = _Vuex.mapActions,
    Store = _Vuex.Store;

var store = new Store({});
_vue2.default.use(codex.CodexPlugin, { store: store });

_vue2.default.codex.extend({ wow: wow, store: store });

var App = _vue2.default.extend({
    store: store,

    mixins: [_vue2.default.codex.mixins.layout, _vue2.default.codex.mixins.resize],
    //        template: welcome(),
    data: function data() {
        return {
            carouselHeight: 9999
        };
    },
    mounted: function mounted() {
        var _this = this;

        this.updateHeight();
        this.$on('resize', function () {
            return _this.updateHeight();
        });
        this.$nextTick(function () {
            _this.$$el.css('display', 'block');
        });

        this.$$ready(function () {
            _this.$nextTick(function () {
                return codex.loader.stop();
            });
            var $header = $(_this.$refs.header.$el);
            _this.$$('.scrollspy').scrollSpy({
                scrollOffset: $header.outerHeight(true) + 1
            }); //.on('scrollSpy:enter', console.log.bind(console)).on('scrollSpy:exit', console.log.bind(console))
        });
    },

    methods: {
        updateHeight: function updateHeight() {
            this.carouselHeight = this.getViewPort().height + 1;
        }
    }
});

codex.App = App;
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(15)))

/***/ },

/***/ 2:
/***/ function(module, exports) {

module.exports = Vue;

/***/ },

/***/ 241:
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
    name: 'carousel-item',
    props: {
        img: String
    },
    computed: {
        styles: function styles() {
            var styles = {};
            if (this.img) {
                styles['background-image'] = 'url(\'' + this.img + '\')';
            }
            return styles;
        }
    }
    //        data(){return {src: ''}},
    //        mounted(){
    //            /** @type HTMLElement */
    //            let e = this.$el;
    //            let imgs = e.getElementsByTagName('img');
    //
    //            if(imgs.length === 0){
    //                this.src = this.img;
    //            } else {
    //                this.src = imgs[0].getAttribute('src');
    //                e.removeChild(imgs[0]);
    //            }
    //        }
};

/***/ },

/***/ 242:
/***/ function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _utils = __webpack_require__(14);

var _layout = __webpack_require__(45);

var _layout2 = _interopRequireDefault(_layout);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// this is directly linked to the bootstrap animation timing in _carousel.scss
// for browsers that do not support transitions like IE9 just change slide immediately
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
//
//
//
//
//
//
//
//


/**
 * Carousel Notes
 * - Ie9 does not support transitions and might require javascript fallbacks. B4 deliberately dropped support for this.
 * - It is not accessible.
 *
 * How it works:
 * - active element applies the transition to the slide but not triggers it
 * - we need to use 'right' and 'left' classes to trigger animation
 * - 'next' and 'prev' class makes the incoming slide positioned absolute, so it can follow outgoing slide
 *
 * To slide right to left we have to:
 * - add class 'active', 'next', and right to the next slide
 * - add class 'left' on the current slide same time as remove the 'right' class on the incoming one
 * - remove all classes and only leave 'active' on the incoming slide0ok0-
 *
 *
 *
 */

var TRANSITION_DURATION = (0, _utils.cssTransitions)() ? 600 : 0;

// when next is set, we want to move from right to left
// when previous is set, we want to move from left to right
var DIRECTION = {
    rtl: {
        outgoing: 'left',
        incoming: 'right',
        overlay: 'next'
    },
    ltr: {
        outgoing: 'right',
        incoming: 'left',
        overlay: 'prev'
    }
};

exports.default = {
    mixins: [_layout2.default],
    data: function data() {
        return {
            index: 0,
            slidesCount: 0,
            animating: false,
            slides: [],
            direction: DIRECTION.rtl,
            style: { height: 'auto' }
        };
    },

    props: {
        interval: { type: Number, default: 5000 },
        indicators: { type: Boolean, default: true },
        controls: { type: Boolean, default: true },
        height: { type: Number, default: 0 },
        fullscreen: { type: Boolean, default: false },
        controlBottom: { type: [Boolean, String], default: false }
    },
    mounted: function mounted() {
        this.updateHeight(this.height);

        // get all slides
        this._items = this.$el.querySelectorAll('.carousel-item');

        this.slidesCount = this._items.length - 1;
        this.slides = Array.apply(null, { length: this._items.length }).map(Number.call, Number);

        // set first slide as active
        this._items[0].classList.add('active');

        // auto rotate slides
        this.start();
    },
    destroyed: function destroyed() {
        clearTimeout(this._carouselAnimation);
        clearInterval(this._intervalId);
    },

    computed: {
        classes: function classes() {
            return ['carousel', 'carousel-codex', 'slide', 'carousel-slide-' + this.index];
        }
    },
    methods: {
        // previous slide
        prev: function prev() {
            if (this.animating) return;
            this.index--;
            if (this.index < 0) {
                this.index = this.slidesCount;
            }
        },

        // next slide
        next: function next() {
            if (this.animating) return;
            this.index++;
            if (this.index > this.slidesCount) {
                this.index = 0;
            }
        },

        // on slide change
        changeSlide: function changeSlide(index) {
            this.index = index;
        },

        // pause auto rotation
        pause: function pause() {
            if (this.interval === 0 || typeof this.interval === 'undefined') return;
            clearInterval(this._intervalId);
        },

        // start auto rotate slides
        start: function start() {
            var _this = this;

            if (this.interval === 0 || typeof this.interval === 'undefined') return;
            this._intervalId = setInterval(function () {
                _this.next();
            }, this.interval);
        },
        updateHeight: function updateHeight(height) {
            height = isNaN(height) ? height : parseInt(height) + 'px';
            this.style.height = height;
            //                this.height = height;
            /**
             * @param {HTMLElement} item
             */
            function ea(item) {
                item.style.height = isNaN(height) ? height : parseInt(height) + 'px';
            }

            //                this._items.forEach(ea.bind(this))
        }
    },
    watch: {
        height: function height(val, oldVal) {
            this.updateHeight(val);
            //                this.$$ready(() => this._items.forEach((item) => this.$$(item).css('height', this.height) ))
        },
        index: function index(val, oldVal) {
            var _this2 = this;

            this.animating = true;
            this.direction = DIRECTION.rtl;

            // when previous is pressed we want to move from left to right
            if (val < oldVal) {
                this.direction = DIRECTION.ltr;
            }

            // lets animate
            // prepare next slide to animate (position it on the opposite side of the direction as a starting point)
            this._items[val].classList.add(this.direction.incoming, this.direction.overlay);
            // reflow
            this._items[val].offsetWidth; // TODO !
            // add class active
            this._items[val].classList.add('active');
            // trigger animation on outgoing and incoming slide
            this._items[oldVal].classList.add(this.direction.outgoing);
            this._items[val].classList.remove(this.direction.incoming);
            // wait for animation to finish and cleanup classes
            this._carouselAnimation = setTimeout(function () {
                _this2._items[oldVal].classList.remove(_this2.direction.outgoing, 'active');
                _this2._items[val].classList.remove(_this2.direction.overlay);
                _this2.animating = false;
                // trigger an event
                _this2.$root.$emit('slid::carousel', val);
            }, TRANSITION_DURATION);
        }
    }
};

/***/ },

/***/ 243:
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
//
//


exports.default = {
    name: 'c-section',
    props: {
        fullWidth: { type: Boolean, default: false },
        scheme: { type: [String, Boolean], default: false },
        title: String,
        titleTag: { type: String, default: 'h2' }
    },

    data: function data() {
        return {
            classes: 'c-section-light',
            schemes: {
                light: 'c-section-light',
                dark: 'c-section-dark'
            }
        };
    },
    mounted: function mounted() {},

    computed: {
        classes: function classes() {
            var cls = ['c-section'];
            if (this.scheme === false) return '';
            if (Object.keys(this.schemes).indexOf(this.scheme) === -1) {
                return console.warn('Scheme "%s" not valid for section.', this.scheme);
            }
            return this.schemes[this.scheme];
        }
    },
    methods: {}
};

/***/ },

/***/ 255:
/***/ function(module, exports, __webpack_require__) {

"use strict";


var cCarousel = __webpack_require__(534);
exports.cCarousel = cCarousel;
var cCarouselItem = __webpack_require__(533);
exports.cCarouselItem = cCarouselItem;
var cSection = __webpack_require__(535);
exports.cSection = cSection;
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

/***/ 465:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/responsive.png";

/***/ },

/***/ 466:
/***/ function(module, exports) {

module.exports = "data:image/png;base64,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"

/***/ },

/***/ 467:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-addon-scan.png";

/***/ },

/***/ 468:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-speed-improvements.png";

/***/ },

/***/ 469:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-toolbar-styles.png";

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

/***/ 470:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/ss-codex-document.png";

/***/ },

/***/ 471:
/***/ function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/ss-codex-phpdoc.png";

/***/ },

/***/ 472:
/***/ function(module, exports) {

module.exports = "data:image/png;base64,bW9kdWxlLmV4cG9ydHMgPSB7c3JjU2V0Ol9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyA1NzZ3IisiLCIrX193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtaHRtbC03NjgucG5nIDc2OHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTkyMi5wbmcgOTIydyIrIiwiK19fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtMTIwMC5wbmcgMTIwMHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTIwMDAucG5nIDIwMDB3IixpbWFnZXM6W3twYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyIsd2lkdGg6NTc2LGhlaWdodDoyODh9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNzY4LnBuZyIsd2lkdGg6NzY4LGhlaWdodDozODR9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtOTIyLnBuZyIsd2lkdGg6OTIyLGhlaWdodDo0NjF9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtMTIwMC5wbmciLHdpZHRoOjEyMDAsaGVpZ2h0OjYwMH0se3BhdGg6X193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtaHRtbC0yMDAwLnBuZyIsd2lkdGg6MjAwMCxoZWlnaHQ6MTAwMH1dLHNyYzpfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTU3Ni5wbmciLHRvU3RyaW5nOmZ1bmN0aW9uKCl7cmV0dXJuIF9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyJ9LHBsYWNlaG9sZGVyOiAiZGF0YTppbWFnZS9wbmc7YmFzZTY0LGlWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFDZ0FBQUFVQ0FZQUFBRC9Sbis3QUFBQUFrbEVRVlI0QWV3YWZ0SUFBQVE5U1VSQlZKWEJ5WEtrU1JHRjBjODlJbkpRU3FvQ3JKZnMyY0Q3UHc4WUc2eTdpbElPL3hEaGZsR3FyZHBFV2czU09mYjNmL3d0bnpGaWdBQUR4SXZIelo2N1gvWWMvenNEeG5LZUdDVGY4K0Z4eTdJS3BkTlNsQ0ZPYlZBM2lRSTJleWM2K0ZTWk5NaE12a1VTKy9zOTgzbWw4anREdkRBTUliWnR3em82VC8rZUtNVXhNOElFNHY4VU54NGVHaEdDTkRJR21ERnBRQTEyZjM2a3o4WjJIaERPMUkrMDdjckJHajBhYzEvNEFWVkpTT0sxV2l0RnNMcW9YakF6eGdoS01Wb3RlREh1RDQyMWkzbnFmSGxha2VEK3pyZ3lNNjdjQ2prZEtZTGNPNGZ0am5VeVlvamowdmtoRmE0cTN4QVJSQlc3dlZQZEtjVnBkY004VnBZMVNCbS8vamFJRUZkbUJvaXJFYUk1bUJrUmdmSUJNOWhNblUvVGpEZWpaV093OGlPK0FTNVF6UUF6dmhLaWV1R3dLMFFacENleE9wZUxLTVVwUU5kZ3Uyc1UzOENhck92S1FsQnJaYnN4SXNWVmFVNHJSNnh1MEc3SEljVHBhV1lkS3orak1LNXFSQ0tKcnd4alJQRHBHT3k5c2ZYSzNHYmtRcU5nWmxSdmFCVE9mU0l6K2FvVXc0c1JLU1NoRG1zOW9DVmdIQmt0MlI0TU96dXpJQ0w0SG5kaEJyV1VRbWFTbWR4cXJXSjNzT2ZBZnJlbGorVDgrY1I1ZEtCelN3SmtnREF6ckFhN2V5RXFkYWtzNTRuTE5JRGdaeklEQ1NvU2tyalZhc1BEbUtaa21VOTg1c1RQbURudVBFdkVzK0djZjUzSVNONHJreGNWTTh5TTEwcXBiTTA1YVlFQnBSYXVJaEpKdkZhTGN6aFVJa1dtaUF5dWFvVnlhRmk5WXpsM3RLN0V1dkIyeGxVMU0yNWxCcE1TTDhhbUZid1ltWW5Tc0FLYm5iTnZqY3NVekhQbmVPcGtpb2M3WjU0NnBWYmNuSmhtekJjME9SSEJ1NGdYRmNTdDRzYjl3V0FuSEZHdFFEcGRnOU9wYy9rRW4zUGxWbWx3WDdiTWN4SVJxR3d4MzJPN2djOFRHY0Y3MVRFQ1NidzJJcm1jS3Z1cE1EQXViUWFEWXBWdHEzZ1pWQnBtVy96U09iR1NLWkRSUjhkTFF4SldWeXlDZVVxVXlYdUk1S3FXVW9nSWJxMDVnTXJCR2h1N0o2YVpjM2JNb05YS21xTEhpVzh4YzNwZmFYLzVLNXZ6Q25jVDgva0pTYnhWcVFYb1ZKNlpHZCt5YjQzeW9lRUJEeDgvOHFGM2pxZUp1UThpazFzU3p3eEplSEh5OHo5WjNKQWNTYnhIK2dhWXFUeVR4SzFTQ2t2dmZQblB4RnU1ODhJTWxFbDkvSWltUk1WNGJPSTRucEI0RTYwVFYxVVNtUEZhcVpXRE4yWjFxaFV3WGtRa2t2Z2VpUmRtQmhoc0h0bEVaejMreHROWWVZOEtyQmpWekRDSjF6S0NjeWJtaHBraFJFUWlpVnZ1UnEwR0dGZEtZUVZxSytqcFgzU2NlUVR2bFJnZ3FpUWs4VnB4NC81Z2FDT0tPV1NsRldlSkZReUtGN2ExY1RrUDFuVmdCbjBJU1poRFJCQVJsTU12TUpMTm44UitoYWZMYjBpOGladGpHTlhNdURVaXVad3ErMWFZcTNBTDVoaTRHeGgwSmIyc0xFdXlMSU92RHZzR0dGZVNVSW9hd0h6aW1BT0p0MnVPRUpYZmlSdHJEa3BzMkk3S3ZKM0JoVnNERTBNRGpjWnV0MkcvZjBCUEY3N2t3cFVraWpmcWJzTTRud21lZVdIakJTclBEQkJnL01INGcySE15MEsvZEl6Qy93RDVrcW1Galk5S3NBQUFBQUJKUlU1RXJrSmdnZz09Iix3aWR0aDo1NzYsaGVpZ2h0OjI4OH07"

/***/ },

/***/ 473:
/***/ function(module, exports) {

module.exports = "data:image/jpeg;base64,bW9kdWxlLmV4cG9ydHMgPSB7c3JjU2V0Ol9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyA1NzZ3IisiLCIrX193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtdHlwZXdyaXRlci03NjguanBnIDc2OHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTkyMi5qcGcgOTIydyIrIiwiK19fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItMTIwMC5qcGcgMTIwMHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTIwMDAuanBnIDIwMDB3IixpbWFnZXM6W3twYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyIsd2lkdGg6NTc2LGhlaWdodDozODR9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNzY4LmpwZyIsd2lkdGg6NzY4LGhlaWdodDo1MTJ9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItOTIyLmpwZyIsd2lkdGg6OTIyLGhlaWdodDo2MTV9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItMTIwMC5qcGciLHdpZHRoOjEyMDAsaGVpZ2h0OjgwMH0se3BhdGg6X193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtdHlwZXdyaXRlci0yMDAwLmpwZyIsd2lkdGg6MjAwMCxoZWlnaHQ6MTMzNH1dLHNyYzpfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTU3Ni5qcGciLHRvU3RyaW5nOmZ1bmN0aW9uKCl7cmV0dXJuIF9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyJ9LHBsYWNlaG9sZGVyOiAiZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFBQUFRQUJBQUQvMndDRUFBSUJBUUVCQVFJQkFRRUNBZ0lDQWdRREFnSUNBZ1VFQkFNRUJnVUdCZ1lGQmdZR0J3a0lCZ2NKQndZR0NBc0lDUW9LQ2dvS0JnZ0xEQXNLREFrS0Nnb0JBZ0lDQWdJQ0JRTURCUW9IQmdjS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDdi9BQUJFSUFCc0FLQU1CRVFBQ0VRRURFUUgveEFHaUFBQUJCUUVCQVFFQkFRQUFBQUFBQUFBQUFRSURCQVVHQndnSkNnc1FBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNStnRUFBd0VCQVFFQkFRRUJBUUFBQUFBQUFBRUNBd1FGQmdjSUNRb0xFUUFDQVFJRUJBTUVCd1VFQkFBQkFuY0FBUUlERVFRRklURUdFa0ZSQjJGeEV5SXlnUWdVUXBHaHNjRUpJek5TOEJWaWN0RUtGaVEwNFNYeEZ4Z1pHaVluS0NrcU5UWTNPRGs2UTBSRlJrZElTVXBUVkZWV1YxaFpXbU5rWldabmFHbHFjM1IxZG5kNGVYcUNnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmk0K1RsNXVmbzZlcnk4L1QxOXZmNCtmci8yZ0FNQXdFQUFoRURFUUEvQVBudnhiKzFMOGNmaFg4Y0didzNmTm9NZWlhcEZJbGhiTzNsM3lJU1Y4ODhHUkhWamxlQmhzZFZCcm5vNERCNGpDYSs4MnQrM3A2SGs0M01NZFF4dkw4S2k5dTY4KzU5NmZ0QWZIV0Q0bi84RXlkYStQUHdjdlVqMUtWb2Jrb0ZXUjdLNE45R1pZbVZ1R1lCbkhvM0JIVUd2bjhCUytxWnNxZFRwZjhBSm5wWmh5WmpsamEybGIvMHBINWJhdG9YamZ4WnI4M2lYV2RHOFBYbC9lM0RUM053K2pSRnBaR0pZc2NEQkpKcjZuKzFLTVZhenQ2bmp3NGVySkpLWitqbi9CR3p3bDhRUGpQbzJ0SDRqM2tkMXBlblhFV21RcmFXaXdKQkJDa2JMRXUwRE9RK0FSbmdkZU1WOHpudGVOYXRUVVZiUnY3L0FQaGoyOGt3VU10bzFtbmR0cjhGL3dBRSsrZmpkK3poNEo4ZjZPSnJXeGcwNjhpbVdZTkZBTmtyQTV3eWpISi92RG51YzE1ZXl1anZvNGljSFo2by9IWHhoNEcrR3Y3Vy9qSzEwSHdGNGh0WWZFTVJjYmpqTndxUjRraTJqQnl2bDdnVHo4eHgwTmU5REVZakxJU2sxZGR2MS9Fd3I0TERacktLNXJOZGZ6Ujl0ZnNoZnNwZUR2aDk4QU5ZK0VPcTIvMiswMTYvVk5jam5QOEFyU0g4c0hqb2VPTWNqSEZmT1lqSFlyRVlyMnJkbXRyZEQxRmc4RmhzT3FNSTNqcmUvWDFLUGliL0FJSndmQXV3dmRXaTByUUowaXRkT1NTSUhVcHNCeVhKT04zdHpXTThibURkM08veVgrUnZTcFplb1dWTkx5VjdmbWU2L0FmNFZhZit6cloydmhyNFJXME9tV3MyK2E0dERGdmlubHpHQ3o5Q1RnWXlDRGdEbkhGWXV2aWFrK2VwTG1mbVM2V0VWUGtoQlJqNWFIZi9BQkQvQUduUEEzZ2o0ZTNmakx4dk8yblMyc2pRUTJFaDh4N3VmZVVWWWR2TXU1aHdBTjJPcWppdTJuTDJtaTNPRjRhU25aYkg0djhBd2kxcXgwNzQvYUY0aytDdmh2OEF0VHhtYkROL05lcDVkdGFUdkd5NzJVTUdtTzBIaFNNZzhzdWErbnhFS2tzTkwyN3RUVDB0dS84QUw4VGpvVG8vV0lxaEc4MnRYMFgrZjlhby9WYjRIWEd1YXg4T1Y4WXlhRUI1MnA3ZFFrdG0zb2txVEVQanVGREU4OUJqbnZYeWM0SlRkdGoxSnpWbEZ2VTNwZFR0NWJyeFdaVUpEV3lIbnNQS0kvcFdmTCtmK1E5dVgwL3pOYld2RUZycGVxMmx3VU9Iak8wQTlTV1RyMDlEVU9QVXFDYlZqdzc0cGZGTDRlNnQ0b3RkQzhRNkJzdnRKMUdlNXNMeThUaVBmTmhtVFBCQkFBM0RvY2c0enpqTEZWYUdLVktVWHl5dFpydjJ0L1gzSHBVTUg3WEN5cVFrdVpicnlYVzUrZDM3QnQ1Yy93RENkTmYrWisrTUNvWk5vemdSWnhYMytheGo3S3g4aGxNbTVOLzFzZnFvYjY3OEovc2NhUS9oMmRyUTNiV0J1REYxa054ZEkwMmMvd0I4dTJmOTQxOHUwblVhUFNXdGRITXk2dnFTMkhpVzVXN1lPMEFETUFPUjg0L2xXVmxkZXAwUFpmMTNMWHhSMUM5YndORHFQMmx4UDlrR0pWT0Q4M2w1NmZVMU5LS2N6VGI4VDUvMTlFOFgvczIrSE5lOFJ4cmRYa091WEt4WERLQXlxdHk2cUFWeHdBQU1lMWRrVXZiTXRlN2RJLy9aIix3aWR0aDo1NzYsaGVpZ2h0OjM4NH07"

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

/***/ 533:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(241)

/* template */
var __vue_template__ = __webpack_require__(578)
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
__vue_options__.__file = "/home/radic/codex-theme/src/components/welcome/carousel-item.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fbcbb288", __vue_options__)
  } else {
    hotAPI.reload("data-v-fbcbb288", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] carousel-item.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 534:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(242)

/* template */
var __vue_template__ = __webpack_require__(575)
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
__vue_options__.__file = "/home/radic/codex-theme/src/components/welcome/carousel.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e0a32698", __vue_options__)
  } else {
    hotAPI.reload("data-v-e0a32698", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] carousel.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 535:
/***/ function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* script */
__vue_exports__ = __webpack_require__(243)

/* template */
var __vue_template__ = __webpack_require__(561)
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
__vue_options__.__file = "/home/radic/codex-theme/src/components/welcome/section.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (true) {(function () {
  var hotAPI = __webpack_require__(1)
  hotAPI.install(__webpack_require__(2), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5d5526c1", __vue_options__)
  } else {
    hotAPI.reload("data-v-5d5526c1", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] section.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ },

/***/ 561:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('section', {
    staticClass: "c-section",
    class: _vm.classes
  }, [(_vm.fullWidth) ? _vm._t("default") : _vm._e(), " ", (_vm.fullWidth === false) ? _vm._h('div', {
    staticClass: "container"
  }, [_vm._t("default")]) : _vm._e()])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-5d5526c1", module.exports)
  }
}

/***/ },

/***/ 575:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('v-touch', {
    on: {
      "swipeleft": _vm.prev,
      "swiperight": _vm.next
    }
  }, [_vm._h('div', {
    class: _vm.classes,
    style: (_vm.style),
    attrs: {
      "data-ride": "carousel"
    },
    on: {
      "mouseenter": function($event) {
        _vm.pause()
      },
      "mouseleave": function($event) {
        _vm.start()
      }
    }
  }, [_vm._h('ol', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.indicators),
      expression: "indicators"
    }],
    staticClass: "carousel-indicators"
  }, [_vm._l((_vm.slides), function(slide, slideIndex) {
    return _vm._h('li', {
      class: {
        active: _vm.index == slideIndex
      },
      on: {
        "click": function($event) {
          _vm.changeSlide(slideIndex)
        }
      }
    })
  })]), " ", " ", _vm._h('div', {
    staticClass: "carousel-inner",
    attrs: {
      "role": "listbox"
    }
  }, [_vm._t("default")]), " ", " ", _vm._t("control-left", [_vm._h('a', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.controls && _vm.index > 0),
      expression: "controls && index > 0"
    }],
    staticClass: "left carousel-control",
    attrs: {
      "href": "#",
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.stopPropagation();
        $event.preventDefault();
        _vm.prev($event)
      }
    }
  }, [_vm._h('span', {
    staticClass: "icon-prev",
    attrs: {
      "aria-hidden": "true"
    }
  }), " ", _vm._h('span', {
    staticClass: "sr-only"
  }, ["Previous"])])]), " ", _vm._t("control-right", [_vm._h('a', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.controls && _vm.index < _vm.slidesCount),
      expression: "controls && index < slidesCount"
    }],
    staticClass: "right carousel-control",
    attrs: {
      "href": "#",
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.stopPropagation();
        $event.preventDefault();
        _vm.next($event)
      }
    }
  }, [_vm._h('span', {
    staticClass: "icon-next",
    attrs: {
      "aria-hidden": "true"
    }
  }), " ", _vm._h('span', {
    staticClass: "sr-only"
  }, ["Next"])])]), " ", _vm._t("control-bottom", [_vm._h('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }, {
      name: "show",
      rawName: "v-show",
      value: (_vm.controls && _vm.controlBottom !== false),
      expression: "controls && controlBottom !== false",
      arg: "href"
    }],
    staticClass: "bottom carousel-control bounce",
    attrs: {
      "href": _vm.controlBottom
    }
  }, [_vm._h('i', {
    staticClass: "fa fa-chevron-down"
  })])])])])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-e0a32698", module.exports)
  }
}

/***/ },

/***/ 578:
/***/ function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;
  return _vm._h('div', {
    staticClass: "carousel-item",
    style: (_vm.styles)
  }, [_vm._t("default")])
},staticRenderFns: []}
if (true) {
  module.hot.accept()
  if (module.hot.data) {
     __webpack_require__(1).rerender("data-v-fbcbb288", module.exports)
  }
}

/***/ },

/***/ 598:
/***/ function(module, exports, __webpack_require__) {

__webpack_require__(31);
module.exports = __webpack_require__(179);


/***/ },

/***/ 6:
/***/ function(module, exports) {

module.exports = _;

/***/ }

},[598]);
//# sourceMappingURL=codex.page.welcome.js.map