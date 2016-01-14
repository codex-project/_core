module codex.util {

    export var str:UnderscoreStringStatic = s;
    export var arr:_.LoDashStatic = _;

    export interface OpenWindowOptions {
        width?:number;
        height?:number;
        url?:string;
        target?:string;
        features?:string;
        replace?:boolean;
        content?:string;
        cb?:Function;
    }

    export var openWindowDefaults:OpenWindowOptions = {
        width: 600,
        height: 600
    };

    export function openWindow(opts:OpenWindowOptions={}):Window{
        opts = $.extend({}, openWindowDefaults, opts);
        var win = window.open('', '', 'width=' + opts.width + ', height=' + opts.height);
        if(defined(opts.content)) {
            win.document.body.innerHTML = opts.content;
        }
        return win;
    }

    export function codeIndentFix(str:string) {
        var fix = (code:string, leading:boolean = true) => {
            var txt = code;
            if (leading) {
                txt = txt.replace(/^[\r\n]+/, "").replace(/\s+$/g, "");	// strip leading newline
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

    export function preCodeIndentFix(el:HTMLElement) {
        return codeIndentFix(el.textContent);
    }

    export module num {
        /**
         * Round a value to a precision
         * @param value
         * @param places
         * @returns {number}
         */
        export function round(value, places) {
            var multiplier = Math.pow(10, places);
            return (Math.round(value * multiplier) / multiplier);
        }

    }

    /**
     * Create a string from an object
     *
     * @param object
     * @returns {any}
     */
    export function makeString(object) {
        if (object == null) return '';
        return '' + object;
    }


    export function defaultToWhiteSpace(characters) {
        if (characters == null)
            return '\\s';
        else if (characters.source)
            return characters.source;
        else
            return '[' + str.escapeRegExp(characters) + ']';
    }

}
