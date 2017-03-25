webpackJsonp([1,6],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(221)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(140),
  /* template */
  __webpack_require__(326),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 4 */
/***/ (function(module, exports) {

module.exports = _;

/***/ }),
/* 5 */,
/* 6 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_deep_assign__ = __webpack_require__(428);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_deep_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_deep_assign__);


const config = {
    disableRipple: false,

    UiAutocomplete: {
        keys: {
            label: 'label',
            value: 'value',
            image: 'image'
        }
    },

    UiCheckboxGroup: {
        keys: {
            id: 'id',
            name: 'name',
            class: 'class',
            label: 'label',
            value: 'value',
            disabled: 'disabled'
        }
    },

    UiMenu: {
        keys: {
            icon: 'icon',
            type: 'type',
            label: 'label',
            secondaryText: 'secondaryText',
            iconProps: 'iconProps',
            disabled: 'disabled'
        }
    },

    UiRadioGroup: {
        keys: {
            id: 'id',
            class: 'class',
            label: 'label',
            value: 'value',
            checked: 'checked',
            disabled: 'disabled'
        }
    },

    UiSelect: {
        keys: {
            label: 'label',
            value: 'value',
            image: 'image'
        }
    }
};

class KeenUiConfig {
    constructor() {
        this.data = __WEBPACK_IMPORTED_MODULE_0_deep_assign___default()(config, window.KeenUiConfig ? window.KeenUiConfig : {});
    }

    set(config = {}) {
        this.data = __WEBPACK_IMPORTED_MODULE_0_deep_assign___default()(this.data, config);
    }
}
/* harmony export (immutable) */ __webpack_exports__["KeenUiConfig"] = KeenUiConfig;


/* harmony default export */ __webpack_exports__["default"] = new KeenUiConfig();


/***/ }),
/* 7 */,
/* 8 */
/***/ (function(module, exports) {

module.exports = Vue;

/***/ }),
/* 9 */
/***/ (function(module, exports) {

module.exports = Vuex;

/***/ }),
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(242)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(151),
  /* template */
  __webpack_require__(350),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
Object.defineProperty(exports, "__esModule", { value: true });
__export(__webpack_require__(56));
__export(__webpack_require__(55));
var loader_1 = __webpack_require__(57);
exports.Loader = loader_1.default;
var md5_1 = __webpack_require__(40);
exports.md5 = md5_1.default;

/***/ }),
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
Object.defineProperty(exports, "__esModule", { value: true });
var resize_1 = __webpack_require__(83);
exports.resize = resize_1.default;
var layout_1 = __webpack_require__(81);
exports.layout = layout_1.default;
__export(__webpack_require__(84));

/***/ }),
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Adapted from dominus v6.0.1
 * https://github.com/bevacqua/dominus/blob/master/src/classes.js
 */

const trim = /^\s+|\s+$/g;
const whitespace = /\s+/g;

function interpret(input) {
    return typeof input === 'string' ? input.replace(trim, '').split(whitespace) : input;
}

function classes(el) {
    if (isElement(el)) {
        return el.className.replace(trim, '').split(whitespace);
    }

    return [];
}

function set(el, input) {
    if (isElement(el)) {
        el.className = interpret(input).join(' ');
    }
}

function add(el, input) {
    const current = remove(el, input);
    const values = interpret(input);

    current.push.apply(current, values);
    set(el, current);

    return current;
}

function remove(el, input) {
    const current = classes(el);
    const values = interpret(input);

    values.forEach(value => {
        const i = current.indexOf(value);
        if (i !== -1) {
            current.splice(i, 1);
        }
    });

    set(el, current);

    return current;
}

function contains(el, input) {
    const current = classes(el);
    const values = interpret(input);

    return values.every(value => {
        return current.indexOf(value) !== -1;
    });
}

function isElement(o) {
    const elementObjects = typeof HTMLElement === 'object';
    return elementObjects ? o instanceof HTMLElement : isElementObject(o);
}

function isElementObject(o) {
    return o &&
        typeof o === 'object' &&
        typeof o.nodeName === 'string' &&
        o.nodeType === 1;
}

/* harmony default export */ __webpack_exports__["a"] = {
    add,
    remove,
    contains,
    has: contains,
    set,
    get: classes
};


/***/ }),
/* 33 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export getDayFull */
/* unused harmony export getDayInitial */
/* unused harmony export getDayAbbreviated */
/* unused harmony export getMonthFull */
/* unused harmony export getMonthAbbreviated */
/* unused harmony export getDayOfMonth */
/* unused harmony export humanize */
/* unused harmony export clone */
/* unused harmony export moveToDayOfWeek */
/* unused harmony export isSameDay */
/* unused harmony export isBefore */
/* unused harmony export isAfter */
const defaultLang = {
    months: {
        full: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ],

        abbreviated: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]
    },

    days: {
        full: [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ],

        abbreviated: [
            'Sun',
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat'
        ],

        initials: [
            'S',
            'M',
            'T',
            'W',
            'T',
            'F',
            'S'
        ]
    }
};
/* unused harmony export defaultLang */


function pad(value, length) {
    while (value.length < length) {
        value = '0' + value;
    }

    return value;
}

function getDayFull(date, lang = defaultLang) {
    return lang.days.full[date.getDay()];
}

function getDayInitial(date, lang = defaultLang) {
    return lang.days.initials[date.getDay()];
}

function getDayAbbreviated(date, lang = defaultLang) {
    return lang.days.abbreviated[date.getDay()];
}

function getMonthFull(date, lang = defaultLang) {
    return lang.months.full[date.getMonth()];
}

function getMonthAbbreviated(date, lang = defaultLang) {
    return lang.months.abbreviated[date.getMonth()];
}

function getDayOfMonth(date, options = { pad: true }) {
    const day = date.getDate().toString();
    return options.pad ? pad(day) : day;
}

function humanize(date, lang = defaultLang) {
    const days = lang.days.abbreviated;
    const months = lang.months.full;

    return days[date.getDay()] + ', ' + months[date.getMonth()] + ' ' + date.getDate() + ', ' +
        date.getFullYear();
}

function clone(date) {
    return new Date(date.getTime());
}

function moveToDayOfWeek(date, dayOfWeek) {
    while (date.getDay() !== dayOfWeek) {
        date.setDate(date.getDate() - 1);
    }

    return date;
}

function isSameDay(date1, date2) {
    return date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate();
}

function isBefore(date1, date2) {
    return date1.getTime() < date2.getTime();
}

function isAfter(date1, date2) {
    return date1.getTime() > date2.getTime();
}

/* harmony default export */ __webpack_exports__["a"] = {
    defaultLang,
    getDayFull,
    getDayInitial,
    getDayAbbreviated,
    getMonthFull,
    getMonthAbbreviated,
    getDayOfMonth,
    humanize,
    clone,
    moveToDayOfWeek,
    isSameDay,
    isBefore,
    isAfter
};


/***/ }),
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */
/***/ (function(module, exports) {

module.exports = radic.util;

/***/ }),
/* 38 */,
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
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

/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
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
exports.default = md5;

/***/ }),
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export isObject */
/* harmony export (immutable) */ __webpack_exports__["a"] = looseEqual;
/* harmony export (immutable) */ __webpack_exports__["b"] = looseIndexOf;
/* unused harmony export startsWith */
/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject(obj) {
    return obj !== null && typeof obj === 'object';
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual(a, b) {
    // eslint-disable-next-line eqeqeq
    return a == b || (
        isObject(a) && isObject(b) ? JSON.stringify(a) === JSON.stringify(b) : false
    );
}

/**
 * Check if a val exists in arr using looseEqual comparison
 */
function looseIndexOf(arr, val) {
    for (let i = 0; i < arr.length; i++) {
        if (looseEqual(arr[i], val)) {
            return i;
        }
    }

    return -1;
}

/**
 * Check if the given string starts with the query, beginning
 * at the given position
 */
function startsWith(string, query, position = 0) {
    return string.substr(position, query.length) === query;
}


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(235)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(127),
  /* template */
  __webpack_require__(342),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(228)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(145),
  /* template */
  __webpack_require__(335),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(234)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(147),
  /* template */
  __webpack_require__(341),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var lodash_1 = __webpack_require__(4);
var axios_1 = __webpack_require__(390);
var util_1 = __webpack_require__(37);
var md5_1 = __webpack_require__(40);

var Api = function () {
    function Api() {
        var _this = this;

        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        _classCallCheck(this, Api);

        this.errorMessages = {
            500: "The requested resource doesn't exist!",
            502: "Server error, please try again.",
            401: "You aren't authorized to access this resource."
        };
        this.options = {
            apiUrl: '',
            debug: false,
            axios: {}
        };
        this.requests = {};
        lodash_1.merge(this.options, options);
        this.cache = util_1.Storage.getOrCreateBag('codex.api.cache', "local");
        if (parseInt(this.cache.getSize('')) >= 8) {
            this.cache.clear();
        }
        this.$http = axios_1.create(options.axios);
        this.$http.interceptors.request.use(function (config) {
            config.url = _this.options.apiUrl + "/" + config.url;
            return config;
        }, this.catchInterceptorError);
        this.$http.interceptors.response.use(function (response) {
            _this.cache.set(response.config.url + _this.getParamsHash(response.config.params), response.data, {
                expires: 600000
            });
            return response;
        }, this.catchInterceptorError);
    }

    _createClass(Api, [{
        key: "getParamsHash",
        value: function getParamsHash(params) {
            if (params === undefined) return '';
            var objectText = Object.keys(params).map(function (key) {
                var val = params[key];
                if (typeof val === 'undefined') {
                    throw new Error('as this is on key ' + key);
                }
                return key + val.toString();
            }).join('');
            return md5_1.default(objectText);
        }
    }, {
        key: "resolveAndDelay",
        value: function resolveAndDelay(deferred, data) {
            setTimeout(function () {
                return deferred.resolve(data);
            }, this.options.debug ? 500 : 0);
        }
    }, {
        key: "apiCall",
        value: function apiCall(path) {
            var _this2 = this;

            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

            return new Promise(function (resolve, reject) {
                var requestKey = _this2.options.apiUrl + "/" + path + _this2.getParamsHash(options.params);
                var cachedObject = _this2.cache.get(requestKey, {});
                if (!lodash_1.isEmpty(cachedObject)) {
                    resolve(cachedObject);
                } else {
                    if (_this2.requests[requestKey] === undefined) {
                        _this2.requests[requestKey] = _this2.$http.get(path, options);
                    }
                    _this2.requests[requestKey].then(function (_ref) {
                        var data = _ref.data;

                        delete _this2.requests[requestKey];
                        resolve(data);
                    }).catch(_this2.catchError.bind(_this2));
                }
            });
        }
    }, {
        key: "spreadData",
        value: function spreadData(result, spreadMembers) {
            var data = {};
            spreadMembers.forEach(function (member, i) {
                data[member] = result[i];
            });
            return data;
        }
    }, {
        key: "get",
        value: function get(path) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

            return this.apiCall(path, options);
        }
    }, {
        key: "post",
        value: function post(path, options) {
            return this.$http.post(path, options);
        }
    }, {
        key: "all",
        value: function all(path, spreadMembers) {
            var _this3 = this;

            return new Promise(function (resolve, reject) {
                var apiCalls = path.map(function (p) {
                    return _this3.apiCall(p);
                });
                axios.all(apiCalls).then(function (result) {
                    return resolve(_this3.spreadData(result, spreadMembers));
                }).catch(_this3.catchError.bind(_this3));
            });
        }
    }, {
        key: "catchInterceptorError",
        value: function catchInterceptorError(error) {
            return Promise.reject(error);
        }
    }, {
        key: "catchError",
        value: function catchError(response) {
            var error = {
                code: response.status,
                message: response.message
            };
            var errorMessage = this.errorMessages[response.status];
            if (errorMessage) {
                error = {
                    code: 500,
                    message: errorMessage
                };
            }
            Promise.reject(error);
        }
    }]);

    return Api;
}();

exports.Api = Api;

/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
exports.default = {
    props: {
        active: {
            type: Boolean,
            default: false
        },
        dismissable: {
            type: Boolean,
            default: false
        },
        header: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        collectionsMixin: function collectionsMixin() {
            return {
                'active': this.active,
                'dismissable': this.dismissable,
                'collection-item': !this.header,
                'collection-header': this.header
            };
        }
    }
};

/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
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

/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Object.defineProperty(exports, "__esModule", { value: true });
var Vue = __webpack_require__(8);
var lodash_1 = __webpack_require__(4);
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
function isObject(obj) {
    return obj !== null && (typeof obj === "undefined" ? "undefined" : _typeof(obj)) === 'object';
}
exports.isObject = isObject;
function looseEqual(a, b) {
    return a == b || (isObject(a) && isObject(b) ? JSON.stringify(a) === JSON.stringify(b) : false);
}
exports.looseEqual = looseEqual;
function looseIndexOf(arr, val) {
    for (var i = 0; i < arr.length; i++) {
        if (looseEqual(arr[i], val)) {
            return i;
        }
    }
    return -1;
}
exports.looseIndexOf = looseIndexOf;
function startsWith(string, query) {
    var position = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

    return string.substr(position, query.length) === query;
}
exports.startsWith = startsWith;

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });

var Loader = function () {
    function Loader(loaderId, bodyLoadingClass, loaderClassSuffix) {
        _classCallCheck(this, Loader);

        this.loaderId = loaderId;
        this.bodyLoadingClass = bodyLoadingClass;
        this.loaderClassSuffix = loaderClassSuffix;
        this.isLoading = false;
    }

    _createClass(Loader, [{
        key: "start",
        value: function start() {
            this.getLoaderElement();
            if (!this.bodyClass.contains(this.bodyLoadingClass)) {
                this.bodyClass.add(this.bodyLoadingClass);
            }
        }
    }, {
        key: "stop",
        value: function stop() {
            this.bodyClass.remove(this.bodyLoadingClass);
        }
    }, {
        key: "getLoaderElement",
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
        key: "bodyClass",
        get: function get() {
            return document.body.classList;
        }
    }]);

    return Loader;
}();

exports.default = Loader;

/***/ }),
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */,
/* 66 */,
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash_debounce__ = __webpack_require__(114);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash_debounce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lodash_debounce__);


/* harmony default export */ __webpack_exports__["a"] = {
    data() {
        return {
            windowResizeListener: null
        };
    },

    mounted() {
        this.windowResizeListener = __WEBPACK_IMPORTED_MODULE_0_lodash_debounce___default()(() => {
            this.$emit('window-resize');
        }, 200);

        window.addEventListener('resize', this.windowResizeListener);
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.windowResizeListener);
    }
};


/***/ }),
/* 68 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(267)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(141),
  /* template */
  __webpack_require__(384),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(263)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(144),
  /* template */
  __webpack_require__(379),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(240)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(163),
  /* template */
  __webpack_require__(348),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 71 */,
/* 72 */,
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */,
/* 77 */,
/* 78 */,
/* 79 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_classlist__ = __webpack_require__(85);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_classlist___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__utils_classlist__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tether_drop__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tether_drop___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_tether_drop__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__radic_util__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__radic_util___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__radic_util__);
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





/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-popover',

    props: {
        trigger: {
            type: String,
            required: true
        },
        dropdownPosition: {
            type: String,
            default: 'bottom left'
        },
        openOn: {
            type: String,
            default: 'click' // 'click', 'hover', 'focus', or 'always'
        },
        containFocus: {
            type: Boolean,
            default: false
        },
        focusRedirector: Function,
        raised: {
            type: Boolean,
            default: true
        }
    },

    data: function data() {
        return {
            dropInstance: null,
            lastfocusedElement: null
        };
    },


    computed: {
        triggerEl: function triggerEl() {
            var parent = this.$parent;
            var el = null;

            while (!el && parent) {
                el = parent.$refs[this.trigger];
                if (el) {
                    return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__radic_util__["kindOf"])(el) === 'array' ? el[0] : el;
                }
                parent = parent.$parent;
            }

            console.log('triggerEl', el);

            return el;
        }
    },

    mounted: function mounted() {
        if (this.triggerEl) {
            this.initializeDropdown();
        }
    },
    beforeDestroy: function beforeDestroy() {
        if (this.dropInstance) {
            this.dropInstance.destroy();
        }
    },


    methods: {
        initializeDropdown: function initializeDropdown() {
            this.dropInstance = new __WEBPACK_IMPORTED_MODULE_1_tether_drop___default.a({
                target: this.triggerEl,
                content: this.$el,
                position: this.dropdownPosition,
                constrainToWindow: true,
                openOn: this.openOn
            });

            // TO FIX: Workaround for Tether not positioning
            // correctly for positions other than 'bottom left'
            if (this.dropdownPosition !== 'bottom left') {
                this.dropInstance.open();
                this.dropInstance.close();
                this.dropInstance.open();
                this.dropInstance.close();
            }

            this.dropInstance.on('open', this.onOpen);
            this.dropInstance.on('close', this.onClose);
        },
        openDropdown: function openDropdown() {
            if (this.dropInstance) {
                this.dropInstance.open();
            }
        },
        closeDropdown: function closeDropdown() {
            if (this.dropInstance) {
                this.dropInstance.close();
            }
        },
        toggleDropdown: function toggleDropdown(e) {
            if (this.dropInstance) {
                this.dropInstance.toggle(e);
            }
        },


        /**
         * Ensures drop is horizontally within viewport (vertical is already solved by drop.js).
         * https://github.com/HubSpot/drop/issues/16
         */
        positionDrop: function positionDrop() {
            var drop = this.dropInstance;
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            var width = drop.drop.getBoundingClientRect().width;
            var left = drop.target.getBoundingClientRect().left;
            var availableSpace = windowWidth - left;

            if (width > availableSpace) {
                var direction = width > availableSpace ? 'right' : 'left';

                drop.tether.attachment.left = direction;
                drop.tether.targetAttachment.left = direction;

                drop.position();
            }
        },
        onOpen: function onOpen() {
            this.positionDrop();
            __WEBPACK_IMPORTED_MODULE_0__utils_classlist___default.a.add(this.triggerEl, 'has-dropdown-open');

            this.lastfocusedElement = document.activeElement;
            this.$el.focus();

            this.$emit('open');
        },
        onClose: function onClose() {
            __WEBPACK_IMPORTED_MODULE_0__utils_classlist___default.a.remove(this.triggerEl, 'has-dropdown-open');

            if (this.lastfocusedElement) {
                this.lastfocusedElement.focus();
            }

            this.$emit('close');
        },
        restrictFocus: function restrictFocus(e) {
            if (!this.containFocus) {
                this.closeDropdown();
                return;
            }

            e.stopPropagation();

            if (this.focusRedirector) {
                this.focusRedirector(e);
            } else {
                this.$el.focus();
            }
        },
        open: function open() {
            this.openDropdown();
        },
        close: function close() {
            this.closeDropdown();
        },
        toggle: function toggle() {
            this.toggleDropdown();
        }
    }
};

/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var Cookie = __webpack_require__(273);
var lodash_1 = __webpack_require__(4);
var mixins = __webpack_require__(28);
var transitions = __webpack_require__(39);
var utils = __webpack_require__(16);
var vuex_1 = __webpack_require__(9);
var api_1 = __webpack_require__(53);
var _Vue = __webpack_require__(8);

var Codex = function () {
    function Codex() {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        _classCallCheck(this, Codex);

        this.plugins = {};
        this.apps = {};
        this.breakpoints = { xs: 0, sm: 576, md: 768, lg: 922, xl: 1200 };
        this.sidebar = { width: 250, collapsedWidth: 54 };
        this.debug = false;
        this.apiUrl = '';
        this.project = '';
        this.displayName = '';
        this.ref = '';
        this.loader = new utils.Loader('page-loader', 'page-loading', 'page');
        this.events = new _Vue();
        this.helpers = utils;
        this.transitions = transitions;
        this.mixins = mixins;
        this.api = new api_1.Api(options.apiOptions || {});
        this.store = new vuex_1.Store(options.storeOptions || {});
    }

    _createClass(Codex, [{
        key: "extend",
        value: function extend() {
            for (var _len = arguments.length, objs = Array(_len), _key = 0; _key < _len; _key++) {
                objs[_key] = arguments[_key];
            }

            lodash_1.merge.apply(lodash_1.merge, [this].concat(objs));
        }
    }, {
        key: "makeExtender",
        value: function makeExtender(obj) {
            obj.extend = function () {
                for (var _len2 = arguments.length, objs = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
                    objs[_key2] = arguments[_key2];
                }

                obj = lodash_1.merge.apply(lodash_1.merge, [obj].concat(objs));
            };
        }
    }, {
        key: "setCookie",
        value: function setCookie(name, value, daysOrOptions) {
            var opts = daysOrOptions;
            if (Number.isInteger(daysOrOptions)) {
                opts = { expires: daysOrOptions };
            }
            return Cookie.set(name, value, opts);
        }
    }, {
        key: "getCookie",
        value: function getCookie(name) {
            return Cookie.get(name);
        }
    }, {
        key: "deleteCookie",
        value: function deleteCookie(name, options) {
            var opts = { expires: -1 };
            if (options !== undefined) {
                opts = Object.assign(options, opts);
            }
            Cookie.set(name, '', opts);
        }
    }]);

    return Codex;
}();

exports.Codex = Codex;

/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var utils_1 = __webpack_require__(16);
var Vue = __webpack_require__(8);
exports.default = {
    data: function data() {
        return { isMd: false };
    },
    created: function created() {
        var _this = this;

        this.isMd = this.isBreakpointUp('md');
        this.$on('resize', function () {
            return _this.isMd = _this.isBreakpointUp('md');
        });
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

/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

Object.defineProperty(exports, "__esModule", { value: true });
var Tether = __webpack_require__(78);
var sides = {
    top: 'bottom',
    bottom: 'top',
    left: 'right',
    right: 'left'
};
var otherSide = function otherSide(side) {
    return sides[side];
};
exports.default = {
    props: {
        content: { type: String },
        effect: { type: String, default: 'fade' },
        header: { type: Boolean, default: true },
        placement: { type: String, default: 'top' },
        title: { type: String },
        trigger: { type: String }
    },
    data: function data() {
        return {
            position: {
                top: 0,
                left: 0
            },
            visible: false
        };
    },

    methods: {
        toggle: function toggle(e) {
            if (this.visible) {
                this.hide(e);
            } else {
                this.show(e);
            }
        },
        show: function show(e) {
            var _this = this;

            if (e && this.trigger === 'contextmenu') e.preventDefault();
            this.visible = true;
            this.reposition().then(function () {
                return _this.$emit('show');
            });
        },
        hide: function hide(e) {
            if (e && this.trigger === 'contextmenu') e.preventDefault();
            this.visible = false;
            this.$emit('hide');
        },
        reposition: function reposition() {
            var _this2 = this;

            return new Promise(function (resolve, reject) {
                _this2.$nextTick(function () {
                    var options = {
                        element: _this2.$refs.popover,
                        target: _this2.$refs.trigger.children[0],
                        attachment: otherSide(_this2.placement) + ' center',
                        targetAttachment: _this2.placement + ' center'
                    };
                    var t = new Tether(options);
                    t.position();
                    resolve();
                });
            });
        }
    },
    mounted: function mounted() {
        var _this3 = this;

        var trigger = this.$refs.trigger;
        if (!trigger) return console.error('Could not find trigger v-el in your component that uses popoverMixin.');
        if (this.trigger === 'focus' && !~trigger.tabIndex) {
            trigger = $('a,input,select,textarea,button', trigger);
            if (!trigger.length) {
                trigger = null;
            }
        }
        if (trigger) {
            var events = { contextmenu: 'contextmenu', hover: 'mouseleave mouseenter', focus: 'blur focus' };
            var event = events[this.trigger] || 'click';
            if (event === 'click') {
                $(trigger).on(event, function (e) {
                    e.stopPropagation();
                    _this3.show(e);
                });
                $(window).on(event, this.hide);
            } else {
                $(trigger).on(event, this.toggle);
            }
            this._trigger = trigger;
        }
        this.$events.$on('phpdoc:open', function () {
            return _this3.hide();
        });
    },
    beforeDestroy: function beforeDestroy() {
        if (this._trigger) $(this._trigger).off();
    }
};
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(14)))

/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var lodash_1 = __webpack_require__(4);
var vuex_1 = __webpack_require__(9);
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

    methods: lodash_1.merge(vuex_1.mapActions(['updateHeights']), {
        handleResize: function handleResize(event) {
            var _this = this;

            if (this.resize) clearTimeout(this.resize);
            this.resize = setTimeout(function () {
                _this.$emit('resize');
            }, 50);
        }
    })
};

/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
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

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Object.defineProperty(exports, "__esModule", { value: true });
var trim = /^\s+|\s+$/g;
var whitespace = /\s+/g;
function interpret(input) {
    return typeof input === 'string' ? input.replace(trim, '').split(whitespace) : input;
}
function classes(el) {
    if (isElement(el)) {
        return el.className.replace(trim, '').split(whitespace);
    }
    return [];
}
function set(el, input) {
    if (isElement(el)) {
        el.className = interpret(input).join(' ');
    }
}
function add(el, input) {
    var current = remove(el, input);
    var values = interpret(input);
    current.push.apply(current, values);
    set(el, current);
    return current;
}
function remove(el, input) {
    var current = classes(el);
    var values = interpret(input);
    values.forEach(function (value) {
        var i = current.indexOf(value);
        if (i !== -1) {
            current.splice(i, 1);
        }
    });
    set(el, current);
    return current;
}
function contains(el, input) {
    var current = classes(el);
    var values = interpret(input);
    return values.every(function (value) {
        return current.indexOf(value) !== -1;
    });
}
function isElement(o) {
    var elementObjects = (typeof HTMLElement === "undefined" ? "undefined" : _typeof(HTMLElement)) === 'object';
    return elementObjects ? o instanceof HTMLElement : isElementObject(o);
}
function isElementObject(o) {
    return o && (typeof o === "undefined" ? "undefined" : _typeof(o)) === 'object' && typeof o.nodeName === 'string' && o.nodeType === 1;
}
exports.default = {
    add: add,
    remove: remove,
    contains: contains,
    has: contains,
    set: set,
    get: classes
};

/***/ }),
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 90 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = {
    inserted(el, { value }) {
        if (value) {
            el.focus();
        }
    }
};


/***/ }),
/* 91 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export inView */
/* harmony export (immutable) */ __webpack_exports__["b"] = scrollIntoView;
/* harmony export (immutable) */ __webpack_exports__["a"] = resetScroll;
function inView(element, container) {
    if (!element) {
        return;
    }

    container = container || element.parentElement;

    const top = element.offsetTop;
    const parentTop = container.scrollTop;
    const bottom = top + element.offsetHeight;
    const parentBottom = container.offsetHeight;

    return top >= parentTop && bottom <= parentBottom;
}

function scrollIntoView(element, options = { container: null, marginTop: 0 }) {
    if (!element) {
        return;
    }

    options.container = options.container || element.parentElement;

    if (inView(element, options.container)) {
        return;
    }

    options.container.scrollTop = element.offsetTop - options.marginTop;
}

function resetScroll(element) {
    if (!element) {
        return;
    }

    element.scrollTop = 0;
}

/* unused harmony default export */ var _unused_webpack_default_export = {
    inView,
    scrollIntoView,
    resetScroll
};


/***/ }),
/* 92 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Fast UUID generator, RFC4122 version 4 compliant.
 * @author Jeff Ward (jcward.com).
 * @license MIT license
 * @link http://stackoverflow.com/questions/105034/how-to-create-a-guid-uuid-in-javascript/21963136#21963136
 */

const lut = [];

for (let i = 0; i < 256; i++) {
    lut[i] = (i < 16 ? '0' : '') + (i).toString(16);
}

const generate = function () {
    const d0 = Math.random() * 0xffffffff | 0;
    const d1 = Math.random() * 0xffffffff | 0;
    const d2 = Math.random() * 0xffffffff | 0;
    const d3 = Math.random() * 0xffffffff | 0;

    /* eslint-disable */
    return lut[d0 & 0xff] + lut[d0 >> 8 & 0xff] + lut[d0 >> 16 & 0xff] + lut[d0 >> 24 & 0xff] + '-' +
        lut[d1 & 0xff] + lut[d1 >> 8 & 0xff] + '-' + lut[d1 >> 16 & 0x0f | 0x40] + lut[d1 >> 24 & 0xff] + '-' +
        lut[d2 & 0x3f | 0x80] + lut[d2 >> 8 & 0xff] + '-' + lut[d2 >> 16 & 0xff] + lut[d2 >> 24 & 0xff] +
        lut[d3 & 0xff] + lut[d3 >> 8 & 0xff] + lut[d3 >> 16 & 0xff] + lut[d3 >> 24 & 0xff];
    /* eslint-enable */
};

const short = function (prefix) {
    prefix = prefix || '';

    const uuid = generate();

    return prefix + uuid.split('-')[0];
};

/* harmony default export */ __webpack_exports__["a"] = {
    generate,
    short
};


/***/ }),
/* 93 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(256)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(128),
  /* template */
  __webpack_require__(368),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 94 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(247)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(132),
  /* template */
  __webpack_require__(358),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 95 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(220)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(134),
  /* template */
  __webpack_require__(325),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 96 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(261)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(148),
  /* template */
  __webpack_require__(375),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 97 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(244)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(149),
  /* template */
  __webpack_require__(355),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 98 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(252)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(155),
  /* template */
  __webpack_require__(363),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 99 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(89)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(79),
  /* template */
  __webpack_require__(100),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 100 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-popover",
    class: {
      'is-raised': _vm.raised
    },
    attrs: {
      "role": "dialog",
      "tabindex": "-1"
    },
    on: {
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        _vm.closeDropdown($event)
      }
    }
  }, [_vm._t("default"), _vm._v(" "), _c('div', {
    staticClass: "ui-popover__focus-redirector",
    attrs: {
      "tabindex": "0"
    },
    on: {
      "focus": _vm.restrictFocus
    }
  })], 2)
},staticRenderFns: []}

/***/ }),
/* 101 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function __export(m) {
    for (var p in m) {
        if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
}
Object.defineProperty(exports, "__esModule", { value: true });
var Vue = __webpack_require__(8);
var plugin_1 = __webpack_require__(189);
exports.plugin = plugin_1.default;
var utils = __webpack_require__(16);
exports.utils = utils;
var mixins = __webpack_require__(28);
exports.mixins = mixins;
__webpack_require__(191);
window['CodexCore'] = Vue.codex.plugins['Core'] = plugin_1.default;
var api_1 = __webpack_require__(53);
exports.Api = api_1.Api;
__export(__webpack_require__(80));

/***/ }),
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */,
/* 117 */,
/* 118 */,
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue__ = __webpack_require__(95);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiIcon_vue__);
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
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-alert',

    props: {
        type: {
            type: String,
            default: 'info' // 'info', 'success', 'warning', or 'error'
        },
        removeIcon: {
            type: Boolean,
            default: false
        },
        dismissible: {
            type: Boolean,
            default: true
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-alert--type-' + this.type];
        }
    },

    methods: {
        dismissAlert: function dismissAlert() {
            this.$emit('dismiss');
        }
    },

    components: {
        UiCloseButton: __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue___default.a,
        UiIcon: __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue___default.a
    }
};

/***/ }),
/* 125 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__directives_autofocus__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiAutocompleteSuggestion_vue__ = __webpack_require__(277);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiAutocompleteSuggestion_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiAutocompleteSuggestion_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__config__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_fuzzysearch__ = __webpack_require__(113);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_fuzzysearch___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_fuzzysearch__);
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








/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-autocomplete',

    props: {
        name: String,
        placeholder: String,
        value: {
            type: [String, Number],
            required: true
        },
        icon: String,
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        label: String,
        floatingLabel: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: 'simple' // 'simple' or 'image'
        },
        suggestions: {
            type: Array,
            default: function _default() {
                return [];
            }
        },
        limit: {
            type: Number,
            default: 8
        },
        append: {
            type: Boolean,
            default: false
        },
        appendDelimiter: {
            type: String,
            default: ', '
        },
        minChars: {
            type: Number,
            default: 2
        },
        showOnUpDown: {
            type: Boolean,
            default: true
        },
        autofocus: {
            type: Boolean,
            default: false
        },
        filter: Function,
        highlightOnFirstMatch: {
            type: Boolean,
            default: true
        },
        cycleHighlight: {
            type: Boolean,
            default: true
        },
        keys: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_3__config__["default"].data.UiAutocomplete.keys;
            }
        },
        invalid: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            initialValue: this.value,
            isActive: false,
            isTouched: false,
            showDropdown: false,
            highlightedIndex: -1
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-autocomplete--type-' + this.type, 'ui-autocomplete--icon-position-' + this.iconPosition, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-touched': this.isTouched }, { 'is-disabled': this.disabled }, { 'has-label': this.hasLabel }, { 'has-floating-label': this.hasFloatingLabel }];
        },
        labelClasses: function labelClasses() {
            return {
                'is-inline': this.hasFloatingLabel && this.isLabelInline,
                'is-floating': this.hasFloatingLabel && !this.isLabelInline
            };
        },
        hasLabel: function hasLabel() {
            return Boolean(this.label) || Boolean(this.$slots.default);
        },
        hasFloatingLabel: function hasFloatingLabel() {
            return this.hasLabel && this.floatingLabel;
        },
        isLabelInline: function isLabelInline() {
            return this.value.length === 0 && !this.isActive;
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || Boolean(this.error);
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        },
        matchingSuggestions: function matchingSuggestions() {
            var _this = this;

            return this.suggestions.filter(function (suggestion, index) {
                if (_this.filter) {
                    return _this.filter(suggestion, _this.value);
                }

                return _this.defaultFilter(suggestion, index);
            }).slice(0, this.limit);
        }
    },

    watch: {
        value: function value() {
            if (this.isActive && this.value.length >= this.minChars) {
                this.openDropdown();
            }

            this.highlightedIndex = this.highlightOnFirstMatch ? 0 : -1;
        }
    },

    mounted: function mounted() {
        document.addEventListener('click', this.onExternalClick);
    },
    beforeDestroy: function beforeDestroy() {
        document.removeEventListener('click', this.onExternalClick);
    },


    methods: {
        defaultFilter: function defaultFilter(suggestion) {
            var text = suggestion[this.keys.label] || suggestion;
            var query = this.value;

            if (typeof query === 'string') {
                query = query.toLowerCase();
            }

            return __WEBPACK_IMPORTED_MODULE_4_fuzzysearch___default()(query, text.toLowerCase());
        },
        selectSuggestion: function selectSuggestion(suggestion) {
            var _this2 = this;

            var value = void 0;

            if (this.append) {
                value += this.appendDelimiter + (suggestion[this.keys.value] || suggestion);
            } else {
                value = suggestion[this.keys.value] || suggestion;
            }

            this.updateValue(value);
            this.$emit('select', suggestion);

            this.$nextTick(function () {
                _this2.closeDropdown();
                _this2.$refs.input.focus();
            });
        },
        highlightSuggestion: function highlightSuggestion(index) {
            var firstIndex = 0;
            var lastIndex = this.$refs.suggestions.length - 1;

            if (index === -2) {
                // Allows for cycling from first to last when cycleHighlight is disabled
                index = lastIndex;
            } else if (index < firstIndex) {
                index = this.cycleHighlight ? lastIndex : index;
            } else if (index > lastIndex) {
                index = this.cycleHighlight ? firstIndex : -1;
            }

            this.highlightedIndex = index;

            if (this.showOnUpDown) {
                this.openDropdown();
            }

            if (index < firstIndex || index > lastIndex) {
                this.$emit('highlight-overflow', index);
            } else {
                this.$emit('highlight', this.$refs.suggestions[index].suggestion, index);
            }
        },
        selectHighlighted: function selectHighlighted(index, e) {
            if (this.showDropdown && this.$refs.suggestions.length > 0) {
                e.preventDefault();
                this.selectSuggestion(this.$refs.suggestions[index].suggestion);
            }
        },
        openDropdown: function openDropdown() {
            if (!this.showDropdown) {
                this.showDropdown = true;
                this.$emit('dropdown-open');
            }
        },
        closeDropdown: function closeDropdown() {
            var _this3 = this;

            if (this.showDropdown) {
                this.$nextTick(function () {
                    _this3.showDropdown = false;
                    _this3.highlightedIndex = -1;
                    _this3.$emit('dropdown-close');
                });
            }
        },
        updateValue: function updateValue(value) {
            this.$emit('input', value);
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onChange: function onChange(e) {
            this.$emit('change', this.value, e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);

            if (!this.isTouched) {
                this.isTouched = true;
                this.$emit('touch');
            }
        },
        onExternalClick: function onExternalClick(e) {
            if (!this.$el.contains(e.target) && this.showDropdown) {
                this.closeDropdown();
            }
        },
        reset: function reset() {
            // Blur input before resetting to avoid "required" errors
            // when the input is blurred after reset
            if (document.isActiveElement === this.$refs.input) {
                document.isActiveElement.blur();
            }

            // Reset state
            this.$emit('input', this.initialValue);
            this.isTouched = false;
        }
    },

    components: {
        UiAutocompleteSuggestion: __WEBPACK_IMPORTED_MODULE_1__UiAutocompleteSuggestion_vue___default.a,
        UiIcon: __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue___default.a
    },

    directives: {
        autofocus: __WEBPACK_IMPORTED_MODULE_0__directives_autofocus__["a" /* default */]
    }
};

/***/ }),
/* 126 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-autocomplete-suggestion',

    props: {
        suggestion: {
            type: [String, Object],
            required: true
        },
        type: {
            type: String,
            default: 'simple' // 'simple' or 'image'
        },
        highlighted: {
            type: Boolean,
            default: false
        },
        keys: {
            type: Object,
            default: function _default() {
                return {
                    label: 'label',
                    image: 'image'
                };
            }
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-autocomplete-suggestion--type-' + this.type, { 'is-highlighted': this.highlighted }];
        },
        imageStyle: function imageStyle() {
            return { 'background-image': 'url(' + this.suggestion[this.keys.image] + ')' };
        }
    }
};

/***/ }),
/* 127 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiPopover_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__config__ = __webpack_require__(6);
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








/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-button',

    props: {
        type: {
            type: String,
            default: 'primary' // 'primary' or 'secondary'
        },
        buttonType: {
            type: String,
            default: 'submit' // HTML default
        },
        color: {
            type: String,
            default: 'default' // 'default', 'primary', 'accent', 'green', 'orange', or 'red'
        },
        size: {
            type: String,
            default: 'normal' // 'small', 'normal', 'large'
        },
        raised: {
            type: Boolean,
            default: false
        },
        icon: String,
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        loading: {
            type: Boolean,
            default: false
        },
        hasDropdown: {
            type: Boolean,
            default: false
        },
        dropdownPosition: {
            type: String,
            default: 'bottom left'
        },
        openDropdownOn: {
            type: String,
            default: 'click' // 'click', 'hover', 'focus', or 'always'
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_4__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            focusRing: {
                top: 0,
                left: 0,
                size: 0
            }
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-button--type-' + this.type, 'ui-button--color-' + this.color, 'ui-button--icon-position-' + this.iconPosition, 'ui-button--size-' + this.size, { 'is-raised': this.raised }, { 'is-loading': this.loading }, { 'is-disabled': this.disabled || this.loading }, { 'has-dropdown': this.hasDropdown }];
        },
        focusRingStyle: function focusRingStyle() {
            return {
                height: this.focusRing.size + 'px',
                width: this.focusRing.size + 'px',
                top: this.focusRing.top + 'px',
                left: this.focusRing.left + 'px'
            };
        },
        progressColor: function progressColor() {
            if (this.color === 'default' || this.type === 'secondary') {
                return 'black';
            }

            return 'white';
        }
    },

    methods: {
        onClick: function onClick(e) {
            this.$emit('click', e);
        },
        onFocus: function onFocus() {
            var bounds = {
                width: this.$el.clientWidth,
                height: this.$el.clientHeight
            };

            this.focusRing.size = bounds.width - 16; // 8px of padding on left and right
            this.focusRing.top = -1 * (this.focusRing.size - bounds.height) / 2;
            this.focusRing.left = (bounds.width - this.focusRing.size) / 2;
        },
        onDropdownOpen: function onDropdownOpen() {
            this.$emit('dropdown-open');
        },
        onDropdownClose: function onDropdownClose() {
            this.$emit('dropdown-close');
        },
        openDropdown: function openDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.open();
            }
        },
        closeDropdown: function closeDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.close();
            }
        },
        toggleDropdown: function toggleDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.toggle();
            }
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiPopover: __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue___default.a,
        UiProgressCircular: __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue___default.a
    }
};

/***/ }),
/* 128 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCalendarControls_vue__ = __webpack_require__(278);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCalendarControls_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiCalendarControls_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiCalendarMonth_vue__ = __webpack_require__(279);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiCalendarMonth_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiCalendarMonth_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__helpers_date__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__helpers_element_scroll__ = __webpack_require__(91);
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
//
//
//







/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-calendar',

    props: {
        value: Date,
        minDate: Date,
        maxDate: Date,
        lang: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].defaultLang;
            }
        },
        yearRange: {
            type: Array,
            default: function _default() {
                var thisYear = new Date().getFullYear();

                // Generates a range of 200 years
                // (100 years into the past and 100 years into the future, including the current year)
                return Array.apply(null, Array(200)).map(function (item, index) {
                    return thisYear - 100 + index;
                });
            }
        },
        dateFilter: Function,
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        orientation: {
            type: String,
            default: 'portrait' // 'portrait' or 'landscape'
        }
    },

    data: function data() {
        return {
            today: new Date(),
            dateInView: this.getDateInRange(this.value, new Date()),
            showYearPicker: false
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-calendar--color-' + this.color, 'ui-calendar--orientation-' + this.orientation];
        },
        headerYear: function headerYear() {
            return this.value ? this.value.getFullYear() : this.today.getFullYear();
        },
        headerDay: function headerDay() {
            return this.value ? __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].getDayAbbreviated(this.value, this.lang) : __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].getDayAbbreviated(this.today, this.lang);
        },
        headerDate: function headerDate() {
            var date = this.value ? this.value : this.today;

            return __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].getMonthAbbreviated(date, this.lang) + ' ' + __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].getDayOfMonth(date, this.lang);
        }
    },

    watch: {
        value: function value() {
            if (this.value) {
                this.dateInView = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.value);
            }
        },
        showYearPicker: function showYearPicker() {
            var _this = this;

            if (this.showYearPicker) {
                this.$nextTick(function () {
                    var el = _this.$refs.years.querySelector('.is-selected') || _this.$refs.years.querySelector('.is-current-year');

                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__helpers_element_scroll__["b" /* scrollIntoView */])(el, { marginTop: 126 });
                });
            }
        }
    },

    methods: {
        selectYear: function selectYear(year) {
            var newDate = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.dateInView);
            newDate.setFullYear(year);

            this.dateInView = this.getDateInRange(newDate);
            this.showYearPicker = false;
        },
        getDateInRange: function getDateInRange(date, fallback) {
            date = date || fallback;

            if (this.minDate && date.getTime() < this.minDate.getTime()) {
                return this.minDate;
            }

            if (this.maxDate && date.getTime() > this.maxDate.getTime()) {
                return this.maxDate;
            }

            return date;
        },
        getYearClasses: function getYearClasses(year) {
            return {
                'is-current-year': this.isYearCurrent(year),
                'is-selected': this.isYearSelected(year)
            };
        },
        isYearCurrent: function isYearCurrent(year) {
            return year === this.today.getFullYear();
        },
        isYearSelected: function isYearSelected(year) {
            return this.value && year === this.value.getFullYear();
        },
        isYearOutOfRange: function isYearOutOfRange(year) {
            if (this.minDate && year < this.minDate.getFullYear()) {
                return true;
            }

            if (this.maxDate && year > this.maxDate.getFullYear()) {
                return true;
            }

            return false;
        },
        onDateSelect: function onDateSelect(date) {
            this.$emit('input', date);
            this.$emit('date-select', date);
        },
        onGoToDate: function onGoToDate(date) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { isForward: true };

            this.$refs.month.goToDate(date, options);
        },
        onMonthChange: function onMonthChange(newDate) {
            this.dateInView = newDate;
            this.$emit('month-change', newDate);
        }
    },

    components: {
        UiCalendarControls: __WEBPACK_IMPORTED_MODULE_0__UiCalendarControls_vue___default.a,
        UiCalendarMonth: __WEBPACK_IMPORTED_MODULE_1__UiCalendarMonth_vue___default.a
    }
};

/***/ }),
/* 129 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIconButton_vue__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIconButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiIconButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__helpers_date__ = __webpack_require__(33);
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
//






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-calendar-controls',

    props: {
        lang: Object,
        dateInView: Date,
        minDate: Date,
        maxDate: Date
    },

    computed: {
        monthAndYear: function monthAndYear() {
            return __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].getMonthFull(this.dateInView, this.lang) + ' ' + this.dateInView.getFullYear();
        },
        previousMonthDisabled: function previousMonthDisabled() {
            if (!this.minDate) {
                return false;
            }

            var lastDayOfPreviousMonth = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.dateInView);

            // Setting the date to zero goes to the last day in previous month
            lastDayOfPreviousMonth.setDate(0);

            return this.minDate.getTime() > lastDayOfPreviousMonth.getTime();
        },
        nextMonthDisabled: function nextMonthDisabled() {
            if (!this.maxDate) {
                return false;
            }

            var firstDayOfNextMonth = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.dateInView);

            // Set the month ot next month, and the day to the first day
            // If the month overflows, it increments the year
            firstDayOfNextMonth.setMonth(this.dateInView.getMonth() + 1, 1);

            return this.maxDate.getTime() < firstDayOfNextMonth.getTime();
        }
    },

    methods: {
        goToPreviousMonth: function goToPreviousMonth() {
            var date = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.dateInView);
            date.setMonth(date.getMonth() - 1);

            this.goToDate(date, { isForward: false });
        },
        goToNextMonth: function goToNextMonth() {
            var date = __WEBPACK_IMPORTED_MODULE_2__helpers_date__["a" /* default */].clone(this.dateInView);
            date.setMonth(date.getMonth() + 1);

            this.goToDate(date, { isForward: true });
        },
        goToDate: function goToDate(date) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { isForward: true };

            this.$emit('go-to-date', date, options);
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiIconButton: __WEBPACK_IMPORTED_MODULE_1__UiIconButton_vue___default.a
    }
};

/***/ }),
/* 130 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCalendarWeek_vue__ = __webpack_require__(280);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCalendarWeek_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiCalendarWeek_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__helpers_date__ = __webpack_require__(33);
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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





/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-calendar-month',

    props: {
        lang: Object,
        dateFilter: Function,
        dateInView: Date,
        selected: Date,
        maxDate: Date,
        minDate: Date
    },

    data: function data() {
        return {
            dateOutOfView: __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(this.dateInView),
            isSliding: false,
            slideDirection: '',

            // Detects IE and not Edge: http://stackoverflow.com/a/22082397
            isIE: Boolean(window.MSInputMethodContext) && Boolean(document.documentMode),
            ieTimeout: null
        };
    },


    computed: {
        weekClasses: function weekClasses() {
            return [_defineProperty({}, 'ui-calendar-month--slide-' + this.slideDirection, this.isSliding), { 'is-sliding': this.isSliding }];
        },
        currentWeekStartDates: function currentWeekStartDates() {
            return this.getWeekStartDates(this.dateInView);
        },
        otherWeekStartDates: function otherWeekStartDates() {
            return this.getWeekStartDates(this.dateOutOfView);
        }
    },

    methods: {
        getWeekStartDates: function getWeekStartDates(dateInWeek) {
            var date = __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(dateInWeek);

            date.setDate(1); // Jump to the start of the month
            date = __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].moveToDayOfWeek(date, 0); // Jump to the start of the week

            var current = __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(date);
            current.setDate(current.getDate() + 7);

            var starts = [date];
            var month = current.getMonth();

            while (current.getMonth() === month) {
                starts.push(__WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(current));
                current.setDate(current.getDate() + 7);
            }

            return starts;
        },
        goToDate: function goToDate(date) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { isForward: true };

            this.isSliding = true;
            this.slideDirection = options.isForward ? 'left' : 'right';
            this.dateOutOfView = __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(date);

            // A hack for IE: sometimes when rapidly scrolling through months, the
            // transitionend event is not fired, causing the month to not change.
            // This ensures that onTransitionEnd() is called after 300ms.
            if (this.isIE) {
                this.ieTimeout = setTimeout(this.onTransitionEnd, 300);
            }
        },
        onDateSelect: function onDateSelect(date) {
            this.$emit('date-select', date);
        },
        onTransitionEnd: function onTransitionEnd() {
            if (this.ieTimeout) {
                clearTimeout(this.ieTimeout);
                this.ieTimeout = null;

                // Abort if the transition has already ended
                if (!this.isSliding) {
                    return;
                }
            }

            this.isSliding = false;
            this.slideDirection = '';

            this.$emit('change', __WEBPACK_IMPORTED_MODULE_1__helpers_date__["a" /* default */].clone(this.dateOutOfView));
            this.$emit('transition-end');
        }
    },

    components: {
        UiCalendarWeek: __WEBPACK_IMPORTED_MODULE_0__UiCalendarWeek_vue___default.a
    }
};

/***/ }),
/* 131 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_date__ = __webpack_require__(33);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-calendar-week',

    props: {
        month: Number,
        weekStart: Date,
        minDate: Date,
        maxDate: Date,
        selected: Date,
        dateFilter: Function,
        visible: {
            type: Boolean,
            default: true
        }
    },

    data: function data() {
        return {
            today: new Date()
        };
    },


    computed: {
        dates: function dates() {
            return this.buildDays(this.weekStart);
        }
    },

    methods: {
        buildDays: function buildDays(weekStart) {
            var days = [__WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].clone(weekStart)];
            var day = __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].clone(weekStart);

            for (var i = 1; i <= 6; i++) {
                day = __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].clone(day);
                day.setDate(day.getDate() + 1);

                days.push(day);
            }

            return days;
        },
        getDateClasses: function getDateClasses(date) {
            return [{ 'is-today': __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].isSameDay(date, this.today) }, { 'is-in-other-month': this.isDateInOtherMonth(date) }, { 'is-selected': this.selected && __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].isSameDay(date, this.selected) }, { 'is-disabled': this.isDateDisabled(date) }];
        },
        selectDate: function selectDate(date) {
            if (this.isDateDisabled(date)) {
                return;
            }

            this.$emit('date-select', date);
        },
        getDayOfMonth: function getDayOfMonth(date) {
            return __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].getDayOfMonth(date);
        },
        isDateInOtherMonth: function isDateInOtherMonth(date) {
            return this.month !== date.getMonth();
        },
        isDateDisabled: function isDateDisabled(date) {
            var isDisabled = this.minDate && __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].isBefore(date, this.minDate) || this.maxDate && __WEBPACK_IMPORTED_MODULE_0__helpers_date__["a" /* default */].isAfter(date, this.maxDate);

            if (isDisabled) {
                return true;
            }

            return this.dateFilter ? !this.dateFilter(date) : false;
        }
    }
};

/***/ }),
/* 132 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_util__ = __webpack_require__(46);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-checkbox',

    props: {
        name: String,
        label: String,
        value: {
            required: true
        },
        trueValue: {
            default: true
        },
        falseValue: {
            default: false
        },
        submittedValue: {
            type: String,
            default: 'on' // HTML default
        },
        checked: {
            type: Boolean,
            default: false
        },
        boxPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            isChecked: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__helpers_util__["a" /* looseEqual */])(this.value, this.trueValue) || this.checked
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-checkbox--color-' + this.color, 'ui-checkbox--box-position-' + this.boxPosition, { 'is-checked': this.isChecked }, { 'is-active': this.isActive }, { 'is-disabled': this.disabled }];
        }
    },

    watch: {
        value: function value() {
            this.isChecked = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__helpers_util__["a" /* looseEqual */])(this.value, this.trueValue);
        }
    },

    created: function created() {
        this.$emit('input', this.isChecked ? this.trueValue : this.falseValue);
    },


    methods: {
        onClick: function onClick(e) {
            this.isChecked = e.target.checked;
            this.$emit('input', e.target.checked ? this.trueValue : this.falseValue);
        },
        onChange: function onChange(e) {
            this.$emit('change', this.isChecked ? this.trueValue : this.falseValue, e);
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);
        }
    }
};

/***/ }),
/* 133 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCheckbox_vue__ = __webpack_require__(94);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCheckbox_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiCheckbox_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__helpers_util__ = __webpack_require__(46);
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
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-checkbox-group',

    props: {
        name: String,
        options: {
            type: Array,
            required: true
        },
        value: {
            type: Array,
            required: true
        },
        keys: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_1__config__["default"].data.UiCheckboxGroup.keys;
            }
        },
        label: String,
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        boxPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        vertical: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        invalid: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            ignoreChange: false,
            checkboxValues: [],
            initialValue: JSON.parse(JSON.stringify(this.value))
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-checkbox-group--color-' + this.color, 'ui-checkbox-group--box-position-' + this.boxPosition, { 'is-vertical': this.vertical }, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-disabled': this.disabled }];
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || this.showError;
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        }
    },

    methods: {
        reset: function reset() {
            var _this = this;

            this.ignoreChange = true;
            this.options.forEach(function (option, index) {
                _this.checkboxValues[index] = _this.isOptionCheckedByDefault(option);
            });
            this.ignoreChange = false;

            this.$emit('input', this.initialValue.length > 0 ? [].concat(this.initialValue) : []);
        },
        isOptionCheckedByDefault: function isOptionCheckedByDefault(option) {
            return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__helpers_util__["b" /* looseIndexOf */])(this.initialValue, option[this.keys.value] || option) > -1;
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);
        },
        onChange: function onChange(args, option) {
            if (this.ignoreChange) {
                return;
            }

            var checked = args[0];
            var e = args[1];

            var value = [];
            var optionValue = option[this.keys.value] || option;
            var i = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__helpers_util__["b" /* looseIndexOf */])(this.value, optionValue);

            if (checked && i < 0) {
                value = this.value.concat(optionValue);
            }

            if (!checked && i > -1) {
                value = this.value.slice(0, i).concat(this.value.slice(i + 1));
            }

            this.$emit('input', value);
            this.$emit('change', value, e);
        }
    },

    components: {
        UiCheckbox: __WEBPACK_IMPORTED_MODULE_0__UiCheckbox_vue___default.a
    }
};

/***/ }),
/* 134 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
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






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-close-button',

    props: {
        size: {
            type: String,
            default: 'normal' // 'small', 'normal', or 'large'
        },
        color: {
            type: String,
            default: 'black' // 'black', or 'white'
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-close-button--size-' + this.size, 'ui-close-button--color-' + this.color, { 'is-disabled': this.disabled || this.loading }];
        }
    },

    methods: {
        onClick: function onClick(e) {
            this.$emit('click', e);
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a
    }
};

/***/ }),
/* 135 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__mixins_RespondsToWindowResize_js__ = __webpack_require__(67);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__helpers_uuid__ = __webpack_require__(92);
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








/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-collapsible',

    props: {
        open: {
            type: Boolean,
            default: false
        },
        title: String,
        removeIcon: {
            type: Boolean,
            default: false
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            height: 0,
            isReady: false,
            isOpen: this.open,
            useInitialHeight: false,
            id: __WEBPACK_IMPORTED_MODULE_4__helpers_uuid__["a" /* default */].short('ui-collapsible-')
        };
    },


    computed: {
        classes: function classes() {
            return [{ 'is-open': this.isOpen }, { 'is-disabled': this.disabled }];
        },
        calculatedHeight: function calculatedHeight() {
            return this.height === 0 || this.useInitialHeight ? 'initial' : this.height + 'px';
        }
    },

    watch: {
        open: function open() {
            if (this.isOpen !== this.open) {
                this.isOpen = this.open;
            }
        }
    },

    mounted: function mounted() {
        var _this = this;

        this.isReady = true;
        this.refreshHeight();

        this.$on('window-resize', function () {
            _this.refreshHeight();
        });
    },


    methods: {
        onEnter: function onEnter() {
            this.$emit('open');
            this.refreshHeight();
        },
        onLeave: function onLeave() {
            this.$emit('close');
        },
        toggleCollapsible: function toggleCollapsible() {
            if (this.disabled) {
                return;
            }

            this.isOpen = !this.isOpen;
        },
        refreshHeight: function refreshHeight() {
            var _this2 = this;

            var body = this.$refs.body;

            this.useInitialHeight = true;
            body.style.display = 'block';

            this.$nextTick(function () {
                _this2.height = body.scrollHeight + 1;
                _this2.useInitialHeight = false;

                if (!_this2.isOpen) {
                    body.style.display = 'none';
                }
            });
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a
    },

    mixins: [__WEBPACK_IMPORTED_MODULE_3__mixins_RespondsToWindowResize_js__["a" /* default */]]
};

/***/ }),
/* 136 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiModal_vue__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiModal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiModal_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__helpers_classlist__ = __webpack_require__(32);
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
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-confirm',

    props: {
        title: {
            type: String,
            default: 'UiConfirm'
        },
        type: {
            type: String,
            default: 'primary' // any of the color prop values of UiButton
        },
        confirmButtonText: {
            type: String,
            default: 'OK'
        },
        confirmButtonIcon: String,
        denyButtonText: {
            type: String,
            default: 'Cancel'
        },
        denyButtonIcon: String,
        autofocus: {
            type: String,
            default: 'deny-button' // 'confirm-button', 'deny-button' or 'none'
        },
        closeOnConfirm: {
            type: Boolean,
            default: true
        },
        dismissOn: String,
        transition: String,
        loading: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        confirmButtonColor: function confirmButtonColor() {
            var typeToColor = {
                default: 'default',
                primary: 'primary',
                accent: 'accent',
                success: 'green',
                warning: 'orange',
                danger: 'red'
            };

            return typeToColor[this.type];
        }
    },

    methods: {
        open: function open() {
            this.$refs.modal.open();
        },
        close: function close() {
            this.$refs.modal.close();
        },
        confirm: function confirm() {
            this.$emit('confirm');

            if (this.closeOnConfirm) {
                this.$refs.modal.close();
            }
        },
        deny: function deny() {
            this.$refs.modal.close();
            this.$emit('deny');
        },
        onModalOpen: function onModalOpen() {
            var button = void 0;

            if (this.autofocus === 'confirm-button') {
                button = this.$refs.confirmButton.$el;
            } else if (this.autofocus === 'deny-button') {
                button = this.$refs.denyButton.$el;
            }

            if (button) {
                __WEBPACK_IMPORTED_MODULE_2__helpers_classlist__["a" /* default */].add(button, 'has-focus-ring');
                button.addEventListener('blur', this.removeAutoFocus);
                button.focus();
            }

            this.$emit('open');
        },
        onModalClose: function onModalClose() {
            this.$emit('close');
        },
        removeAutoFocus: function removeAutoFocus() {
            var button = void 0;

            if (this.autofocus === 'confirm-button') {
                button = this.$refs.confirmButton.$el;
            } else if (this.autofocus === 'deny-button') {
                button = this.$refs.denyButton.$el;
            }

            if (button) {
                __WEBPACK_IMPORTED_MODULE_2__helpers_classlist__["a" /* default */].remove(button, 'has-focus-ring');

                // This listener should run only once
                button.removeEventListener('blur', this.removeAutoFocus);
            }
        }
    },

    components: {
        UiButton: __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default.a,
        UiModal: __WEBPACK_IMPORTED_MODULE_1__UiModal_vue___default.a
    }
};

/***/ }),
/* 137 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiCalendar_vue__ = __webpack_require__(93);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiCalendar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiCalendar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiModal_vue__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiModal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__UiModal_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiPopover_vue__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiPopover_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__UiPopover_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__helpers_date__ = __webpack_require__(33);
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









/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-datepicker',

    props: {
        name: String,
        value: Date,
        minDate: Date,
        maxDate: Date,
        yearRange: Array,
        lang: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_5__helpers_date__["a" /* default */].defaultLang;
            }
        },
        customFormatter: Function,
        dateFilter: Function,
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        orientation: {
            type: String,
            default: 'portrait' // 'portrait' or 'landscape'
        },
        pickerType: {
            type: String,
            default: 'popover' // 'popover' or 'modal'
        },
        okButtonText: {
            type: String,
            default: 'OK'
        },
        cancelButtonText: {
            type: String,
            default: 'Cancel'
        },
        placeholder: String,
        icon: String,
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        label: String,
        floatingLabel: {
            type: Boolean,
            default: false
        },
        invalid: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            isTouched: false,
            valueAtModalOpen: null,
            initialValue: JSON.stringify(this.value)
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-datepicker--icon-position-' + this.iconPosition, 'ui-datepicker--orientation-' + this.orientation, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-touched': this.isTouched }, { 'is-disabled': this.disabled }, { 'has-label': this.hasLabel }, { 'has-floating-label': this.hasFloatingLabel }];
        },
        labelClasses: function labelClasses() {
            return {
                'is-inline': this.hasFloatingLabel && this.isLabelInline,
                'is-floating': this.hasFloatingLabel && !this.isLabelInline
            };
        },
        hasLabel: function hasLabel() {
            return Boolean(this.label) || Boolean(this.$slots.default);
        },
        hasFloatingLabel: function hasFloatingLabel() {
            return this.hasLabel && this.floatingLabel;
        },
        isLabelInline: function isLabelInline() {
            return !this.value && !this.isActive;
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || Boolean(this.error);
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        },
        displayText: function displayText() {
            if (!this.value) {
                return '';
            }

            return this.customFormatter ? this.customFormatter(this.value, this.lang) : __WEBPACK_IMPORTED_MODULE_5__helpers_date__["a" /* default */].humanize(this.value, this.lang);
        },
        hasDisplayText: function hasDisplayText() {
            return Boolean(this.displayText.length);
        },
        submittedValue: function submittedValue() {
            return this.value ? this.value.getFullYear() + '-' + this.value.getMonth() + '-' + this.value.getDate() : '';
        },
        usesPopover: function usesPopover() {
            return this.pickerType === 'popover';
        },
        usesModal: function usesModal() {
            return this.pickerType === 'modal';
        }
    },

    mounted: function mounted() {
        document.addEventListener('click', this.onExternalClick);
    },
    beforeDestroy: function beforeDestroy() {
        document.removeEventListener('click', this.onExternalClick);
    },


    methods: {
        onDateSelect: function onDateSelect(date) {
            this.$emit('input', date);
            this.closePicker();
        },
        openPicker: function openPicker() {
            if (this.disabled) {
                return;
            }

            this.$refs[this.usesModal ? 'modal' : 'popover'].open();
        },
        closePicker: function closePicker() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { autoBlur: false };

            if (this.usesPopover) {
                this.$refs.popover.close();
            }

            if (options.autoBlur) {
                this.isActive = false;
            } else {
                this.$refs.label.focus();
            }
        },
        onClick: function onClick() {
            if (this.usesModal && !this.disabled) {
                this.$refs.modal.open();
            }
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);

            if (this.usesPopover && this.$refs.popover.dropInstance.isOpened()) {
                this.closePicker({ autoBlur: true });
            }
        },
        onPickerOpen: function onPickerOpen() {
            if (this.usesModal) {
                this.valueAtModalOpen = this.value ? __WEBPACK_IMPORTED_MODULE_5__helpers_date__["a" /* default */].clone(this.value) : null;
            }

            this.isActive = true;
            this.$emit('open');
        },
        onPickerClose: function onPickerClose() {
            this.$emit('close');

            if (!this.isTouched) {
                this.isTouched = true;
                this.$emit('touch');
            }
        },
        onPickerCancel: function onPickerCancel() {
            this.$emit('input', this.valueAtModalOpen);
            this.$refs.modal.close();
        },
        onExternalClick: function onExternalClick(e) {
            if (this.disabled) {
                return;
            }

            var clickWasInternal = this.$el.contains(e.target) || this.$refs[this.usesPopover ? 'popover' : 'modal'].$el.contains(e.target);

            if (clickWasInternal) {
                return;
            }

            if (this.isActive) {
                this.isActive = false;
            }
        },
        reset: function reset() {
            this.$emit('input', JSON.parse(this.initialValue));
        },
        resetTouched: function resetTouched() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { touched: false };

            this.isTouched = options.touched;
        }
    },

    components: {
        UiButton: __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default.a,
        UiCalendar: __WEBPACK_IMPORTED_MODULE_1__UiCalendar_vue___default.a,
        UiIcon: __WEBPACK_IMPORTED_MODULE_2__UiIcon_vue___default.a,
        UiModal: __WEBPACK_IMPORTED_MODULE_3__UiModal_vue___default.a,
        UiPopover: __WEBPACK_IMPORTED_MODULE_4__UiPopover_vue___default.a
    }
};

/***/ }),
/* 138 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiTooltip_vue__ = __webpack_require__(70);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiTooltip_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiTooltip_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__config__ = __webpack_require__(6);
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







/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-fab',

    props: {
        size: {
            type: String,
            default: 'normal' // 'normal' or 'small'
        },
        color: {
            type: String,
            default: 'default' // 'default', primary', or 'accent'
        },
        icon: String,
        ariaLabel: String,
        tooltip: String,
        openTooltipOn: String,
        tooltipPosition: String,
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_3__config__["default"].data.disableRipple
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-fab--color-' + this.color, 'ui-fab--size-' + this.size];
        }
    },

    methods: {
        onClick: function onClick(e) {
            this.$emit('click', e);
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a,
        UiTooltip: __WEBPACK_IMPORTED_MODULE_2__UiTooltip_vue___default.a
    }
};

/***/ }),
/* 139 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
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
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-fileupload',

    props: {
        name: {
            type: String,
            required: true
        },
        label: String,
        accept: String,
        multiple: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: 'primary' // 'primary' or 'secondary'
        },
        color: {
            type: String,
            default: 'default' // 'default', 'primary', 'accent'
        },
        size: {
            type: String,
            default: 'normal' // 'small', 'normal', 'large'
        },
        raised: {
            type: Boolean,
            default: false
        },
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            hasSelection: false,
            hasMultiple: false,
            displayText: '',
            focusRing: {
                top: 0,
                left: 0,
                size: 0,
                initialized: false
            }
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-fileupload--type-' + this.type, 'ui-fileupload--color-' + this.color, 'ui-fileupload--icon-position-' + this.iconPosition, 'ui-fileupload--size-' + this.size, { 'is-active': this.isActive }, { 'is-multiple': this.hasMultiple }, { 'is-raised': this.raised }, { 'is-disabled': this.disabled }];
        },
        placeholder: function placeholder() {
            if (this.label) {
                return this.label;
            }

            return this.multiple ? 'Choose files' : 'Choose a file';
        },
        focusRingStyle: function focusRingStyle() {
            return {
                height: this.focusRing.size + 'px',
                width: this.focusRing.size + 'px',
                top: this.focusRing.top + 'px',
                left: this.focusRing.left + 'px'
            };
        }
    },

    methods: {
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);

            if (!this.focusRing.initialized) {
                this.initializeFocusRing();
            }
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);
        },
        onChange: function onChange(e) {
            var _this = this;

            var displayText = void 0;
            var input = this.$refs.input;

            if (input.files && input.files.length > 1) {
                displayText = input.files.length + ' files selected';
            } else {
                displayText = e.target.value.split('\\').pop();
            }

            if (displayText) {
                this.hasSelection = true;
                this.displayText = displayText;
                this.hasMultiple = input.files.length > 1;

                this.$nextTick(function () {
                    return _this.refreshFocusRing();
                });
            }

            this.$emit('change', input.files, e);
        },
        initializeFocusRing: function initializeFocusRing() {
            this.refreshFocusRing();
            this.focusRing.initialized = true;
        },
        refreshFocusRing: function refreshFocusRing() {
            var bounds = {
                width: this.$el.clientWidth,
                height: this.$el.clientHeight
            };

            this.focusRing.size = bounds.width - 16; // 8px of padding on left and right
            this.focusRing.top = -1 * (this.focusRing.size - bounds.height) / 2;
            this.focusRing.left = (bounds.width - this.focusRing.size) / 2;
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a
    }
};

/***/ }),
/* 140 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-icon',

    props: {
        icon: String,
        iconSet: {
            type: String,
            default: 'material-icons'
        },
        ariaLabel: String,
        removeText: {
            type: Boolean,
            default: false
        },
        useSvg: {
            type: Boolean,
            default: false
        }
    }
};

/***/ }),
/* 141 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiPopover_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiTooltip_vue__ = __webpack_require__(70);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiTooltip_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__UiTooltip_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__config__ = __webpack_require__(6);
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









/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-icon-button',

    props: {
        type: {
            type: String,
            default: 'primary' // 'primary' or 'secondary'
        },
        buttonType: {
            type: String,
            default: 'button'
        },
        color: {
            type: String,
            default: 'default' // 'default', 'primary', 'accent', 'green', 'orange', or 'red'
        },
        size: {
            type: String,
            default: 'normal' // 'small', normal', or 'large'
        },
        icon: String,
        ariaLabel: String,
        loading: {
            type: Boolean,
            default: false
        },
        hasDropdown: {
            type: Boolean,
            default: false
        },
        dropdownPosition: {
            type: String,
            default: 'bottom left'
        },
        openDropdownOn: {
            type: String,
            default: 'click' // 'click', 'hover', 'focus', or 'always'
        },
        tooltip: String,
        openTooltipOn: String,
        tooltipPosition: String,
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_5__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-icon-button--type-' + this.type, 'ui-icon-button--color-' + this.color, 'ui-icon-button--size-' + this.size, { 'is-loading': this.loading }, { 'is-disabled': this.disabled || this.loading }, { 'has-dropdown': this.hasDropdown }];
        },
        progressColor: function progressColor() {
            if (this.type === 'primary') {
                if (this.color === 'default' || this.color === 'black') {
                    return 'black';
                }

                return 'white';
            }

            if (this.color === 'white') {
                return 'white';
            }

            return 'black';
        }
    },

    methods: {
        onClick: function onClick(e) {
            this.$emit('click', e);
        },
        onDropdownOpen: function onDropdownOpen() {
            this.$emit('dropdown-open');
        },
        onDropdownClose: function onDropdownClose() {
            this.$emit('dropdown-close');
        },
        openDropdown: function openDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.open();
            }
        },
        closeDropdown: function closeDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.close();
            }
        },
        toggleDropdown: function toggleDropdown() {
            if (this.$refs.dropdown) {
                this.$refs.dropdown.toggle();
            }
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiPopover: __WEBPACK_IMPORTED_MODULE_1__UiPopover_vue___default.a,
        UiProgressCircular: __WEBPACK_IMPORTED_MODULE_2__UiProgressCircular_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_3__UiRippleInk_vue___default.a,
        UiTooltip: __WEBPACK_IMPORTED_MODULE_4__UiTooltip_vue___default.a
    }
};

/***/ }),
/* 142 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiMenuOption_vue__ = __webpack_require__(288);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiMenuOption_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiMenuOption_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(6);
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





/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-menu',

    props: {
        options: {
            type: Array,
            default: function _default() {
                return [];
            }
        },
        hasIcons: {
            type: Boolean,
            default: false
        },
        iconProps: Object,
        hasSecondaryText: {
            type: Boolean,
            default: false
        },
        containFocus: {
            type: Boolean,
            default: false
        },
        keys: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_1__config__["default"].data.UiMenu.keys;
            }
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_1__config__["default"].data.disableRipple
        },
        raised: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return {
                'is-raised': this.raised,
                'has-icons': this.hasIcons,
                'has-secondary-text': this.hasSecondaryText
            };
        }
    },

    methods: {
        selectOption: function selectOption(option) {
            if (option.disabled || option.type === 'divider') {
                return;
            }

            this.$emit('select', option);
            this.closeMenu();
        },
        closeMenu: function closeMenu() {
            this.$emit('close');
        },
        redirectFocus: function redirectFocus(e) {
            e.stopPropagation();
            this.$el.querySelector('.ui-menu-option').focus();
        }
    },

    components: {
        UiMenuOption: __WEBPACK_IMPORTED_MODULE_0__UiMenuOption_vue___default.a
    }
};

/***/ }),
/* 143 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
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






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-menu-option',

    props: {
        type: String,
        label: String,
        icon: String,
        iconProps: {
            type: Object,
            default: function _default() {
                return {};
            }
        },
        secondaryText: String,
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return {
                'is-divider': this.isDivider,
                'is-disabled': this.disabled
            };
        },
        isDivider: function isDivider() {
            return this.type === 'divider';
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a
    }
};

/***/ }),
/* 144 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue__ = __webpack_require__(95);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__helpers_classlist__ = __webpack_require__(32);
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





/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-modal',

    props: {
        title: {
            type: String,
            default: 'UiModal title'
        },
        size: {
            type: String,
            default: 'normal' // 'small', 'normal', or 'large'
        },
        role: {
            type: String,
            default: 'dialog' // 'dialog' or 'alertdialog'
        },
        transition: {
            type: String,
            default: 'scale' // 'scale', or 'fade'
        },
        removeHeader: {
            type: Boolean,
            default: false
        },
        removeCloseButton: {
            type: Boolean,
            default: false
        },
        preventShift: {
            type: Boolean,
            default: false
        },
        dismissible: {
            type: Boolean,
            default: true
        },
        dismissOn: {
            type: String,
            default: 'backdrop esc close-button'
        }
    },

    data: function data() {
        return {
            isOpen: false,
            lastfocusedElement: null
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-modal--size-' + this.size, { 'has-footer': this.hasFooter }, { 'is-open': this.isOpen }];
        },
        hasFooter: function hasFooter() {
            return Boolean(this.$slots.footer);
        },
        toggleTransition: function toggleTransition() {
            return 'ui-modal--transition-' + this.transition;
        },
        dismissOnBackdrop: function dismissOnBackdrop() {
            return this.dismissOn.indexOf('backdrop') > -1;
        },
        dismissOnCloseButton: function dismissOnCloseButton() {
            return this.dismissOn.indexOf('close-button') > -1;
        },
        dismissOnEsc: function dismissOnEsc() {
            return this.dismissOn.indexOf('esc') > -1;
        }
    },

    watch: {
        isOpen: function isOpen() {
            var _this = this;

            this.$nextTick(function () {
                _this[_this.isOpen ? 'onOpen' : 'onClose']();
            });
        }
    },

    beforeDestroy: function beforeDestroy() {
        if (this.isOpen) {
            this.teardownModal();
        }
    },


    methods: {
        open: function open() {
            this.isOpen = true;
        },
        close: function close() {
            this.isOpen = false;
        },
        closeModal: function closeModal(e) {
            if (!this.dismissible) {
                return;
            }

            // Make sure the element clicked was the backdrop and not a child whose click
            // event has bubbled up
            if (e.currentTarget === this.$refs.backdrop && e.target !== e.currentTarget) {
                return;
            }

            this.isOpen = false;
        },
        onOpen: function onOpen() {
            this.lastfocusedElement = document.activeElement;
            this.$refs.container.focus();

            __WEBPACK_IMPORTED_MODULE_1__helpers_classlist__["a" /* default */].add(document.body, 'ui-modal--is-open');
            document.addEventListener('focus', this.restrictFocus, true);

            this.$emit('open');
        },
        onClose: function onClose() {
            this.teardownModal();
            this.$emit('close');
        },
        redirectFocus: function redirectFocus() {
            this.$refs.container.focus();
        },
        restrictFocus: function restrictFocus(e) {
            if (!this.$refs.container.contains(e.target)) {
                e.stopPropagation();
                this.$refs.container.focus();
            }
        },
        teardownModal: function teardownModal() {
            // classlist.remove(document.body, 'ui-modal--is-open');
            document.removeEventListener('focus', this.restrictFocus, true);

            if (this.lastfocusedElement) {
                this.lastfocusedElement.focus();
            }
        },
        onEnter: function onEnter() {
            this.$emit('reveal');
        },
        onLeave: function onLeave() {
            this.$emit('hide');

            __WEBPACK_IMPORTED_MODULE_1__helpers_classlist__["a" /* default */].remove(document.body, 'ui-modal--is-open');
        }
    },

    components: {
        UiCloseButton: __WEBPACK_IMPORTED_MODULE_0__UiCloseButton_vue___default.a
    }
};

/***/ }),
/* 145 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tether_drop__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_tether_drop___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_tether_drop__);
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




/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-popover',

    props: {
        trigger: {
            type: String,
            required: true
        },
        dropdownPosition: {
            type: String,
            default: 'bottom left'
        },
        openOn: {
            type: String,
            default: 'click' // 'click', 'hover', 'focus', or 'always'
        },
        containFocus: {
            type: Boolean,
            default: false
        },
        focusRedirector: Function,
        raised: {
            type: Boolean,
            default: true
        }
    },

    data: function data() {
        return {
            dropInstance: null,
            lastfocusedElement: null
        };
    },


    computed: {
        triggerEl: function triggerEl() {
            return this.$parent.$refs[this.trigger];
        }
    },

    mounted: function mounted() {
        if (this.triggerEl) {
            this.initializeDropdown();
        }
    },
    beforeDestroy: function beforeDestroy() {
        if (this.dropInstance) {
            this.dropInstance.destroy();
        }
    },


    methods: {
        initializeDropdown: function initializeDropdown() {
            this.dropInstance = new __WEBPACK_IMPORTED_MODULE_1_tether_drop___default.a({
                target: this.triggerEl,
                content: this.$el,
                position: this.dropdownPosition,
                constrainToWindow: true,
                openOn: this.openOn
            });

            // TO FIX: Workaround for Tether not positioning
            // correctly for positions other than 'bottom left'
            if (this.dropdownPosition !== 'bottom left') {
                this.dropInstance.open();
                this.dropInstance.close();
                this.dropInstance.open();
                this.dropInstance.close();
            }

            this.dropInstance.on('open', this.onOpen);
            this.dropInstance.on('close', this.onClose);
        },
        openDropdown: function openDropdown() {
            if (this.dropInstance) {
                this.dropInstance.open();
            }
        },
        closeDropdown: function closeDropdown() {
            if (this.dropInstance) {
                this.dropInstance.close();
            }
        },
        toggleDropdown: function toggleDropdown(e) {
            if (this.dropInstance) {
                this.dropInstance.toggle(e);
            }
        },


        /**
         * Ensures drop is horizontally within viewport (vertical is already solved by drop.js).
         * https://github.com/HubSpot/drop/issues/16
         */
        positionDrop: function positionDrop() {
            var drop = this.dropInstance;
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            var width = drop.drop.getBoundingClientRect().width;
            var left = drop.target.getBoundingClientRect().left;
            var availableSpace = windowWidth - left;

            if (width > availableSpace) {
                var direction = width > availableSpace ? 'right' : 'left';

                drop.tether.attachment.left = direction;
                drop.tether.targetAttachment.left = direction;

                drop.position();
            }
        },
        onOpen: function onOpen() {
            this.positionDrop();
            __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__["a" /* default */].add(this.triggerEl, 'has-dropdown-open');

            this.lastfocusedElement = document.activeElement;
            this.$el.focus();

            this.$emit('open');
        },
        onClose: function onClose() {
            __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__["a" /* default */].remove(this.triggerEl, 'has-dropdown-open');

            if (this.lastfocusedElement) {
                this.lastfocusedElement.focus();
            }

            this.$emit('close');
        },
        restrictFocus: function restrictFocus(e) {
            if (!this.containFocus) {
                this.closeDropdown();
                return;
            }

            e.stopPropagation();

            if (this.focusRedirector) {
                this.focusRedirector(e);
            } else {
                this.$el.focus();
            }
        },
        open: function open() {
            this.openDropdown();
        },
        close: function close() {
            this.closeDropdown();
        },
        toggle: function toggle() {
            this.toggleDropdown();
        }
    }
};

/***/ }),
/* 146 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-preloader',

    props: {
        show: {
            type: Boolean,
            required: true
        }
    }
};

/***/ }),
/* 147 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-progress-circular',

    props: {
        type: {
            type: String,
            default: 'indeterminate' // 'indeterminate' or 'determinate'
        },
        color: {
            type: String,
            default: 'primary' // 'primary', 'accent', multi-color', 'black', or 'white'
        },
        progress: {
            type: Number,
            default: 0
        },
        size: {
            type: Number,
            default: 32
        },
        stroke: Number,
        autoStroke: {
            type: Boolean,
            default: true
        },
        disableTransition: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-progress-circular--color-' + this.color, 'ui-progress-circular--type-' + this.type];
        },
        strokeDashArray: function strokeDashArray() {
            var circumference = 2 * Math.PI * this.radius;

            // Use first 3 decimal places, rounded as appropriate
            return Math.round(circumference * 1000) / 1000;
        },
        strokeDashOffset: function strokeDashOffset() {
            var progress = this.moderateProgress(this.progress);
            var circumference = 2 * Math.PI * this.radius;

            return (100 - progress) / 100 * circumference;
        },
        radius: function radius() {
            var stroke = this.stroke ? this.stroke : 4;
            return (this.size - stroke) / 2;
        },
        calculatedStroke: function calculatedStroke() {
            if (this.stroke) {
                return this.stroke;
            }

            if (this.autoStroke) {
                return parseInt(this.size / 8, 10);
            }

            return 4;
        }
    },

    methods: {
        moderateProgress: function moderateProgress(progress) {
            if (isNaN(progress) || progress < 0) {
                return 0;
            }

            if (progress > 100) {
                return 100;
            }

            return progress;
        }
    }
};

/***/ }),
/* 148 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-progress-linear',

    props: {
        type: {
            type: String,
            default: 'indeterminate' // 'determinate' or 'indeterminate'
        },
        color: {
            type: String,
            default: 'primary' // 'primary', 'accent', 'black' or 'white'
        },
        progress: {
            type: Number,
            default: 0
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-progress-linear--color-' + this.color, 'ui-progress-linear--type-' + this.type];
        },
        moderatedProgress: function moderatedProgress() {
            if (this.progress < 0) {
                return 0;
            }

            if (this.progress > 100) {
                return 100;
            }

            return this.progress;
        }
    }
};

/***/ }),
/* 149 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-radio',

    props: {
        name: String,
        label: String,
        value: {
            type: [Number, String],
            required: true
        },
        trueValue: {
            type: [Number, String],
            required: true
        },
        checked: {
            type: Boolean,
            default: false
        },
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        buttonPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-radio--color-' + this.color, 'ui-radio--button-position-' + this.buttonPosition, { 'is-active': this.isActive }, { 'is-checked': this.isChecked }, { 'is-disabled': this.disabled }];
        },
        isChecked: function isChecked() {
            // eslint-disable-next-line eqeqeq
            return String(this.value).length > 0 && this.value == this.trueValue;
        }
    },

    created: function created() {
        if (this.checked) {
            this.$emit('input', this.trueValue);
        }
    },


    methods: {
        toggleCheck: function toggleCheck() {
            if (!this.disabled) {
                this.$emit('input', this.trueValue);
            }
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);
        },
        onChange: function onChange(e) {
            this.$emit('change', this.isChecked, e);
        }
    }
};

/***/ }),
/* 150 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiRadio_vue__ = __webpack_require__(97);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiRadio_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiRadio_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(6);
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
//
//
//





/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-radio-group',

    props: {
        name: {
            type: String,
            required: true
        },
        label: String,
        options: {
            type: Array,
            required: true
        },
        value: {
            type: [Number, String],
            required: true
        },
        keys: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_1__config__["default"].data.UiRadioGroup.keys;
            }
        },
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        buttonPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        vertical: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        invalid: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            initialValue: this.value,
            selectedOptionValue: this.value
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-radio-group--color-' + this.color, 'ui-radio-group--button-position-' + this.buttonPosition, { 'is-vertical': this.vertical }, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-disabled': this.disabled }];
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || this.showError;
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        }
    },

    watch: {
        selectedOptionValue: function selectedOptionValue() {
            this.$emit('input', this.selectedOptionValue);
            this.$emit('change', this.selectedOptionValue);
        },
        value: function value() {
            this.selectedOptionValue = this.value;
        }
    },

    methods: {
        reset: function reset() {
            this.$emit('input', this.initialValue);
        },
        isOptionCheckedByDefault: function isOptionCheckedByDefault(option) {
            // eslint-disable-next-line eqeqeq
            return this.initialValue == option[this.keys.value] || this.initialValue == option || option[this.keys.checked];
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);
        }
    },

    components: {
        UiRadio: __WEBPACK_IMPORTED_MODULE_0__UiRadio_vue___default.a
    }
};

/***/ }),
/* 151 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__ = __webpack_require__(32);
//
//
//
//

/**
 * Adapted from rippleJS (https://github.com/samthor/rippleJS, version 1.0.3)
 * removed jQuery, convert to ES6
 */


var startRipple = function startRipple(eventType, event) {
    var holder = event.currentTarget || event.target;

    if (holder && !__WEBPACK_IMPORTED_MODULE_0__helpers_classlist__["a" /* default */].has(holder, 'ui-ripple-ink')) {
        holder = holder.querySelector('.ui-ripple-ink');
    }

    if (!holder) {
        return;
    }

    // Store the event use to generate this ripple on the holder: don't allow
    // further events of different types until we're done. Prevents double
    // ripples from mousedown/touchstart.
    var prev = holder.getAttribute('data-ui-event');

    if (prev && prev !== eventType) {
        return;
    }

    holder.setAttribute('data-ui-event', eventType);

    // Create and position the ripple
    var rect = holder.getBoundingClientRect();
    var x = event.offsetX;
    var y = void 0;

    if (x === undefined) {
        x = event.clientX - rect.left;
        y = event.clientY - rect.top;
    } else {
        y = event.offsetY;
    }

    var ripple = document.createElement('div');
    var max = void 0;

    if (rect.width === rect.height) {
        max = rect.width * 1.412;
    } else {
        max = Math.sqrt(rect.width * rect.width + rect.height * rect.height);
    }

    var dim = max * 2 + 'px';

    ripple.style.width = dim;
    ripple.style.height = dim;
    ripple.style.marginLeft = -max + x + 'px';
    ripple.style.marginTop = -max + y + 'px';

    // Activate/add the element
    ripple.className = 'ui-ripple-ink__ink';
    holder.appendChild(ripple);

    setTimeout(function () {
        __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__["a" /* default */].add(ripple, 'is-held');
    }, 0);

    var releaseEvent = eventType === 'mousedown' ? 'mouseup' : 'touchend';

    var handleRelease = function handleRelease() {
        document.removeEventListener(releaseEvent, handleRelease);

        __WEBPACK_IMPORTED_MODULE_0__helpers_classlist__["a" /* default */].add(ripple, 'is-done');

        // Larger than the animation duration in CSS
        setTimeout(function () {
            holder.removeChild(ripple);

            if (holder.children.length === 0) {
                holder.removeAttribute('data-ui-event');
            }
        }, 650);
    };

    document.addEventListener(releaseEvent, handleRelease);
};

var handleMouseDown = function handleMouseDown(e) {
    // Trigger on left click only
    if (e.button === 0) {
        startRipple(e.type, e);
    }
};

var handleTouchStart = function handleTouchStart(e) {
    if (e.changedTouches) {
        for (var i = 0; i < e.changedTouches.length; ++i) {
            startRipple(e.type, e.changedTouches[i]);
        }
    }
};

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-ripple-ink',

    props: {
        trigger: {
            type: String,
            required: true
        }
    },

    watch: {
        trigger: function trigger() {
            this.initialize();
        }
    },

    mounted: function mounted() {
        var _this = this;

        this.$nextTick(function () {
            _this.initialize();
        });
    },
    beforeDestroy: function beforeDestroy() {
        var triggerEl = this.trigger ? this.$parent.$refs[this.trigger] : null;

        if (!triggerEl) {
            return;
        }

        triggerEl.removeEventListener('mousedown', handleMouseDown);
        triggerEl.removeEventListener('touchstart', handleTouchStart);
    },


    methods: {
        initialize: function initialize() {
            var triggerEl = this.trigger ? this.$parent.$refs[this.trigger] : null;

            if (!triggerEl) {
                return;
            }

            triggerEl.addEventListener('touchstart', handleTouchStart);
            triggerEl.addEventListener('mousedown', handleMouseDown);
        }
    }
};

/***/ }),
/* 152 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiProgressCircular_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiProgressCircular_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiProgressCircular_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiSelectOption_vue__ = __webpack_require__(292);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiSelectOption_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiSelectOption_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__config__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_fuzzysearch__ = __webpack_require__(113);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_fuzzysearch___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_fuzzysearch__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__helpers_util__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__helpers_element_scroll__ = __webpack_require__(91);
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










/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-select',

    props: {
        name: String,
        value: {
            type: [String, Number, Object, Array],
            required: true
        },
        options: {
            type: Array,
            default: function _default() {
                return [];
            }
        },
        placeholder: String,
        icon: String,
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        label: String,
        floatingLabel: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: 'basic' // 'basic' or 'image'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        multipleDelimiter: {
            type: String,
            default: ', '
        },
        hasSearch: {
            type: Boolean,
            default: false
        },
        searchPlaceholder: {
            type: String,
            default: 'Search'
        },
        filter: Function,
        disableFilter: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        noResults: {
            type: Boolean,
            default: false
        },
        keys: {
            type: Object,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_3__config__["default"].data.UiSelect.keys;
            }
        },
        invalid: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            query: '',
            isActive: false,
            isTouched: false,
            selectedIndex: -1,
            highlightedIndex: -1,
            showDropdown: false,
            initialValue: JSON.stringify(this.value)
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-select--type-' + this.type, 'ui-select--icon-position-' + this.iconPosition, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-touched': this.isTouched }, { 'is-disabled': this.disabled }, { 'is-multiple': this.multiple }, { 'has-label': this.hasLabel }, { 'has-floating-label': this.hasFloatingLabel }];
        },
        labelClasses: function labelClasses() {
            return {
                'is-inline': this.hasFloatingLabel && this.isLabelInline,
                'is-floating': this.hasFloatingLabel && !this.isLabelInline
            };
        },
        hasLabel: function hasLabel() {
            return Boolean(this.label) || Boolean(this.$slots.default);
        },
        hasFloatingLabel: function hasFloatingLabel() {
            return this.hasLabel && this.floatingLabel;
        },
        isLabelInline: function isLabelInline() {
            return this.value.length === 0 && !this.isActive;
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || Boolean(this.error);
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        },
        filteredOptions: function filteredOptions() {
            var _this = this;

            if (this.disableFilter) {
                return this.options;
            }

            return this.options.filter(function (option, index) {
                if (_this.filter) {
                    return _this.filter(option, _this.query);
                }

                return _this.defaultFilter(option, index);
            });
        },
        displayText: function displayText() {
            var _this2 = this;

            if (this.multiple) {
                if (this.value.length > 0) {
                    return this.value.map(function (value) {
                        return value[_this2.keys.label] || value;
                    }).join(this.multipleDelimiter);
                }

                return '';
            }

            return this.value ? this.value[this.keys.label] || this.value : '';
        },
        hasDisplayText: function hasDisplayText() {
            return Boolean(this.displayText.length);
        },
        hasNoResults: function hasNoResults() {
            if (this.loading || this.query.length === 0) {
                return false;
            }

            return this.disableFilter ? this.noResults : this.filteredOptions.length === 0;
        },
        submittedValue: function submittedValue() {
            var _this3 = this;

            // Assuming that if there is no name, then there's no
            // need to computed the submittedValue
            if (!this.name || !this.value) {
                return;
            }

            if (Array.isArray(this.value)) {
                return this.value.map(function (option) {
                    return option[_this3.keys.value] || option;
                }).join(',');
            }

            return this.value[this.keys.value] || this.value;
        }
    },

    watch: {
        filteredOptions: function filteredOptions() {
            this.highlightedIndex = 0;
            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__helpers_element_scroll__["a" /* resetScroll */])(this.$refs.optionsList);
        },
        showDropdown: function showDropdown() {
            if (this.showDropdown) {
                this.onOpen();
                this.$emit('dropdown-open');
            } else {
                this.onClose();
                this.$emit('dropdown-close');
            }
        },
        query: function query() {
            this.$emit('query-change', this.query);
        }
    },

    created: function created() {
        if (!this.value || this.value === '') {
            this.setValue(null);
        }
    },
    mounted: function mounted() {
        document.addEventListener('click', this.onExternalClick);
    },
    beforeDestroy: function beforeDestroy() {
        document.removeEventListener('click', this.onExternalClick);
    },


    methods: {
        setValue: function setValue(value) {
            value = value ? value : this.multiple ? [] : '';

            this.$emit('input', value);
            this.$emit('change', value);
        },
        highlightOption: function highlightOption(index) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { autoScroll: true };

            if (this.highlightedIndex === index || this.$refs.options.length === 0) {
                return;
            }

            var firstIndex = 0;
            var lastIndex = this.$refs.options.length - 1;

            if (index < firstIndex) {
                index = lastIndex;
            } else if (index > lastIndex) {
                index = firstIndex;
            }

            this.highlightedIndex = index;

            if (options.autoScroll) {
                this.scrollOptionIntoView(this.$refs.options[index].$el);
            }
        },
        selectHighlighted: function selectHighlighted(index, e) {
            if (this.$refs.options.length > 0) {
                e.preventDefault();
                this.selectOption(this.$refs.options[index].option, index);
            }
        },
        selectOption: function selectOption(option, index) {
            var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : { autoClose: true };

            var shouldSelect = this.multiple && !this.isOptionSelected(option);

            if (this.multiple) {
                this.updateOption(option, { select: shouldSelect });
            } else {
                this.setValue(option);
                this.selectedIndex = index;
            }

            this.$emit('select', option, {
                selected: this.multiple ? shouldSelect : true
            });

            this.highlightedIndex = index;
            this.clearQuery();

            if (!this.multiple && options.autoClose) {
                this.closeDropdown();
            }
        },
        isOptionSelected: function isOptionSelected(option) {
            if (this.multiple) {
                return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_5__helpers_util__["b" /* looseIndexOf */])(this.value, option) > -1;
            }

            return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_5__helpers_util__["a" /* looseEqual */])(this.value, option);
        },
        updateOption: function updateOption(option) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { select: true };

            var value = [];
            var updated = false;
            var i = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_5__helpers_util__["b" /* looseIndexOf */])(this.value, option);

            if (options.select && i < 0) {
                value = this.value.concat(option);
                updated = true;
            }

            if (!options.select && i > -1) {
                value = this.value.slice(0, i).concat(this.value.slice(i + 1));
                updated = true;
            }

            if (updated) {
                this.setValue(value);
            }
        },
        defaultFilter: function defaultFilter(option) {
            var query = this.query.toLowerCase();
            var text = option[this.keys.label] || option;

            if (typeof text === 'string') {
                text = text.toLowerCase();
            }

            return __WEBPACK_IMPORTED_MODULE_4_fuzzysearch___default()(query, text);
        },
        clearQuery: function clearQuery() {
            this.query = '';
        },
        toggleDropdown: function toggleDropdown() {
            this[this.showDropdown ? 'closeDropdown' : 'openDropdown']();
        },
        openDropdown: function openDropdown() {
            if (this.disabled) {
                return;
            }

            this.showDropdown = true;

            // IE: clicking label doesn't focus the select element
            // to set isActive to true
            if (!this.isActive) {
                this.isActive = true;
            }
        },
        closeDropdown: function closeDropdown() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { autoBlur: false };

            this.showDropdown = false;

            if (!this.isTouched) {
                this.isTouched = true;
                this.$emit('touch');
            }

            if (options.autoBlur) {
                this.isActive = false;
            } else {
                this.$refs.label.focus();
            }
        },
        onFocus: function onFocus(e) {
            if (this.isActive) {
                return;
            }

            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);

            if (this.showDropdown) {
                this.closeDropdown({ autoBlur: true });
            }
        },
        onOpen: function onOpen() {
            var _this4 = this;

            this.$nextTick(function () {
                _this4.$refs[_this4.hasSearch ? 'searchInput' : 'dropdown'].focus();
                _this4.scrollOptionIntoView(_this4.$refs.optionsList.querySelector('.is-selected'));
            });
        },
        onClose: function onClose() {
            this.highlightedIndex = this.multiple ? -1 : this.selectedIndex;
        },
        onExternalClick: function onExternalClick(e) {
            if (!this.$el.contains(e.target)) {
                if (this.showDropdown) {
                    this.closeDropdown({ autoBlur: true });
                } else if (this.isActive) {
                    this.isActive = false;
                }
            }
        },
        scrollOptionIntoView: function scrollOptionIntoView(optionEl) {
            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__helpers_element_scroll__["b" /* scrollIntoView */])(optionEl, {
                container: this.$refs.optionsList,
                marginTop: 180
            });
        },
        reset: function reset() {
            this.setValue(JSON.parse(this.initialValue));
            this.clearQuery();
            this.resetTouched();

            this.selectedIndex = -1;
            this.highlightedIndex = -1;
        },
        resetTouched: function resetTouched() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { touched: false };

            this.isTouched = options.touched;
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiProgressCircular: __WEBPACK_IMPORTED_MODULE_1__UiProgressCircular_vue___default.a,
        UiSelectOption: __WEBPACK_IMPORTED_MODULE_2__UiSelectOption_vue___default.a
    }
};

/***/ }),
/* 153 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-select-option',

    props: {
        option: {
            type: [String, Object],
            required: true
        },
        type: {
            type: String,
            default: 'basic' // 'basic' or 'image'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        highlighted: {
            type: Boolean,
            default: false
        },
        selected: {
            type: Boolean,
            default: false
        },
        keys: {
            type: Object,
            default: function _default() {
                return {
                    label: 'label',
                    image: 'image'
                };
            }
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-select-option--type-' + this.type, { 'is-highlighted': this.highlighted }, { 'is-selected': this.selected }];
        },
        imageStyle: function imageStyle() {
            return { 'background-image': 'url(' + this.option[this.keys.image] + ')' };
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a
    }
};

/***/ }),
/* 154 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__helpers_classlist__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_RespondsToWindowResize_js__ = __webpack_require__(67);
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






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-slider',

    props: {
        name: String,
        icon: String,
        value: {
            type: Number,
            required: true
        },
        step: {
            type: Number,
            default: 10
        },
        snapToSteps: {
            type: Boolean,
            default: false
        },
        showMarker: {
            type: Boolean,
            default: false
        },
        markerValue: Number,
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            initialValue: this.value,
            isActive: false,
            isDragging: false,
            thumbSize: 0,
            trackLength: 0,
            trackOffset: 0,
            localValue: this.value
        };
    },


    computed: {
        classes: function classes() {
            return [{ 'is-dragging': this.isDragging }, { 'is-disabled': this.disabled }, { 'is-active': this.isActive }, { 'has-icon': this.hasIcon }, { 'has-marker': this.showMarker }];
        },
        hasIcon: function hasIcon() {
            return Boolean(this.$slots.icon) || Boolean(this.icon);
        },
        fillStyle: function fillStyle() {
            return { transform: 'scaleX(' + this.localValue / 100 + ')' };
        },
        thumbStyle: function thumbStyle() {
            return {
                transform: 'translateX(' + (this.localValue / 100 * this.trackLength - this.thumbSize / 2) + 'px)'
            };
        },
        markerText: function markerText() {
            return this.markerValue ? this.markerValue : this.value;
        },
        snapPoints: function snapPoints() {
            var points = [];
            var index = 0;
            var point = index * this.step;

            while (point <= 100) {
                points.push(point);
                index++;
                point = index * this.step;
            }

            return points;
        }
    },

    watch: {
        value: function value() {
            this.setValue(this.value);
        },
        isDragging: function isDragging() {
            var operation = this.isDragging ? 'add' : 'remove';
            __WEBPACK_IMPORTED_MODULE_1__helpers_classlist__["a" /* default */][operation](document.body, 'ui-slider--is-dragging');
        }
    },

    mounted: function mounted() {
        this.initializeSlider();
    },
    beforeDestroy: function beforeDestroy() {
        this.teardownSlider();
    },


    methods: {
        reset: function reset() {
            this.setValue(this.initialValue);
        },
        onFocus: function onFocus() {
            this.isActive = true;
            this.$emit('focus');
        },
        onBlur: function onBlur() {
            this.isActive = false;
            this.$emit('blur');
        },
        onExternalClick: function onExternalClick(e) {
            if (!this.$el.contains(e.target)) {
                this.onBlur();
            }
        },
        setValue: function setValue(value) {
            if (value > 100) {
                value = 100;
            } else if (value < 0) {
                value = 0;
            }

            if (value === this.localValue) {
                return;
            }

            this.localValue = value;
            this.$emit('input', value);
            this.$emit('change', value);
        },
        incrementValue: function incrementValue() {
            this.setValue(this.localValue + this.step);
        },
        decrementValue: function decrementValue() {
            this.setValue(this.localValue - this.step);
        },
        getTrackOffset: function getTrackOffset() {
            var el = this.$refs.track;
            var offset = el.offsetLeft;

            while (el.offsetParent) {
                el = el.offsetParent;
                offset += el.offsetLeft;
            }

            return offset;
        },
        getPointStyle: function getPointStyle(point) {
            return {
                left: point + '%'
            };
        },
        refreshSize: function refreshSize() {
            this.thumbSize = this.$refs.thumb.offsetWidth;
            this.trackLength = this.$refs.track.offsetWidth;
            this.trackOffset = this.getTrackOffset(this.$refs.track);
        },
        initializeSlider: function initializeSlider() {
            var _this = this;

            document.addEventListener('touchend', this.onDragStop);
            document.addEventListener('mouseup', this.onDragStop);
            document.addEventListener('click', this.onExternalClick);

            this.$on('window-resize', function () {
                _this.refreshSize();
                _this.isDragging = false;
            });

            this.refreshSize();
            this.initializeDrag();
        },
        teardownSlider: function teardownSlider() {
            document.removeEventListener('touchend', this.onDragStop);
            document.removeEventListener('mouseup', this.onDragStop);
            document.removeEventListener('click', this.onExternalClick);
        },
        initializeDrag: function initializeDrag() {
            var value = this.getEdge(this.localValue ? this.localValue : 0, 0, 100);
            this.setValue(value);
        },
        onDragStart: function onDragStart(e) {
            if (this.disabled) {
                return;
            }

            if (!this.isActive) {
                this.onFocus();
            }

            this.isDragging = true;
            this.dragUpdate(e);

            document.addEventListener('touchmove', this.onDragMove);
            document.addEventListener('mousemove', this.onDragMove);

            this.$emit('dragstart', this.localValue, e);
        },
        onDragMove: function onDragMove(e) {
            this.dragUpdate(e);
        },
        dragUpdate: function dragUpdate(e) {
            var position = e.touches ? e.touches[0].pageX : e.pageX;
            var value = this.getEdge((position - this.trackOffset) / this.trackLength * 100, 0, 100);

            if (this.isDragging) {
                this.setValue(Math.round(value));
            }
        },
        onDragStop: function onDragStop(e) {
            this.isDragging = false;

            if (this.snapToSteps && this.value % this.step !== 0) {
                this.setValue(this.getNearestSnapPoint());
            }

            document.removeEventListener('touchmove', this.onDragMove);
            document.removeEventListener('mousemove', this.onDragMove);

            this.$emit('dragend', this.localValue, e);
        },
        getNearestSnapPoint: function getNearestSnapPoint() {
            var previousSnapPoint = Math.floor(this.value / this.step) * this.step;
            var nextSnapPoint = previousSnapPoint + this.step;
            var midpoint = (previousSnapPoint + nextSnapPoint) / 2;

            return this.value >= midpoint ? nextSnapPoint : previousSnapPoint;
        },
        getEdge: function getEdge(a, b, c) {
            if (a < b) {
                return b;
            }

            if (a > c) {
                return c;
            }

            return a;
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a
    },

    mixins: [__WEBPACK_IMPORTED_MODULE_2__mixins_RespondsToWindowResize_js__["a" /* default */]]
};

/***/ }),
/* 155 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiButton_vue__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-snackbar',

    props: {
        message: String,
        action: String,
        actionColor: {
            type: String,
            default: 'accent' // 'primary' or 'accent'
        },
        transition: {
            type: String,
            default: 'slide' // 'slide' or 'fade'
        }
    },

    computed: {
        transitionName: function transitionName() {
            return 'ui-snackbar--transition-' + this.transition;
        }
    },

    methods: {
        onClick: function onClick() {
            this.$emit('click');
        },
        onActionClick: function onActionClick() {
            this.$emit('action-click');
        },
        onEnter: function onEnter() {
            this.$emit('show');
        },
        onLeave: function onLeave() {
            this.$emit('hide');
        }
    },

    components: {
        UiButton: __WEBPACK_IMPORTED_MODULE_0__UiButton_vue___default.a
    }
};

/***/ }),
/* 156 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiSnackbar_vue__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiSnackbar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiSnackbar_vue__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-snackbar-container',

    props: {
        queueSnackbars: {
            type: Boolean,
            default: false
        },
        duration: {
            type: Number,
            default: 5000
        },
        allowHtml: {
            type: Boolean,
            default: false
        },
        position: {
            type: String,
            default: 'left' // 'left', 'center', 'right'
        },
        transition: {
            type: String,
            default: 'slide' // 'slide' or 'fade'
        }
    },

    data: function data() {
        return {
            queue: [],
            snackbarTimeout: null
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-snackbar-container--position-' + this.position];
        }
    },

    beforeDestroy: function beforeDestroy() {
        this.resetTimeout();
    },


    methods: {
        createSnackbar: function createSnackbar(snackbar) {
            snackbar.show = false;
            snackbar.duration = snackbar.duration || this.duration;

            this.queue.push(snackbar);

            if (this.queue.length === 1) {
                // If there's only one item in the queue,
                // it's the new snackbar, show it immediately
                return this.showNextSnackbar();
            } else if (!this.queueSnackbars) {
                // If we're not queuing snackbars, hide the current one.
                // This will trigger onHide(), which will show the new snackbar
                this.queue[0].show = false;
            }
        },
        showNextSnackbar: function showNextSnackbar() {
            if (this.queue.length === 0) {
                return;
            }

            // Show the first snackbar in the queue.
            // Will trigger onShow(), which will hide the snackbar after its duration
            this.queue[0].show = true;
        },
        onShow: function onShow(snackbar) {
            var _this = this;

            // Abort if the snackbar is not the first in the queue
            // (since v-show triggers @show for all the snackbars, regardless of actual visibility)
            if (this.queue.indexOf(snackbar) !== 0) {
                return;
            }

            // Hide the snackbar after it's duration is complete.
            // Will trigger onHide(), which will remove it from
            // the queue and show the next snackbar
            this.snackbarTimeout = setTimeout(function () {
                _this.queue[0].show = false;
            }, snackbar.duration);

            this.$emit('snackbar-show', snackbar);
            this.callHook('onShow', snackbar);
        },
        onHide: function onHide(snackbar, index) {
            if (this.queueSnackbars || this.queue.length === 1) {
                // Remove the snackbar from the queue
                this.queue.splice(index, 1);
            } else {
                // If snackbars are created too rapidly, a backlog grows even if we're
                // not queuing, due to the leave transition we have to wait for.
                //
                // When this happens, remove the current snackbar and all
                // other snackbars except the last.
                this.queue.splice(index, this.queue.length - 1);
            }

            this.$emit('snackbar-hide', snackbar);
            this.callHook('onHide', snackbar);

            this.resetTimeout();
            this.showNextSnackbar();
        },
        onClick: function onClick(snackbar) {
            snackbar.show = false;
            this.callHook('onClick', snackbar);
        },
        onActionClick: function onActionClick(snackbar) {
            this.callHook('onActionClick', snackbar);
        },
        callHook: function callHook(hook, snackbar) {
            if (typeof snackbar[hook] === 'function') {
                snackbar[hook].call(undefined, snackbar);
            }
        },
        resetTimeout: function resetTimeout() {
            clearTimeout(this.snackbarTimeout);
            this.snackbarTimeout = null;
        }
    },

    components: {
        UiSnackbar: __WEBPACK_IMPORTED_MODULE_0__UiSnackbar_vue___default.a
    }
};

/***/ }),
/* 157 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_util__ = __webpack_require__(46);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-switch',

    props: {
        name: String,
        label: String,
        value: {
            required: true
        },
        trueValue: {
            default: true
        },
        falseValue: {
            default: false
        },
        submittedValue: {
            type: String,
            default: 'on' // HTML default
        },
        checked: {
            type: Boolean,
            default: false
        },
        color: {
            type: String,
            default: 'primary' // 'primary' or 'accent'
        },
        switchPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            isChecked: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__helpers_util__["a" /* looseEqual */])(this.value, this.trueValue) || this.checked,
            initialValue: this.value
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-switch--color-' + this.color, 'ui-switch--switch-position-' + this.switchPosition, { 'is-active': this.isActive }, { 'is-checked': this.isChecked }, { 'is-disabled': this.disabled }];
        }
    },

    watch: {
        value: function value() {
            this.isChecked = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__helpers_util__["a" /* looseEqual */])(this.value, this.trueValue);
        }
    },

    created: function created() {
        this.$emit('input', this.isChecked ? this.trueValue : this.falseValue);
    },


    methods: {
        onClick: function onClick(e) {
            this.isChecked = e.target.checked;
            this.$emit('input', e.target.checked ? this.trueValue : this.falseValue);
        },
        onChange: function onChange(e) {
            this.$emit('change', this.isChecked ? this.trueValue : this.falseValue, e);
        },
        onFocus: function onFocus() {
            this.isActive = true;
            this.$emit('focus');
        },
        onBlur: function onBlur() {
            this.isActive = false;
            this.$emit('blur');
        }
    }
};

/***/ }),
/* 158 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_uuid__ = __webpack_require__(92);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-tab',

    props: {
        id: {
            type: String,
            default: function _default() {
                return __WEBPACK_IMPORTED_MODULE_0__helpers_uuid__["a" /* default */].short('ui-tab-');
            }
        },
        title: String,
        icon: String,
        iconProps: {
            type: Object,
            default: function _default() {
                return {};
            }
        },
        show: {
            type: Boolean,
            default: true
        },
        selected: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false
        };
    },


    watch: {
        show: function show() {
            this.$parent.handleTabShowChange(this);
        },
        disabled: function disabled() {
            this.$parent.handleTabDisableChange(this);
        }
    },

    created: function created() {
        this.$parent.registerTab(this);
    },


    methods: {
        activate: function activate() {
            this.isActive = true;
            this.$emit('select', this.id);
        },
        deactivate: function deactivate() {
            this.isActive = false;
            this.$emit('deselect', this.id);
        }
    }
};

/***/ }),
/* 159 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
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






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-tab-header-item',

    props: {
        id: String,
        type: {
            type: String,
            default: 'text' // 'text', 'icon', or 'icon-and-text'
        },
        title: String,
        icon: String,
        iconProps: {
            type: Object,
            default: function _default() {
                return {};
            }
        },
        active: {
            type: Boolean,
            default: false
        },
        show: {
            type: Boolean,
            default: true
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-tab-header-item--type-' + this.type, { 'is-active': this.active }, { 'is-disabled': this.disabled }];
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_0__UiIcon_vue___default.a,
        UiRippleInk: __WEBPACK_IMPORTED_MODULE_1__UiRippleInk_vue___default.a
    }
};

/***/ }),
/* 160 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_RespondsToWindowResize_js__ = __webpack_require__(67);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiTabHeaderItem_vue__ = __webpack_require__(297);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiTabHeaderItem_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiTabHeaderItem_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(6);
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
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-tabs',

    props: {
        type: {
            type: String,
            default: 'text' // 'icon', text', or 'icon-and-text'
        },
        backgroundColor: {
            type: String,
            default: 'default' // 'default', 'primary', 'accent', or 'clear'
        },
        textColor: {
            type: String,
            default: 'black' // 'black', or 'white'
        },
        textColorActive: {
            type: String,
            default: 'primary' // 'primary', 'accent', or 'white'
        },
        indicatorColor: {
            type: String,
            default: 'primary' // 'primary', 'accent', or 'white'
        },
        fullwidth: {
            type: Boolean,
            default: false
        },
        raised: {
            type: Boolean,
            default: false
        },
        disableRipple: {
            type: Boolean,
            default: __WEBPACK_IMPORTED_MODULE_2__config__["default"].data.disableRipple
        }
    },

    data: function data() {
        return {
            tabs: [],
            activeTabId: null,
            activeTabIndex: -1,
            activeTabElement: null,
            activeTabPosition: {
                left: 0,
                width: 0
            },
            tabContainerWidth: 0
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-tabs--type-' + this.type, 'ui-tabs--text-color-' + this.textColor, 'ui-tabs--text-color-active-' + this.textColorActive, 'ui-tabs--background-color-' + this.backgroundColor, 'ui-tabs--indicator-color-' + this.textColorActive, { 'is-raised': this.raised }, { 'is-fullwidth': this.fullwidth }];
        },
        indicatorLeft: function indicatorLeft() {
            return this.activeTabPosition.left + 'px';
        },
        indicatorRight: function indicatorRight() {
            return this.tabContainerWidth - (this.activeTabPosition.left + this.activeTabPosition.width) + 'px';
        }
    },

    watch: {
        activeTabId: function activeTabId() {
            var _this = this;

            this.tabs.forEach(function (tab, index) {
                if (_this.activeTabId === tab.id) {
                    tab.activate();
                    _this.activeTabIndex = index;
                } else if (tab.isActive) {
                    tab.deactivate();
                }
            });
        },
        activeTabElement: function activeTabElement() {
            this.refreshIndicator();
        }
    },

    mounted: function mounted() {
        var _this2 = this;

        // Set the tab container width and the active tab element
        // (to show the active tab indicator)
        this.$nextTick(function () {
            _this2.tabContainerWidth = _this2.$refs.tabsContainer.offsetWidth;
            _this2.activeTabElement = _this2.$refs.tabsContainer.querySelector('.is-active');
        });

        // Refresh the active tab indication when the window size changes
        this.$on('window-resize', function () {
            _this2.tabContainerWidth = _this2.$refs.tabsContainer.offsetWidth;
            _this2.refreshIndicator();
        });
    },


    methods: {
        // Called externally from UiTab
        registerTab: function registerTab(tab) {
            this.tabs.push(tab);

            // Select the tab if there's no tab selected (i.e. the tab is the only tab)
            // or the tab's selected prop is true
            if (this.activeTabId === null || tab.selected) {
                this.activeTabId = tab.id;
            }
        },


        // Called externally from UiTab
        handleTabShowChange: function handleTabShowChange(tab) {
            // Switch to the nearest available tab if the tab being hidden is currently active
            if (this.activeTabId === tab.id && !tab.show) {
                var newTab = this.findNearestAvailableTab({ preferPrevious: true });

                if (newTab) {
                    this.selectTab(newTab.$el, newTab);
                }
            }

            // Refresh the active tab indicator
            this.refreshIndicator();
        },


        // Called externally from UiTab
        handleTabDisableChange: function handleTabDisableChange(tab) {
            // Switch to the nearest available tab if the tab being disabled is currently active
            if (this.activeTabId === tab.id && tab.disabled) {
                var newTab = this.findNearestAvailableTab({ preferPrevious: true });

                if (newTab) {
                    this.selectTab(newTab.$el, newTab);
                }
            }
        },
        selectTab: function selectTab(e, tab) {
            // e can be Element (if called by selectPrevious or selectNext) or Event
            // (if called by click listener)
            var newTabElement = e.currentTarget ? e.currentTarget : e;

            // Abort if the tab is disabled or already selected
            if (tab.disabled || this.activeTabElement === newTabElement) {
                return;
            }

            this.activeTabElement = newTabElement;
            this.activeTabId = tab.id;

            this.$emit('tab-change', tab.id);
        },
        selectPreviousTab: function selectPreviousTab() {
            // Abort if the current tab is the first tab
            if (this.activeTabIndex === 0) {
                return;
            }

            var previousTab = this.findTabByIndex(this.activeTabIndex, { findPrevious: true });

            if (!previousTab) {
                return;
            }

            this.selectTab(previousTab.$el, previousTab);
            this.activeTabElement.focus();
        },
        selectNextTab: function selectNextTab() {
            // Abort if the current tab is the last tab
            if (this.activeTabIndex === this.$refs.tabElements.length - 1) {
                return;
            }

            var nextTab = this.findTabByIndex(this.activeTabIndex);

            if (!nextTab) {
                return;
            }

            this.selectTab(nextTab.$el, nextTab);
            this.activeTabElement.focus();
        },
        findTabByIndex: function findTabByIndex(currentTabIndex) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : { findPrevious: false };

            var tab = null;

            if (options.findPrevious) {
                for (var i = currentTabIndex - 1; i >= 0; i--) {
                    if (!this.$refs.tabElements[i].disabled && this.$refs.tabElements[i].show) {
                        tab = this.$refs.tabElements[i];
                        break;
                    }
                }
            } else {
                for (var _i = currentTabIndex + 1; _i < this.$refs.tabElements.length; _i++) {
                    if (!this.$refs.tabElements[_i].disabled && this.$refs.tabElements[_i].show) {
                        tab = this.$refs.tabElements[_i];
                        break;
                    }
                }
            }

            return tab;
        },
        findTabById: function findTabById(id) {
            var tab = null;
            var numberOfTabs = this.$refs.tabElements.length;

            for (var i = 0; i <= numberOfTabs; i++) {
                if (id === this.$refs.tabElements[i].id) {
                    tab = this.$refs.tabElements[i];
                    break;
                }
            }

            return tab;
        },
        findNearestAvailableTab: function findNearestAvailableTab() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { preferPrevious: false };

            var tab = this.findTabByIndex(this.activeTabIndex, {
                findPrevious: options.preferPrevious
            });

            if (tab) {
                return tab;
            }

            return this.findTabByIndex(this.activeTabIndex, {
                findPrevious: !options.preferPrevious
            });
        },


        // Used externally to programmatically change the active tab
        setActiveTab: function setActiveTab(tabId) {
            var tab = this.findTabById(tabId);

            if (tab && !tab.disabled) {
                this.selectTab(tab.$el, tab);
            }
        },


        // Used locally and externally to refresh the active tab indicator position
        refreshIndicator: function refreshIndicator() {
            this.activeTabPosition = {
                left: this.activeTabElement ? this.activeTabElement.offsetLeft : 0,
                width: this.activeTabElement ? this.activeTabElement.offsetWidth : 0
            };
        }
    },

    components: {
        UiTabHeaderItem: __WEBPACK_IMPORTED_MODULE_1__UiTabHeaderItem_vue___default.a,
        RenderVnodes: {
            name: 'render-vnodes',
            functional: true,
            props: ['nodes'],
            render: function render(createElement, context) {
                return createElement('div', context.props.nodes);
            }
        }
    },

    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_RespondsToWindowResize_js__["a" /* default */]]
};

/***/ }),
/* 161 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__directives_autofocus__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_autosize__ = __webpack_require__(389);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_autosize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_autosize__);
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






/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-textbox',

    props: {
        name: String,
        placeholder: String,
        value: {
            type: [String, Number],
            required: true
        },
        icon: String,
        iconPosition: {
            type: String,
            default: 'left' // 'left' or 'right'
        },
        label: String,
        floatingLabel: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: 'text' // all the possible HTML5 input types, except those that have a special UI
        },
        multiLine: {
            type: Boolean,
            default: false
        },
        rows: {
            type: Number,
            default: 2
        },
        autocomplete: String,
        autofocus: {
            type: Boolean,
            default: false
        },
        autosize: {
            type: Boolean,
            default: true
        },
        min: Number,
        max: Number,
        step: {
            type: String,
            default: 'any'
        },
        maxlength: Number,
        enforceMaxlength: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        readonly: {
            type: Boolean,
            default: false
        },
        help: String,
        error: String,
        invalid: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },

    data: function data() {
        return {
            isActive: false,
            isTouched: false,
            initialValue: this.value,
            autosizeInitialized: false
        };
    },


    computed: {
        classes: function classes() {
            return ['ui-textbox--icon-position-' + this.iconPosition, { 'is-active': this.isActive }, { 'is-invalid': this.invalid }, { 'is-touched': this.isTouched }, { 'is-multi-line': this.multiLine }, { 'has-counter': this.maxlength }, { 'is-disabled': this.disabled }, { 'has-label': this.hasLabel }, { 'has-floating-label': this.hasFloatingLabel }];
        },
        labelClasses: function labelClasses() {
            return {
                'is-inline': this.hasFloatingLabel && this.isLabelInline,
                'is-floating': this.hasFloatingLabel && !this.isLabelInline
            };
        },
        hasLabel: function hasLabel() {
            return Boolean(this.label) || Boolean(this.$slots.default);
        },
        hasFloatingLabel: function hasFloatingLabel() {
            return this.hasLabel && this.floatingLabel;
        },
        isLabelInline: function isLabelInline() {
            return this.value.length === 0 && !this.isActive;
        },
        minValue: function minValue() {
            if (this.type === 'number' && this.min !== undefined) {
                return this.min;
            }

            return null;
        },
        maxValue: function maxValue() {
            if (this.type === 'number' && this.max !== undefined) {
                return this.max;
            }

            return null;
        },
        stepValue: function stepValue() {
            return this.type === 'number' ? this.step : null;
        },
        hasFeedback: function hasFeedback() {
            return Boolean(this.help) || Boolean(this.error);
        },
        showError: function showError() {
            return this.invalid && Boolean(this.error);
        },
        showHelp: function showHelp() {
            return !this.showError && Boolean(this.help);
        }
    },

    mounted: function mounted() {
        if (this.multiLine && this.autosize) {
            __WEBPACK_IMPORTED_MODULE_2_autosize___default()(this.$refs.textarea);
            this.autosizeInitialized = true;
        }
    },
    beforeDestroy: function beforeDestroy() {
        if (this.autosizeInitialized) {
            __WEBPACK_IMPORTED_MODULE_2_autosize___default.a.destroy(this.$refs.textarea);
        }
    },


    methods: {
        updateValue: function updateValue(value) {
            this.$emit('input', value);
        },
        onChange: function onChange(e) {
            this.$emit('change', this.value, e);
        },
        onFocus: function onFocus(e) {
            this.isActive = true;
            this.$emit('focus', e);
        },
        onBlur: function onBlur(e) {
            this.isActive = false;
            this.$emit('blur', e);

            if (!this.isTouched) {
                this.isTouched = true;
                this.$emit('touch');
            }
        },
        onKeydown: function onKeydown(e) {
            this.$emit('keydown', e);
        },
        onKeydownEnter: function onKeydownEnter(e) {
            this.$emit('keydown-enter', e);
        },
        reset: function reset() {
            // Blur the input if it's focused to prevent required errors
            // when it's value is reset
            if (document.activeElement === this.$refs.input || document.activeElement === this.$refs.textarea) {
                document.activeElement.blur();
            }

            this.updateValue(this.initialValue);
            this.resetTouched();
        },
        resetTouched: function resetTouched() {
            var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { touched: false };

            this.isTouched = options.touched;
        },
        refreshSize: function refreshSize() {
            if (this.autosizeInitialized) {
                __WEBPACK_IMPORTED_MODULE_2_autosize___default.a.update(this.$refs.textarea);
            }
        }
    },

    components: {
        UiIcon: __WEBPACK_IMPORTED_MODULE_1__UiIcon_vue___default.a
    },

    directives: {
        autofocus: __WEBPACK_IMPORTED_MODULE_0__directives_autofocus__["a" /* default */]
    }
};

/***/ }),
/* 162 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIconButton_vue__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UiIconButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UiIconButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiProgressLinear_vue__ = __webpack_require__(96);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiProgressLinear_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiProgressLinear_vue__);
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
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-toolbar',

    props: {
        type: {
            type: String,
            default: 'default' // 'default', 'colored' or 'clear' - colored is brand primary color
        },
        textColor: {
            type: String,
            default: 'black' // 'black' or 'white'
        },
        title: String,
        brand: String,
        removeBrandDivider: {
            type: Boolean,
            default: false
        },
        navIcon: {
            type: String,
            default: 'menu'
        },
        removeNavIcon: {
            type: Boolean,
            default: false
        },
        raised: {
            type: Boolean,
            default: true
        },
        progressPosition: {
            type: String,
            default: 'bottom' // 'top' or 'bottom'
        },
        loading: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return ['ui-toolbar--type-' + this.type, 'ui-toolbar--text-color-' + this.textColor, 'ui-toolbar--progress-position-' + this.progressPosition, { 'is-raised': this.raised }];
        },
        progressColor: function progressColor() {
            return this.textColor === 'black' ? 'primary' : 'white';
        },
        hasBrandDivider: function hasBrandDivider() {
            return this.removeBrandDivider ? false : this.brand || this.$slots.brand;
        }
    },

    methods: {
        navIconClick: function navIconClick() {
            this.$emit('nav-icon-click');
        }
    },

    components: {
        UiIconButton: __WEBPACK_IMPORTED_MODULE_0__UiIconButton_vue___default.a,
        UiProgressLinear: __WEBPACK_IMPORTED_MODULE_1__UiProgressLinear_vue___default.a
    }
};

/***/ }),
/* 163 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tether_tooltip__ = __webpack_require__(434);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tether_tooltip___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_tether_tooltip__);
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'ui-tooltip',

    props: {
        trigger: {
            type: String,
            required: true
        },
        position: {
            type: String,
            default: 'bottom center'
        },
        openOn: {
            type: String,
            default: 'hover focus'
        },
        openDelay: {
            type: Number,
            default: 0
        }
    },

    data: function data() {
        return {
            tooltip: null
        };
    },


    watch: {
        trigger: function trigger() {
            if (this.tooltip === null) {
                this.initialize();
            }
        }
    },

    mounted: function mounted() {
        if (this.tooltip === null) {
            this.initialize();
        }
    },
    beforeDestroy: function beforeDestroy() {
        if (this.tooltip !== null) {
            this.tooltip.destroy();
        }
    },


    methods: {
        initialize: function initialize() {
            if (this.trigger !== undefined) {
                this.tooltip = new __WEBPACK_IMPORTED_MODULE_0_tether_tooltip___default.a({
                    target: this.$parent.$refs[this.trigger],
                    content: this.$refs.tooltip,
                    classes: 'ui-tooltip--theme-default',
                    position: this.position,
                    openOn: this.openOn,
                    openDelay: this.openDelay
                });
            }
        }
    }
};

/***/ }),
/* 164 */
/***/ (function(module, exports, __webpack_require__) {

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
    props: {
        tiny: {
            type: Boolean,
            default: false
        },

        small: {
            type: Boolean,
            default: false
        },

        medium: {
            type: Boolean,
            default: false
        },

        large: {
            type: Boolean,
            default: false
        },

        prefix: {
            type: Boolean,
            default: false
        },

        right: {
            type: Boolean,
            default: false
        },

        left: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return {
                'tiny': this.tiny,
                'small': this.small,
                'medium': this.medium,
                'large': this.large,
                'prefix': this.prefix,
                'right': this.right,
                'left': this.left
            };
        }
    }
};

/***/ }),
/* 165 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
  name: 'nprogress-container'
};

/***/ }),
/* 166 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash_debounce__ = __webpack_require__(114);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash_debounce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lodash_debounce__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_javascript_detect_element_resize__ = __webpack_require__(429);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_javascript_detect_element_resize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_javascript_detect_element_resize__);
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {
    beforeDestroy: function beforeDestroy() {
        removeResizeListener(this.$el.parentElement, this.parentResizing);
        window.removeEventListener('resize', this.windowResizing);
        window.removeEventListener('scroll', this.scrolling);
    },
    data: function data() {
        return {
            affixed: false,
            affixedStyles: { position: 'relative' },
            affixedToBottom: false,
            elementSizes: {},
            parentSizes: {},
            windowSizes: {}
        };
    },


    methods: {
        affixElement: function affixElement() {
            var element = this.$el;
            this.affixedStyles = {
                bottom: this.elementSizes.bottom,
                height: element.offsetHeight,
                left: this.getOffset(element).left,
                top: 0,
                width: element.offsetWidth,
                position: 'fixed'
            };
        },
        affixElementToBottom: function affixElementToBottom() {
            this.affixedStyles = {
                bottom: 0,
                height: this.elementSizes.height,
                left: this.elementSizes.left,
                position: 'absolute',
                width: this.elementSizes.width
            };
        },
        elementResizing: function elementResizing() {
            var element = this.$el;
            this.elementSizes = {
                outerHeight: element.offsetHeight,
                offsetTop: this.getOffset(element).top
            };
            this.elementSizes.offsetBottom = this.elementSizes.outerHeight + this.elementSizes.offsetTop;
        },
        elementShouldBeAtBottom: function elementShouldBeAtBottom(windowScrollTop) {
            var elementBottom = windowScrollTop + this.elementSizes.outerHeight;
            return elementBottom >= this.parentSizes.offsetBottom;
        },
        elementShouldBeAtTop: function elementShouldBeAtTop(windowScrollTop) {
            return windowScrollTop <= this.elementSizes.offsetTop;
        },
        elementShouldBeFixed: function elementShouldBeFixed(windowScrollTop) {
            return windowScrollTop > this.elementSizes.offsetTop;
        },
        getOffset: function getOffset(element) {
            var rect = element.getBoundingClientRect();
            var body = document.body;
            var clientTop = element.clientTop || body.clientTop || 0;
            var clientLeft = element.clientLeft || body.clientLeft || 0;
            var scrollTop = this.getScroll(window, true);
            var scrollLeft = this.getScroll(window);

            return {
                top: rect.top + scrollTop - clientTop,
                left: rect.left + scrollLeft - clientLeft
            };
        },
        getScroll: function getScroll(w, top) {
            var ret = w['page' + (top ? 'Y' : 'X') + 'Offset'];
            var method = 'scroll' + (top ? 'Top' : 'Left');

            if (typeof ret !== 'number') {
                var d = w.document;
                // ie6,7,8 standard mode
                ret = d.documentElement[method];

                if (typeof ret !== 'number') {
                    // quirks mode
                    ret = d.body[method];
                }
            }
            return ret;
        },
        parentResizing: function parentResizing() {
            var parent = this.$el.parentElement;

            this.parentSizes = {
                outerHeight: parent.offsetHeight,
                offsetTop: this.getOffset(parent).top
            };
            this.parentSizes.offsetBottom = this.parentSizes.outerHeight + this.parentSizes.offsetTop;
        },
        scrolling: function scrolling() {
            var element = this.$el;
            var parent = element.parentElement;
            var windowScrollTop = this.getScroll(window, true);

            if (window.innerHeight <= this.elementSizes.outerHeight || this.parentSizes.outerHeight <= this.elementSizes.outerHeight || this.affixed && this.elementShouldBeAtTop(windowScrollTop)) {
                this.affixed = false;
                this.affixedToBottom = false;
                this.unaffixElement();
            } else if (this.elementShouldBeAtBottom(windowScrollTop)) {
                this.affixed = false;
                this.affixedToBottom = true;
                this.affixElementToBottom();
            } else if (!this.affixed && this.elementShouldBeFixed(windowScrollTop)) {
                this.affixed = true;
                this.affixedToBottom = false;
                this.affixElement();
            }
        },
        unaffixElement: function unaffixElement() {
            this.affixedStyles = { position: 'relative' };
        },
        windowResizing: function windowResizing() {
            this.elementResizing();
            this.parentResizing();
        }
    },

    props: {
        disabled: {
            default: false,
            type: Boolean
        }
    },

    mounted: function mounted() {
        // Set original position for the parent element to relative
        this.$el.parentElement.style.position = 'relative';

        // Save the sizes and positions of the affixed element and parent element
        this.elementResizing();
        this.parentResizing();

        // Add event listeners for scrolling and window/element resizing
        addResizeListener(this.$el.parentElement, this.parentResizing);
        window.addEventListener('resize', __WEBPACK_IMPORTED_MODULE_0_lodash_debounce___default()(this.windowResizing, 200));
        window.addEventListener('scroll', this.scrolling);
    },


    watch: {
        'disabled': function disabled(value) {
            if (value) {
                removeResizeListener(this.$el.parentElement, this.parentResizing);
                window.removeEventListener('resize', this.windowResizing);
                window.removeEventListener('scroll', this.scrolling);
                this.affixed = false;
                this.affixedToBottom = false;
                this.unaffixElement();
            } else {
                addResizeListener(this.$el.parentElement, this.parentResizing);
                window.addEventListener('resize', __WEBPACK_IMPORTED_MODULE_0_lodash_debounce___default()(this.windowResizing, 200));
                window.addEventListener('scroll', this.scrolling);
            }
        },

        'parentSizes.outerHeight': 'scrolling'
    }
};

/***/ }),
/* 167 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-centered',
    props: {
        fullScreen: Boolean
    }

};

/***/ }),
/* 168 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__ = __webpack_require__(54);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default.a],

    props: {
        src: String
    },

    computed: {
        classes: function classes() {
            return this.collectionsMixin;
        }
    }
};

/***/ }),
/* 169 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__ = __webpack_require__(54);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default.a],

    computed: {
        classes: function classes() {
            return this.collectionsMixin;
        }
    }
};

/***/ }),
/* 170 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__ = __webpack_require__(54);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_collection_item___default.a],

    computed: {
        classes: function classes() {
            return this.collectionsMixin;
        }
    }
};

/***/ }),
/* 171 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    props: {
        withHeader: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        classes: function classes() {
            return {
                'with-header': this.withHeader
            };
        }
    }
};

/***/ }),
/* 172 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_codex_core_utils__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_codex_core_utils___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_codex_core_utils__);
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



// const EVENT_LIST = ['click', 'contextmenu', 'keydown']

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'context-menu',
    props: {
        id: {
            type: String,
            default: 'default-ctx'
        },
        align: { type: String, default: 'left' }
    },
    data: function data() {
        var _this = this;

        return {
            locals: {},
            ctxTop: 0,
            ctxLeft: 0,
            ctxVisible: false,

            bodyClickListener: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_codex_core_utils__["createBodyClickListener"])(function (e) {
                var isOpen = !!_this.ctxVisible;
                var outsideClick = isOpen && !_this.$el.contains(e.target);

                if (outsideClick) {
                    if (e.which !== 1) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    } else {
                        _this.close();
                        e.stopPropagation();
                    }
                } else {
                    //                            this.ctxVisible = false
                    //                            this.$emit('ctx-close', this.locals)
                }
            })
        };
    },

    methods: {
        setPositionFromEvent: function setPositionFromEvent(e) {
            var pageX = e.pageX,
                pageY = e.pageY;

            this.ctxTop = pageY - document.body.scrollTop;
            this.ctxLeft = pageX;
        },
        open: function open(e, data) {
            if (this.ctxVisible) this.ctxVisible = false;
            this.ctxVisible = true;
            this.$emit('context-menu-open', this.locals = data || {});
            this.setPositionFromEvent(e);
            this.$el.setAttribute('tab-index', -1);
            this.bodyClickListener.start();
            return this;
        },
        close: function close() {

            this.ctxVisible = false;
            this.$emit('context-menu-cancel', this.locals);
        }
    },
    watch: {
        ctxVisible: function ctxVisible(newVal, oldVal) {
            if (oldVal === true && newVal === false) {
                this.bodyClickListener.stop(function (e) {
                    //
                    // this.locals = {}
                });
            }
        }
    },
    computed: {
        ctxStyle: function ctxStyle() {
            return {
                'display': this.ctxVisible ? 'block' : 'none',
                'top': (this.ctxTop || 0) + 'px',
                'left': (this.ctxLeft || 0) + 'px'
            };
        }
    }
};

/***/ }),
/* 173 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__webpack_require__(117), __webpack_require__(115)],
    props: {
        id: {
            type: String
        },
        style: {
            "default": function _default() {}
        },
        "class": {
            "default": function _default() {}
        },
        factor: {
            type: Number,
            "default": 2
        },
        maxLeft: {
            type: Number,
            "default": 0
        },
        maxRight: {
            type: Number,
            "default": 0
        },
        offset: {
            type: Number,
            "default": 0
        },
        zIndex: {
            type: Number,
            "default": 1002
        },
        disabled: {
            type: Boolean,
            "default": false
        }
    },
    computed: {
        mergeStyle: function mergeStyle() {
            return {
                height: "100%",
                position: "absolute",
                top: "0",
                zIndex: this.zIndex
            };
        }
    },
    data: function data() {
        return {
            atMax: false,
            pos: null
        };
    },
    methods: {
        click: function click(e) {
            if (!(this.pos != null && this.pos.x === e.x && this.pos.y === e.y)) {
                return this.$emit("clean-click", e);
            }
        },
        onPan: function onPan(e) {
            var dX;
            if (e.type === "pan") {
                e.srcEvent.preventDefault();
                dX = e.deltaX * this.factor;
                this.pos = null;
                if (e.isFinal) {
                    this.pos = {
                        x: e.srcEvent.x,
                        y: e.srcEvent.y
                    };
                    if (this.maxRight > 0 && dX >= this.maxRight) {
                        this.$emit("right");
                        return this.$emit("max", "right");
                    } else if (this.maxLeft > 0 && dX <= -this.maxLeft) {
                        this.$emit("left");
                        return this.$emit("max", "left");
                    } else {
                        return this.$emit("aborted");
                    }
                } else if (this.maxRight > 0 && dX >= 0) {
                    if (dX <= this.maxRight) {
                        this.$emit("move", dX + this.offset);
                        return this.atMax = false;
                    } else if (!this.atMax) {
                        this.$emit("move", this.maxRight + this.offset);
                        return this.atMax = true;
                    }
                } else if (this.maxLeft > 0 && dX <= 0) {
                    if (dX >= -this.maxLeft) {
                        this.$emit("move", dX + this.offset);
                        return this.atMax = false;
                    } else if (!this.atMax) {
                        this.$emit("move", -this.maxLeft + this.offset);
                        return this.atMax = true;
                    }
                }
            }
        }
    }

};

/***/ }),
/* 174 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_jquery__);
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = {
    name: 'drag-handle',
    props: ['disabled'],
    mounted: function mounted() {
        this.dragHandleBuild();
    },

    computed: {
        horizontal: function horizontal() {
            return Object.is(this.$parent.options.direction, 'horizontal');
        }
    },
    methods: {
        dragHandleBuild: function dragHandleBuild() {

            var self = this;

            // 模式
            var horizontal = self.horizontal;

            // 父容器宽高信息
            var $wrap = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(this.$parent.$el);

            // 父容器宽度
            var warpClientAttr = $wrap[0][horizontal ? 'clientWidth' : 'clientHeight'];

            // 载体本身
            var $currentHandle = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(this.$el);

            // 载体宽高
            var currentHandleAttr = $currentHandle[0][horizontal ? 'clientWidth' : 'clientHeight'];

            // 计算元素组的指定属性之和
            var elementsAttrs = function elementsAttrs() {
                var elements = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
                var attr = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'minWidth';
                var notReduce = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

                if (!elements.length) return 0;
                var elementsArr = Array.from(elements).map(function (element) {
                    var elementAttr = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(element).css(attr);
                    if (!elementAttr || elementAttr === 'auto') {
                        elementAttr = 0;
                    } else {
                        elementAttr = parseInt(elementAttr);
                    }
                    return elementAttr;
                });
                return notReduce ? elementsArr : elementsArr.reduce(function (preValue, curValue) {
                    return preValue + curValue;
                });
            };

            // 给当前label绑定事件
            $currentHandle.bind('mousedown', function (e) {

                // 判断是否禁用
                if (self.disabled) return false;

                // 父容器绝对位置
                var wrapOffsetAttr = $wrap.offset()[horizontal ? 'left' : 'top'];

                // 要设置的属性
                var buildStyle = horizontal ? 'width' : 'height';

                // 前后的所有兄弟元素
                var $prevAll = $currentHandle.prevAll();
                var $nextAll = $currentHandle.nextAll();
                // 到前后所有的Handle
                var $prevHandles = $prevAll.filter('.drag-handle');
                var $nextHandles = $nextAll.filter('.drag-handle');
                // 到前后紧邻的Handle
                var $prevHandle = $prevHandles[0] ? __WEBPACK_IMPORTED_MODULE_0_jquery___default()($prevHandles[0]) : null;
                var $nextHandle = $nextHandles[0] ? __WEBPACK_IMPORTED_MODULE_0_jquery___default()($nextHandles[0]) : null;
                // 获取到前后紧邻的Handle的距前/上距离
                var prevHandleOffsetAttr = $prevHandle ? __WEBPACK_IMPORTED_MODULE_0_jquery___default()($prevHandle).offset()[horizontal ? 'left' : 'top'] : null;
                var nextHandleOffsetAttr = $nextHandle ? __WEBPACK_IMPORTED_MODULE_0_jquery___default()($nextHandle).offset()[horizontal ? 'left' : 'top'] : null;

                // 前面需要设置样式的元素集合
                var prevElementsToDo = $prevHandle ? $currentHandle.prevUntil('.drag-handle') : $prevAll;

                // 后面需要设置样式的元素集合
                var nextElementsToDo = $nextHandle ? $currentHandle.nextUntil('.drag-handle') : $nextAll;

                // 前面的元素的最小宽度/高度之和
                var prevElementsMinAttrs = elementsAttrs(prevElementsToDo, horizontal ? 'minWidth' : 'minHeight');
                var prevElementsMaxAttrs = elementsAttrs(prevElementsToDo, horizontal ? 'maxWidth' : 'maxHeight');

                // 后面的元素的最小宽度/高度之和
                var nextElementsMinAttrs = elementsAttrs(nextElementsToDo, horizontal ? 'minWidth' : 'minHeight');
                var nextElementsMaxAttrs = elementsAttrs(nextElementsToDo, horizontal ? 'maxWidth' : 'maxHeight');

                // 监听移动
                __WEBPACK_IMPORTED_MODULE_0_jquery___default()(document).bind('mousemove', function (event) {

                    if (self.disabled) return false;

                    // 鼠标定位
                    var mousePosition = event[horizontal ? 'pageX' : 'pageY'];

                    // 可移动的最小范围
                    // 如果后面元素有max限制，则minScope应该是
                    //    如果后面没有handle了，则是 父元素宽度 + 父元素左边距离 - 右边元素的最大宽度之和
                    //    如果后面还有handle，则应该是 父元素宽度 + 父元素左边距离 - 右边所有元素的宽度之和
                    // 如果前边有label，则应该是label的前边距加前边label的宽度
                    // 如果前边没有label，则应该是父容器的距前距离
                    // 无论什么情况，如果前边元素有min属性，则应该要加上min属性值的总和
                    var minScope = void 0;

                    if (nextElementsMaxAttrs) minScope = warpClientAttr + wrapOffsetAttr - nextElementsMaxAttrs;else if ($prevHandle) minScope = prevHandleOffsetAttr + $prevHandle[0][horizontal ? 'clientWidth' : 'clientHeight'];
                    if (!$prevHandle) minScope = wrapOffsetAttr;
                    minScope += prevElementsMinAttrs;

                    // 可移动的最大范围

                    // 如果前边有max，则计算出前边max的总和， + label的前边距加前边label的宽度 = max
                    // 如果前边没有max
                    //  - 如果后边有label，则应该是后边label的距前距离
                    //  - 否则是父容器宽度 + 父容器距前边距
                    //  - 无论上面任意情况，如果后边元素有min属性，则应该要减去这个属性值的总和
                    var maxScope = void 0;
                    if (!!prevElementsMaxAttrs) {
                        if ($prevHandle) maxScope = prevHandleOffsetAttr + $prevHandle[0][horizontal ? 'clientWidth' : 'clientHeight'];
                        if (!$prevHandle) maxScope = wrapOffsetAttr;
                        maxScope += prevElementsMaxAttrs;
                    } else {
                        if (nextHandleOffsetAttr) maxScope = nextHandleOffsetAttr;
                        if (!nextHandleOffsetAttr) maxScope = warpClientAttr + wrapOffsetAttr;
                        maxScope -= currentHandleAttr + nextElementsMinAttrs;
                    }

                    // 限制最大最小范围
                    if (mousePosition < minScope) mousePosition = minScope;
                    if (mousePosition > maxScope) mousePosition = maxScope;

                    // 设置前面元素的属性
                    if (prevElementsToDo.length) {

                        var toDoAttr = void 0;

                        if (prevHandleOffsetAttr) toDoAttr = mousePosition - prevHandleOffsetAttr - currentHandleAttr;else toDoAttr = mousePosition - wrapOffsetAttr;

                        // 如果待分配的属性还大于最小属性之和，则分配
                        if (toDoAttr > prevElementsMinAttrs) {

                            // 平均值
                            var average = toDoAttr / prevElementsToDo.length;

                            // 最大minwidth
                            var prevElementsMinMaxAttr = Math.max.apply(null, elementsAttrs(prevElementsToDo, horizontal ? 'minWidth' : 'minHeight', true));

                            //

                            // 如果平均分配的值，大于其中任何一个拥有max-attr的元素，
                            // 则给这个元素设置width为自己的maxattr，然后把剩下的给剩下的元素在均分

                            // 如果平均分配的值大于最大的minwidth，则平均分配
                            if (average >= prevElementsMinMaxAttr) {
                                prevElementsToDo.css(buildStyle, toDoAttr / prevElementsToDo.length);
                            } else {
                                // 否则，开始特殊分配
                                // 给有minwidth的全部width设置为自己的minwidth
                                var notHasMinAttrElements = [];
                                Array.from(prevElementsToDo).forEach(function (element) {
                                    var minAttr = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(element).css(horizontal ? 'minWidth' : 'minHeight');
                                    if (minAttr !== 'auto') {
                                        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(element).css(horizontal ? 'width' : 'height', minAttr);
                                    } else {
                                        notHasMinAttrElements.push(element);
                                    }
                                });
                                // 给没有minwidth的设置(toDoAttr - minwidth之和) / 自己数量
                                __WEBPACK_IMPORTED_MODULE_0_jquery___default()(notHasMinAttrElements).css(buildStyle, (toDoAttr - prevElementsMinMaxAttr) / notHasMinAttrElements.length);
                                //
                            }
                        }
                    }

                    // 设置后面元素的宽度
                    if (nextElementsToDo.length) {

                        var _toDoAttr = void 0;

                        if (nextHandleOffsetAttr) _toDoAttr = nextHandleOffsetAttr - mousePosition;else _toDoAttr = warpClientAttr - (mousePosition - wrapOffsetAttr);

                        _toDoAttr -= currentHandleAttr;

                        // 如果toDoAttr还大于minwidth之和，则分配
                        if (_toDoAttr > nextElementsMinAttrs) {

                            // 平均值
                            var _average = _toDoAttr / nextElementsToDo.length;

                            // 最大minwidth
                            var nextElementsMinMaxAttr = Math.max.apply(null, elementsAttrs(nextElementsToDo, horizontal ? 'minWidth' : 'minHeight', true));

                            //

                            // 如果平均分配的值大于最大的minwidth，则平均分配
                            if (_average >= nextElementsMinMaxAttr) {
                                nextElementsToDo.css(buildStyle, _toDoAttr / nextElementsToDo.length);
                            } else {
                                // 否则，开始特殊分配
                                // 给有minwidth的全部width设置为自己的minwidth
                                var _notHasMinAttrElements = [];
                                Array.from(nextElementsToDo).forEach(function (element) {
                                    var minAttr = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(element).css(horizontal ? 'minWidth' : 'minHeight');
                                    if (minAttr !== 'auto') {
                                        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(element).css(horizontal ? 'width' : 'height', minAttr);
                                    } else {
                                        _notHasMinAttrElements.push(element);
                                    }
                                });
                                // 给没有minwidth的设置(toDoAttr - minwidth之和) / 自己数量
                                __WEBPACK_IMPORTED_MODULE_0_jquery___default()(_notHasMinAttrElements).css(buildStyle, (_toDoAttr - nextElementsMinMaxAttr) / _notHasMinAttrElements.length);
                                //
                            }
                        }
                    }
                });
            });

            // 移除监听事件
            __WEBPACK_IMPORTED_MODULE_0_jquery___default()(document).bind('mouseup', function (event) {
                __WEBPACK_IMPORTED_MODULE_0_jquery___default()(document).unbind('mousemove');
                self.$emit('change');
                event.cancelBubble = true;
            });
        }
    }
};

/***/ }),
/* 175 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'drag-zone',
    props: {
        options: {
            type: Object,
            default: function _default() {
                return {
                    direction: 'horizontal'
                };
            }
        }
    }
};

/***/ }),
/* 176 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-footer',
    props: {
        hideCopyright: Boolean,
        textLeft: { type: String, default: 'Copyright 2017 - Codex Project' },
        textRight: { type: String, default: 'Brought to you by Codex - a Open Source documentation platform' }
    }
};

/***/ }),
/* 177 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__radic_util__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__radic_util___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__radic_util__);
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


//    import VBtn from 'bootstrap-vue/components/menu-item.vue'
/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-header-menu-item',
    props: {
        label: { type: [Boolean, String], default: false },
        icon: { type: [Boolean, String], default: false },
        title: { type: [Boolean, String], default: false }
    },
    data: function data() {
        return {
            id: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__radic_util__["getRandomId"])(5)
        };
    },

    watch: {
        $route: function $route() {
            $('#' + this.id).sideNav('hide');
        }
    }
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(14)))

/***/ }),
/* 178 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins__ = __webpack_require__(28);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vuex__);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-header',
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins__["layout"]],
    props: {
        logoHref: { type: String, default: '/' },
        logoText: { type: String, default: 'Codex' },
        logoClass: { type: String, default: 'logo-text' },
        showLogo: { type: Boolean, default: true },
        showToggle: { type: Boolean, default: false },
        isDropdown: Boolean
    },

    data: function data() {
        return { md: false }; //, logoLink: '', logoText: '', showLogo: true, showToggle: false}
    },
    mounted: function mounted() {
        var _this = this;

        this.handleResize();
        this.$on('resize', this.handleResize);
        this.$$ready(function () {
            _this.handleResize();
            if (_this.$refs['sidenav-header-menu']) {
                document.body.appendChild(_this.$refs['sidenav-header-menu'].$el);
            }
        });
    },
    beforeDestroy: function beforeDestroy() {
        this.$off('resize', this.handleResize);
    },

    methods: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_vuex__["mapActions"])(['toggleSidebar']), {
        handleResize: function handleResize() {
            this.md = this.isBreakpointUp('md');
        },
        toggleHeaderMenu: function toggleHeaderMenu() {

            this.$refs['sidenav-header-menu'].toggle();
        },
        handleLogoClick: function handleLogoClick() {
            window.document.location.replace(this.logoHref);
        },
        dropdownOpen: function dropdownOpen() {
            var popover = this.$refs.dropdown.parentNode;
            var dropContent = popover.parentNode;
            var dropEl = dropContent.parentNode;

            if (!popover.classList.contains('ui-popover-header-dropdown')) {
                popover.classList.add('ui-popover-header-dropdown');
            }
            console.log('dropdownOpen', { self: this, popover: popover, dropContent: dropContent, dropEl: dropEl });
            var display = dropEl.style.display;
            dropEl.style.display = 'none';
            this.$nextTick(function () {
                dropEl.style.display = display;
                dropEl.style.position = 'fixed';
            });
        }
    })
};

/***/ }),
/* 179 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = {

    name: 'BeatLoader',

    props: {
        loading: {
            type: Boolean,
            default: true
        },
        color: {
            type: String,
            default: '#5dc596'
        },
        size: {
            type: String,
            default: '15px'
        },
        margin: {
            type: String,
            default: '2px'
        },
        radius: {
            type: String,
            default: '100%'
        }
    },
    data: function data() {
        return {
            spinnerStyle: {
                backgroundColor: this.color,
                height: this.size,
                width: this.size,
                margin: this.margin,
                borderRadius: this.radius
            }
        };
    }
};

/***/ }),
/* 180 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_popover__ = __webpack_require__(82);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_popover___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins_popover__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-popover',
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_popover___default.a],
    props: {
        trigger: { type: String, default: 'click' },
        popoverClass: { type: String, default: '' }
    }
};

/***/ }),
/* 181 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-scroll-to-top',
    props: {
        duration: { type: Number, default: 500 }
    },
    mounted: function mounted() {
        this.$helpers.listen(window, 'scroll', this.scrolling);
    },
    beforeDestroy: function beforeDestroy() {},

    computed: {},
    watch: {},
    methods: {
        scrolling: function scrolling() {
            if (this.$helpers.getScroll(window, true) > 100) return $(this.$el).fadeIn();
            $(this.$el).fadeOut();
        },
        scrollToTop: function scrollToTop() {
            this.$scroll(window.document.body, this.duration);
        }
    }
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(14)))

/***/ }),
/* 182 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transitions__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transitions___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__transitions__);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

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


/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-side-nav-item',
    props: {
        hasChildren: { type: Boolean, default: false },
        header: Boolean,
        title: String,
        href: String,
        icon: String
    },
    data: function data() {
        return {
            open: false,
            active: false
        };
    },
    mounted: function mounted() {},

    computed: {
        iconClass: function iconClass() {
            if (this.header) return false;
            if (this.icon) return 'fa-' + this.icon;
            return this.hasChildren ? 'fa-folder' : 'fa-book';
        }
    },
    methods: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__transitions__["cSlide"])(150), {
        openSubMenu: function openSubMenu() {
            this.open = true;
        },
        closeSubMenu: function closeSubMenu() {
            this.open = false;
        },
        toggleSubMenu: function toggleSubMenu() {
            if (this.open) this.closeSubMenu();else this.openSubMenu();
        }
    })
};

/***/ }),
/* 183 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vendor_overlay__ = __webpack_require__(190);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vendor_overlay___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__vendor_overlay__);
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

// https://github.com/vue-comps/vue-side-nav



/* harmony default export */ __webpack_exports__["default"] = {

    components: {
        "drag-handle": __webpack_require__(310)
    },

    created: function created() {
        return this.overlay = __WEBPACK_IMPORTED_MODULE_0__vendor_overlay___default()(this.Vue);
    },


    mixins: [__webpack_require__(439), __webpack_require__(438), __webpack_require__(116), __webpack_require__(436), __webpack_require__(115), __webpack_require__(117)],

    props: {
        id: String,
        class: {
            default: function _default() {
                return ["side-nav"];
            }
        },
        style: {
            default: function _default() {
                return [];
            }
        },
        width: { type: Number, coerce: Number, default: 240 },
        opacity: { type: Number, default: 0.5, coerce: Number },
        right: { type: Boolean, default: false },
        notDismissable: { type: Boolean, default: false },
        closeOnClick: { type: Boolean, default: false },
        fixed: { type: Boolean, default: false },
        fixedScreenSize: { type: Number, coerce: Number, default: 992 },
        transition: {
            type: Function,
            default: function _default(_ref) {
                var el = _ref.el,
                    style = _ref.style,
                    cb = _ref.cb;

                this.position = style[this.side].replace("px", "");
                return cb();
            }
        },
        zIndex: { type: Number, default: 1000, coerce: Number }
    },

    computed: {
        side: function side() {
            if (this.right) {
                return "right";
            } else {
                return "left";
            }
        },
        otherSide: function otherSide() {
            if (this.right) {
                return "left";
            } else {
                return "right";
            }
        },
        mergeClass: function mergeClass() {
            return { fixed: this.fixed };
        },
        mergeStyle: function mergeStyle() {
            var style = {
                position: "fixed",
                width: this.width + "px",
                top: "0",
                margin: "0",
                height: "100%",
                zIndex: this.overlayZIndex + 1,
                boxSizing: "border-box",
                transform: "translateX(0)"
            };
            style[this.otherSide] = 'initial';

            style[this.side] = this.position + "px";
            return style;
        },
        realWidth: function realWidth() {
            var width = void 0;
            if (this.computedStyle[1] != null) {
                width = this.computedStyle[1].width;
            }
            if (width == null) {
                width = this.computedStyle[0].width;
            }
            return width;
        }
    },
    watch: {
        fixed: "processFixed",
        fixedScreenSize: "processFixed",
        side: "setParentMargin"
    },
    data: function data() {
        return {
            isFixed: null,
            position: -1 * (this.width + 10),
            overlayZIndex: 1001
        };
    },

    methods: {
        makeFixed: function makeFixed(fixed) {
            if (fixed !== this.isFixed) {
                this.isFixed = fixed;
                this.setParentMargin();
                return this.$emit("fixed", fixed);
            }
        },
        setParentMargin: function setParentMargin() {
            var _this = this;

            if (this.$el.parentElement) {
                var width = void 0;
                if (this.isFixed) {
                    width = this.realWidth;
                } else {
                    width = null;
                }
                return function () {
                    var result = [];
                    var _iteratorNormalCompletion = true;
                    var _didIteratorError = false;
                    var _iteratorError = undefined;

                    try {
                        for (var _iterator = _this.$el.parentElement.children[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                            var el = _step.value;

                            var item = void 0;
                            if (el !== _this.$el) {
                                _this.setCss(el, "margin-" + _this.side, width);
                                item = _this.setCss(el, "margin-" + _this.otherSide, null);
                            }
                            result.push(item);
                        }
                    } catch (err) {
                        _didIteratorError = true;
                        _iteratorError = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion && _iterator.return) {
                                _iterator.return();
                            }
                        } finally {
                            if (_didIteratorError) {
                                throw _iteratorError;
                            }
                        }
                    }

                    return result;
                }();
            }
        },
        processFixed: function processFixed() {
            var _this2 = this;

            if (this.fixed) {
                this.makeFixed(window.innerWidth > this.fixedScreenSize);
                if (this.isFixed) {
                    this.position = 0;
                } else {
                    this.position = -1 * (this.width + 10);
                }
                this.disposeWindowResize = this.onWindowResize(function () {
                    if (window.innerWidth > _this2.fixedScreenSize) {
                        // getting bigger
                        if (!_this2.isFixed) {
                            if (_this2.opened) {
                                _this2.close(true);
                                _this2.wasOpened = true;
                            } else {
                                _this2.show(false);
                            }
                            return _this2.makeFixed(true);
                        }
                    } else {
                        // getting smaller
                        if (_this2.isFixed) {
                            if (_this2.wasOpened) {
                                _this2.open(true);
                            } else {
                                _this2.hide(false);
                            }
                            return _this2.makeFixed(false);
                        }
                    }
                });
            } else {
                this.makeFixed(false);
                if (this.opened) {
                    this.position = 0;
                } else {
                    this.position = -1 * (this.width + 10);
                }
                __guardMethod__(this, 'disposeWindowResize', function (o) {
                    return o.disposeWindowResize();
                });
            }
            return this.setParentMargin();
        },
        onClick: function onClick(e) {
            if (this.closeOnClick) {
                return this.dismiss(e);
            }
        },
        dismiss: function dismiss(e) {
            if (!e.defaultPrevented) {
                if (!this.notDismissable && !this.isFixed) {
                    this.close();
                    return e.preventDefault();
                }
            }
        },
        move: function move(position) {
            var fac = this.right ? -1 : 1;
            return this.position = -this.width + fac * position;
        },
        show: function show(animate) {
            var _this3 = this;

            if (animate == null) {
                animate = true;
            }
            this.$emit("before-enter");
            if (animate) {
                var style = {};
                style[this.side] = "0";
                return this.transition({ el: this.$refs.nav, style: style, cb: function cb() {
                        _this3.setCss(_this3.$refs.nav, "transform", "translateX(0)");
                        _this3.setOpened();
                        return _this3.$emit("after-enter");
                    }
                });
            } else {
                this.position = 0;
                this.setOpened();
                return this.$emit("after-enter");
            }
        },
        hide: function hide(animate) {
            var _this4 = this;

            if (animate == null) {
                animate = true;
            }
            this.wasOpened = false;
            this.$emit("before-leave");
            if (animate) {
                var style = {};
                style[this.side] = -1 * (this.width + 10) + "px";
                return this.transition({ el: this.$refs.nav, style: style, cb: function cb() {
                        _this4.setClosed();
                        return _this4.$emit("after-leave");
                    }
                });
            } else {
                this.position = -1 * (this.width + 10);
                this.setClosed();
                return this.$emit("after-leave");
            }
        },
        open: function open(restoreOverlay) {
            var _this5 = this;

            if (this.opened && !restoreOverlay) {
                return;
            }

            var _overlay$open = this.overlay.open({ zIndex: this.zIndex, opacity: this.opacity, onBeforeClose: function onBeforeClose() {
                    return _this5.close();
                } }),
                zIndex = _overlay$open.zIndex,
                close = _overlay$open.close;

            this.overlayZIndex = zIndex;
            this.closeOverlay = close;
            if (!restoreOverlay) {
                return this.show();
            }
        },
        close: function close(restoreNav) {
            if (!this.opened) {
                return;
            }
            __guardMethod__(this, 'closeOverlay', function (o) {
                return o.closeOverlay(false);
            });
            this.closeOverlay = null;
            if (!restoreNav) {
                return this.hide();
            }
        },
        toggle: function toggle() {
            if (this.isFixed) {
                // disable opening
                return this.opened = this.isOpened;
            } else {
                if (this.opened) {
                    return this.close();
                } else {
                    return this.open();
                }
            }
        }
    },

    mounted: function mounted() {
        return this.$nextTick(function () {
            return this.processFixed();
        });
    },
    beforeDestory: function beforeDestory() {
        return __guardMethod__(this, 'closeOverlay', function (o) {
            return o.closeOverlay();
        });
    }
};
function __guardMethod__(obj, methodName, transform) {
    if (typeof obj !== 'undefined' && obj !== null && typeof obj[methodName] === 'function') {
        return transform(obj, methodName);
    } else {
        return undefined;
    }
}

/***/ }),
/* 184 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_img_logo_png__ = __webpack_require__(274);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_img_logo_png___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__assets_img_logo_png__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_nprogress_src_NprogressContainer_vue__ = __webpack_require__(302);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_nprogress_src_NprogressContainer_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_nprogress_src_NprogressContainer_vue__);
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




/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-theme',
    components: {
        NprogressContainer: __WEBPACK_IMPORTED_MODULE_1_vue_nprogress_src_NprogressContainer_vue___default.a
    },
    data: function data() {
        return { show: false };
    },
    mounted: function mounted() {
        this.show = true;
    }
};

/***/ }),
/* 185 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_popover__ = __webpack_require__(82);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_popover___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mixins_popover__);
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



/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_popover___default.a],
    props: {
        effect: { type: String, default: 'scale' },
        trigger: { type: String, default: 'hover' }
    }
};

/***/ }),
/* 186 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = {

    mixins: [__webpack_require__(116), __webpack_require__(437), __webpack_require__(435)],

    computed: {
        zIndex: function zIndex() {
            if (this.lastItem != null) {
                return this.lastItem.zIndex;
            }
            return 995;
        },
        color: function color() {
            if (this.lastItem != null && this.lastItem.color) {
                return this.lastItem.color;
            }
            return "black";
        },
        opacity: function opacity() {
            if (this.lastItem != null) {
                if (this.lastItem.opacity != null) {
                    return this.lastItem.opacity;
                }
                return 0.5;
            }
            return 0;
        },
        dismissable: function dismissable() {
            if (this.lastItem != null && this.lastItem.dismissable != null) {
                return this.lastItem.dismissable;
            }
            return true;
        },
        lastItem: function lastItem() {
            if (this.stack.length > 0) {
                var li = this.stack[this.stack.length - 1];
                this.updateScroll(li);
                this.updateKeyListener(true);
                return li;
            }
            this.updateScroll();
            this.updateKeyListener();
            return null;
        }
    },

    data: function data() {
        return { stack: [] };
    },


    methods: {
        fade: function fade(_ref) {
            var el = _ref.el,
                opacity = _ref.opacity,
                cb = _ref.cb;

            this.setCss(el, "opacity", opacity);
            return cb();
        },
        dismiss: function dismiss(e) {
            if (e != null && !e.defaultPrevented) {
                if (this.dismissable) {
                    if (e.type === "keyup" && e.which !== 27) {
                        return null;
                    }
                    this.close();
                    return e.preventDefault();
                }
            }
        },
        updateKeyListener: function updateKeyListener(set) {
            if (set && !this.removeListener) {
                if (!this.removeListener) {
                    return this.removeListener = this.onDocument("keyup", this.dismiss);
                }
            } else {
                if (typeof this.removeListener === 'function') {
                    this.removeListener();
                }
                return this.removeListener = null;
            }
        },
        updateScroll: function updateScroll(options) {
            var style = { o: null, m: null };
            if (options && !options.allowScroll) {
                if (this.scrollDisabled) {
                    return null;
                }
                style.o = "hidden";
                style.m = this.getViewportSize().width - document.documentElement.clientWidth + "px";
                this.scrollDisabled = true;
            } else {
                this.scrollDisabled = false;
            }
            this.setCss(document.documentElement, "overflow", style.o);
            return this.setCss(document.documentElement, "margin-right", style.m);
        },
        open: function open(options) {
            var _this = this;

            if (options == null) {
                options = {};
            }
            if (this.lastItem == null) {
                document.body.appendChild(this.$el);
            }
            if (typeof options.onBeforeOpen === 'function') {
                options.onBeforeOpen();
            }
            var newZIndex = this.zIndex + 5;
            if (options.zIndex == null || options.zIndex <= newZIndex) {
                options.zIndex = newZIndex;
            }
            this.stack.push(options);
            this.fade({
                el: this.$el, opacity: this.opacity, cb: function cb() {
                    return typeof options.onOpened === 'function' ? options.onOpened() : undefined;
                }
            });
            return { zIndex: this.zIndex + 1, close: function close(callCbs) {
                    return callCbs != null ? callCbs : callCbs = true, _this.close(options, callCbs);
                } };
        },
        close: function close(options, callCbs) {
            var _this2 = this;

            var index = void 0;
            if (options == null) {
                options = this.lastItem;
            }
            if (callCbs == null) {
                callCbs = true;
            }
            if ((index = this.stack.indexOf(options)) > -1) {
                this.stack.splice(index, 1);
                if (callCbs) {
                    if (typeof options.onBeforeClose === 'function') {
                        options.onBeforeClose();
                    }
                }
                return this.fade({
                    el: this.$el, opacity: this.opacity, cb: function cb() {
                        if (callCbs) {
                            if (typeof options.onClosed === 'function') {
                                options.onClosed();
                            }
                        }
                        if (_this2.lastItem == null) {
                            return document.body.removeChild(_this2.$el);
                        }
                    }
                });
            }
        }
    }
};

/***/ }),
/* 187 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var cFooter = __webpack_require__(313);
exports.cFooter = cFooter;
var cHeader = __webpack_require__(315);
exports.cHeader = cHeader;
var cHeaderMenuItem = __webpack_require__(314);
exports.cHeaderMenuItem = cHeaderMenuItem;
var cTheme = __webpack_require__(321);
exports.cTheme = cTheme;
var cAffix = __webpack_require__(303);
exports.cAffix = cAffix;
var cScrollToTop = __webpack_require__(318);
exports.cScrollToTop = cScrollToTop;
var cSideNav = __webpack_require__(320);
exports.cSideNav = cSideNav;
var cSideNavItem = __webpack_require__(319);
exports.cSideNavItem = cSideNavItem;
var cTooltip = __webpack_require__(322);
exports.cTooltip = cTooltip;
var cPopover = __webpack_require__(317);
exports.cPopover = cPopover;
var cCentered = __webpack_require__(304);
exports.cCentered = cCentered;
var cLoader = __webpack_require__(316);
exports.cLoader = cLoader;
var vCollection = __webpack_require__(308);
exports.vCollection = vCollection;
var vCollectionAvatar = __webpack_require__(305);
exports.vCollectionAvatar = vCollectionAvatar;
var vCollectionItem = __webpack_require__(306);
exports.vCollectionItem = vCollectionItem;
var vCollectionLink = __webpack_require__(307);
exports.vCollectionLink = vCollectionLink;
var cContextMenu = __webpack_require__(309);
exports.cContextMenu = cContextMenu;
var cDragZone = __webpack_require__(312);
exports.cDragZone = cDragZone;
var cDragZoneHandle = __webpack_require__(311);
exports.cDragZoneHandle = cDragZoneHandle;
var uiPopover = __webpack_require__(99);
exports.uiPopover = uiPopover;

/***/ }),
/* 188 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Object.defineProperty(exports, "__esModule", { value: true });
var lodash_1 = __webpack_require__(4);
var utils_1 = __webpack_require__(16);
exports.dropdown = {
    bind: function bind(el, binding, vnode, oldVnode) {
        utils_1.load(vnode.context, function () {
            var id = binding.arg,
                params = {};
            if (typeof binding.value === 'string' && typeof binding.arg !== 'string') id = binding.value;
            if (typeof binding.value !== 'string') params = binding.value || {};
            el.setAttribute('data-activates', id);
            $(el).dropdown(params);
        });
    }
};
exports.scrollTo = {
    bind: function bind(el, binding, vnode, oldVnode) {
        var o = {
            to: null,
            duration: 500,
            easing: 'swing',
            offset: 0
        };
        $(function () {
            $(el).on('click', function (event) {
                event.stopPropagation();
                event.preventDefault();
                if (_typeof(binding.value) === 'object') {
                    lodash_1.merge(o, binding.value);
                }
                if (typeof binding.value === 'string') {
                    o.to = $(binding.value).offset().top;
                } else if (binding.arg) {
                    o.to = $($(el).attr(binding.arg)).offset().top;
                }
                setTimeout(function () {
                    return $("html, body").stop().animate({ scrollTop: o.to + o.offset }, o.duration, o.easing, function () {});
                }, 50);
            });
        });
    }
};
exports.scrollspy = {
    bind: function bind(el, binding, vnode, oldVnode) {
        var defaults = {};
        var options = lodash_1.merge({}, defaults, binding.value);
    }
};
exports.popover = {
    bind: function bind(el, binding, vnode, oldVnode) {
        var defaults = {};
        var options = lodash_1.merge({}, defaults, binding.value);
    }
};
function updateHeight(el, binding) {
    var key = 'height';
    if (binding.modifiers['max']) key = 'maxHeight';
    if (binding.modifiers['min']) key = 'minHeight';
    el.style[key] = binding.value + 'px';
}
exports.scrollable = {
    bind: function bind(el, binding, vnode, oldVnode) {
        if (!el.classList.contains('scrollable')) {
            el.classList.add('scrollable');
        }
        if (binding.modifiers['x']) {
            el.style['overflow-x'] = 'scroll';
        }
        if (binding.modifiers['y']) {
            el.style['overflow-y'] = 'scroll';
        }
        updateHeight(el, binding);
    },
    componentUpdated: function componentUpdated(el, binding, vnode, oldVnode) {
        updateHeight(el, binding);
    }
};
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(14)))

/***/ }),
/* 189 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

Object.defineProperty(exports, "__esModule", { value: true });
var Vue = __webpack_require__(8);
var SmoothScroll = __webpack_require__(433);
var VueCookie = __webpack_require__(120);
var NProgress = __webpack_require__(121);
var lodash_1 = __webpack_require__(4);
var vuex_1 = __webpack_require__(9);
var components = __webpack_require__(187);
var directives = __webpack_require__(188);
var api_1 = __webpack_require__(53);
var codex_1 = __webpack_require__(80);
var vIcon = __webpack_require__(301);
lodash_1.merge(Vue, {
    codex: new codex_1.Codex()
});
window['codex'] = Vue['codex'];
exports.plugin = function (Vue) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    if (exports.plugin.installed) return;
    Vue.codex.makeExtender(options);
    options.extend({
        mergePhpData: true
    });
    if (options.mergePhpData && window['_CODEX_PHP_DATA'] !== undefined) {
        Vue.codex.extend(window['_CODEX_PHP_DATA']);
        Vue.config.debug = Vue.codex.debug;
    }
    options.extend({
        apiOptions: {
            apiUrl: Vue.codex.apiUrl,
            debug: Vue.codex.debug
        },
        storeOptions: {}
    });
    Vue.codex.store = new vuex_1.Store(options.storeOptions);
    Vue.codex.api = new api_1.Api(options.apiOptions);
    var KeenUiConfig = __webpack_require__(6).default;
    KeenUiConfig.set({
        disableRipple: true,
        UiAutocomplete: {
            keys: {
                label: 'name',
                value: 'id',
                image: 'picture'
            }
        }
    });
    var KeenUI = __webpack_require__(271).default;
    Vue.use(KeenUI);
    Vue.use(VueCookie);
    Vue.use(__webpack_require__(122));
    Vue.use(NProgress, {
        latencyThreshold: 100,
        router: false,
        http: true
    });
    Vue.codex.nprogress = new NProgress({ parent: '.nprogress-container' });
    Object.defineProperties(Vue.prototype, {
        $helpers: {
            get: function get() {
                return Vue.codex.helpers;
            }
        },
        $codex: {
            get: function get() {
                return Vue.codex;
            }
        }
    });
    Vue.mixin({
        nprogress: Vue.codex.nprogress,
        computed: {
            $$el: function $$el() {
                return $(this.$el);
            },
            $events: function $events() {
                return Vue.codex.events;
            },
            classes: function classes() {
                return {};
            }
        },
        methods: {
            $$: function $$(selector, options) {
                return $(selector, options);
            },
            $$ready: function $$ready(cb) {
                if (document.readyState === 'complete') {
                    this.$nextTick(function () {
                        return cb();
                    });
                } else {
                    document.addEventListener('DOMContentLoaded', function () {
                        return cb();
                    });
                }
            },
            $scroll: function $scroll(el) {
                var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;
                var callback = arguments[2];
                var context = arguments[3];

                SmoothScroll(el, duration, callback, context);
            }
        }
    });
    lodash_1.merge(components, { vIcon: vIcon });
    console.log('registering core plugin', components);
    Object.keys(components).forEach(function (key) {
        return Vue.component(key, components[key]);
    });
    Object.keys(directives).forEach(function (key) {
        return Vue.directive(key, directives[key]);
    });
};
exports.default = exports.plugin;
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(14)))

/***/ }),
/* 190 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var overlay = null;
var creator = function creator(Vue) {
    if (overlay == null) {
        overlay = Vue.extend(creator.obj);
        overlay = new overlay().$mount();
    }
    return overlay;
};
creator.obj = __webpack_require__(323);
exports.default = creator;

/***/ }),
/* 191 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(jQuery) {Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__utils__);

/**
 * Extend jquery with a scrollspy plugin.
 * This watches the window scroll and fires events when elements are scrolled into viewport.
 *
 * throttle() and getTime() taken from Underscore.js
 * https://github.com/jashkenas/underscore
 *
 * @author Copyright 2013 John Smart
 * @license https://raw.github.com/thesmart/jquery-scrollspy/master/LICENSE
 * @see https://github.com/thesmart
 * @version 0.1.2
 */
(function ($) {

    var jWindow = $(window);
    var elements = [];
    var elementsInView = [];
    var isSpying = false;
    var ticks = 0;
    var unique_id = 1;
    var offset = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    };

    /**
     * Find elements that are within the boundary
     * @param {number} top
     * @param {number} right
     * @param {number} bottom
     * @param {number} left
     * @return {jQuery}		A collection of elements
     */
    function findElements(top, right, bottom, left) {
        var hits = $();
        $.each(elements, function (i, element) {
            if (element.height() > 0) {
                var elTop = element.offset().top,
                    elLeft = element.offset().left,
                    elRight = elLeft + element.width(),
                    elBottom = elTop + element.height();

                var isIntersect = !(elLeft > right || elRight < left || elTop > bottom || elBottom < top);

                if (isIntersect) {
                    hits.push(element);
                }
            }
        });

        return hits;
    }

    /**
     * Called when the user scrolls the window
     */
    function onScroll(scrollOffset) {
        // unique tick id
        ++ticks;

        // viewport rectangle
        var top = jWindow.scrollTop(),
            left = jWindow.scrollLeft(),
            right = left + jWindow.width(),
            bottom = top + jWindow.height();

        // determine which elements are in view
        var intersections = findElements(top + offset.top + scrollOffset || 200, right + offset.right, bottom + offset.bottom, left + offset.left);
        $.each(intersections, function (i, element) {

            var lastTick = element.data('scrollSpy:ticks');
            if (typeof lastTick != 'number') {
                // entered into view
                element.triggerHandler('scrollSpy:enter');
            }

            // update tick id
            element.data('scrollSpy:ticks', ticks);
        });

        // determine which elements are no longer in view
        $.each(elementsInView, function (i, element) {
            var lastTick = element.data('scrollSpy:ticks');
            if (typeof lastTick == 'number' && lastTick !== ticks) {
                // exited from view
                element.triggerHandler('scrollSpy:exit');
                element.data('scrollSpy:ticks', null);
            }
        });

        // remember elements in view for next tick
        elementsInView = intersections;
    }

    /**
     * Called when window is resized
     */
    function onWinSize() {
        jWindow.trigger('scrollSpy:winSize');
    }

    /**
     * Get time in ms
     * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
     * @type {function}
     * @return {number}
     */
    var getTime = Date.now || function () {
        return new Date().getTime();
    };

    /**
     * Returns a function, that, when invoked, will only be triggered at most once
     * during a given window of time. Normally, the throttled function will run
     * as much as it can, without ever going more than once per `wait` duration;
     * but if you'd like to disable the execution on the leading edge, pass
     * `{leading: false}`. To disable execution on the trailing edge, ditto.
     * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
     * @param {function} func
     * @param {number} wait
     * @param {Object=} options
     * @returns {Function}
     */
    function throttle(func, wait, options) {
        var context, args, result;
        var timeout = null;
        var previous = 0;
        options || (options = {});
        var later = function later() {
            previous = options.leading === false ? 0 : getTime();
            timeout = null;
            result = func.apply(context, args);
            context = args = null;
        };
        return function () {
            var now = getTime();
            if (!previous && options.leading === false) previous = now;
            var remaining = wait - (now - previous);
            context = this;
            args = arguments;
            if (remaining <= 0) {
                clearTimeout(timeout);
                timeout = null;
                previous = now;
                result = func.apply(context, args);
                context = args = null;
            } else if (!timeout && options.trailing !== false) {
                timeout = setTimeout(later, remaining);
            }
            return result;
        };
    }
    /**
     * Enables ScrollSpy using a selector
     * @param {jQuery|string} selector  The elements collection, or a selector
     * @param {Object=} options	Optional.
     throttle : number -> scrollspy throttling. Default: 100 ms
     offsetTop : number -> offset from top. Default: 0
     offsetRight : number -> offset from right. Default: 0
     offsetBottom : number -> offset from bottom. Default: 0
     offsetLeft : number -> offset from left. Default: 0
     * @returns {jQuery}
     */
    $.scrollSpy = function (selector, options) {
        var defaults = {
            throttle: 100,
            scrollOffset: 200 // offset - 200 allows elements near bottom of page to scroll
        };
        options = $.extend(defaults, options);

        var visible = [];
        selector = $(selector);
        selector.each(function (i, element) {
            elements.push($(element));
            $(element).data("scrollSpy:id", i);
            // Smooth scroll to section
            $('a[href="#' + $(element).attr('id') + '"]').click(function (e) {
                e.preventDefault();
                var offset = $(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__utils__["escapeHash"])(this.hash)).offset().top + 1;
                $('html, body').animate({ scrollTop: offset - options.scrollOffset }, { duration: 400, queue: false }); //, easing: 'easeOutCubic'});
            });
        });

        offset.top = options.offsetTop || 0;
        offset.right = options.offsetRight || 0;
        offset.bottom = options.offsetBottom || 0;
        offset.left = options.offsetLeft || 0;

        var throttledScroll = throttle(function () {
            onScroll(options.scrollOffset);
        }, options.throttle || 100);
        var readyScroll = function readyScroll() {
            $(document).ready(throttledScroll);
        };

        if (!isSpying) {
            jWindow.on('scroll', readyScroll);
            jWindow.on('resize', readyScroll);
            isSpying = true;
        }

        // perform a scan once, after current execution context, and after dom is ready
        setTimeout(readyScroll, 0);

        selector.on('scrollSpy:enter', function () {
            visible = $.grep(visible, function (value) {
                return value.height() != 0;
            });

            var $this = $(this);

            if (visible[0]) {
                $('a[href="#' + visible[0].attr('id') + '"]').removeClass('active');
                if ($this.data('scrollSpy:id') < visible[0].data('scrollSpy:id')) {
                    visible.unshift($(this));
                } else {
                    visible.push($(this));
                }
            } else {
                visible.push($(this));
            }

            $('a[href="#' + visible[0].attr('id') + '"]').addClass('active');
        });
        selector.on('scrollSpy:exit', function () {
            visible = $.grep(visible, function (value) {
                return value.height() != 0;
            });

            if (visible[0]) {
                $('a[href="#' + visible[0].attr('id') + '"]').removeClass('active');
                var $this = $(this);
                visible = $.grep(visible, function (value) {
                    return value.attr('id') != $this.attr('id');
                });
                if (visible[0]) {
                    // Check if empty
                    $('a[href="#' + visible[0].attr('id') + '"]').addClass('active');
                }
            }
        });

        return selector;
    };

    /**
     * Listen for window resize events
     * @param {Object=} options						Optional. Set { throttle: number } to change throttling. Default: 100 ms
     * @returns {jQuery}		$(window)
     */
    $.winSizeSpy = function (options) {
        $.winSizeSpy = function () {
            return jWindow;
        }; // lock from multiple calls
        options = options || {
            throttle: 100
        };
        return jWindow.on('resize', throttle(onWinSize, options.throttle || 100));
    };

    /**
     * Enables ScrollSpy on a collection of elements
     * e.g. $('.scrollSpy').scrollSpy()
     * @param {Object=} options	Optional.
     throttle : number -> scrollspy throttling. Default: 100 ms
     offsetTop : number -> offset from top. Default: 0
     offsetRight : number -> offset from right. Default: 0
     offsetBottom : number -> offset from bottom. Default: 0
     offsetLeft : number -> offset from left. Default: 0
     * @returns {jQuery}
     */
    $.fn.scrollSpy = function (options) {
        return $.scrollSpy($(this), options);
    };
})(jQuery);
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(14)))

/***/ }),
/* 192 */,
/* 193 */,
/* 194 */,
/* 195 */,
/* 196 */,
/* 197 */,
/* 198 */,
/* 199 */,
/* 200 */,
/* 201 */,
/* 202 */,
/* 203 */,
/* 204 */,
/* 205 */,
/* 206 */,
/* 207 */,
/* 208 */,
/* 209 */,
/* 210 */,
/* 211 */,
/* 212 */,
/* 213 */,
/* 214 */,
/* 215 */,
/* 216 */,
/* 217 */,
/* 218 */,
/* 219 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 220 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 221 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 222 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 223 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 224 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 225 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 226 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 227 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 228 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 229 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 230 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 231 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 232 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 233 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 234 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 235 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 236 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 237 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 238 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 239 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 240 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 241 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 242 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 243 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 244 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 245 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 246 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 247 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 248 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 249 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 250 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 251 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 252 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 253 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 254 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 255 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 256 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 257 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 258 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 259 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 260 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 261 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 262 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 263 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 264 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 265 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 266 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 267 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 268 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 269 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_modality__ = __webpack_require__(270);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_modality___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__helpers_modality__);



/***/ }),
/* 270 */
/***/ (function(module, exports) {

/**
 * Adapted from https://github.com/alice/modality
 * Version: 1.0.2
 */
document.addEventListener('DOMContentLoaded', () => {
    let hadKeyboardEvent = false;
    const keyboardModalityWhitelist = [
        'input:not([type])',
        'input[type=text]',
        'input[type=number]',
        'input[type=date]',
        'input[type=time]',
        'input[type=datetime]',
        'textarea',
        '[role=textbox]',
        '[supports-modality=keyboard]'
    ].join(',');

    let isHandlingKeyboardThrottle;

    const matcher = (() => {
        const el = document.body;

        if (el.matchesSelector) {
            return el.matchesSelector;
        }

        if (el.webkitMatchesSelector) {
            return el.webkitMatchesSelector;
        }

        if (el.mozMatchesSelector) {
            return el.mozMatchesSelector;
        }

        if (el.msMatchesSelector) {
            return el.msMatchesSelector;
        }

        console.error('Couldn\'t find any matchesSelector method on document.body.');
    })();

    const disableFocusRingByDefault = function () {
        const css = 'body:not([modality=keyboard]) :focus { outline: none; }';
        const head = document.head || document.getElementsByTagName('head')[0];
        const style = document.createElement('style');

        style.type = 'text/css';
        style.id = 'disable-focus-ring';

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.insertBefore(style, head.firstChild);
    };

    const focusTriggersKeyboardModality = function (el) {
        let triggers = false;

        if (matcher) {
            triggers = matcher.call(el, keyboardModalityWhitelist) &&
                matcher.call(el, ':not([readonly])');
        }

        return triggers;
    };

    disableFocusRingByDefault();

    document.body.addEventListener('keydown', () => {
        hadKeyboardEvent = true;

        if (isHandlingKeyboardThrottle) {
            clearTimeout(isHandlingKeyboardThrottle);
        }

        isHandlingKeyboardThrottle = setTimeout(() => {
            hadKeyboardEvent = false;
        }, 100);
    }, true);

    document.body.addEventListener('focus', e => {
        if (hadKeyboardEvent || focusTriggersKeyboardModality(e.target)) {
            document.body.setAttribute('modality', 'keyboard');
        }
    }, true);

    document.body.addEventListener('blur', () => {
        document.body.removeAttribute('modality');
    }, true);
});


/***/ }),
/* 271 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__bootstrap__ = __webpack_require__(269);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiAlert_vue__ = __webpack_require__(275);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UiAlert_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__UiAlert_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue__ = __webpack_require__(276);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiButton_vue__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UiButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__UiButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue__ = __webpack_require__(93);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue__ = __webpack_require__(94);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue__ = __webpack_require__(281);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue__ = __webpack_require__(282);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue__ = __webpack_require__(283);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue__ = __webpack_require__(284);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__UiFab_vue__ = __webpack_require__(285);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__UiFab_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__UiFab_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue__ = __webpack_require__(286);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__UiIcon_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__UiIcon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_12__UiIcon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__UiMenu_vue__ = __webpack_require__(287);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__UiMenu_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_14__UiMenu_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__UiModal_vue__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__UiModal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_15__UiModal_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__UiPopover_vue__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__UiPopover_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_16__UiPopover_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue__ = __webpack_require__(289);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue__ = __webpack_require__(96);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__UiRadio_vue__ = __webpack_require__(97);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__UiRadio_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_20__UiRadio_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue__ = __webpack_require__(290);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_23__UiSelect_vue__ = __webpack_require__(291);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_23__UiSelect_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_23__UiSelect_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_24__UiSlider_vue__ = __webpack_require__(293);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_24__UiSlider_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_24__UiSlider_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue__ = __webpack_require__(294);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue__ = __webpack_require__(295);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_28__UiTab_vue__ = __webpack_require__(296);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_28__UiTab_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_28__UiTab_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_29__UiTabs_vue__ = __webpack_require__(298);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_29__UiTabs_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_29__UiTabs_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue__ = __webpack_require__(299);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue__ = __webpack_require__(300);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue__ = __webpack_require__(70);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue__);
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiAlert", function() { return __WEBPACK_IMPORTED_MODULE_1__UiAlert_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiAutocomplete", function() { return __WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiButton", function() { return __WEBPACK_IMPORTED_MODULE_3__UiButton_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiCalendar", function() { return __WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiCheckbox", function() { return __WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiCheckboxGroup", function() { return __WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiCollapsible", function() { return __WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiConfirm", function() { return __WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiDatepicker", function() { return __WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiFab", function() { return __WEBPACK_IMPORTED_MODULE_10__UiFab_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiFileupload", function() { return __WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiIcon", function() { return __WEBPACK_IMPORTED_MODULE_12__UiIcon_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiIconButton", function() { return __WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiMenu", function() { return __WEBPACK_IMPORTED_MODULE_14__UiMenu_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiModal", function() { return __WEBPACK_IMPORTED_MODULE_15__UiModal_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiPopover", function() { return __WEBPACK_IMPORTED_MODULE_16__UiPopover_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiPreloader", function() { return __WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiProgressCircular", function() { return __WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiProgressLinear", function() { return __WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiRadio", function() { return __WEBPACK_IMPORTED_MODULE_20__UiRadio_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiRadioGroup", function() { return __WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiRippleInk", function() { return __WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiSelect", function() { return __WEBPACK_IMPORTED_MODULE_23__UiSelect_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiSlider", function() { return __WEBPACK_IMPORTED_MODULE_24__UiSlider_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiSnackbar", function() { return __WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiSnackbarContainer", function() { return __WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiSwitch", function() { return __WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiTab", function() { return __WEBPACK_IMPORTED_MODULE_28__UiTab_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiTabs", function() { return __WEBPACK_IMPORTED_MODULE_29__UiTabs_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiTextbox", function() { return __WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiToolbar", function() { return __WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue___default.a; });
/* harmony reexport (default from non-hamory) */ __webpack_require__.d(__webpack_exports__, "UiTooltip", function() { return __WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue___default.a; });



































const Keen = {
    UiAlert: __WEBPACK_IMPORTED_MODULE_1__UiAlert_vue___default.a,
    UiAutocomplete: __WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue___default.a,
    UiButton: __WEBPACK_IMPORTED_MODULE_3__UiButton_vue___default.a,
    UiCalendar: __WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue___default.a,
    UiCheckbox: __WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue___default.a,
    UiCheckboxGroup: __WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue___default.a,
    UiCollapsible: __WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue___default.a,
    UiConfirm: __WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue___default.a,
    UiDatepicker: __WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue___default.a,
    UiFab: __WEBPACK_IMPORTED_MODULE_10__UiFab_vue___default.a,
    UiFileupload: __WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue___default.a,
    UiIcon: __WEBPACK_IMPORTED_MODULE_12__UiIcon_vue___default.a,
    UiIconButton: __WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue___default.a,
    UiMenu: __WEBPACK_IMPORTED_MODULE_14__UiMenu_vue___default.a,
    UiModal: __WEBPACK_IMPORTED_MODULE_15__UiModal_vue___default.a,
    UiPopover: __WEBPACK_IMPORTED_MODULE_16__UiPopover_vue___default.a,
    UiPreloader: __WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue___default.a,
    UiProgressCircular: __WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue___default.a,
    UiProgressLinear: __WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue___default.a,
    UiRadio: __WEBPACK_IMPORTED_MODULE_20__UiRadio_vue___default.a,
    UiRadioGroup: __WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue___default.a,
    UiRippleInk: __WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue___default.a,
    UiSelect: __WEBPACK_IMPORTED_MODULE_23__UiSelect_vue___default.a,
    UiSlider: __WEBPACK_IMPORTED_MODULE_24__UiSlider_vue___default.a,
    UiSnackbar: __WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue___default.a,
    UiSnackbarContainer: __WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue___default.a,
    UiSwitch: __WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue___default.a,
    UiTab: __WEBPACK_IMPORTED_MODULE_28__UiTab_vue___default.a,
    UiTabs: __WEBPACK_IMPORTED_MODULE_29__UiTabs_vue___default.a,
    UiTextbox: __WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue___default.a,
    UiToolbar: __WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue___default.a,
    UiTooltip: __WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue___default.a,

    install(Vue) {
        Vue.component('ui-alert', __WEBPACK_IMPORTED_MODULE_1__UiAlert_vue___default.a);
        Vue.component('ui-autocomplete', __WEBPACK_IMPORTED_MODULE_2__UiAutocomplete_vue___default.a);
        Vue.component('ui-button', __WEBPACK_IMPORTED_MODULE_3__UiButton_vue___default.a);
        Vue.component('ui-calendar', __WEBPACK_IMPORTED_MODULE_4__UiCalendar_vue___default.a);
        Vue.component('ui-checkbox', __WEBPACK_IMPORTED_MODULE_5__UiCheckbox_vue___default.a);
        Vue.component('ui-checkbox-group', __WEBPACK_IMPORTED_MODULE_6__UiCheckboxGroup_vue___default.a);
        Vue.component('ui-collapsible', __WEBPACK_IMPORTED_MODULE_7__UiCollapsible_vue___default.a);
        Vue.component('ui-confirm', __WEBPACK_IMPORTED_MODULE_8__UiConfirm_vue___default.a);
        Vue.component('ui-datepicker', __WEBPACK_IMPORTED_MODULE_9__UiDatepicker_vue___default.a);
        Vue.component('ui-fab', __WEBPACK_IMPORTED_MODULE_10__UiFab_vue___default.a);
        Vue.component('ui-fileupload', __WEBPACK_IMPORTED_MODULE_11__UiFileupload_vue___default.a);
        Vue.component('ui-icon', __WEBPACK_IMPORTED_MODULE_12__UiIcon_vue___default.a);
        Vue.component('ui-icon-button', __WEBPACK_IMPORTED_MODULE_13__UiIconButton_vue___default.a);
        Vue.component('ui-menu', __WEBPACK_IMPORTED_MODULE_14__UiMenu_vue___default.a);
        Vue.component('ui-modal', __WEBPACK_IMPORTED_MODULE_15__UiModal_vue___default.a);
        Vue.component('ui-popover', __WEBPACK_IMPORTED_MODULE_16__UiPopover_vue___default.a);
        Vue.component('ui-preloader', __WEBPACK_IMPORTED_MODULE_17__UiPreloader_vue___default.a);
        Vue.component('ui-progress-circular', __WEBPACK_IMPORTED_MODULE_18__UiProgressCircular_vue___default.a);
        Vue.component('ui-progress-linear', __WEBPACK_IMPORTED_MODULE_19__UiProgressLinear_vue___default.a);
        Vue.component('ui-radio', __WEBPACK_IMPORTED_MODULE_20__UiRadio_vue___default.a);
        Vue.component('ui-radio-group', __WEBPACK_IMPORTED_MODULE_21__UiRadioGroup_vue___default.a);
        Vue.component('ui-ripple-ink', __WEBPACK_IMPORTED_MODULE_22__UiRippleInk_vue___default.a);
        Vue.component('ui-select', __WEBPACK_IMPORTED_MODULE_23__UiSelect_vue___default.a);
        Vue.component('ui-slider', __WEBPACK_IMPORTED_MODULE_24__UiSlider_vue___default.a);
        Vue.component('ui-snackbar', __WEBPACK_IMPORTED_MODULE_25__UiSnackbar_vue___default.a);
        Vue.component('ui-snackbar-container', __WEBPACK_IMPORTED_MODULE_26__UiSnackbarContainer_vue___default.a);
        Vue.component('ui-switch', __WEBPACK_IMPORTED_MODULE_27__UiSwitch_vue___default.a);
        Vue.component('ui-tab', __WEBPACK_IMPORTED_MODULE_28__UiTab_vue___default.a);
        Vue.component('ui-tabs', __WEBPACK_IMPORTED_MODULE_29__UiTabs_vue___default.a);
        Vue.component('ui-textbox', __WEBPACK_IMPORTED_MODULE_30__UiTextbox_vue___default.a);
        Vue.component('ui-toolbar', __WEBPACK_IMPORTED_MODULE_31__UiToolbar_vue___default.a);
        Vue.component('ui-tooltip', __WEBPACK_IMPORTED_MODULE_32__UiTooltip_vue___default.a);
    }
};

// Automatically install Keen UI if Vue is available globally
if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Keen);
}

/* harmony default export */ __webpack_exports__["default"] = Keen;



































/***/ }),
/* 272 */,
/* 273 */,
/* 274 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/logo.png";

/***/ }),
/* 275 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(257)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(124),
  /* template */
  __webpack_require__(370),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 276 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(253)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(125),
  /* template */
  __webpack_require__(365),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 277 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(223)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(126),
  /* template */
  __webpack_require__(328),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 278 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(232)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(129),
  /* template */
  __webpack_require__(339),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 279 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(227)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(130),
  /* template */
  __webpack_require__(332),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 280 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(237)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(131),
  /* template */
  __webpack_require__(345),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 281 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(219)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(133),
  /* template */
  __webpack_require__(324),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 282 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(239)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(135),
  /* template */
  __webpack_require__(347),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 283 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(230)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(136),
  /* template */
  __webpack_require__(337),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 284 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(238)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(137),
  /* template */
  __webpack_require__(346),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 285 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(254)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(138),
  /* template */
  __webpack_require__(366),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 286 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(265)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(139),
  /* template */
  __webpack_require__(381),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 287 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(222)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(142),
  /* template */
  __webpack_require__(327),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 288 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(231)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(143),
  /* template */
  __webpack_require__(338),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 289 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(229)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(146),
  /* template */
  __webpack_require__(336),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 290 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(241)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(150),
  /* template */
  __webpack_require__(349),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 291 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(249)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(152),
  /* template */
  __webpack_require__(360),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 292 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(258)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(153),
  /* template */
  __webpack_require__(371),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 293 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(248)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(154),
  /* template */
  __webpack_require__(359),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 294 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(268)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(156),
  /* template */
  __webpack_require__(385),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 295 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(225)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(157),
  /* template */
  __webpack_require__(330),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 296 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(245)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(158),
  /* template */
  __webpack_require__(356),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 297 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(243)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(159),
  /* template */
  __webpack_require__(353),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 298 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(226)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(160),
  /* template */
  __webpack_require__(331),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 299 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(264)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(161),
  /* template */
  __webpack_require__(380),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 300 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(266)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(162),
  /* template */
  __webpack_require__(383),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 301 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(164),
  /* template */
  __webpack_require__(372),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 302 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(233)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(165),
  /* template */
  __webpack_require__(340),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 303 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(166),
  /* template */
  __webpack_require__(361),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 304 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(236)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(167),
  /* template */
  __webpack_require__(343),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 305 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(168),
  /* template */
  __webpack_require__(386),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 306 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(169),
  /* template */
  __webpack_require__(352),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 307 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(170),
  /* template */
  __webpack_require__(351),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 308 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(171),
  /* template */
  __webpack_require__(333),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 309 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(224)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(172),
  /* template */
  __webpack_require__(329),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 310 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(173),
  /* template */
  __webpack_require__(364),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 311 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(259)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(174),
  /* template */
  __webpack_require__(373),
  /* scopeId */
  "data-v-b80da10c",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 312 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(175),
  /* template */
  __webpack_require__(334),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 313 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(260)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(176),
  /* template */
  __webpack_require__(374),
  /* scopeId */
  "data-v-b98a2c76",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 314 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(262)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(177),
  /* template */
  __webpack_require__(378),
  /* scopeId */
  "data-v-dccb33aa",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 315 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(250)
__webpack_require__(251)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(178),
  /* template */
  __webpack_require__(362),
  /* scopeId */
  "data-v-77256492",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 316 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(179),
  /* template */
  __webpack_require__(354),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 317 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(180),
  /* template */
  __webpack_require__(377),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 318 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(181),
  /* template */
  __webpack_require__(376),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 319 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(182),
  /* template */
  __webpack_require__(369),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 320 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(183),
  /* template */
  __webpack_require__(344),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 321 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(246)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(184),
  /* template */
  __webpack_require__(357),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 322 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(255)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(185),
  /* template */
  __webpack_require__(367),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 323 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(186),
  /* template */
  __webpack_require__(382),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 324 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-checkbox-group",
    class: _vm.classes
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-checkbox-group__label-text"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-checkbox-group__checkboxes"
  }, _vm._l((_vm.options), function(option, index) {
    return _c('ui-checkbox', {
      key: option[_vm.keys.id],
      staticClass: "ui-checkbox-group__checkbox",
      class: option[_vm.keys.class],
      attrs: {
        "box-position": _vm.boxPosition,
        "checked": _vm.isOptionCheckedByDefault(option),
        "color": _vm.color,
        "disabled": _vm.disabled || option[_vm.keys.disabled],
        "id": option[_vm.keys.id],
        "name": _vm.name || option[_vm.keys.name]
      },
      on: {
        "blur": _vm.onBlur,
        "change": function($event) {
          _vm.onChange(arguments, option)
        },
        "focus": _vm.onFocus
      },
      model: {
        value: (_vm.checkboxValues[index]),
        callback: function($$v) {
          var $$exp = _vm.checkboxValues,
            $$idx = index;
          if (!Array.isArray($$exp)) {
            _vm.checkboxValues[index] = $$v
          } else {
            $$exp.splice($$idx, 1, $$v)
          }
        }
      }
    }, [_vm._v(_vm._s(option[_vm.keys.label] || option))])
  })), _vm._v(" "), (_vm.hasFeedback) ? _c('div', {
    staticClass: "ui-checkbox-group__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-checkbox-group__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-checkbox-group__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}

/***/ }),
/* 325 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    ref: "button",
    staticClass: "ui-close-button",
    class: _vm.classes,
    attrs: {
      "aria-label": "Close",
      "type": "button",
      "disabled": _vm.disabled
    },
    on: {
      "click": _vm.onClick
    }
  }, [_c('div', {
    staticClass: "ui-close-button__icon"
  }, [_c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M18.984 6.422L13.406 12l5.578 5.578-1.406 1.406L12 13.406l-5.578 5.578-1.406-1.406L10.594 12 5.016 6.422l1.406-1.406L12 10.594l5.578-5.578z"
    }
  })])])], 1), _vm._v(" "), _c('span', {
    staticClass: "ui-close-button__focus-ring"
  }), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "button"
    }
  }) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 326 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    staticClass: "ui-icon",
    class: [_vm.iconSet, _vm.icon],
    attrs: {
      "aria-label": _vm.ariaLabel
    }
  }, [(_vm.useSvg) ? _c('svg', {
    staticClass: "ui-icon__svg"
  }, [_c('use', {
    attrs: {
      "xmlns:xlink": "http://www.w3.org/1999/xlink",
      "xlink:href": '#' + _vm.icon
    }
  })]) : _vm._t("default", [_vm._v(_vm._s(_vm.removeText ? null : _vm.icon))])], 2)
},staticRenderFns: []}

/***/ }),
/* 327 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('ul', {
    staticClass: "ui-menu",
    class: _vm.classes,
    attrs: {
      "role": "menu"
    }
  }, [_vm._l((_vm.options), function(option) {
    return _c('ui-menu-option', {
      attrs: {
        "disable-ripple": _vm.disableRipple,
        "disabled": option[_vm.keys.disabled],
        "icon-props": _vm.iconProps || option[_vm.keys.iconProps],
        "icon": _vm.hasIcons ? option[_vm.keys.icon] : null,
        "label": option[_vm.keys.type] === 'divider' ? null : option[_vm.keys.label] || option,
        "secondary-text": _vm.hasSecondaryText ? option[_vm.keys.secondaryText] : null,
        "type": option[_vm.keys.type]
      },
      nativeOn: {
        "click": function($event) {
          _vm.selectOption(option)
        },
        "keydown": [function($event) {
          if (_vm._k($event.keyCode, "enter", 13)) { return null; }
          $event.preventDefault();
          _vm.selectOption(option)
        }, function($event) {
          if (_vm._k($event.keyCode, "esc", 27)) { return null; }
          _vm.closeMenu($event)
        }]
      }
    }, [_vm._t("option", null, {
      option: option
    })], 2)
  }), _vm._v(" "), (_vm.containFocus) ? _c('div', {
    staticClass: "ui-menu__focus-redirector",
    attrs: {
      "tabindex": "0"
    },
    on: {
      "focus": _vm.redirectFocus
    }
  }) : _vm._e()], 2)
},staticRenderFns: []}

/***/ }),
/* 328 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "ui-autocomplete-suggestion",
    class: _vm.classes
  }, [_vm._t("default", [(_vm.type === 'simple') ? _c('div', {
    staticClass: "ui-autocomplete-suggestion__simple"
  }, [_vm._v("\n            " + _vm._s(_vm.suggestion[_vm.keys.label] || _vm.suggestion) + "\n        ")]) : _vm._e(), _vm._v(" "), (_vm.type === 'image') ? _c('div', {
    staticClass: "ui-autocomplete-suggestion__image"
  }, [_c('div', {
    staticClass: "ui-autocomplete-suggestion__image-object",
    style: (_vm.imageStyle)
  }), _vm._v(" "), _c('div', {
    staticClass: "ui-autocomplete-suggestion__image-text"
  }, [_vm._v(_vm._s(_vm.suggestion[_vm.keys.label]))])]) : _vm._e()])], 2)
},staticRenderFns: []}

/***/ }),
/* 329 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "context-menu-menu-container",
    style: (_vm.ctxStyle),
    attrs: {
      "context-menu": "",
      "id": _vm.id
    },
    on: {
      "click": function($event) {
        $event.stopPropagation();
      },
      "contextmenu": function($event) {
        $event.stopPropagation();
      }
    }
  }, [_c('div', {
    staticClass: "ctx open",
    staticStyle: {
      "background-color": "transparent"
    }
  }, [_vm._t("menu", [_c('ul', {
    staticClass: "context-menu-menu dropdown-menu",
    class: {
      'ctx-menu-right': _vm.align === 'right',
        'ctx-menu-left': _vm.align === 'left'
    },
    attrs: {
      "role": "menu"
    }
  }, [_vm._t("default")], 2)])], 2)])
},staticRenderFns: []}

/***/ }),
/* 330 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "ui-switch",
    class: _vm.classes
  }, [_c('div', {
    staticClass: "ui-switch__input-wrapper"
  }, [_c('input', {
    staticClass: "ui-switch__input",
    attrs: {
      "type": "checkbox",
      "disabled": _vm.disabled,
      "name": _vm.name
    },
    domProps: {
      "checked": _vm.isChecked,
      "value": _vm.submittedValue
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "click": _vm.onClick,
      "focus": _vm.onFocus
    }
  }), _vm._v(" "), _vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "ui-switch__track"
  })]), _vm._v(" "), (_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-switch__label-text"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e()])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-switch__thumb"
  }, [_c('div', {
    staticClass: "ui-switch__focus-ring"
  })])
}]}

/***/ }),
/* 331 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-tabs",
    class: _vm.classes
  }, [_c('div', {
    staticClass: "ui-tabs__header"
  }, [_c('ul', {
    ref: "tabsContainer",
    staticClass: "ui-tabs__header-items",
    attrs: {
      "role": "tablist"
    }
  }, _vm._l((_vm.tabs), function(tab) {
    return _c('ui-tab-header-item', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (tab.show),
        expression: "tab.show"
      }],
      ref: "tabElements",
      refInFor: true,
      attrs: {
        "active": _vm.activeTabId === tab.id,
        "disable-ripple": _vm.disableRipple,
        "disabled": tab.disabled,
        "icon-props": tab.iconProps,
        "icon": tab.icon,
        "id": tab.id,
        "show": tab.show,
        "title": tab.title,
        "type": _vm.type
      },
      nativeOn: {
        "click": function($event) {
          _vm.selectTab($event, tab)
        },
        "keydown": [function($event) {
          if ($event.button !== 0) { return null; }
          _vm.selectPreviousTab($event)
        }, function($event) {
          if ($event.button !== 2) { return null; }
          _vm.selectNextTab($event)
        }]
      }
    }, [(tab.$slots.icon) ? _c('render-vnodes', {
      attrs: {
        "nodes": tab.$slots.icon
      },
      slot: "icon"
    }) : _vm._e()], 1)
  })), _vm._v(" "), (_vm.tabContainerWidth != 0) ? _c('div', {
    staticClass: "ui-tabs__active-tab-indicator",
    style: ({
      'left': _vm.indicatorLeft,
      'right': _vm.indicatorRight
    })
  }) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "ui-tabs__body"
  }, [_vm._t("default")], 2)])
},staticRenderFns: []}

/***/ }),
/* 332 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-calendar-month"
  }, [_c('div', {
    staticClass: "ui-calendar-month__header"
  }, _vm._l((_vm.lang.days.initials), function(day) {
    return _c('span', [_vm._v(_vm._s(day))])
  })), _vm._v(" "), _c('div', {
    ref: "current",
    staticClass: "ui-calendar-month__week is-current",
    class: _vm.weekClasses,
    on: {
      "transitionend": _vm.onTransitionEnd
    }
  }, _vm._l((_vm.currentWeekStartDates), function(date, index) {
    return _c('ui-calendar-week', {
      key: index,
      attrs: {
        "date-filter": _vm.dateFilter,
        "max-date": _vm.maxDate,
        "min-date": _vm.minDate,
        "month": _vm.currentWeekStartDates[1].getMonth(),
        "selected": _vm.selected,
        "week-start": date
      },
      on: {
        "date-select": _vm.onDateSelect
      }
    })
  })), _vm._v(" "), _c('div', {
    ref: "other",
    staticClass: "ui-calendar-month__week is-other",
    class: _vm.weekClasses
  }, _vm._l((_vm.otherWeekStartDates), function(date, index) {
    return _c('ui-calendar-week', {
      key: index,
      attrs: {
        "max-date": _vm.maxDate,
        "min-date": _vm.minDate,
        "month": _vm.otherWeekStartDates[1].getMonth(),
        "selected": _vm.selected,
        "visible": false,
        "week-start": date
      },
      on: {
        "date-select": _vm.onDateSelect
      }
    })
  }))])
},staticRenderFns: []}

/***/ }),
/* 333 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('ul', {
    staticClass: "collection",
    class: _vm.classes
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 334 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "drag-zone"
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 335 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-popover",
    class: {
      'is-raised': _vm.raised
    },
    attrs: {
      "role": "dialog",
      "tabindex": "-1"
    },
    on: {
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        _vm.closeDropdown($event)
      }
    }
  }, [_vm._t("default"), _vm._v(" "), _c('div', {
    staticClass: "ui-popover__focus-redirector",
    attrs: {
      "tabindex": "0"
    },
    on: {
      "focus": _vm.restrictFocus
    }
  })], 2)
},staticRenderFns: []}

/***/ }),
/* 336 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-preloader",
    class: {
      'is-loading': _vm.show
    }
  }, [_c('div', {
    staticClass: "ui-preloader__progressbar",
    attrs: {
      "role": "progressbar",
      "aria-busy": _vm.show ? 'true' : false
    }
  })])
},staticRenderFns: []}

/***/ }),
/* 337 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-confirm"
  }, [_c('ui-modal', {
    ref: "modal",
    attrs: {
      "role": "alertdialog",
      "dismiss-on": _vm.dismissOn,
      "dismissible": !_vm.loading,
      "title": _vm.title,
      "transition": _vm.transition
    },
    on: {
      "close": _vm.onModalClose,
      "open": _vm.onModalOpen
    }
  }, [_c('div', {
    staticClass: "ui-confirm__message"
  }, [_vm._t("default")], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-confirm__footer",
    slot: "footer"
  }, [_c('ui-button', {
    ref: "confirmButton",
    attrs: {
      "color": _vm.confirmButtonColor,
      "icon": _vm.confirmButtonIcon,
      "loading": _vm.loading
    },
    on: {
      "click": _vm.confirm
    }
  }, [_vm._v(_vm._s(_vm.confirmButtonText))]), _vm._v(" "), _c('ui-button', {
    ref: "denyButton",
    attrs: {
      "disabled": _vm.loading,
      "icon": _vm.denyButtonIcon
    },
    on: {
      "click": _vm.deny
    }
  }, [_vm._v(_vm._s(_vm.denyButtonText))])], 1)])], 1)
},staticRenderFns: []}

/***/ }),
/* 338 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    ref: "menuOption",
    staticClass: "ui-menu-option",
    class: _vm.classes,
    attrs: {
      "role": "menu-item",
      "tabindex": (_vm.isDivider || _vm.disabled) ? null : '0'
    }
  }, [(!_vm.isDivider) ? _vm._t("default", [_c('div', {
    staticClass: "ui-menu-option__content"
  }, [(_vm.icon) ? _c('ui-icon', {
    staticClass: "ui-menu-option__icon",
    attrs: {
      "icon-set": _vm.iconProps.iconSet,
      "icon": _vm.icon,
      "remove-text": _vm.iconProps.removeText,
      "use-svg": _vm.iconProps.useSvg
    }
  }) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-menu-option__text"
  }, [_vm._v(_vm._s(_vm.label))]), _vm._v(" "), (_vm.secondaryText) ? _c('div', {
    staticClass: "ui-menu-option__secondary-text"
  }, [_vm._v("\n                " + _vm._s(_vm.secondaryText) + "\n            ")]) : _vm._e()], 1)]) : _vm._e(), _vm._v(" "), (!_vm.disabled && !_vm.isDivider && !_vm.disableRipple) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "menuOption"
    }
  }) : _vm._e()], 2)
},staticRenderFns: []}

/***/ }),
/* 339 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-calendar-controls"
  }, [_c('ui-icon-button', {
    staticClass: "ui-calendar-controls__nav-button",
    attrs: {
      "icon": "keyboard_arrow_left",
      "type": "secondary",
      "disabled": _vm.previousMonthDisabled
    },
    on: {
      "click": _vm.goToPreviousMonth
    }
  }, [_c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M15.422 16.078l-1.406 1.406-6-6 6-6 1.406 1.406-4.594 4.594z"
    }
  })])])], 1), _vm._v(" "), _c('div', {
    staticClass: "ui-calendar-controls__month-and-year"
  }, [_vm._v(_vm._s(_vm.monthAndYear))]), _vm._v(" "), _c('ui-icon-button', {
    staticClass: "ui-calendar-controls__nav-button",
    attrs: {
      "icon": "keyboard_arrow_right",
      "type": "secondary",
      "disabled": _vm.nextMonthDisabled
    },
    on: {
      "click": _vm.goToNextMonth
    }
  }, [_c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M8.578 16.36l4.594-4.595L8.578 7.17l1.406-1.405 6 6-6 6z"
    }
  })])])], 1)], 1)
},staticRenderFns: []}

/***/ }),
/* 340 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "nprogress-container"
  })
},staticRenderFns: []}

/***/ }),
/* 341 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": _vm.disableTransition ? null : 'ui-progress-circular--transition-fade'
    }
  }, [_c('div', {
    staticClass: "ui-progress-circular",
    class: _vm.classes,
    style: ({
      'width': _vm.size + 'px',
      'height': _vm.size + 'px'
    })
  }, [(_vm.type === 'determinate') ? _c('svg', {
    staticClass: "ui-progress-circular__determinate",
    attrs: {
      "role": "progressbar",
      "aria-valuemax": 100,
      "aria-valuemin": 0,
      "aria-valuenow": _vm.progress,
      "height": _vm.size,
      "width": _vm.size
    }
  }, [_c('circle', {
    staticClass: "ui-progress-circular__determinate-path",
    style: ({
      'stroke-dashoffset': _vm.strokeDashOffset,
      'stroke-width': _vm.calculatedStroke
    }),
    attrs: {
      "fill": "transparent",
      "stroke-dashoffset": "0",
      "cx": _vm.size / 2,
      "cy": _vm.size / 2,
      "r": _vm.radius,
      "stroke-dasharray": _vm.strokeDashArray
    }
  })]) : _c('svg', {
    staticClass: "ui-progress-circular__indeterminate",
    attrs: {
      "role": "progressbar",
      "viewBox": "25 25 50 50",
      "aria-valuemax": 100,
      "aria-valuemin": 0
    }
  }, [_c('circle', {
    staticClass: "ui-progress-circular__indeterminate-path",
    attrs: {
      "cx": "50",
      "cy": "50",
      "fill": "none",
      "r": "20",
      "stroke-miterlimit": "10",
      "stroke-width": _vm.calculatedStroke
    }
  })])])])
},staticRenderFns: []}

/***/ }),
/* 342 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    ref: "button",
    staticClass: "ui-button",
    class: _vm.classes,
    attrs: {
      "disabled": _vm.disabled || _vm.loading,
      "type": _vm.buttonType
    },
    on: {
      "click": _vm.onClick,
      "~focus": function($event) {
        _vm.onFocus($event)
      }
    }
  }, [_c('div', {
    staticClass: "ui-button__content"
  }, [(_vm.icon || _vm.$slots.icon) ? _c('div', {
    staticClass: "ui-button__icon"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _vm._t("default"), _vm._v(" "), (_vm.hasDropdown && _vm.iconPosition !== 'right') ? _c('ui-icon', {
    staticClass: "ui-button__dropdown-icon"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M6.984 9.984h10.03L12 15z"
    }
  })])]) : _vm._e()], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-button__focus-ring",
    style: (_vm.focusRingStyle)
  }), _vm._v(" "), _c('ui-progress-circular', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.loading),
      expression: "loading"
    }],
    staticClass: "ui-button__progress",
    attrs: {
      "disable-transition": "",
      "color": _vm.progressColor,
      "size": 18,
      "stroke": 4.5
    }
  }), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "button"
    }
  }) : _vm._e(), _vm._v(" "), (_vm.hasDropdown) ? _c('ui-popover', {
    ref: "dropdown",
    attrs: {
      "trigger": "button",
      "dropdown-position": _vm.dropdownPosition,
      "open-on": _vm.openDropdownOn
    },
    on: {
      "close": _vm.onDropdownClose,
      "open": _vm.onDropdownOpen
    }
  }, [_vm._t("dropdown")], 2) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 343 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "centered-container",
    class: {
      'centered-container-full-screeen': _vm.fullScreen === true
    }
  }, [_c('div', {
    staticClass: "centered"
  }, [_vm._t("default")], 2)])
},staticRenderFns: []}

/***/ }),
/* 344 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('drag-handle', {
    style: ({
      width: '20px',
      left: _vm.right ? null : '0',
      right: _vm.right ? '0' : null
    }),
    attrs: {
      "disabled": _vm.opened || _vm.isFixed,
      "max-right": _vm.right ? null : _vm.width,
      "max-left": _vm.right ? _vm.width : null,
      "z-index": _vm.overlayZIndex
    },
    on: {
      "move": _vm.move,
      "max": function($event) {
        _vm.open(false)
      },
      "aborted": _vm.hide
    }
  }), _vm._v(" "), _c('drag-handle', {
    style: ({
      left: '0',
      right: '0'
    }),
    attrs: {
      "disabled": !_vm.opened || _vm.isFixed,
      "max-right": _vm.right ? _vm.width : null,
      "max-left": _vm.right ? null : _vm.width,
      "offset": _vm.right ? -_vm.width : _vm.width,
      "z-index": _vm.overlayZIndex
    },
    on: {
      "move": _vm.move,
      "max": function($event) {
        _vm.close(false)
      },
      "aborted": _vm.show,
      "clean-click": _vm.dismiss
    }
  }), _vm._v(" "), _c('ul', {
    ref: "nav",
    class: _vm.computedClass,
    style: (_vm.computedStyle),
    attrs: {
      "id": _vm.id
    },
    on: {
      "click": _vm.onClick,
      "keyup": function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        _vm.dismiss($event)
      }
    }
  }, [_vm._t("default")], 2)], 1)
},staticRenderFns: []}

/***/ }),
/* 345 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-calendar-week"
  }, _vm._l((_vm.dates), function(date, index) {
    return _c('div', {
      key: index,
      staticClass: "ui-calendar-week__date",
      class: _vm.getDateClasses(date),
      attrs: {
        "tabindex": (_vm.visible && !_vm.isDateDisabled(date)) ? 0 : null
      },
      on: {
        "click": function($event) {
          _vm.selectDate(date)
        },
        "keydown": function($event) {
          if (_vm._k($event.keyCode, "enter", 13)) { return null; }
          _vm.selectDate(date)
        }
      }
    }, [_vm._v("\n        " + _vm._s(_vm.getDayOfMonth(date)) + "\n    ")])
  }))
},staticRenderFns: []}

/***/ }),
/* 346 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-datepicker",
    class: _vm.classes
  }, [_c('input', {
    staticClass: "ui-datepicker__hidden-input",
    attrs: {
      "type": "hidden",
      "name": _vm.name
    },
    domProps: {
      "value": _vm.submittedValue
    }
  }), _vm._v(" "), (_vm.icon || _vm.$slots.icon) ? _c('div', {
    staticClass: "ui-datepicker__icon-wrapper"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-datepicker__content"
  }, [_c('div', {
    ref: "label",
    staticClass: "ui-datepicker__label",
    attrs: {
      "tabindex": _vm.disabled ? null : '0'
    },
    on: {
      "click": _vm.onClick,
      "focus": _vm.onFocus,
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        $event.preventDefault();
        _vm.openPicker($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "space", 32)) { return null; }
        $event.preventDefault();
        _vm.openPicker($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "tab", 9)) { return null; }
        _vm.onBlur($event)
      }]
    }
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-datepicker__label-text",
    class: _vm.labelClasses
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-datepicker__display"
  }, [_c('div', {
    staticClass: "ui-datepicker__display-value",
    class: {
      'is-placeholder': !_vm.hasDisplayText
    }
  }, [_vm._v("\n                    " + _vm._s(_vm.hasDisplayText ? _vm.displayText : (_vm.hasFloatingLabel && _vm.isLabelInline) ? null : _vm.placeholder) + "\n                ")]), _vm._v(" "), (_vm.usesPopover && !_vm.disabled) ? _c('ui-icon', {
    staticClass: "ui-datepicker__dropdown-button"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M6.984 9.984h10.03L12 15z"
    }
  })])]) : _vm._e()], 1)]), _vm._v(" "), (_vm.hasFeedback) ? _c('div', {
    staticClass: "ui-datepicker__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-datepicker__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-datepicker__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e()]) : _vm._e()]), _vm._v(" "), (_vm.usesModal && !_vm.disabled) ? _c('ui-modal', {
    ref: "modal",
    attrs: {
      "remove-header": ""
    },
    on: {
      "close": _vm.onPickerClose,
      "open": _vm.onPickerOpen
    }
  }, [_c('ui-calendar', {
    attrs: {
      "color": _vm.color,
      "date-filter": _vm.dateFilter,
      "lang": _vm.lang,
      "max-date": _vm.maxDate,
      "min-date": _vm.minDate,
      "orientation": _vm.orientation,
      "value": _vm.value
    },
    on: {
      "date-select": _vm.onDateSelect
    }
  }, [_c('div', {
    staticClass: "ui-datepicker__modal-buttons",
    slot: "footer"
  }, [_c('ui-button', {
    attrs: {
      "type": "secondary",
      "color": _vm.color
    },
    on: {
      "click": function($event) {
        _vm.$refs.modal.close()
      }
    }
  }, [_vm._v(_vm._s(_vm.okButtonText))]), _vm._v(" "), _c('ui-button', {
    attrs: {
      "type": "secondary",
      "color": _vm.color
    },
    on: {
      "click": _vm.onPickerCancel
    }
  }, [_vm._v(_vm._s(_vm.cancelButtonText))])], 1)])], 1) : _vm._e(), _vm._v(" "), (_vm.usesPopover && !_vm.disabled) ? _c('ui-popover', {
    ref: "popover",
    attrs: {
      "contain-focus": "",
      "trigger": "label"
    },
    on: {
      "close": _vm.onPickerClose,
      "open": _vm.onPickerOpen
    }
  }, [_c('ui-calendar', {
    attrs: {
      "color": _vm.color,
      "date-filter": _vm.dateFilter,
      "lang": _vm.lang,
      "max-date": _vm.maxDate,
      "min-date": _vm.minDate,
      "orientation": _vm.orientation,
      "value": _vm.value
    },
    on: {
      "date-select": _vm.onDateSelect
    }
  })], 1) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 347 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-collapsible",
    class: _vm.classes
  }, [_c('div', {
    ref: "header",
    staticClass: "ui-collapsible__header",
    attrs: {
      "aria-controls": _vm.id,
      "aria-expanded": _vm.isOpen ? 'true' : 'false',
      "tabindex": _vm.disabled ? null : 0
    },
    on: {
      "click": _vm.toggleCollapsible,
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        $event.preventDefault();
        _vm.toggleCollapsible($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "space", 32)) { return null; }
        $event.preventDefault();
        _vm.toggleCollapsible($event)
      }]
    }
  }, [_c('div', {
    staticClass: "ui-collapsible__header-content"
  }, [_vm._t("header", [_vm._v(_vm._s(_vm.title))])], 2), _vm._v(" "), (!_vm.removeIcon) ? _c('ui-icon', {
    staticClass: "ui-collapsible__header-icon"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M7.406 7.828L12 12.422l4.594-4.594L18 9.234l-6 6-6-6z"
    }
  })])]) : _vm._e(), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled && _vm.isReady) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "header"
    }
  }) : _vm._e()], 1), _vm._v(" "), _c('transition', {
    attrs: {
      "name": "ui-collapsible--transition-toggle"
    },
    on: {
      "after-enter": _vm.onEnter,
      "after-leave": _vm.onLeave
    }
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.isOpen),
      expression: "isOpen"
    }],
    ref: "body",
    staticClass: "ui-collapsible__body-wrapper",
    style: ({
      'height': _vm.calculatedHeight
    })
  }, [_c('div', {
    staticClass: "ui-collapsible__body",
    attrs: {
      "aria-hidden": _vm.isOpen ? null : 'true',
      "id": _vm.id
    }
  }, [_vm._t("default")], 2)])])], 1)
},staticRenderFns: []}

/***/ }),
/* 348 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    ref: "tooltip",
    staticClass: "ui-tooltip"
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 349 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-radio-group",
    class: _vm.classes
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-radio-group__label-text"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-radio-group__radios"
  }, _vm._l((_vm.options), function(option) {
    return _c('ui-radio', {
      key: option[_vm.keys.id],
      staticClass: "ui-radio-group__radio",
      class: option[_vm.keys.class],
      attrs: {
        "button-position": _vm.buttonPosition,
        "checked": _vm.isOptionCheckedByDefault(option),
        "color": _vm.color,
        "disabled": _vm.disabled || option[_vm.keys.disabled],
        "id": option[_vm.keys.id],
        "name": _vm.name,
        "true-value": option[_vm.keys.value] || option
      },
      on: {
        "blur": _vm.onBlur,
        "focus": _vm.onFocus
      },
      model: {
        value: (_vm.selectedOptionValue),
        callback: function($$v) {
          _vm.selectedOptionValue = $$v
        }
      }
    }, [_vm._v(_vm._s(option[_vm.keys.label] || option))])
  })), _vm._v(" "), (_vm.hasFeedback) ? _c('div', {
    staticClass: "ui-radio-group__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-radio-group__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-radio-group__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}

/***/ }),
/* 350 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-ripple-ink"
  })
},staticRenderFns: []}

/***/ }),
/* 351 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    class: _vm.classes,
    attrs: {
      "href": "#!"
    }
  }, [_vm._t("default"), _vm._v(" "), _c('a', {
    staticClass: "secondary-content",
    attrs: {
      "href": "#!"
    }
  }, [_vm._t("secondary")], 2)], 2)
},staticRenderFns: []}

/***/ }),
/* 352 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    class: _vm.classes
  }, [_vm._t("default"), _vm._v(" "), _c('a', {
    staticClass: "secondary-content",
    attrs: {
      "href": "#!"
    }
  }, [_vm._t("secondary")], 2)], 2)
},staticRenderFns: []}

/***/ }),
/* 353 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    ref: "headerItem",
    staticClass: "ui-tab-header-item",
    class: _vm.classes,
    attrs: {
      "role": "tab",
      "aria-controls": _vm.id,
      "aria-selected": _vm.active ? 'true' : null,
      "disabled": _vm.disabled,
      "tabindex": _vm.active ? 0 : -1
    }
  }, [(_vm.type === 'icon' || _vm.type === 'icon-and-text') ? _c('div', {
    staticClass: "ui-tab-header-item__icon"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon-set": _vm.iconProps.iconSet,
      "icon": _vm.icon,
      "remove-text": _vm.iconProps.removeText,
      "use-svg": _vm.iconProps.useSvg
    }
  })])], 2) : _vm._e(), _vm._v(" "), (_vm.type === 'text' || _vm.type === 'icon-and-text') ? _c('div', {
    staticClass: "ui-tab-header-item__text"
  }, [_vm._v(_vm._s(_vm.title))]) : _vm._e(), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "headerItem"
    }
  }) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 354 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.loading),
      expression: "loading"
    }],
    staticClass: "v-spinner"
  }, [_c('div', {
    staticClass: "v-beat v-beat-odd",
    style: (_vm.spinnerStyle)
  }), _vm._v(" "), _c('div', {
    staticClass: "v-beat v-beat-even",
    style: (_vm.spinnerStyle)
  }), _vm._v(" "), _c('div', {
    staticClass: "v-beat v-beat-odd",
    style: (_vm.spinnerStyle)
  })])
},staticRenderFns: []}

/***/ }),
/* 355 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "ui-radio",
    class: _vm.classes,
    on: {
      "click": _vm.toggleCheck
    }
  }, [_c('div', {
    staticClass: "ui-radio__input-wrapper"
  }, [_c('input', {
    staticClass: "ui-radio__input",
    attrs: {
      "type": "radio",
      "disabled": _vm.disabled,
      "name": _vm.name
    },
    domProps: {
      "value": _vm.trueValue
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "focus": _vm.onFocus
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ui-radio__focus-ring"
  }), _vm._v(" "), _c('span', {
    staticClass: "ui-radio__outer-circle"
  }), _vm._v(" "), _c('span', {
    staticClass: "ui-radio__inner-circle"
  })]), _vm._v(" "), (_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-radio__label-text"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e()])
},staticRenderFns: []}

/***/ }),
/* 356 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show && _vm.isActive),
      expression: "show && isActive"
    }],
    staticClass: "ui-tab",
    attrs: {
      "role": "tabpanel",
      "aria-hidden": !_vm.isActive ? 'true' : null,
      "id": _vm.id,
      "tabindex": _vm.isActive ? '0' : null
    }
  }, [_c('div', {
    staticStyle: {
      "display": "none"
    }
  }, [_vm._t("icon")], 2), _vm._v(" "), _vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 357 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": "fade"
    }
  }, [_c('div', [_c('nprogress-container'), _vm._v(" "), _vm._t("default")], 2)])
},staticRenderFns: []}

/***/ }),
/* 358 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "ui-checkbox",
    class: _vm.classes
  }, [_c('input', {
    staticClass: "ui-checkbox__input",
    attrs: {
      "type": "checkbox",
      "disabled": _vm.disabled,
      "name": _vm.name
    },
    domProps: {
      "checked": _vm.isChecked,
      "value": _vm.submittedValue
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "click": _vm.onClick,
      "focus": _vm.onFocus
    }
  }), _vm._v(" "), _vm._m(0), _vm._v(" "), (_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-checkbox__label-text"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e()])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-checkbox__checkmark"
  }, [_c('div', {
    staticClass: "ui-checkbox__focus-ring"
  })])
}]}

/***/ }),
/* 359 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-slider",
    class: _vm.classes,
    attrs: {
      "role": "slider",
      "aria-valuemax": 100,
      "aria-valuemin": 0,
      "aria-valuenow": _vm.localValue,
      "tabindex": _vm.disabled ? null : 0
    },
    on: {
      "blur": _vm.onBlur,
      "focus": _vm.onFocus,
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "down", 40)) { return null; }
        $event.preventDefault();
        _vm.decrementValue($event)
      }, function($event) {
        if ($event.button !== 0) { return null; }
        $event.preventDefault();
        _vm.decrementValue($event)
      }, function($event) {
        if ($event.button !== 2) { return null; }
        $event.preventDefault();
        _vm.incrementValue($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "up", 38)) { return null; }
        $event.preventDefault();
        _vm.incrementValue($event)
      }]
    }
  }, [(_vm.name) ? _c('input', {
    staticClass: "ui-slider__hidden-input",
    attrs: {
      "type": "hidden",
      "name": _vm.name
    },
    domProps: {
      "value": _vm.value
    }
  }) : _vm._e(), _vm._v(" "), (_vm.hasIcon) ? _c('div', {
    staticClass: "ui-slider__icon"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    ref: "track",
    staticClass: "ui-slider__track",
    on: {
      "mousedown": _vm.onDragStart,
      "touchstart": _vm.onDragStart
    }
  }, [_c('div', {
    staticClass: "ui-slider__track-background"
  }, _vm._l((_vm.snapPoints), function(point) {
    return (_vm.snapToSteps) ? _c('span', {
      staticClass: "ui-slider__snap-point",
      style: ({
        left: point + '%'
      })
    }) : _vm._e()
  })), _vm._v(" "), _c('div', {
    staticClass: "ui-slider__track-fill",
    style: (_vm.fillStyle)
  }), _vm._v(" "), _c('div', {
    ref: "thumb",
    staticClass: "ui-slider__thumb",
    style: (_vm.thumbStyle)
  }, [(_vm.showMarker) ? _c('div', {
    staticClass: "ui-slider__marker"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "viewBox": "0 0 24 24",
      "width": "36",
      "height": "36"
    }
  }, [_c('path', {
    attrs: {
      "d": "M11 .5c-1.7.2-3.4.9-4.7 2-1.1.9-2 2-2.5 3.2-1.2 2.4-1.2 5.1-.1 7.7 1.1 2.6 2.8 5 5.3 7.5 1.2 1.2 2.8 2.7 3 2.7 0 0 .3-.2.6-.5 3.2-2.7 5.6-5.6 7.1-8.5.8-1.5 1.1-2.6 1.3-3.8.2-1.4 0-2.9-.5-4.3-1.2-3.2-4.1-5.4-7.5-5.8-.5-.2-1.5-.2-2-.2z"
    }
  })]), _vm._v(" "), _c('span', {
    staticClass: "ui-slider__marker-text"
  }, [_vm._v(_vm._s(_vm.markerText))])]) : _vm._e()])])])
},staticRenderFns: []}

/***/ }),
/* 360 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-select",
    class: _vm.classes
  }, [(_vm.name) ? _c('input', {
    staticClass: "ui-select__hidden-input",
    attrs: {
      "type": "hidden",
      "name": _vm.name
    },
    domProps: {
      "value": _vm.submittedValue
    }
  }) : _vm._e(), _vm._v(" "), (_vm.icon || _vm.$slots.icon) ? _c('div', {
    staticClass: "ui-select__icon-wrapper"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-select__content"
  }, [_c('div', {
    ref: "label",
    staticClass: "ui-select__label",
    attrs: {
      "tabindex": _vm.disabled ? null : '0'
    },
    on: {
      "click": _vm.toggleDropdown,
      "focus": _vm.onFocus,
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        $event.preventDefault();
        _vm.openDropdown($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "space", 32)) { return null; }
        $event.preventDefault();
        _vm.openDropdown($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "tab", 9)) { return null; }
        _vm.onBlur($event)
      }]
    }
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-select__label-text",
    class: _vm.labelClasses
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-select__display"
  }, [_c('div', {
    staticClass: "ui-select__display-value",
    class: {
      'is-placeholder': !_vm.hasDisplayText
    }
  }, [_vm._v("\n                    " + _vm._s(_vm.hasDisplayText ? _vm.displayText : (_vm.hasFloatingLabel && _vm.isLabelInline) ? null : _vm.placeholder) + "\n                ")]), _vm._v(" "), _c('ui-icon', {
    staticClass: "ui-select__dropdown-button"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M6.984 9.984h10.03L12 15z"
    }
  })])])], 1), _vm._v(" "), _c('transition', {
    attrs: {
      "name": "ui-select--transition-fade"
    }
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.showDropdown),
      expression: "showDropdown"
    }],
    ref: "dropdown",
    staticClass: "ui-select__dropdown",
    attrs: {
      "tabindex": "-1"
    },
    on: {
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "down", 40)) { return null; }
        $event.preventDefault();
        _vm.highlightOption(_vm.highlightedIndex + 1)
      }, function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        $event.preventDefault();
        $event.stopPropagation();
        _vm.selectHighlighted(_vm.highlightedIndex, $event)
      }, function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        $event.preventDefault();
        _vm.closeDropdown()
      }, function($event) {
        if (_vm._k($event.keyCode, "tab", 9)) { return null; }
        _vm.onBlur($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "up", 38)) { return null; }
        $event.preventDefault();
        _vm.highlightOption(_vm.highlightedIndex - 1)
      }]
    }
  }, [(_vm.hasSearch) ? _c('div', {
    staticClass: "ui-select__search",
    on: {
      "click": function($event) {
        $event.stopPropagation();
      },
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "space", 32)) { return null; }
        $event.stopPropagation();
      }
    }
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.query),
      expression: "query"
    }],
    ref: "searchInput",
    staticClass: "ui-select__search-input",
    attrs: {
      "autocomplete": "off",
      "type": "text",
      "placeholder": _vm.searchPlaceholder
    },
    domProps: {
      "value": (_vm.query)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.query = $event.target.value
      }
    }
  }), _vm._v(" "), _c('ui-icon', {
    staticClass: "ui-select__search-icon"
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M9.516 14.016c2.484 0 4.5-2.016 4.5-4.5s-2.016-4.5-4.5-4.5-4.5 2.016-4.5 4.5 2.016 4.5 4.5 4.5zm6 0l4.97 4.97-1.5 1.5-4.97-4.97v-.797l-.28-.282c-1.126.984-2.626 1.547-4.22 1.547-3.61 0-6.516-2.86-6.516-6.47S5.906 3 9.516 3s6.47 2.906 6.47 6.516c0 1.594-.564 3.094-1.548 4.22l.28.28h.798z"
    }
  })])]), _vm._v(" "), _c('ui-progress-circular', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.loading),
      expression: "loading"
    }],
    staticClass: "ui-select__search-progress",
    attrs: {
      "size": 20,
      "stroke": 4
    }
  })], 1) : _vm._e(), _vm._v(" "), _c('ul', {
    ref: "optionsList",
    staticClass: "ui-select__options"
  }, [_vm._l((_vm.filteredOptions), function(option, index) {
    return _c('ui-select-option', {
      ref: "options",
      refInFor: true,
      attrs: {
        "highlighted": _vm.highlightedIndex === index,
        "keys": _vm.keys,
        "multiple": _vm.multiple,
        "option": option,
        "selected": _vm.isOptionSelected(option),
        "type": _vm.type
      },
      nativeOn: {
        "click": function($event) {
          $event.stopPropagation();
          _vm.selectOption(option, index)
        },
        "mouseover": function($event) {
          $event.stopPropagation();
          _vm.highlightOption(index, {
            autoScroll: false
          })
        }
      }
    }, [_vm._t("option", null, {
      highlighted: _vm.highlightedIndex === index,
      index: index,
      option: option,
      selected: _vm.isOptionSelected(option)
    })], 2)
  }), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.hasNoResults),
      expression: "hasNoResults"
    }],
    staticClass: "ui-select__no-results"
  }, [_vm._t("no-results", [_vm._v("No results found")])], 2)], 2)])])], 1), _vm._v(" "), (_vm.hasFeedback) ? _c('div', {
    staticClass: "ui-select__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-select__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-select__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e()]) : _vm._e()])])
},staticRenderFns: []}

/***/ }),
/* 361 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "vuelation-affix",
    style: (_vm.affixedStyles)
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 362 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('header', {
    staticClass: "c-header"
  }, [_c('div', {
    staticClass: "header-inner"
  }, [(_vm.showLogo) ? _c('div', {
    staticClass: "logo",
    class: _vm.logoClass
  }, [_vm._t("logo", [_c('h1', {
    on: {
      "click": _vm.handleLogoClick
    }
  }, [_vm._v(_vm._s(_vm.logoText))]), _vm._v(" "), _c('span', {
    staticClass: "logo-beta-text"
  }, [_vm._v("Beta")])]), _vm._v(" "), (_vm.showToggle && _vm.md) ? _c('div', {
    staticClass: "sidebar-toggle-desktop",
    on: {
      "click": _vm.toggleSidebar
    }
  }) : _vm._e()], 2) : _vm._e(), _vm._v(" "), (_vm.showToggle) ? _c('a', {
    staticClass: "sidebar-toggle-mobile",
    attrs: {
      "href": "#"
    },
    on: {
      "click": _vm.toggleSidebar
    }
  }) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "header-menu"
  }, [(_vm.isDropdown) ? _c('ui-button', {
    attrs: {
      "type": "secondary",
      "has-dropdown": "",
      "size": "large"
    },
    on: {
      "dropdown-open": _vm.dropdownOpen
    }
  }, [_c('span', [_vm._v("MENU")]), _vm._v(" "), _c('nav', {
    ref: "dropdown",
    staticClass: "nav nav-header nav-header-dropdown",
    slot: "dropdown"
  }, [_vm._t("menu")], 2)]) : _vm._e(), _vm._v(" "), (!_vm.isDropdown) ? _c('ul', {
    staticClass: "nav nav-header nav-header-horizontal"
  }, [_vm._t("menu")], 2) : _vm._e()], 1)]), _vm._v(" "), _vm._t("after")], 2)
},staticRenderFns: []}

/***/ }),
/* 363 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": _vm.transitionName
    },
    on: {
      "after-enter": _vm.onEnter,
      "after-leave": _vm.onLeave
    }
  }, [_c('div', {
    staticClass: "ui-snackbar",
    on: {
      "click": _vm.onClick
    }
  }, [_c('div', {
    staticClass: "ui-snackbar__message"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.message))])], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-snackbar__action"
  }, [(_vm.action) ? _c('ui-button', {
    staticClass: "ui-snackbar__action-button",
    attrs: {
      "type": "secondary",
      "color": _vm.actionColor
    },
    on: {
      "click": function($event) {
        $event.stopPropagation();
        _vm.onActionClick($event)
      }
    }
  }, [_vm._v(_vm._s(_vm.action))]) : _vm._e()], 1)])])
},staticRenderFns: []}

/***/ }),
/* 364 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('v-touch', {
    on: {
      "pan": _vm.onPan
    }
  }, [(!_vm.disabled) ? _c('div', {
    staticClass: "drag-handle",
    class: _vm.computedClass,
    style: (_vm.computedStyle),
    attrs: {
      "id": _vm.id
    },
    on: {
      "click": _vm.click
    }
  }) : _vm._e()])
},staticRenderFns: []}

/***/ }),
/* 365 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-autocomplete",
    class: _vm.classes
  }, [(_vm.icon || _vm.$slots.icon) ? _c('div', {
    staticClass: "ui-autocomplete__icon-wrapper"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-autocomplete__content"
  }, [_c('label', {
    staticClass: "ui-autocomplete__label"
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-autocomplete__label-text",
    class: _vm.labelClasses
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), _c('ui-icon', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (!_vm.disabled && _vm.value.length),
      expression: "!disabled && value.length"
    }],
    staticClass: "ui-autocomplete__clear-button",
    attrs: {
      "title": "Clear"
    },
    nativeOn: {
      "click": function($event) {
        _vm.updateValue('')
      }
    }
  }, [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M18.984 6.422L13.406 12l5.578 5.578-1.406 1.406L12 13.406l-5.578 5.578-1.406-1.406L10.594 12 5.016 6.422l1.406-1.406L12 10.594l5.578-5.578z"
    }
  })])]), _vm._v(" "), _c('input', {
    directives: [{
      name: "autofocus",
      rawName: "v-autofocus",
      value: (_vm.autofocus),
      expression: "autofocus"
    }],
    ref: "input",
    staticClass: "ui-autocomplete__input",
    attrs: {
      "autocomplete": "off",
      "disabled": _vm.disabled,
      "name": _vm.name,
      "placeholder": _vm.hasFloatingLabel ? null : _vm.placeholder,
      "readonly": _vm.readonly ? _vm.readonly : null
    },
    domProps: {
      "value": _vm.value
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "focus": _vm.onFocus,
      "input": function($event) {
        _vm.updateValue($event.target.value)
      },
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "down", 40)) { return null; }
        $event.preventDefault();
        _vm.highlightSuggestion(_vm.highlightedIndex + 1)
      }, function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.selectHighlighted(_vm.highlightedIndex, $event)
      }, function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        _vm.closeDropdown($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "tab", 9)) { return null; }
        _vm.closeDropdown($event)
      }, function($event) {
        if (_vm._k($event.keyCode, "up", 38)) { return null; }
        $event.preventDefault();
        _vm.highlightSuggestion(_vm.highlightedIndex - 1)
      }]
    }
  }), _vm._v(" "), _c('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.showDropdown),
      expression: "showDropdown"
    }],
    staticClass: "ui-autocomplete__suggestions"
  }, _vm._l((_vm.matchingSuggestions), function(suggestion, index) {
    return _c('ui-autocomplete-suggestion', {
      ref: "suggestions",
      refInFor: true,
      attrs: {
        "highlighted": _vm.highlightedIndex === index,
        "keys": _vm.keys,
        "suggestion": suggestion,
        "type": _vm.type
      },
      nativeOn: {
        "click": function($event) {
          _vm.selectSuggestion(suggestion)
        }
      }
    }, [_vm._t("suggestion", null, {
      highlighted: _vm.highlightedIndex === index,
      index: index,
      suggestion: suggestion
    })], 2)
  }))], 1), _vm._v(" "), (_vm.hasFeedback) ? _c('div', {
    staticClass: "ui-autocomplete__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-autocomplete__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-autocomplete__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e()]) : _vm._e()])])
},staticRenderFns: []}

/***/ }),
/* 366 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    ref: "button",
    staticClass: "ui-fab",
    class: _vm.classes,
    attrs: {
      "aria-label": _vm.ariaLabel || _vm.tooltip
    },
    on: {
      "click": _vm.onClick
    }
  }, [(_vm.icon || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-fab__icon"
  }, [_vm._t("default", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('span', {
    staticClass: "ui-fab__focus-ring"
  }), _vm._v(" "), (!_vm.disableRipple) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "button"
    }
  }) : _vm._e(), _vm._v(" "), (_vm.tooltip) ? _c('ui-tooltip', {
    attrs: {
      "trigger": "button",
      "open-on": _vm.openTooltipOn,
      "position": _vm.tooltipPosition
    }
  }, [_vm._v(_vm._s(_vm.tooltip))]) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 367 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    ref: "trigger"
  }, [_vm._t("default"), _vm._v(" "), _c('transition', {
    attrs: {
      "name": _vm.effect
    }
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.visible),
      expression: "visible"
    }],
    ref: "popover",
    class: ['tooltip', _vm.placement],
    staticStyle: {
      "display": "block"
    }
  }, [_c('div', {
    staticClass: "tooltip-arrow"
  }), _vm._v(" "), _c('div', {
    staticClass: "tooltip-inner",
    domProps: {
      "innerHTML": _vm._s(_vm.content)
    }
  }, [_vm._t("content")], 2)])])], 2)
},staticRenderFns: []}

/***/ }),
/* 368 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-calendar",
    class: _vm.classes
  }, [_c('div', {
    staticClass: "ui-calendar__header"
  }, [_c('div', {
    staticClass: "ui-calendar__header-year",
    class: {
      'is-active': _vm.showYearPicker
    },
    attrs: {
      "tabindex": "0"
    },
    on: {
      "click": function($event) {
        _vm.showYearPicker = true
      },
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.showYearPicker = true
      }
    }
  }, [_vm._v(_vm._s(_vm.headerYear))]), _vm._v(" "), _c('div', {
    staticClass: "ui-calendar__header-details",
    class: {
      'is-active': !_vm.showYearPicker
    },
    attrs: {
      "tabindex": "0"
    },
    on: {
      "click": function($event) {
        _vm.showYearPicker = false
      },
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.showYearPicker = false
      }
    }
  }, [_c('span', {
    staticClass: "ui-calendar__header-day"
  }, [_vm._v(_vm._s(_vm.headerDay) + ", ")]), _vm._v(" "), _c('span', {
    staticClass: "ui-calendar__header-date"
  }, [_vm._v(_vm._s(_vm.headerDate))])])]), _vm._v(" "), _c('div', {
    staticClass: "ui-calendar__body"
  }, [_c('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.showYearPicker),
      expression: "showYearPicker"
    }],
    ref: "years",
    staticClass: "ui-calendar__years"
  }, _vm._l((_vm.yearRange), function(year) {
    return (!_vm.isYearOutOfRange(year)) ? _c('li', {
      staticClass: "ui-calendar__year",
      class: _vm.getYearClasses(year),
      attrs: {
        "tabindex": "0"
      },
      on: {
        "click": function($event) {
          _vm.selectYear(year)
        },
        "keydown": function($event) {
          if (_vm._k($event.keyCode, "enter", 13)) { return null; }
          _vm.selectYear(year)
        }
      }
    }, [_vm._v(_vm._s(year))]) : _vm._e()
  })), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (!_vm.showYearPicker),
      expression: "!showYearPicker"
    }]
  }, [_c('ui-calendar-controls', {
    ref: "controls",
    attrs: {
      "date-in-view": _vm.dateInView,
      "lang": _vm.lang,
      "max-date": _vm.maxDate,
      "min-date": _vm.minDate
    },
    on: {
      "go-to-date": _vm.onGoToDate
    }
  }), _vm._v(" "), _c('ui-calendar-month', {
    ref: "month",
    attrs: {
      "date-filter": _vm.dateFilter,
      "date-in-view": _vm.dateInView,
      "lang": _vm.lang,
      "max-date": _vm.maxDate,
      "min-date": _vm.minDate,
      "selected": _vm.value
    },
    on: {
      "change": _vm.onMonthChange,
      "date-select": _vm.onDateSelect
    }
  })], 1), _vm._v(" "), (_vm.$slots.footer) ? _c('div', {
    staticClass: "ui-calendar__footer"
  }, [_vm._t("footer")], 2) : _vm._e()])])
},staticRenderFns: []}

/***/ }),
/* 369 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    class: {
      'open': _vm.open, 'active': _vm.active
    }
  }, [(_vm.hasChildren !== true) ? _c('a', {
    class: _vm.header ? ['subheader'] : [],
    attrs: {
      "href": _vm.header ? false : _vm.href
    }
  }, [(_vm.iconClass) ? _c('i', {
    class: ['fa', _vm.iconClass]
  }) : _vm._e(), _vm._v(" "), _vm._t("default", [_vm._v(_vm._s(_vm.title))])], 2) : _vm._e(), _vm._v(" "), (_vm.hasChildren === true) ? _c('a', {
    on: {
      "click": function($event) {
        _vm.toggleSubMenu()
      }
    }
  }, [(_vm.iconClass) ? _c('i', {
    class: ['fa', _vm.iconClass]
  }) : _vm._e(), _vm._v(" "), _vm._t("title", [_vm._v(_vm._s(_vm.title))]), _vm._v(" "), _c('span', {
    staticClass: "arrow"
  })], 2) : _vm._e(), _vm._v(" "), (_vm.hasChildren) ? _c('transition', {
    attrs: {
      "css": false
    },
    on: {
      "enter": _vm.slideEnter,
      "leave": _vm.slideLeave
    }
  }, [(_vm.hasChildren === true) ? _c('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.open),
      expression: "open"
    }],
    ref: "ul",
    staticClass: "sub-menu"
  }, [_vm._t("default")], 2) : _vm._e()]) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 370 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": "ui-alert--transition-toggle"
    }
  }, [_c('div', {
    staticClass: "ui-alert",
    class: _vm.classes,
    attrs: {
      "role": "alert"
    }
  }, [_c('div', {
    staticClass: "ui-alert__body"
  }, [(!_vm.removeIcon) ? _c('div', {
    staticClass: "ui-alert__icon"
  }, [_vm._t("icon", [(_vm.type === 'info') ? _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M12.984 9V6.984h-1.97V9h1.97zm0 8.016v-6h-1.97v6h1.97zm-.984-15c5.53 0 9.984 4.453 9.984 9.984S17.53 21.984 12 21.984 2.016 17.53 2.016 12 6.47 2.016 12 2.016z"
    }
  })])]) : _vm._e(), _vm._v(" "), (_vm.type === 'success') ? _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M9.984 17.016l9-9-1.406-1.453-7.594 7.594-3.563-3.563L5.016 12zm2.016-15c5.53 0 9.984 4.453 9.984 9.984S17.53 21.984 12 21.984 2.016 17.53 2.016 12 6.47 2.016 12 2.016z"
    }
  })])]) : _vm._e(), _vm._v(" "), (_vm.type === 'warning') ? _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M12.984 14.016v-4.03h-1.97v4.03h1.97zm0 3.984v-2.016h-1.97V18h1.97zm-12 3L12 2.016 23.016 21H.986z"
    }
  })])]) : _vm._e(), _vm._v(" "), (_vm.type === 'error') ? _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M12.984 12.984v-6h-1.97v6h1.97zm0 4.032V15h-1.97v2.016h1.97zm-.984-15c5.53 0 9.984 4.453 9.984 9.984S17.53 21.984 12 21.984 2.016 17.53 2.016 12 6.47 2.016 12 2.016z"
    }
  })])]) : _vm._e()])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-alert__content"
  }, [_vm._t("default")], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-alert__dismiss-button"
  }, [(_vm.dismissible) ? _c('ui-close-button', {
    attrs: {
      "size": "small"
    },
    on: {
      "click": _vm.dismissAlert
    }
  }) : _vm._e()], 1)])])])
},staticRenderFns: []}

/***/ }),
/* 371 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "ui-select-option",
    class: _vm.classes
  }, [_vm._t("default", [(_vm.type === 'basic') ? _c('div', {
    staticClass: "ui-select-option__basic"
  }, [_vm._v("\n            " + _vm._s(_vm.option[_vm.keys.label] || _vm.option) + "\n        ")]) : _vm._e(), _vm._v(" "), (_vm.type === 'image') ? _c('div', {
    staticClass: "ui-select-option__image"
  }, [_c('div', {
    staticClass: "ui-select-option__image-object",
    style: (_vm.imageStyle)
  }), _vm._v(" "), _c('div', {
    staticClass: "ui-select-option__image-text"
  }, [_vm._v(_vm._s(_vm.option[_vm.keys.label]))])]) : _vm._e(), _vm._v(" "), (_vm.multiple) ? _c('div', {
    staticClass: "ui-select-option__checkbox"
  }, [(_vm.selected) ? _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M9.984 17.016l9-9-1.406-1.453-7.594 7.594-3.563-3.563L5.016 12zm9-14.016C20.11 3 21 3.938 21 5.016v13.97C21 20.062 20.11 21 18.984 21H5.014C3.89 21 3 20.064 3 18.986V5.015C3 3.94 3.89 3 5.014 3h13.97z"
    }
  })])]) : _c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M18.984 3C20.062 3 21 3.938 21 5.016v13.97C21 20.062 20.062 21 18.984 21H5.014C3.938 21 3 20.064 3 18.986V5.015C3 3.94 3.936 3 5.014 3h13.97zm0 2.016H5.014v13.97h13.97V5.015z"
    }
  })])])], 1) : _vm._e()])], 2)
},staticRenderFns: []}

/***/ }),
/* 372 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('i', {
    staticClass: "material-icons",
    class: _vm.classes
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 373 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "drag-handle",
    class: {
      'disabled': _vm.disabled, 'horizontal': _vm.horizontal, 'vertical': !_vm.horizontal
    }
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 374 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('footer', {
    staticClass: "c-footer"
  }, [_vm._t("default"), _vm._v(" "), (_vm.hideCopyright !== true) ? _vm._t("copyright", [_c('div', {
    staticClass: "copyright"
  }, [_c('div', {
    staticClass: "container"
  }, [_c('div', {
    staticClass: "row"
  }, [_vm._t("left", [_c('p', {
    staticClass: "left"
  }, [_vm._v("Copyright 2017 - Codex Project")])]), _vm._v(" "), _vm._t("right", [_c('p', {
    staticClass: "right"
  }, [_vm._v("Brought to you by Codex - a Open Source documentation platform")])])], 2)])])]) : _vm._e()], 2)
},staticRenderFns: []}

/***/ }),
/* 375 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": "ui-progress-linear--transition-fade"
    }
  }, [_c('div', {
    staticClass: "ui-progress-linear",
    class: _vm.classes
  }, [(_vm.type === 'determinate') ? _c('div', {
    staticClass: "ui-progress-linear__progress-bar is-determinate",
    style: ({
      'transform': ("scaleX(" + (_vm.moderatedProgress / 100) + ")")
    }),
    attrs: {
      "role": "progressbar",
      "aria-valuemax": 100,
      "aria-valuemin": 0,
      "aria-valuenow": _vm.moderatedProgress
    }
  }) : _c('div', {
    staticClass: "ui-progress-linear__progress-bar is-indeterminate",
    attrs: {
      "role": "progressbar",
      "aria-valuemax": 100,
      "aria-valuemin": 0
    }
  })])])
},staticRenderFns: []}

/***/ }),
/* 376 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "scroll-to-top",
    on: {
      "click": function($event) {
        _vm.scrollToTop()
      }
    }
  })
},staticRenderFns: []}

/***/ }),
/* 377 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    ref: "trigger"
  }, [_vm._t("default"), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.visible),
      expression: "visible"
    }],
    ref: "popover",
    class: ['popover', _vm.placement, _vm.popoverClass],
    attrs: {
      "transition": _vm.effect
    }
  }, [_c('div', {
    staticClass: "arrow"
  }), _vm._v(" "), (_vm.title) ? _c('h3', {
    staticClass: "popover-title"
  }, [_vm._t("title", [_vm._v(_vm._s(_vm.title))])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "popover-content"
  }, [_vm._t("content", [_c('span', {
    domProps: {
      "innerHTML": _vm._s(_vm.content)
    }
  })])], 2)])], 2)
},staticRenderFns: []}

/***/ }),
/* 378 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    class: {
      'nav-link-split': _vm.title, 'nav-link-icon': _vm.icon
    },
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [(_vm.title) ? _c('div', {
    staticClass: "nav-link-top"
  }, [_vm._v(_vm._s(_vm.title))]) : _vm._e(), _vm._v(" "), (_vm.label) ? _c('span', [_vm._v(_vm._s(_vm.label))]) : _vm._e(), _vm._v(" "), (_vm.icon) ? _c('i', {
    class: 'fa fa-' + _vm.icon
  }) : _vm._e(), _vm._v(" "), _vm._t("default")], 2)])
},staticRenderFns: []}

/***/ }),
/* 379 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": _vm.toggleTransition
    },
    on: {
      "after-enter": _vm.onEnter,
      "after-leave": _vm.onLeave
    }
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.isOpen),
      expression: "isOpen"
    }],
    staticClass: "ui-modal ui-modal__mask",
    class: _vm.classes,
    attrs: {
      "role": _vm.role
    }
  }, [_c('div', {
    ref: "backdrop",
    staticClass: "ui-modal__wrapper",
    class: {
      'has-dummy-scrollbar': _vm.preventShift
    },
    on: {
      "click": function($event) {
        _vm.dismissOnBackdrop && _vm.closeModal($event)
      }
    }
  }, [_c('div', {
    ref: "container",
    staticClass: "ui-modal__container",
    attrs: {
      "tabindex": "-1"
    },
    on: {
      "keydown": function($event) {
        if (_vm._k($event.keyCode, "esc", 27)) { return null; }
        _vm.dismissOnEsc && _vm.closeModal($event)
      }
    }
  }, [(!_vm.removeHeader) ? _c('div', {
    staticClass: "ui-modal__header"
  }, [_vm._t("header", [_c('h1', {
    staticClass: "ui-modal__header-text"
  }, [_vm._v(_vm._s(_vm.title))])]), _vm._v(" "), _c('div', {
    staticClass: "ui-modal__close-button"
  }, [(_vm.dismissOnCloseButton && !_vm.removeCloseButton && _vm.dismissible) ? _c('ui-close-button', {
    on: {
      "click": _vm.closeModal
    }
  }) : _vm._e()], 1)], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-modal__body"
  }, [_vm._t("default")], 2), _vm._v(" "), (_vm.hasFooter) ? _c('div', {
    staticClass: "ui-modal__footer"
  }, [_vm._t("footer")], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-modal__focus-redirect",
    attrs: {
      "tabindex": "0"
    },
    on: {
      "focus": function($event) {
        $event.stopPropagation();
        _vm.redirectFocus($event)
      }
    }
  })])])])])
},staticRenderFns: []}

/***/ }),
/* 380 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-textbox",
    class: _vm.classes
  }, [(_vm.icon || _vm.$slots.icon) ? _c('div', {
    staticClass: "ui-textbox__icon-wrapper"
  }, [_vm._t("icon", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-textbox__content"
  }, [_c('label', {
    staticClass: "ui-textbox__label"
  }, [(_vm.label || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-textbox__label-text",
    class: _vm.labelClasses
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.label))])], 2) : _vm._e(), _vm._v(" "), (!_vm.multiLine) ? _c('input', {
    directives: [{
      name: "autofocus",
      rawName: "v-autofocus",
      value: (_vm.autofocus),
      expression: "autofocus"
    }],
    ref: "input",
    staticClass: "ui-textbox__input",
    attrs: {
      "autocomplete": _vm.autocomplete ? _vm.autocomplete : null,
      "disabled": _vm.disabled,
      "max": _vm.maxValue,
      "maxlength": _vm.enforceMaxlength ? _vm.maxlength : null,
      "min": _vm.minValue,
      "name": _vm.name,
      "number": _vm.type === 'number' ? true : null,
      "placeholder": _vm.hasFloatingLabel ? null : _vm.placeholder,
      "readonly": _vm.readonly,
      "required": _vm.required,
      "step": _vm.stepValue,
      "type": _vm.type
    },
    domProps: {
      "value": _vm.value
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "focus": _vm.onFocus,
      "input": function($event) {
        _vm.updateValue($event.target.value)
      },
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.onKeydownEnter($event)
      }, _vm.onKeydown]
    }
  }) : _c('textarea', {
    directives: [{
      name: "autofocus",
      rawName: "v-autofocus",
      value: (_vm.autofocus),
      expression: "autofocus"
    }],
    ref: "textarea",
    staticClass: "ui-textbox__textarea",
    attrs: {
      "autocomplete": _vm.autocomplete ? _vm.autocomplete : null,
      "disabled": _vm.disabled,
      "maxlength": _vm.enforceMaxlength ? _vm.maxlength : null,
      "name": _vm.name,
      "placeholder": _vm.hasFloatingLabel ? null : _vm.placeholder,
      "readonly": _vm.readonly,
      "required": _vm.required,
      "rows": _vm.rows
    },
    domProps: {
      "value": _vm.value
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "focus": _vm.onFocus,
      "input": function($event) {
        _vm.updateValue($event.target.value)
      },
      "keydown": [function($event) {
        if (_vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.onKeydownEnter($event)
      }, _vm.onKeydown]
    }
  }, [_vm._v(_vm._s(_vm.value))])]), _vm._v(" "), (_vm.hasFeedback || _vm.maxlength) ? _c('div', {
    staticClass: "ui-textbox__feedback"
  }, [(_vm.showError) ? _c('div', {
    staticClass: "ui-textbox__feedback-text"
  }, [_vm._t("error", [_vm._v(_vm._s(_vm.error))])], 2) : (_vm.showHelp) ? _c('div', {
    staticClass: "ui-textbox__feedback-text"
  }, [_vm._t("help", [_vm._v(_vm._s(_vm.help))])], 2) : _vm._e(), _vm._v(" "), (_vm.maxlength) ? _c('div', {
    staticClass: "ui-textbox__counter"
  }, [_vm._v("\n                " + _vm._s(_vm.value.length + '/' + _vm.maxlength) + "\n            ")]) : _vm._e()]) : _vm._e()])])
},staticRenderFns: []}

/***/ }),
/* 381 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    ref: "label",
    staticClass: "ui-fileupload",
    class: _vm.classes
  }, [_c('input', {
    ref: "input",
    staticClass: "ui-fileupload__input",
    attrs: {
      "type": "file",
      "accept": _vm.accept,
      "disabled": _vm.disabled,
      "multiple": _vm.multiple,
      "name": _vm.name,
      "required": _vm.required
    },
    on: {
      "blur": _vm.onBlur,
      "change": _vm.onChange,
      "focus": _vm.onFocus
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ui-fileupload__content"
  }, [_c('div', {
    staticClass: "ui-fileupload__icon"
  }, [_vm._t("icon", [_c('ui-icon', [_c('svg', {
    attrs: {
      "xmlns": "http://www.w3.org/2000/svg",
      "width": "24",
      "height": "24",
      "viewBox": "0 0 24 24"
    }
  }, [_c('path', {
    attrs: {
      "d": "M5.016 18h13.969v2.016H5.016V18zM9 15.984v-6H5.016L12 3l6.984 6.984H15v6H9z"
    }
  })])])])], 2), _vm._v(" "), (_vm.hasSelection) ? _c('span', {
    staticClass: "ui-fileupload__display-text"
  }, [_vm._v(_vm._s(_vm.displayText))]) : _vm._t("default", [_vm._v(_vm._s(_vm.placeholder))])], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-fileupload__focus-ring",
    style: (_vm.focusRingStyle)
  }), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "label"
    }
  }) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 382 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticStyle: {
      "opacity": "0",
      "position": "fixed",
      "top": "-10px",
      "left": "0",
      "right": "0",
      "height": "120vh",
      "willChange": "opacity"
    },
    style: ({
      zIndex: _vm.zIndex,
      backgroundColor: _vm.color
    }),
    on: {
      "click": _vm.dismiss
    }
  })
},staticRenderFns: []}

/***/ }),
/* 383 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-toolbar",
    class: _vm.classes
  }, [_c('div', {
    staticClass: "ui-toolbar__left"
  }, [(!_vm.removeNavIcon) ? _c('div', {
    staticClass: "ui-toolbar__nav-icon"
  }, [_vm._t("icon", [_c('ui-icon-button', {
    attrs: {
      "size": "large",
      "type": "secondary",
      "color": _vm.textColor,
      "icon": _vm.navIcon
    },
    on: {
      "click": _vm.navIconClick
    }
  })])], 2) : _vm._e(), _vm._v(" "), (_vm.brand || _vm.$slots.brand) ? _c('div', {
    staticClass: "ui-toolbar__brand"
  }, [_vm._t("brand", [_c('div', {
    staticClass: "ui-toolbar__brand-text"
  }, [_vm._v(_vm._s(_vm.brand))])])], 2) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "ui-toolbar__body",
    class: {
      'has-brand-divider': _vm.hasBrandDivider
    }
  }, [_vm._t("default", [(_vm.title) ? _c('div', {
    staticClass: "ui-toolbar__title"
  }, [_vm._v(_vm._s(_vm.title))]) : _vm._e()])], 2), _vm._v(" "), _c('div', {
    staticClass: "ui-toolbar__right"
  }, [_vm._t("actions")], 2), _vm._v(" "), _c('ui-progress-linear', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.loading),
      expression: "loading"
    }],
    staticClass: "ui-toolbar__progress",
    attrs: {
      "color": _vm.progressColor
    }
  })], 1)
},staticRenderFns: []}

/***/ }),
/* 384 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    ref: "button",
    staticClass: "ui-icon-button",
    class: _vm.classes,
    attrs: {
      "aria-label": _vm.ariaLabel || _vm.tooltip,
      "disabled": _vm.disabled || _vm.loading,
      "type": _vm.buttonType
    },
    on: {
      "click": _vm.onClick
    }
  }, [(_vm.icon || _vm.$slots.default) ? _c('div', {
    staticClass: "ui-icon-button__icon"
  }, [_vm._t("default", [_c('ui-icon', {
    attrs: {
      "icon": _vm.icon
    }
  })])], 2) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "ui-icon-button__focus-ring"
  }), _vm._v(" "), _c('ui-progress-circular', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.loading),
      expression: "loading"
    }],
    staticClass: "ui-icon-button__progress",
    attrs: {
      "color": _vm.progressColor,
      "size": _vm.size === 'large' ? 24 : 18,
      "stroke": 4.5
    }
  }), _vm._v(" "), (!_vm.disableRipple && !_vm.disabled) ? _c('ui-ripple-ink', {
    attrs: {
      "trigger": "button"
    }
  }) : _vm._e(), _vm._v(" "), (_vm.hasDropdown) ? _c('ui-popover', {
    ref: "dropdown",
    attrs: {
      "trigger": "button",
      "dropdown-position": _vm.dropdownPosition,
      "open-on": _vm.openDropdownOn
    },
    on: {
      "close": _vm.onDropdownClose,
      "open": _vm.onDropdownOpen
    }
  }, [_vm._t("dropdown")], 2) : _vm._e(), _vm._v(" "), (_vm.tooltip) ? _c('ui-tooltip', {
    attrs: {
      "trigger": "button",
      "open-on": _vm.openTooltipOn,
      "position": _vm.tooltipPosition
    }
  }, [_vm._v(_vm._s(_vm.tooltip))]) : _vm._e()], 1)
},staticRenderFns: []}

/***/ }),
/* 385 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ui-snackbar-container",
    class: _vm.classes
  }, _vm._l((_vm.queue), function(snackbar, index) {
    return _c('ui-snackbar', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (snackbar.show),
        expression: "snackbar.show"
      }],
      attrs: {
        "action-color": snackbar.actionColor,
        "action": snackbar.action,
        "message": snackbar.message,
        "transition": _vm.transition
      },
      on: {
        "action-click": function($event) {
          _vm.onActionClick(snackbar)
        },
        "click": function($event) {
          _vm.onClick(snackbar)
        },
        "hide": function($event) {
          _vm.onHide(snackbar, index)
        },
        "show": function($event) {
          _vm.onShow(snackbar)
        }
      }
    }, [(_vm.allowHtml) ? _c('div', {
      domProps: {
        "innerHTML": _vm._s(snackbar.message)
      }
    }) : _vm._e()])
  }))
},staticRenderFns: []}

/***/ }),
/* 386 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "avatar",
    class: _vm.classes
  }, [_vm._t("image", [_c('img', {
    staticClass: "circle",
    attrs: {
      "src": _vm.src
    }
  })]), _vm._v(" "), _vm._t("default"), _vm._v(" "), _c('span', {
    staticClass: "secondary-content"
  }, [_vm._t("secondary")], 2)], 2)
},staticRenderFns: []}

/***/ }),
/* 387 */,
/* 388 */,
/* 389 */,
/* 390 */,
/* 391 */,
/* 392 */,
/* 393 */,
/* 394 */,
/* 395 */,
/* 396 */,
/* 397 */,
/* 398 */,
/* 399 */,
/* 400 */,
/* 401 */,
/* 402 */,
/* 403 */,
/* 404 */,
/* 405 */,
/* 406 */,
/* 407 */,
/* 408 */,
/* 409 */,
/* 410 */,
/* 411 */,
/* 412 */,
/* 413 */,
/* 414 */,
/* 415 */,
/* 416 */,
/* 417 */,
/* 418 */,
/* 419 */,
/* 420 */,
/* 421 */,
/* 422 */,
/* 423 */,
/* 424 */,
/* 425 */,
/* 426 */,
/* 427 */,
/* 428 */,
/* 429 */,
/* 430 */,
/* 431 */,
/* 432 */,
/* 433 */,
/* 434 */,
/* 435 */,
/* 436 */,
/* 437 */,
/* 438 */,
/* 439 */,
/* 440 */,
/* 441 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

Object.defineProperty(exports, "__esModule", { value: true });
var Vue = __webpack_require__(8);
var plugin_1 = __webpack_require__(501);
__webpack_require__(725);
__webpack_require__(723);
__webpack_require__(724);
__webpack_require__(720);
__webpack_require__(721);
__webpack_require__(722);
__webpack_require__(726);
__webpack_require__(727);
__webpack_require__(718);
__webpack_require__(716);
__webpack_require__(719);
__webpack_require__(717);
var core_1 = __webpack_require__(101);
var menuOptions = [{
    id: 'edit',
    label: 'Edit',
    icon: 'edit',
    secondaryText: 'Ctrl+E'
}, {
    id: 'duplicate',
    label: 'Duplicate',
    icon: 'content_copy',
    secondaryText: 'Ctrl+D'
}, {
    id: 'share',
    label: 'Share',
    icon: 'share',
    secondaryText: 'Ctrl+Shift+S',
    disabled: true
}, {
    type: 'divider'
}, {
    id: 'delete',
    label: 'Delete',
    icon: 'delete',
    secondaryText: 'Del'
}];
Vue.codex.plugins['Welcome'] = plugin_1.plugin;
exports.App = Vue.codex.apps['Welcome'] = Vue.extend({
    mixins: [core_1.mixins.layout, core_1.mixins.resize],
    data: function data() {
        return {
            carouselHeight: 9999,
            menuOptions: menuOptions,
            wow: null
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
                return Vue.codex.loader.stop();
            });
            var $header = $(_this.$refs.header.$el);
            _this.$$('.scrollspy').scrollSpy({
                scrollOffset: $header.outerHeight(true) + 1
            });
            _this.wow.init();
        });
    },

    methods: {
        updateHeight: function updateHeight() {
            this.carouselHeight = this.getViewPort().height + 1;
        }
    },
    beforeMount: function beforeMount() {
        this.wow = new WOW({
            mobile: false
        });
    }
});
exports.default = exports.App;
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(14)))

/***/ }),
/* 442 */,
/* 443 */,
/* 444 */,
/* 445 */,
/* 446 */,
/* 447 */,
/* 448 */,
/* 449 */,
/* 450 */,
/* 451 */,
/* 452 */,
/* 453 */,
/* 454 */,
/* 455 */,
/* 456 */,
/* 457 */,
/* 458 */,
/* 459 */,
/* 460 */,
/* 461 */,
/* 462 */,
/* 463 */,
/* 464 */,
/* 465 */,
/* 466 */,
/* 467 */,
/* 468 */,
/* 469 */,
/* 470 */,
/* 471 */,
/* 472 */,
/* 473 */,
/* 474 */,
/* 475 */,
/* 476 */,
/* 477 */,
/* 478 */,
/* 479 */,
/* 480 */,
/* 481 */,
/* 482 */,
/* 483 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
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

/***/ }),
/* 484 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__core__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__core___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__core__);
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



// this is directly linked to the bootstrap animation timing in _carousel.scss
// for browsers that do not support transitions like IE9 just change slide immediately
var TRANSITION_DURATION = __WEBPACK_IMPORTED_MODULE_0__core__["utils"].cssTransitions() ? 600 : 0;

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

/* harmony default export */ __webpack_exports__["default"] = {
    mixins: [__WEBPACK_IMPORTED_MODULE_0__core__["mixins"].layout],
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
        controlBottom: { type: [Boolean, String], default: false },
        addClass: { type: String, default: '' }
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
            return ['carousel', 'carousel-codex', 'slide', 'carousel-slide-' + this.index + ' ' + this.addClass];
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

/***/ }),
/* 485 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    name: 'c-footer-welcome'
};

/***/ }),
/* 486 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = {
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
        sectionClass: function sectionClass() {
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

/***/ }),
/* 487 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {};

/***/ }),
/* 488 */,
/* 489 */,
/* 490 */,
/* 491 */,
/* 492 */,
/* 493 */,
/* 494 */,
/* 495 */,
/* 496 */,
/* 497 */,
/* 498 */,
/* 499 */,
/* 500 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var cCarousel = __webpack_require__(749);
exports.cCarousel = cCarousel;
var cCarouselItem = __webpack_require__(748);
exports.cCarouselItem = cCarouselItem;
var cSection = __webpack_require__(751);
exports.cSection = cSection;
var cWelcome = __webpack_require__(752);
exports.cWelcome = cWelcome;
var cFooterWelcome = __webpack_require__(750);
exports.cFooterWelcome = cFooterWelcome;

/***/ }),
/* 501 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var components = __webpack_require__(500);
exports.plugin = function (Vue) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    if (exports.plugin.installed) return;
    Vue.codex.extend({});
    console.log('registering welcome plugin', components);
    Object.keys(components).forEach(function (key) {
        return Vue.component(key, components[key]);
    });
};
exports.default = exports.plugin;

/***/ }),
/* 502 */,
/* 503 */,
/* 504 */,
/* 505 */,
/* 506 */,
/* 507 */,
/* 508 */,
/* 509 */,
/* 510 */,
/* 511 */,
/* 512 */,
/* 513 */,
/* 514 */,
/* 515 */,
/* 516 */,
/* 517 */,
/* 518 */,
/* 519 */,
/* 520 */,
/* 521 */,
/* 522 */,
/* 523 */,
/* 524 */,
/* 525 */,
/* 526 */,
/* 527 */,
/* 528 */,
/* 529 */,
/* 530 */,
/* 531 */,
/* 532 */,
/* 533 */,
/* 534 */,
/* 535 */,
/* 536 */,
/* 537 */,
/* 538 */,
/* 539 */,
/* 540 */,
/* 541 */,
/* 542 */,
/* 543 */,
/* 544 */,
/* 545 */,
/* 546 */,
/* 547 */,
/* 548 */,
/* 549 */,
/* 550 */,
/* 551 */,
/* 552 */,
/* 553 */,
/* 554 */,
/* 555 */,
/* 556 */,
/* 557 */,
/* 558 */,
/* 559 */,
/* 560 */,
/* 561 */,
/* 562 */,
/* 563 */,
/* 564 */,
/* 565 */,
/* 566 */,
/* 567 */,
/* 568 */,
/* 569 */,
/* 570 */,
/* 571 */,
/* 572 */,
/* 573 */,
/* 574 */,
/* 575 */,
/* 576 */,
/* 577 */,
/* 578 */,
/* 579 */,
/* 580 */,
/* 581 */,
/* 582 */,
/* 583 */,
/* 584 */,
/* 585 */,
/* 586 */,
/* 587 */,
/* 588 */,
/* 589 */,
/* 590 */,
/* 591 */,
/* 592 */,
/* 593 */,
/* 594 */,
/* 595 */,
/* 596 */,
/* 597 */,
/* 598 */,
/* 599 */,
/* 600 */,
/* 601 */,
/* 602 */,
/* 603 */,
/* 604 */,
/* 605 */,
/* 606 */,
/* 607 */,
/* 608 */,
/* 609 */,
/* 610 */,
/* 611 */,
/* 612 */,
/* 613 */,
/* 614 */,
/* 615 */,
/* 616 */,
/* 617 */,
/* 618 */,
/* 619 */,
/* 620 */,
/* 621 */,
/* 622 */,
/* 623 */,
/* 624 */,
/* 625 */,
/* 626 */,
/* 627 */,
/* 628 */,
/* 629 */,
/* 630 */,
/* 631 */,
/* 632 */,
/* 633 */,
/* 634 */,
/* 635 */,
/* 636 */,
/* 637 */,
/* 638 */,
/* 639 */,
/* 640 */,
/* 641 */,
/* 642 */,
/* 643 */,
/* 644 */,
/* 645 */,
/* 646 */,
/* 647 */,
/* 648 */,
/* 649 */,
/* 650 */,
/* 651 */,
/* 652 */,
/* 653 */,
/* 654 */,
/* 655 */,
/* 656 */,
/* 657 */,
/* 658 */,
/* 659 */,
/* 660 */,
/* 661 */,
/* 662 */,
/* 663 */,
/* 664 */,
/* 665 */,
/* 666 */,
/* 667 */,
/* 668 */,
/* 669 */,
/* 670 */,
/* 671 */,
/* 672 */,
/* 673 */,
/* 674 */,
/* 675 */,
/* 676 */,
/* 677 */,
/* 678 */,
/* 679 */,
/* 680 */,
/* 681 */,
/* 682 */,
/* 683 */,
/* 684 */,
/* 685 */,
/* 686 */,
/* 687 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 688 */,
/* 689 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 690 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 691 */,
/* 692 */,
/* 693 */,
/* 694 */,
/* 695 */,
/* 696 */,
/* 697 */,
/* 698 */,
/* 699 */,
/* 700 */,
/* 701 */,
/* 702 */,
/* 703 */,
/* 704 */,
/* 705 */,
/* 706 */,
/* 707 */,
/* 708 */,
/* 709 */,
/* 710 */,
/* 711 */,
/* 712 */,
/* 713 */,
/* 714 */,
/* 715 */,
/* 716 */
/***/ (function(module, exports) {

module.exports = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAXO0lEQVR4nO2df4hc53nvP99BLItYlkWoukIIkbrWjDDGeA+uNRNS1/i6aZr6Ok3SJE7tuOm1I9/YVp00V/2BrjFCCDXtdXwdx3Wd1kkc3/YmrZu4uWmSOm7wNUIzNuFsCCJoxkYIIYQwQqjbZVmWZb/3j3N2tVrtnB+jOTOzP75h+Dqr8573ed/3Oc/7vM/7S8ZsYANZUeq3ABtYXdhQmA3kwobCbCAXNhRmA7mwoTAbyIUNhdlALmzqJFFlvFoCbkTcDNrlLiqeYAY4gXmtOVGf7dZ7VxPKQW1EcJfhOjpso5UgmLH5uUTYDOvvdvKO3MJUglrJ5m5JXwSuB0rqJOcEGE9KfAr4XpdfPfCoBLVNmH3GRyUNdfv9ElPAG5Wg9kAzrJ/Pmz63ZTDcLel5oNxJ+iwQGgV9shJUu/Z1rRbY3irxoSKUJcYI5oO2X6gEte15E+ducMEDwLa86TrAZtC6U5hYUYpSljgTkHQ7UM2bNFVhhEpLGbh9cTahSLYB5pfnv9YZg+3i6xc2A3tXaN9EpD5kPL+UgZGF+aci2dKK+a91ZolDWHQ9E7Xl8vZNREcmX3FjFs2XP4n1hV7VbycTz5nMUF6z1RWYadD8SvmvcZ4x7k04wbEC5WjfTApwhdla7F+L4bj/voB4qRnW567Kf+3zBdA/2Z7ELqyesRe7vzzdUqYuSahkPC9UKi861uqA/TrS/43+b/z3ZSxpBvMO4jWh0u7xvZsk3QzsMhxvhfVzS+VZcxx6vhLUvop0Fti52EZt6svSQ4JyJ+0hX92+aUqjvP1YJajGqmnyMYCnQfdifoRoa3abYX0eoDxeGwIOS+yzPSzpAnAv0GiGazsKXAlqpSuq7mqMAA/bHJbYlL89jNFXWmF9fx65emhhALQZeBrxWDOsv5L0pZWDakn2fUifA4ZiR20n8AL2ASAx/arnMPnfdwfVRwUHImXppD0ut0vBFqbmqP8TnTGALoE/BrzRDBtXWYporkoPIo4CW65IH4k9ifiMzfdaE/WZXAVY5agE1RHQPuAo9lDn7SBsf6U10chlYToY9cSZdswAjIGeA92xYhbSbcZHgC1XpRcgRm2eFr47v/yrHOZh4HGIleUa2uNy+CI7OlCYTvyXFdhcb/ulclB939I5o0pQe7/N85K2JqYX25Eeyi//6kQlqG2uBLVHQYfBY91ph/zoZGpgSWYr8jxx/CTxOYGkrULPg94X+S2164CnJcpp6eP/mhqQ2EnhDOwzPoQYyuSfmNm057xyPonoZGogDT8HvgRMZ3ra3AD+u3JQ/QjmBWBPxnSngacHJHZSGJeD6nBlvLYPOCq0JUO9gDmJOJT2qHDu9u36bLBhVvAcMIv5HGJzYoLICd5h+0VJyc9ezmNGcMD4jWuXeMBhPm1xSDCc6Xn5hM1nQTvSO5383VKqwiw3VeWUGXFFdm4OOIL4d+AQGQqbQ1kuCZ5AvPJ2+OZ8VlO6FLvHqyXEmPCoYURoGHsH0ojNiMQwZh4xg5lCTGLOI2aMp4QmgUutsJE368woB9Uh4B7wX4rMdXNK6F6JE8DvZkmzvP7SLE0mC7N0jF6hliUJrbAxUw6qXwJ+CfthMipEohw2ko4CX2uFjfk8sY1KUBsC9mCqiAqwB7RTsB3YgqK1N2rf7c8AF4XOA2eBX5SDvU2sY8inW+GbueRJlZfa/cARsivLScH+Vtg4EZc3e71mjMFABoW5uo9L9ryNUcTzhMxXgtphxL9jP440dA2e/Szobw1fboWXYy8JfT8ValvK7L2hQu124KPgnUgjhmHlz38YtAO8AxQY3yUzG1kfvVMOqv9Upnas7OrJCrUpT3Tqs+wdqlD9CNZTUXeeIWJrzgr9PnJ4daOntlfBPkyK/LoiwAbNsD5ZGa/9Bfg/2X5QMNzZCFDfkjjUDNMDdZWgtg34OPAboDuBzUuDVpGMOfNfXk5TQhrGHkbahv1eSZcsfgT8ayWofacZ1idz1y/6PeAIeHM82kmrl1MS+5th/a2lb1kobrdH1h1MDexNfDYSVFeka0005srj1ceFJ5H+OGu+AIZ52a8jPt8K37y0XJ6lUwmxH3If8CngOvBQVDGdxRw6wBj2PZLuxt5fCWovGL6DfaE10ZhLmQoZAu6y/RQwmkli+zzSHwDHYVk7KfvqyzxTA/njMG1mTRdnm/GK6VoTjUmkw8CrWd6zpJGnEM8vVZblXA6qwzafA74LHCEamg/FJi9bPl3i+GPZjBQAzwq+LenTsQ/VNs5i83HgGUmjUrrchjMWj7TCxrFW2LhqKesikt5j547DZPZhFlBxNdmULVtauZhuvFYCbjAOcn3vYhR0pDy+9yTSLxbWyABUgtowcBtwAPk2IPaRBgeG2wS3GH6zHFSfwrzVnLhchnJQHRL6IFFMaSxj3VyQ9Bng9XYWIRqcJNdFFLLJHF8DOttmMhVpTLsfs/FvWTrfjPkboe3J6a/8xTHd60EvsmSVe+yn/DHwj8CdQkN53turXyS/Ngv9LvBd5P9WGa+OLZQj/vuzwJgyvZNzmMeaYf3VlCUeM6DZlHfl9rFyO72Cbxh/WmhkqQbHYeYp4F+ACwt/j9d17BB6AXFzxxYg2mX5UiWofsJRFPlZRQpU7JaM7mIb6IuI/1wJqgds9gg9w8IkawqiGJQ+S+RYJz9r/0LSMePbdHU7zxtOgX6ctwCdLG/YAv4A6DqusFCeA86AXl46kqkEtV3gZ0F35RVuJRjOEA3dd3XhddPAGeAcUWxlMv7bDFCKh9KbgTFgF1HMZhfdUdIWMBq/MwveBf6sGda/ljWDSlC9HnMXaHSZGzEDHAPeWtrFZ0FuhcmDclAbE7xo80HhTdcyjL1WNoCZRDotCIF/BU4Al4gqcMYwJ5gD5uOEm4g+iqF4+DwMbAUCzG8ibsTeSbT6rUD5NWn7IaFXmn1e/1OYwlSC2hbbh4QezdSgUSg+jm+kP589fgPAaeAV4P8BP+ksPrJiGbcBH7D9a5J+B9jadUW3L0h6ohnW/6obMl8rUhWmk9B2OagOYR8xeljKNGk2B/x5vILsj+jOpOic4azsZxHfxzrdnKjPdCt0v8Dl8VpJMGz5BqFP2vyexDa6sO/cMCXYb/jW22Fjtptyt+M0mbpuYeJ4wz7gaexShiWbs6BvAp8FSsZPCz5NNCGYkC6RLyF9GXixGdZPdbWAKSgHtUD4M6D/em1LKLkEOtwM61/qpfxp6P7GNHOT4fNAKUPwCdD/Bh9shvW5eJh4EPRXxnN5g2aOZsl/gPgw+GivlQWgFdZD0AHgXks/TZI3gadBB4G/7onQOZDJwuTsju4A/yPWWIY++lXbn3h74s3JFWaW/wW4M0eff8n4G5KeaIWNqV6Y79QZ5/HaTsRT2HeB8syhfaUZ1vf3S+4kXcg0NZAzs5OgY4sOZ3t+DfzYCspScjTU3JOSfilfAH9G8PigKItQqTlRPws8hHQQxSsQs5Xnlsp4bXTQlAUKsDDRl1XdhXgJ9D5waYVP6ATwoVbYOL2ChdoKfgb4eMbx8knEF5ph/QeDoCQJlvdh4CB4e8bh3Z+DDzfDxvQgKU3+vdUZuDnROIN5AHiZ5QvCrRPA/mZYP7U8XXm8CvAgcHfqpxhtJD9NdLTZq53I2VM2f4t5CHMpsVyXYwH7iIOdvZY3CYVYmCXdy6jxc6CPyAxbnAE++XbYaLR5fg/mTcRohvhKC/uh5kTj9UGwIDkszf3AFzHbMhiaFrC3FTYmeylnki503Ye5og8P65NC+wUfQzwi+DCwsrKM18aAg4hR47i3acPRV/pZ0LFBUIJ8jeFvAU9YzKaVk+gcwUd3j1c3DYKyQAFxmE5RGa/eh/QcC2H29pgE/qQZ1gduyJkHlaD6lM2jUto5fj5r84nWRON4byRLRu8OCEpAJagNIe0nTVki3f4m5u97IFbB0JMoXkyW/NxOSQ9UgtpAtFXuFXdFsOFu4NY0WQw/Aw42J+qTvZCrSG6FjXOCx4hmodNwH3hPL+RKQ+6dj93m8nh1i/AfYEj62b4ocWRh4rDXI4ciuBk23rH9lO3ZlPIPGT1SGa8NFS1XGvpu5oxvNXovAhQ7eyuw4B+wf9BfabsPwTck/SRD+e+0nG0bcYHou8JIfFhmLDrPDVZimxmkJ5sTjWz7tVcTxLvAM7bn25U/tjLXYd3WV1npsw9TCWqjWB+HeJYWVmRJ32yFjVNFy9MPboVvYviRpLfalT9uiE0SD6xvH8bc5mh/M7ZZiYHz2P9nEHyOorgVnen3HGimXT3Ep4veVA6qu4qUJw1965IqQW2T4UOSooOl2rBxAxT2S84e4g3EiaT6AJfAXVkb3SkydUlF/IAdEjct5NKOhX7YmmhMFSXHoPyAs9HHkVwfNr9eCWqbC5Tj2hSmQLyHaAV+EmbAL/dAlr6jFTbmZf1d2nOSrgd29ECkFdE3H4boCNWtKdmfaIaNi0XKMUhs8TPSN5ftAO8YaB+mkMqBXyVtsbf9WlH5DyLHx5ikzRltJdoT1hfHt39dkl0mMbrpOaSJvsnXP9ST64WS7V/pl3B9u/FM0nXRgLHNv1sXDbnvJFz1sE9azJPwMSu2MP1AXxQmumjUO1MOFr4o+1KvZBoUODoWbZJoe247pA0WCkO/uqRRSclLGcRFpIs9kmdgIHHRkFJu7+yNNFejLxbGsFkJ3VH8zCxoXd0jEEGzisIJSQ9d8wGTnaIvFkZ2aoGFZuT2V+SsVRjPsML5OsvQN4Xpj9MbnYKQhjkn3Km0ViFrznguyb8z6R9cUeiLhTGeS5pwjCbaXJL7N4rrG0RJUilxQraPlrcvyxtkTYto5r4dg4YQm4rIf5DZ9hAwlFw/mi4q/zRkmhoQ3d3KYDEVvT1xM9cQMFxE/oPMig52HEquHwrbDnzNCrOgNN1kwVTKIAnjEWLnrt8h+56yGIGUkAOeKlKOJGRSmG6bvVbYmEOcS8lzK3hrEfkPNmur7eRrbqzTRcqRhEw+TBHmD3MmuVIYA40NQjfRSwa2K2UUaXymwPyvTWEK6yvldxIzFqPgPYPQiL1kSL8uRlKzwPyvTWEWlKb7rGbq5e1x5RXVVw8o35pSL7NER8UOpg9TYD8ZKh4ttR0rWbenndG/lrgc1HYCN6QcBHLW+HSB7ZKITF1SEUx0mHLa8oXtwM1FyjFILPhASn0APid0rh/WBfq4gMr4NPgUXvzDyow/VQlqaz7iWwlqY+CPptWHo9O7suzHLgR9UxjBJKiRHLsDovsEdvVQtH5hD9aNafUh+HEz2sfUF/TNh2mFbwL+NkQngMeZXc3WzcAHB8HHKJKB32dhnUv7+riE+UHBciSibz6M8TzWSUyr/TDJIDYZHioH1VLh8vSJK0Ftu/E9lyu9TX3Aawt3Daw7HwagOVGfR3wdKdqIvngX45UsuBG4rzwgh+p0E5WgNoz5gqyxduWPeQpI3bdUNDI1QLHm2K/aPpXu+/II9nXFy9NjNrdY3JNW/njP0lu9kCsJffNhLgunE0jfT736UdyC9IXKeLX/jdwlLo/vHUYcFuxMPU0evwic76eyQL99GKAZ1udkv0B0o0nCJwaC+5Hu6IVcRfPu8b0l0H2Y29PKHW230cutsFG4XGnIpFXFC6lfAF8FxyOm+OSlq3mz4clyUA16IVeRLOkuiydSygt4RnCkGdYv9Uq+JAyADwOtiQbAC6BTCzm2Z9+EObJwgkEv5Os2V8ZrO4GjWtxUn1Be8VOiy8F6Jl8SBsLCxPxz4NlFU9wGiirx/cAz5fHq1h7K1xWuBLU9lr9uMpxXZ2aNjhJNo/RMziQMzMHOAJWgNoL5MVCNjAm0Y4sZwTeI7i3IddFlv1AOaqOYbytS+FJy+Qzm7yV9qp+R3eUYiC5psWsKG9PGB4BTjoJ2tGPsYcOD4KfK49XtvZSzE66MV/cIvyT5A0AprXyyjks63Azr872WNwmZFKaXiA8HfDLL5WWK9lXtA54uB7XRHouaGeXxvbuAv2HJVcwp5ZtFHCa6qnigMFBd0gIq49UhpGeB++NtF4mQNG/zE4lDwPFBMeHxLPvdtp+AhePZkiGYjpRF/3MQu9qBVBiIRxLiOSDPIYCnwQcw329ONPq6LztarsD9tg9JSjqJ4QoY/lr2weZEYyAPIsh0DXGPZLkCu8f3ImkH8EPM5Wn/VHgK9KrhccE7rbDR06+0HFSHDYHsLyLdQrS/Kh1mDngd8dFW2JgqVMhEMZJHSoXcW91NrgS1W4HniG6jbzuqWIHfAf4B83xzol7YKvslcpbANxj2Y/2OxLac8v4I2N8KG6f6Wd9pClXojWzd4HJQBVzG+mdEOecd0HOYM4jvAV/HPtecaFzorpKw3WYX0QVid2JvQyplldP2vNBxi4/JvNucqPd998I1K8wgoBLUqpgnkd+LBYqCMdmZC8BbmB+Cf4r0s2Z0CGFulIPaqOAWoit7fgscACMdyvU94EAzrA/ciGglDLyFWbQ041UQO4AXgNs7vnUeZm1PCb2L+DlmAnEacwoxY5gTLHxlm4w3ydoMXA9+j2GvpD3AFtsjgk0dyWGmwd+JLxabXIi39Lueu+LDpOtd77A7qG6XOWD8h1JXZZsHpg0zghnsEmLYaFh4mO7WwwxwCPPV1kRjoM7xS1OYvi9vyMutsH4OcVDSQ5iTlwVNWOaZjUvAiOytRIdO7wBtiU7Lin2Sa87HAD8F3wv8r9ZEo2cz0Fk5DavGh1mOSlAtgW4EjtrcKTGUc1TSW8bTSK+AH2/GV/msRqy6Lmk5ykF1DHwH8IRRWVnjHr3DDOYE4nHgeD9jLFmw5nyYdigH1Z3APeAHgDLZI31FYR58wvA88PLb4ZsX+i1QFnRlWN1vrz1HXGQT0aa3O2weEbwHGOux7lwE3jF+SugYcL4VNuYHoX7WVRwmLyrjtS3g9xp+W9ElpDdFKweMUVcZaR4IgWPAD7EbzYlG2q0kqxJrpktqh3JQHQK2gm8AVYHfAHYajwoNgzfn6L7mwTOgaWAKOAX8G/ZxUAu42JporOqjYtdVl5QtALi3hLQds8ewE/HLwPsV7eFOwhvAv4FPA2dBJzHnByGUv9El9RDx8Px/AIdSHv085svNicFYa9MvDNQSzX5wM2zMx0sL0jAX724YCLmL5CSkPtBv89gLRtmsbL/l7Hd3lElhBqEQhVdSFIldLPHKvE4+nhRkOtlpQfPWKl85Smq3qaz/cvauPtpj3fswUUVlgPsvZ684CRs+DCopiw+jddI9X6vCDEIhCq8kZwvc9VvOXnBqHXiNx2HK49WSpGHMFqvtB7Jf8N9T1ik84Whr7hUQgJlDXGqG9elCCjFAWPOR3t3B3i1CBzH7UAFX30U6NQX+Cugvm2H94iCUu6huaT34MLcCDyI2O1791lWO9kOPgPYBNw9AeQtTFsgwrF54yWplYBtmBECR51oMwxZga7/L24X6SsR6GFaXEBT+AxYG6ANS7v4Nq1cz9xbqe3mLrq/MXdJqRYXaos9RNCSt+vpKw5q/9AGYvXwHdHHbAhwtrhq44zm6jVSF6Y9p7x52Uz0rfB60/bKzUQifZck5uqsVaRZyzVsYwXHg8+B7Qe3iMO8Brkt5VYtIKVbCtODrxCd1r2Ws+cCd8XxlvFpCGlvcj70c5jHEnybVgc1Bia+t9A9Gs62J1R+wW+CkelgXyxuaE415ou0fK6Ic1P4jbTZJ0Yb5xBvk+l3OXsRi1kMcJp0NqXujNQByDsDQes3HYbLx4lEg7Xmd1Eca1nwcJguyxGrWQ4wlC9b8KCkrtJIzvIGrsOHDRP8xl+bDRCdTDYa8A+3DrBMcM8zEU8+swNNxPGfdY10Mq1OHkfZbkr4A/i+gLcuKf8HwXcGJfss5CMNqnOF/QGmD1w8n6sKGsmxwVmXJpDCDUIgNHhylWfO7BjbQXWyMkjaQCxsKs4Fc2FCYDeTC/wdQQGr6l+idMAAAAABJRU5ErkJggg=="

/***/ }),
/* 717 */
/***/ (function(module, exports) {

module.exports = "data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiCgkgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sbnM6YT0iaHR0cDovL25zLmFkb2JlLmNvbS9BZG9iZVNWR1ZpZXdlckV4dGVuc2lvbnMvMy4wLyIKCSB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0MHB4IiBoZWlnaHQ9IjEyMHB4IiB2aWV3Qm94PSIwIDAgODQuMSA1Ny42IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA4NC4xIDU3LjYiCgkgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxkZWZzPgo8L2RlZnM+CjxwYXRoIGZpbGw9IiNGQjUwM0IiIGQ9Ik04My44LDI2LjljLTAuNi0wLjYtOC4zLTEwLjMtOS42LTExLjljLTEuNC0xLjYtMi0xLjMtMi45LTEuMnMtMTAuNiwxLjgtMTEuNywxLjljLTEuMSwwLjItMS44LDAuNi0xLjEsMS42CgljMC42LDAuOSw3LDkuOSw4LjQsMTJsLTI1LjUsNi4xTDIxLjIsMS41Yy0wLjgtMS4yLTEtMS42LTIuOC0xLjVDMTYuNiwwLjEsMi41LDEuMywxLjUsMS4zYy0xLDAuMS0yLjEsMC41LTEuMSwyLjkKCWMxLDIuNCwxNywzNi44LDE3LjQsMzcuOGMwLjQsMSwxLjYsMi42LDQuMywyYzIuOC0wLjcsMTIuNC0zLjIsMTcuNy00LjZjMi44LDUsOC40LDE1LjIsOS41LDE2LjdjMS40LDIsMi40LDEuNiw0LjUsMQoJYzEuNy0wLjUsMjYuMi05LjMsMjcuMy05LjhjMS4xLTAuNSwxLjgtMC44LDEtMS45Yy0wLjYtMC44LTctOS41LTEwLjQtMTRjMi4zLTAuNiwxMC42LTIuOCwxMS41LTMuMUM4NC4yLDI4LDg0LjQsMjcuNSw4My44LDI2Ljl6CgkgTTM3LjUsMzYuNGMtMC4zLDAuMS0xNC42LDMuNS0xNS4zLDMuN2MtMC44LDAuMi0wLjgsMC4xLTAuOC0wLjJDMjEuMiwzOS42LDQuNCw0LjgsNC4xLDQuNGMtMC4yLTAuNC0wLjItMC44LDAtMC44CgljMC4yLDAsMTMuNS0xLjIsMTMuOS0xLjJjMC41LDAsMC40LDAuMSwwLjYsMC40YzAsMCwxOC43LDMyLjMsMTksMzIuOEMzOCwzNi4xLDM3LjgsMzYuMywzNy41LDM2LjR6IE03Ny43LDQzLjkKCWMwLjIsMC40LDAuNSwwLjYtMC4zLDAuOGMtMC43LDAuMy0yNC4xLDguMi0yNC42LDguNGMtMC41LDAuMi0wLjgsMC4zLTEuNC0wLjZzLTguMi0xNC04LjItMTRMNjguMSwzMmMwLjYtMC4yLDAuOC0wLjMsMS4yLDAuMwoJQzY5LjcsMzMsNzcuNSw0My42LDc3LjcsNDMuOXogTTc5LjMsMjYuM2MtMC42LDAuMS05LjcsMi40LTkuNywyLjRsLTcuNS0xMC4yYy0wLjItMC4zLTAuNC0wLjYsMC4xLTAuN2MwLjUtMC4xLDktMS42LDkuNC0xLjcKCWMwLjQtMC4xLDAuNy0wLjIsMS4yLDAuNWMwLjUsMC42LDYuOSw4LjgsNy4yLDkuMUM4MC4zLDI2LDc5LjksMjYuMiw3OS4zLDI2LjN6Ii8+Cjwvc3ZnPg=="

/***/ }),
/* 718 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/plugins.png";

/***/ }),
/* 719 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/responsive.png";

/***/ }),
/* 720 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-addon-scan.png";

/***/ }),
/* 721 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-speed-improvements.png";

/***/ }),
/* 722 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/issue-toolbar-styles.png";

/***/ }),
/* 723 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/ss-codex-document.png";

/***/ }),
/* 724 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/ss-codex-phpdoc.png";

/***/ }),
/* 725 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "assets/img/ss-codex.png";

/***/ }),
/* 726 */
/***/ (function(module, exports) {

module.exports = "data:image/png;base64,bW9kdWxlLmV4cG9ydHMgPSB7c3JjU2V0Ol9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyA1NzZ3IisiLCIrX193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtaHRtbC03NjgucG5nIDc2OHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTkyMi5wbmcgOTIydyIrIiwiK19fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtMTIwMC5wbmcgMTIwMHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTIwMDAucG5nIDIwMDB3IixpbWFnZXM6W3twYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyIsd2lkdGg6NTc2LGhlaWdodDoyODh9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNzY4LnBuZyIsd2lkdGg6NzY4LGhlaWdodDozODR9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtOTIyLnBuZyIsd2lkdGg6OTIyLGhlaWdodDo0NjF9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtMTIwMC5wbmciLHdpZHRoOjEyMDAsaGVpZ2h0OjYwMH0se3BhdGg6X193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtaHRtbC0yMDAwLnBuZyIsd2lkdGg6MjAwMCxoZWlnaHQ6MTAwMH1dLHNyYzpfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS1odG1sLTU3Ni5wbmciLHRvU3RyaW5nOmZ1bmN0aW9uKCl7cmV0dXJuIF9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLWh0bWwtNTc2LnBuZyJ9LHBsYWNlaG9sZGVyOiAiZGF0YTppbWFnZS9wbmc7YmFzZTY0LGlWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFDZ0FBQUFVQ0FZQUFBRC9Sbis3QUFBQUFrbEVRVlI0QWV3YWZ0SUFBQVE5U1VSQlZKWEJ5WEtrU1JHRjBjODlJbkpRU3FvQ3JKZnMyY0Q3UHc4WUc2eTdpbElPL3hEaGZsR3FyZHBFV2czU09mYjNmL3d0bnpGaWdBQUR4SXZIelo2N1gvWWMvenNEeG5LZUdDVGY4K0Z4eTdJS3BkTlNsQ0ZPYlZBM2lRSTJleWM2K0ZTWk5NaE12a1VTKy9zOTgzbWw4anREdkRBTUliWnR3em82VC8rZUtNVXhNOElFNHY4VU54NGVHaEdDTkRJR21ERnBRQTEyZjM2a3o4WjJIaERPMUkrMDdjckJHajBhYzEvNEFWVkpTT0sxV2l0RnNMcW9YakF6eGdoS01Wb3RlREh1RDQyMWkzbnFmSGxha2VEK3pyZ3lNNjdjQ2prZEtZTGNPNGZ0am5VeVlvamowdmtoRmE0cTN4QVJSQlc3dlZQZEtjVnBkY004VnBZMVNCbS8vamFJRUZkbUJvaXJFYUk1bUJrUmdmSUJNOWhNblUvVGpEZWpaV093OGlPK0FTNVF6UUF6dmhLaWV1R3dLMFFacENleE9wZUxLTVVwUU5kZ3Uyc1UzOENhck92S1FsQnJaYnN4SXNWVmFVNHJSNnh1MEc3SEljVHBhV1lkS3orak1LNXFSQ0tKcnd4alJQRHBHT3k5c2ZYSzNHYmtRcU5nWmxSdmFCVE9mU0l6K2FvVXc0c1JLU1NoRG1zOW9DVmdIQmt0MlI0TU96dXpJQ0w0SG5kaEJyV1VRbWFTbWR4cXJXSjNzT2ZBZnJlbGorVDgrY1I1ZEtCelN3SmtnREF6ckFhN2V5RXFkYWtzNTRuTE5JRGdaeklEQ1NvU2tyalZhc1BEbUtaa21VOTg1c1RQbURudVBFdkVzK0djZjUzSVNONHJreGNWTTh5TTEwcXBiTTA1YVlFQnBSYXVJaEpKdkZhTGN6aFVJa1dtaUF5dWFvVnlhRmk5WXpsM3RLN0V1dkIyeGxVMU0yNWxCcE1TTDhhbUZid1ltWW5Tc0FLYm5iTnZqY3NVekhQbmVPcGtpb2M3WjU0NnBWYmNuSmhtekJjME9SSEJ1NGdYRmNTdDRzYjl3V0FuSEZHdFFEcGRnOU9wYy9rRW4zUGxWbWx3WDdiTWN4SVJxR3d4MzJPN2djOFRHY0Y3MVRFQ1NidzJJcm1jS3Z1cE1EQXViUWFEWXBWdHEzZ1pWQnBtVy96U09iR1NLWkRSUjhkTFF4SldWeXlDZVVxVXlYdUk1S3FXVW9nSWJxMDVnTXJCR2h1N0o2YVpjM2JNb05YS21xTEhpVzh4YzNwZmFYLzVLNXZ6Q25jVDgva0pTYnhWcVFYb1ZKNlpHZCt5YjQzeW9lRUJEeDgvOHFGM2pxZUp1UThpazFzU3p3eEplSEh5OHo5WjNKQWNTYnhIK2dhWXFUeVR4SzFTQ2t2dmZQblB4RnU1ODhJTWxFbDkvSWltUk1WNGJPSTRucEI0RTYwVFYxVVNtUEZhcVpXRE4yWjFxaFV3WGtRa2t2Z2VpUmRtQmhoc0h0bEVaejMreHROWWVZOEtyQmpWekRDSjF6S0NjeWJtaHBraFJFUWlpVnZ1UnEwR0dGZEtZUVZxSytqcFgzU2NlUVR2bFJnZ3FpUWs4VnB4NC81Z2FDT0tPV1NsRldlSkZReUtGN2ExY1RrUDFuVmdCbjBJU1poRFJCQVJsTU12TUpMTm44UitoYWZMYjBpOGladGpHTlhNdURVaXVad3ErMWFZcTNBTDVoaTRHeGgwSmIyc0xFdXlMSU92RHZzR0dGZVNVSW9hd0h6aW1BT0p0MnVPRUpYZmlSdHJEa3BzMkk3S3ZKM0JoVnNERTBNRGpjWnV0MkcvZjBCUEY3N2t3cFVraWpmcWJzTTRud21lZVdIakJTclBEQkJnL01INGcySE15MEsvZEl6Qy93RDVrcW1Galk5S3NBQUFBQUJKUlU1RXJrSmdnZz09Iix3aWR0aDo1NzYsaGVpZ2h0OjI4OH07"

/***/ }),
/* 727 */
/***/ (function(module, exports) {

module.exports = "data:image/jpeg;base64,bW9kdWxlLmV4cG9ydHMgPSB7c3JjU2V0Ol9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyA1NzZ3IisiLCIrX193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtdHlwZXdyaXRlci03NjguanBnIDc2OHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTkyMi5qcGcgOTIydyIrIiwiK19fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItMTIwMC5qcGcgMTIwMHciKyIsIitfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTIwMDAuanBnIDIwMDB3IixpbWFnZXM6W3twYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyIsd2lkdGg6NTc2LGhlaWdodDozODR9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNzY4LmpwZyIsd2lkdGg6NzY4LGhlaWdodDo1MTJ9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItOTIyLmpwZyIsd2lkdGg6OTIyLGhlaWdodDo2MTV9LHtwYXRoOl9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItMTIwMC5qcGciLHdpZHRoOjEyMDAsaGVpZ2h0OjgwMH0se3BhdGg6X193ZWJwYWNrX3B1YmxpY19wYXRoX18gKyAiYXNzZXRzL2ltZy9zbGlkZXMvc2xpZGUtdHlwZXdyaXRlci0yMDAwLmpwZyIsd2lkdGg6MjAwMCxoZWlnaHQ6MTMzNH1dLHNyYzpfX3dlYnBhY2tfcHVibGljX3BhdGhfXyArICJhc3NldHMvaW1nL3NsaWRlcy9zbGlkZS10eXBld3JpdGVyLTU3Ni5qcGciLHRvU3RyaW5nOmZ1bmN0aW9uKCl7cmV0dXJuIF9fd2VicGFja19wdWJsaWNfcGF0aF9fICsgImFzc2V0cy9pbWcvc2xpZGVzL3NsaWRlLXR5cGV3cml0ZXItNTc2LmpwZyJ9LHBsYWNlaG9sZGVyOiAiZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFBQUFRQUJBQUQvMndDRUFBSUJBUUVCQVFJQkFRRUNBZ0lDQWdRREFnSUNBZ1VFQkFNRUJnVUdCZ1lGQmdZR0J3a0lCZ2NKQndZR0NBc0lDUW9LQ2dvS0JnZ0xEQXNLREFrS0Nnb0JBZ0lDQWdJQ0JRTURCUW9IQmdjS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDZ29LQ2dvS0Nnb0tDdi9BQUJFSUFCc0FLQU1CRVFBQ0VRRURFUUgveEFHaUFBQUJCUUVCQVFFQkFRQUFBQUFBQUFBQUFRSURCQVVHQndnSkNnc1FBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNStnRUFBd0VCQVFFQkFRRUJBUUFBQUFBQUFBRUNBd1FGQmdjSUNRb0xFUUFDQVFJRUJBTUVCd1VFQkFBQkFuY0FBUUlERVFRRklURUdFa0ZSQjJGeEV5SXlnUWdVUXBHaHNjRUpJek5TOEJWaWN0RUtGaVEwNFNYeEZ4Z1pHaVluS0NrcU5UWTNPRGs2UTBSRlJrZElTVXBUVkZWV1YxaFpXbU5rWldabmFHbHFjM1IxZG5kNGVYcUNnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmk0K1RsNXVmbzZlcnk4L1QxOXZmNCtmci8yZ0FNQXdFQUFoRURFUUEvQVBudnhiKzFMOGNmaFg4Y0didzNmTm9NZWlhcEZJbGhiTzNsM3lJU1Y4ODhHUkhWamxlQmhzZFZCcm5vNERCNGpDYSs4MnQrM3A2SGs0M01NZFF4dkw4S2k5dTY4KzU5NmZ0QWZIV0Q0bi84RXlkYStQUHdjdlVqMUtWb2Jrb0ZXUjdLNE45R1pZbVZ1R1lCbkhvM0JIVUd2bjhCUytxWnNxZFRwZjhBSm5wWmh5WmpsamEybGIvMHBINWJhdG9YamZ4WnI4M2lYV2RHOFBYbC9lM0RUM053K2pSRnBaR0pZc2NEQkpKcjZuKzFLTVZhenQ2bmp3NGVySkpLWitqbi9CR3p3bDhRUGpQbzJ0SDRqM2tkMXBlblhFV21RcmFXaXdKQkJDa2JMRXUwRE9RK0FSbmdkZU1WOHpudGVOYXRUVVZiUnY3L0FQaGoyOGt3VU10bzFtbmR0cjhGL3dBRSsrZmpkK3poNEo4ZjZPSnJXeGcwNjhpbVdZTkZBTmtyQTV3eWpISi92RG51YzE1ZXl1anZvNGljSFo2by9IWHhoNEcrR3Y3Vy9qSzEwSHdGNGh0WWZFTVJjYmpqTndxUjRraTJqQnl2bDdnVHo4eHgwTmU5REVZakxJU2sxZGR2MS9Fd3I0TERacktLNXJOZGZ6Ujl0ZnNoZnNwZUR2aDk4QU5ZK0VPcTIvMiswMTYvVk5jam5QOEFyU0g4c0hqb2VPTWNqSEZmT1lqSFlyRVlyMnJkbXRyZEQxRmc4RmhzT3FNSTNqcmUvWDFLUGliL0FJSndmQXV3dmRXaTByUUowaXRkT1NTSUhVcHNCeVhKT04zdHpXTThibURkM08veVgrUnZTcFplb1dWTkx5VjdmbWU2L0FmNFZhZit6cloydmhyNFJXME9tV3MyK2E0dERGdmlubHpHQ3o5Q1RnWXlDRGdEbkhGWXV2aWFrK2VwTG1mbVM2V0VWUGtoQlJqNWFIZi9BQkQvQUduUEEzZ2o0ZTNmakx4dk8yblMyc2pRUTJFaDh4N3VmZVVWWWR2TXU1aHdBTjJPcWppdTJuTDJtaTNPRjRhU25aYkg0djhBd2kxcXgwNzQvYUY0aytDdmh2OEF0VHhtYkROL05lcDVkdGFUdkd5NzJVTUdtTzBIaFNNZzhzdWErbnhFS2tzTkwyN3RUVDB0dS84QUw4VGpvVG8vV0lxaEc4MnRYMFgrZjlhby9WYjRIWEd1YXg4T1Y4WXlhRUI1MnA3ZFFrdG0zb2txVEVQanVGREU4OUJqbnZYeWM0SlRkdGoxSnpWbEZ2VTNwZFR0NWJyeFdaVUpEV3lIbnNQS0kvcFdmTCtmK1E5dVgwL3pOYld2RUZycGVxMmx3VU9Iak8wQTlTV1RyMDlEVU9QVXFDYlZqdzc0cGZGTDRlNnQ0b3RkQzhRNkJzdnRKMUdlNXNMeThUaVBmTmhtVFBCQkFBM0RvY2c0enpqTEZWYUdLVktVWHl5dFpydjJ0L1gzSHBVTUg3WEN5cVFrdVpicnlYVzUrZDM3QnQ1Yy93RENkTmYrWisrTUNvWk5vemdSWnhYMytheGo3S3g4aGxNbTVOLzFzZnFvYjY3OEovc2NhUS9oMmRyUTNiV0J1REYxa054ZEkwMmMvd0I4dTJmOTQxOHUwblVhUFNXdGRITXk2dnFTMkhpVzVXN1lPMEFETUFPUjg0L2xXVmxkZXAwUFpmMTNMWHhSMUM5YndORHFQMmx4UDlrR0pWT0Q4M2w1NmZVMU5LS2N6VGI4VDUvMTlFOFgvczIrSE5lOFJ4cmRYa091WEt4WERLQXlxdHk2cUFWeHdBQU1lMWRrVXZiTXRlN2RJLy9aIix3aWR0aDo1NzYsaGVpZ2h0OjM4NH07"

/***/ }),
/* 728 */,
/* 729 */,
/* 730 */,
/* 731 */,
/* 732 */,
/* 733 */,
/* 734 */,
/* 735 */,
/* 736 */,
/* 737 */,
/* 738 */,
/* 739 */,
/* 740 */,
/* 741 */,
/* 742 */,
/* 743 */,
/* 744 */,
/* 745 */,
/* 746 */,
/* 747 */,
/* 748 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(483),
  /* template */
  __webpack_require__(769),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 749 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(687)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(484),
  /* template */
  __webpack_require__(763),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 750 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(690)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(485),
  /* template */
  __webpack_require__(770),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 751 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(486),
  /* template */
  __webpack_require__(761),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 752 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(689)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(487),
  /* template */
  __webpack_require__(768),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 753 */,
/* 754 */,
/* 755 */,
/* 756 */,
/* 757 */,
/* 758 */,
/* 759 */,
/* 760 */,
/* 761 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('section', {
    staticClass: "c-section",
    class: _vm.sectionClass
  }, [(_vm.fullWidth) ? _vm._t("default") : _vm._e(), _vm._v(" "), (_vm.fullWidth === false) ? _c('div', {
    staticClass: "container"
  }, [_vm._t("default")], 2) : _vm._e()], 2)
},staticRenderFns: []}

/***/ }),
/* 762 */,
/* 763 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('v-touch', {
    on: {
      "swipeleft": _vm.prev,
      "swiperight": _vm.next
    }
  }, [_c('div', {
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
  }, [_c('ol', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.indicators),
      expression: "indicators"
    }],
    staticClass: "carousel-indicators"
  }, _vm._l((_vm.slides), function(slide, slideIndex) {
    return _c('li', {
      class: {
        active: _vm.index == slideIndex
      },
      on: {
        "click": function($event) {
          _vm.changeSlide(slideIndex)
        }
      }
    })
  })), _vm._v(" "), _c('div', {
    staticClass: "carousel-inner",
    attrs: {
      "role": "listbox"
    }
  }, [_vm._t("default")], 2), _vm._v(" "), _vm._t("control-left", [_c('a', {
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
  }, [_c('span', {
    staticClass: "icon-prev",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "sr-only"
  }, [_vm._v("Previous")])])]), _vm._v(" "), _vm._t("control-right", [_c('a', {
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
  }, [_c('span', {
    staticClass: "icon-next",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "sr-only"
  }, [_vm._v("Next")])])]), _vm._v(" "), _vm._t("control-bottom", [_c('a', {
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
  }, [_c('i', {
    staticClass: "fa fa-chevron-down"
  })])])], 2)])
},staticRenderFns: []}

/***/ }),
/* 764 */,
/* 765 */,
/* 766 */,
/* 767 */,
/* 768 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 769 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "carousel-item",
    style: (_vm.styles)
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 770 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "container"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-4"
  }, [_c('h4', {
    staticClass: "section-title"
  }, [_vm._v("Navigation")]), _vm._v(" "), _c('hr', {
    staticClass: "section-title-divider"
  }), _vm._v(" "), _c('ul', {
    staticClass: "nav nav-footer"
  }, [_c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }],
    staticClass: "nav-link",
    attrs: {
      "href": "#welcome"
    }
  }, [_vm._v("Welcome")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }],
    staticClass: "nav-link",
    attrs: {
      "href": "#features"
    }
  }, [_vm._v("Features")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }],
    staticClass: "nav-link",
    attrs: {
      "href": "#overview"
    }
  }, [_vm._v("Overview")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }],
    staticClass: "nav-link",
    attrs: {
      "href": "#getting-started"
    }
  }, [_vm._v("Getting Started")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    directives: [{
      name: "scroll-to",
      rawName: "v-scroll-to:href",
      value: ({
        offset: -50
      }),
      expression: "{ offset: -50 }",
      arg: "href"
    }],
    staticClass: "nav-link",
    attrs: {
      "href": "#documentation"
    }
  }, [_vm._v("Documentation")])])])]), _vm._v(" "), _vm._m(0), _vm._v(" "), _vm._m(1)])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-4"
  }, [_c('h4', {
    staticClass: "section-title"
  }, [_vm._v("Social")]), _vm._v(" "), _c('hr', {
    staticClass: "section-title-divider"
  }), _vm._v(" "), _c('ul', {
    staticClass: "nav nav-footer-social"
  }, [_c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "target": "_blank",
      "href": "https://github.com/codex-project"
    }
  }, [_c('i', {
    staticClass: "fa fa-github"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-facebook"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-google-plus"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-twitter"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-slack"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-linkedin"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-youtube"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-pinterest-p"
  })])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-md-4"
  }, [_c('h4', {
    staticClass: "section-title"
  }, [_vm._v("Related")]), _vm._v(" "), _c('hr', {
    staticClass: "section-title-divider"
  }), _vm._v(" "), _c('ul', {
    staticClass: "nav nav-footer"
  }, [_c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "target": "_blank",
      "href": "https://packagist.org/packages/codex"
    }
  }, [_vm._v("Packagist")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "target": "_blank",
      "href": "https://www.npmjs.com/package/codex-theme"
    }
  }, [_vm._v("NPMJS")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "target": "_blank",
      "href": "https://github.com/codex-project/codex/blob/master/LICENSE.md"
    }
  }, [_vm._v("MIT License")])]), _vm._v(" "), _c('li', {
    staticClass: "nav-item"
  }, [_c('a', {
    staticClass: "nav-link",
    attrs: {
      "target": "_blank",
      "href": "#welcome"
    }
  }, [_vm._v("Contributing")])])])])
}]}

/***/ }),
/* 771 */,
/* 772 */,
/* 773 */,
/* 774 */,
/* 775 */,
/* 776 */,
/* 777 */,
/* 778 */,
/* 779 */,
/* 780 */,
/* 781 */,
/* 782 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(38);
module.exports = __webpack_require__(441);


/***/ })
],[782]);
//# sourceMappingURL=codex.welcome.js.map