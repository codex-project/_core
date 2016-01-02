
module packadic {

    import DeferredInterface = packadic.util.promise.DeferredInterface;
    import PromiseInterface = packadic.util.promise.PromiseInterface;

    declare var hljs:HighlightJS;

    export function highlight(code:string, lang?:string, wrap:boolean = false, wrapPre:boolean = false):util.promise.PromiseInterface<string> {
        if (!defined(hljs)) {
            console.warn('Cannot call highlight function in packadic.plugins, hljs is not defined');
            return;
        }

        var defer:util.promise.DeferredInterface<string> = util.promise.create();

        var highlighted;
        if (lang && hljs.getLanguage(lang)) {
            highlighted = hljs.highlight(lang, code).value;
        } else {
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

    export function makeSlimScroll(el:any, opts:any = {}) {
        var $el:JQuery = typeof(el) === 'string' ? $(el) : el;

        $el.each(function () {
            if ($(this).attr("data-initialized")) {
                return; // exit
            }
            var height;

            if ($(this).attr("data-height")) {
                height = $(this).attr("data-height");
            } else {
                height = $(this).css('height');
            }

            var o:any = app.config('vendor.slimscroll');

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

    export function destroySlimScroll(el:any) {
        var $el:JQuery = typeof(el) === 'string' ? $(el) : el;
        $el.each(function () {
            if ($(this).attr("data-initialized") === "1") { // destroy existing instance before updating the height
                $(this).removeAttr("data-initialized");
                $(this).removeAttr("style");

                var attrList = {};

                // store the custom attribures so later we will reassign.
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

               $(this).slimScroll(<any> {
                    wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                    destroy: true
                });

                var the = $(this);

                // reassign custom attributes
                $.each(attrList, function (key, value) {
                    the.attr(key, value);
                });

                //$(this).parent().find('.slimScrollBar, .slimScrollRail').remove();
                //$(this).unwrap();
            }
        });
    }

    export function registerHelperPlugins() {
        if (kindOf($.fn.prefixedData) === 'function') {
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

        $.fn.removeAttributes = function ():JQuery {
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

        $.fn.ensureClass = function (clas:string, has:boolean = true):JQuery {

            var $this:JQuery = $(this);
            if (has === true && $this.hasClass(clas) === false) {
                $this.addClass(clas);
            } else if (has === false && $this.hasClass(clas) === true) {
                $this.removeClass(clas);
            }
            return this;
        };

        $.fn.onClick = function(...args:any[]):JQuery{
            var $this = $(this);
            return $this.on.apply($this, [isTouchDevice() ? 'touchend' : 'click'].concat(args));
        }
    }

}
