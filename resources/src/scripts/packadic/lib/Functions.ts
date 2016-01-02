module packadic {

    import DeferredInterface = packadic.util.promise.DeferredInterface;
    import PromiseInterface = packadic.util.promise.PromiseInterface;

    var kindsOf:any = {};
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

    /**
     * Returns the type of a variablse
     *
     * @param value
     * @returns {any}
     */
    export function kindOf(value:any):any {
        // Null or undefined.
        if (value == null) {
            return String(value);
        }
        // Everything else.
        return kindsOf[kindsOf.toString.call(value)] || 'object';
    }

    /**
     * If val is not defined, return def as default
     * @param val
     * @param def
     * @returns {any}
     */
    export function def(val, def) {
        return defined(val) ? val : def;
    }

    /**
     * Checks wether the passed variable is defined
     *
     * @param obj
     * @returns {boolean}
     */
    export function defined(obj?:any) {
        return !_.isUndefined(obj);
    }

    /**
     * Create a element wrapped in jQuery
     * @param name
     * @returns {JQuery}
     */
    export function cre(name?:string) {
        if (!defined(name)) {
            name = 'div';
        }
        return $(document.createElement(name));
    }

    /**
     * Get the current viewport
     * @returns {{width: *, height: *}}
     */
    export function getViewPort():any {
        var e:any = window,
            a:any = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }

        return {
            width: e[a + 'Width'],
            height: e[a + 'Height']
        };
    }

    /**
     * Checks if the device currently used is a touch device
     * @returns {boolean}
     */
    export function isTouchDevice():boolean {
        try {
            document.createEvent("TouchEvent");
            return true;
        } catch (e) {
            return false;
        }
    }

    /**
     * Get a random generated id string
     *
     * @param length
     * @returns {string}
     */
    export function getRandomId(length?:number):string {
        if (!_.isNumber(length)) {
            length = 15;
        }
        var text:string = "";
        var possible:string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    export function getTemplate(name):any {

        if(!defined(window['JST'][name])){
            throw new Error('Template [' + name + '] not found');
        }
        return window['JST'][name];
    }



}
