/// <reference path="./../types.d.ts" />
/// <reference path="./../codex.d.ts" />
var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") return Reflect.decorate(decorators, target, key, desc);
    switch (arguments.length) {
        case 2: return decorators.reduceRight(function(o, d) { return (d && d(o)) || o; }, target);
        case 3: return decorators.reduceRight(function(o, d) { return (d && d(target, key)), void 0; }, void 0);
        case 4: return decorators.reduceRight(function(o, d) { return (d && d(target, key, o)) || o; }, desc);
    }
};
var codex;
(function (codex) {
    var extensions;
    (function (extensions) {
        var defaultConfig = {
            selectors: {
                'search': '.sidebar-search',
                'header': '.page-header',
                'header-inner': '<%= layout.selectors.header %> .page-header-inner',
                'container': '.page-container',
                'sidebar-wrapper': '.page-sidebar-wrapper',
                'sidebar': '.page-sidebar',
                'sidebar-menu': '.page-sidebar-menu',
                'content-wrapper': '.page-content-wrapper',
                'content': '.page-content',
                'content-head': '<%= layout.selectors.content %> .page-head',
                'content-breadcrumbs': '<%= layout.selectors.content %> .page-breadcrumbs',
                'content-inner': '<%= layout.selectors.content %> .page-content-inner',
                'footer': '.page-footer',
                'footer-inner': '.page-footer-inner',
            },
            breakpoints: {
                'screen-lg-med': "1260px",
                'screen-lg-min': "1200px",
                'screen-md-max': "1199px",
                'screen-md-min': "992px",
                'screen-sm-max': "991px",
                'screen-sm-min': "768px",
                'screen-xs-max': "767px",
                'screen-xs-min': "480px"
            },
            breakpoints4: {
                xs: 0,
                sm: 544,
                md: 768,
                lg: 992,
                xl: 1200
            },
            sidebar: {
                autoScroll: true,
                keepExpanded: true,
                slideSpeed: 200,
                togglerSelector: '.sidebar-toggler',
                openCloseDuration: 600,
                openedWidth: 235,
                closedWidth: 54,
                resolveActive: true
            },
            preferences: {
                sidebar: {
                    hidden: false,
                    closed: false,
                    reversed: false,
                    fixed: true,
                    condensed: false,
                },
                header: {
                    fixed: true
                },
                footer: {
                    fixed: true
                },
                page: {
                    boxed: false
                }
            },
        };
        var $window = $(window), $document = $(document), $body = $('body');
        var Elements = (function () {
            function Elements(layout) {
                this.l = layout;
            }
            Object.defineProperty(Elements.prototype, "header", {
                get: function () {
                    return this.l.e('header');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "headerInner", {
                get: function () {
                    return this.l.e('header-inner');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "container", {
                get: function () {
                    return this.l.e('container');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "content", {
                get: function () {
                    return this.l.e('content');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "sidebar", {
                get: function () {
                    return this.l.e('sidebar');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "sidebarMenu", {
                get: function () {
                    return this.l.e('sidebar-menu');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "footer", {
                get: function () {
                    return this.l.e('footer');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(Elements.prototype, "footerInner", {
                get: function () {
                    return this.l.e('footer-inner');
                },
                enumerable: true,
                configurable: true
            });
            return Elements;
        })();
        var el;
        var LayoutExtension = (function (_super) {
            __extends(LayoutExtension, _super);
            function LayoutExtension() {
                _super.apply(this, arguments);
                this.openCloseInProgress = false;
                this.closing = false;
            }
            LayoutExtension.prototype.init = function () {
                var _this = this;
                this.app.debug.log('LayoutComponent init');
                this.app.on('booted', function () {
                    codex.debug.log('layout received event emitted from app: booted');
                    _this.removePageLoader();
                });
            };
            LayoutExtension.prototype.boot = function () {
                codex.debug.log('LayoutComponent debug');
                el = new Elements(this);
                this._initLayoutApiActions();
                this._initHeader();
                this._initFixed();
                this._initSidebarSubmenus();
                this._initToggleButton();
                this._initGoTop();
                this.sidebarResolveActive();
                this.fixBreadcrumb();
                this._initResizeEvent();
                this._initSidebarResizeListener();
                this._initEdgedHeightResizeListener();
            };
            LayoutExtension.prototype._initLayoutApiActions = function () {
                var _this = this;
                var self = this;
                this._apiCallbacks = {};
                var apiActions = {
                    'theme': function (themeName) {
                        _this.setTheme(themeName);
                    },
                    'page-boxed': function () {
                        _this.setBoxed(!_this.isBoxed());
                    },
                    'page-edged': function () {
                        _this.setEdged(!_this.isEdged());
                    },
                    'header-fixed': function () {
                        _this.setHeaderFixed(!_this.isHeaderFixed());
                    },
                    'footer-fixed': function () {
                        _this.setFooterFixed(!_this.isFooterFixed());
                    },
                    'sidebar-toggle': function () {
                        _this.isSidebarClosed() ? _this.openSidebar() : _this.closeSidebar();
                    },
                    'sidebar-fixed': function () {
                        _this.setSidebarFixed(!_this.isSidebarFixed());
                    },
                    'sidebar-close-submenus': function () {
                        _this.closeSubmenus();
                    },
                    'sidebar-close': function () {
                        _this.closeSidebar();
                    },
                    'sidebar-open': function () {
                        _this.openSidebar();
                    },
                    'sidebar-hide': function () {
                        _this.hideSidebar();
                    },
                    'sidebar-show': function () {
                        _this.showSidebar();
                    },
                    'sidebar-condensed': function () {
                        _this.setSidebarCondensed(!_this.isSidebarCondensed());
                    },
                    'sidebar-hover': function () {
                        _this.setSidebarHover(!_this.isSidebarHover());
                    },
                    'sidebar-reversed': function () {
                        _this.setSidebarReversed(!_this.isSidebarReversed());
                    },
                };
                this.setApiActions(apiActions);
                $body.onClick('[data-layout-api]', function (e) {
                    e.stopImmediatePropagation();
                    e.stopPropagation();
                    e.preventDefault();
                    var action = $(this).attr('data-layout-api');
                    var args = $(this).attr('data-layout-api-args');
                    self.api(action, args);
                });
            };
            LayoutExtension.prototype.setApiAction = function (actionName, callbackFn) {
                this._apiCallbacks[actionName] = callbackFn;
            };
            LayoutExtension.prototype.setApiActions = function (apiActions) {
                var _this = this;
                console.log('setapi actions', apiActions, this);
                $.each(apiActions, function (actionName, actionFn) {
                    _this.setApiAction(actionName, actionFn);
                });
            };
            LayoutExtension.prototype.api = function (action) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
                var self = this;
                if (!this._apiCallbacks[action]) {
                    throw new Error('Layout api action ' + action + ' does not exist');
                }
                this._apiCallbacks[action].apply(this._apiCallbacks[action], args);
            };
            LayoutExtension.prototype.removePageLoader = function () {
                $body.removeClass('page-loading');
            };
            LayoutExtension.prototype.createLoader = function (name, el) {
                return new Loader(name, el);
            };
            LayoutExtension.prototype.e = function (selectorName) {
                var selector = this.config.get('layout.selectors.' + selectorName);
                return $(selector);
            };
            LayoutExtension.prototype._initResizeEvent = function () {
                var _this = this;
                var resize;
                $(window).resize(function () {
                    if (resize) {
                        clearTimeout(resize);
                    }
                    resize = setTimeout(function () {
                        _this.app.emit('resize');
                    }, 50);
                });
            };
            LayoutExtension.prototype._initSidebarResizeListener = function () {
                var _this = this;
                var resizing = false;
                this.app.on('resize', function () {
                    if (resizing) {
                        return;
                    }
                    resizing = true;
                    setTimeout(function () {
                        _this._initFixed();
                        resizing = false;
                    }, _this.config('layout.sidebar.slideSpeed'));
                });
            };
            LayoutExtension.prototype._initEdgedHeightResizeListener = function () {
                var _this = this;
                var listener = function () {
                    if (_this.isEdged() && codex.getViewPort().width >= _this.getBreakpoint('md')) {
                        codex.debug.log('edged height resize', 'viewport height', codex.getViewPort().height, 'calculated', _this.calculateViewportHeight());
                        el.sidebarMenu.css('min-height', _this.calculateViewportHeight());
                        el.content.css('min-height', _this.calculateViewportHeight());
                    }
                    else {
                        el.sidebarMenu.removeAttr('style');
                        el.content.removeAttr('style');
                    }
                };
                this.app.on('resize', listener);
                this.app.on('sidebar:closed', listener);
                this.app.on('sidebar:opened', listener);
                listener();
            };
            LayoutExtension.prototype._initHeader = function () {
                var self = this;
            };
            LayoutExtension.prototype.fixBreadcrumb = function () {
                var $i = $('.page-breadcrumb').find('> li').last().find('i');
                if ($i.size() > 0) {
                    $i.remove();
                }
            };
            LayoutExtension.prototype._initGoTop = function () {
                var self = this;
                var offset = 300;
                var duration = 500;
                if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
                    $window.bind("touchend touchcancel touchleave", function (e) {
                        if ($(this).scrollTop() > offset) {
                            $('.scroll-to-top').fadeIn(duration);
                        }
                        else {
                            $('.scroll-to-top').fadeOut(duration);
                        }
                    });
                }
                else {
                    $window.scroll(function () {
                        if ($(this).scrollTop() > offset) {
                            $('.scroll-to-top').fadeIn(duration);
                        }
                        else {
                            $('.scroll-to-top').fadeOut(duration);
                        }
                    });
                }
                $('.scroll-to-top').click(function (e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, duration);
                    return false;
                });
            };
            LayoutExtension.prototype._initFixed = function () {
                codex.destroySlimScroll(el.sidebarMenu);
                if (!this.isSidebarFixed()) {
                    return;
                }
                if (codex.getViewPort().width >= this.getBreakpoint('md')) {
                    el.sidebarMenu.attr("data-height", this.calculateViewportHeight());
                    codex.makeSlimScroll(el.sidebarMenu, {
                        position: this.isSidebarReversed() ? 'left' : 'right',
                        allowPageScroll: false
                    });
                }
            };
            LayoutExtension.prototype._initSidebarSubmenus = function () {
                var self = this;
                el.sidebar.onClick('li > a', function (e) {
                    var $this = $(this);
                    if (codex.getViewPort().width >= self.getBreakpoint('md') && $this.parents('.page-sidebar-menu-hover-submenu').size() === 1) {
                        return;
                    }
                    if ($this.next().hasClass('sub-menu') === false) {
                        if (codex.getViewPort().width < self.getBreakpoint('md') && el.sidebarMenu.hasClass("in")) {
                            $('.page-header .responsive-toggler').click();
                        }
                        return;
                    }
                    if ($this.next().hasClass('sub-menu always-open')) {
                        return;
                    }
                    var $parent = $this.parent().parent();
                    var $subMenu = $this.next();
                    if (self.config('layout.sidebar.keepExpand') !== true) {
                        $parent.children('li.open').children('a').children('.arrow').removeClass('open');
                        $parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(self.config('layout.sidebar.slideSpeed'));
                        $parent.children('li.open').removeClass('open');
                    }
                    var slideOffeset = -200;
                    var visible = $subMenu.is(":visible");
                    $this.find('.arrow').ensureClass("open", !visible);
                    $this.parent().ensureClass("open", !visible);
                    codex.debug.log('sidebarsubmenu', visible, $this, $subMenu);
                    $subMenu[visible ? 'slideUp' : 'slideDown'](self.config('layout.sidebar.slideSpeed'), function () {
                        if (self.config('layout.sidebar.autoScroll') === true && self.isSidebarClosed() === false) {
                            if (self.isSidebarFixed()) {
                                el.sidebarMenu.slimScroll({ scrollTo: $this.position().top });
                            }
                            else {
                                self.scrollTo($this, slideOffeset);
                            }
                        }
                    });
                    e.preventDefault();
                });
                $document.onClick('.page-header-fixed-mobile .responsive-toggler', function () {
                    self.scrollTop();
                });
            };
            LayoutExtension.prototype._initToggleButton = function () {
                return;
                var self = this;
                $body.onClick(self.config('layout.sidebar.togglerSelector'), function (e) {
                    if (self.isSidebarClosed()) {
                        self.openSidebar();
                    }
                    else {
                        self.closeSidebar();
                    }
                });
                self._initFixedHovered();
            };
            LayoutExtension.prototype._initFixedHovered = function () {
                var self = this;
                if (self.isSidebarFixed()) {
                    el.sidebarMenu.on('mouseenter', function () {
                        if (self.isSidebarClosed()) {
                            el.sidebar.removeClass('page-sidebar-menu-closed');
                        }
                    }).on('mouseleave', function () {
                        if (self.isSidebarClosed()) {
                            el.sidebar.addClass('page-sidebar-menu-closed');
                        }
                    });
                }
            };
            LayoutExtension.prototype.setSidebarClosed = function (closed) {
                if (closed === void 0) { closed = true; }
                $body.ensureClass("page-sidebar-closed", closed);
                el.sidebarMenu.ensureClass("page-sidebar-menu-closed", closed);
                if (this.isSidebarClosed() && this.isSidebarFixed()) {
                    el.sidebarMenu.trigger("mouseleave");
                }
            };
            LayoutExtension.prototype.closeSubmenus = function () {
                el.sidebarMenu.children('li.open').children('a').children('.arrow').removeClass('open');
                el.sidebarMenu.children('li.open').children('.sub-menu:not(.always-open)').slideUp(this.config('layout.sidebar.slideSpeed'));
                el.sidebarMenu.children('li.open').removeClass('open');
                this.app.emit('layout:sidebar:close-submenus');
            };
            LayoutExtension.prototype.closeSidebar = function (callback) {
                var self = this;
                var $main = $('main');
                if (self.openCloseInProgress || self.isSidebarClosed()) {
                    return;
                }
                self.openCloseInProgress = true;
                self.closing = true;
                var defer = $.Deferred();
                this.app.emit('layout:sidebar:close');
                self.closeSubmenus();
                var $title = el.sidebarMenu.find('li a span.title, li a span.arrow');
                async.parallel([
                    function (cb) {
                        el.content.animate({
                            'margin-left': self.config('layout.sidebar.closedWidth')
                        }, self.config('layout.sidebar.openCloseDuration'), function () {
                            cb();
                        });
                    },
                    function (cb) {
                        el.sidebar.animate({
                            width: self.config('layout.sidebar.closedWidth')
                        }, self.config('layout.sidebar.openCloseDuration'), function () {
                            cb();
                        });
                    },
                    function (cb) {
                        var closed = 0;
                        $title.animate({
                            opacity: 0
                        }, self.config('layout.sidebar.openCloseDuration') / 3, function () {
                            closed++;
                            if (closed == $title.length) {
                                $title.css('display', 'none');
                                cb();
                            }
                        });
                    }
                ], function (err, results) {
                    self.setSidebarClosed(true);
                    el.sidebar.removeAttr('style');
                    el.content.removeAttr('style');
                    $title.removeAttr('style');
                    self.closing = false;
                    self.openCloseInProgress = false;
                    if (_.isFunction(callback)) {
                        callback();
                    }
                    defer.resolve();
                    self.app.emit('layout:sidebar:closed');
                    self.app.emit('resize');
                });
                return defer.promise();
            };
            LayoutExtension.prototype.openSidebar = function (callback) {
                var self = this;
                if (self.openCloseInProgress || !self.isSidebarClosed()) {
                    return;
                }
                self.openCloseInProgress = true;
                var defer = $.Deferred();
                var $title = el.sidebarMenu.find('li a span.title, li a span.arrow');
                self.setSidebarClosed(false);
                this.app.emit('layout:sidebar:open');
                async.parallel([
                    function (cb) {
                        el.content.css('margin-left', self.config('layout.sidebar.closedWidth'))
                            .animate({
                            'margin-left': self.config('layout.sidebar.openedWidth')
                        }, self.config('layout.sidebar.openCloseDuration'), function () {
                            cb();
                        });
                    },
                    function (cb) {
                        el.sidebar.css('width', self.config('layout.sidebar.closedWidth'))
                            .animate({
                            width: self.config('layout.sidebar.openedWidth')
                        }, self.config('layout.sidebar.openCloseDuration'), function () {
                            cb();
                        });
                    },
                    function (cb) {
                        var opened = 0;
                        $title.css({
                            opacity: 0,
                            display: 'none'
                        });
                        setTimeout(function () {
                            $title.css('display', 'initial');
                            $title.animate({
                                opacity: 1
                            }, self.config('layout.sidebar.openCloseDuration ') / 2, function () {
                                opened++;
                                if (opened == $title.length) {
                                    $title.css('display', 'none');
                                    cb();
                                }
                            });
                        }, self.config('layout.sidebar.openCloseDuration') / 2);
                    }
                ], function (err, results) {
                    el.content.removeAttr('style');
                    el.sidebar.removeAttr('style');
                    $title.removeAttr('style');
                    self.openCloseInProgress = false;
                    if (_.isFunction(callback)) {
                        callback();
                    }
                    defer.resolve();
                    self.app.emit('layout:sidebar:opened');
                    self.app.emit('resize');
                });
                return defer.promise();
            };
            LayoutExtension.prototype.hideSidebar = function () {
                if (this.config('layout.preferences.sidebar.hidden')) {
                    return;
                }
                if (!$body.hasClass('page-sidebar-closed')) {
                    $body.addClass('page-sidebar-closed');
                }
                if (!$body.hasClass('page-sidebar-hide')) {
                    $body.addClass('page-sidebar-hide');
                }
                $('header.top .sidebar-toggler').hide();
                this.app.emit('layout:sidebar:hide');
            };
            LayoutExtension.prototype.showSidebar = function () {
                $body.removeClass('page-sidebar-closed')
                    .removeClass('page-sidebar-hide');
                $('header.top .sidebar-toggler').show();
                this.app.emit('layout:sidebar:show');
            };
            LayoutExtension.prototype.sidebarResolveActive = function () {
                var self = this;
                if (this.config('layout.sidebar.resolveActive') !== true)
                    return;
                var currentPath = codex.util.str.trim(location.pathname.toLowerCase(), '/');
                var md = this.getBreakpoint('md');
                if (codex.getViewPort().width < md) {
                    return;
                }
                el.sidebarMenu.find('a').each(function () {
                    var href = $(this).attr('href');
                    if (!_.isString(href)) {
                        return;
                    }
                    href = codex.util.str.trim(href)
                        .replace(location['origin'], '')
                        .replace(/\.\.\//g, '');
                    if (location['hostname'] !== 'localhost') {
                    }
                    var path = codex.util.str.trim(href, '/');
                    if (path == currentPath) {
                        var $el = $(this);
                        $el.parent('li').not('.active').addClass('active');
                        var $parentsLi = $el.parents('li').addClass('open');
                        $parentsLi.find('.arrow').addClass('open');
                        $parentsLi.has('ul').children('ul').show();
                    }
                });
            };
            LayoutExtension.prototype.setSidebarFixed = function (fixed) {
                $body.ensureClass("page-sidebar-fixed", fixed);
                if (!fixed) {
                    el.sidebarMenu.unbind('mouseenter').unbind('mouseleave');
                }
                else {
                    this._initFixedHovered();
                }
                this._initFixed();
                this.app.emit('layout:sidebar:fixed', fixed);
            };
            LayoutExtension.prototype.setSidebarCondensed = function (condensed) {
                $body.ensureClass("page-sidebar-condensed", condensed);
                this.app.emit('layout:sidebar:condensed', condensed);
            };
            LayoutExtension.prototype.setSidebarHover = function (hover) {
                el.sidebarMenu.ensureClass("page-sidebar-menu-hover-submenu", hover && !this.isSidebarFixed());
                this.app.emit('layout:sidebar:hover', hover);
            };
            LayoutExtension.prototype.setSidebarReversed = function (reversed) {
                $body.ensureClass("page-sidebar-reversed", reversed);
                this.app.emit('layout:sidebar:reversed', reversed);
            };
            LayoutExtension.prototype.setHeaderFixed = function (fixed) {
                if (fixed === true) {
                    $body.addClass("page-header-fixed");
                    el.header.removeClass("navbar-static-top").addClass("navbar-fixed-top");
                }
                else {
                    $body.removeClass("page-header-fixed");
                    el.header.removeClass("navbar-fixed-top").addClass("navbar-static-top");
                }
                this.app.emit('layout:header:fixed', fixed);
            };
            LayoutExtension.prototype.setFooterFixed = function (fixed) {
                if (fixed === true) {
                    $body.addClass("page-footer-fixed");
                }
                else {
                    $body.removeClass("page-footer-fixed");
                }
                this.app.emit('layout:footer:fixed', fixed);
            };
            LayoutExtension.prototype.setBoxed = function (boxed) {
                $body.ensureClass('page-boxed', boxed);
                el.headerInner.ensureClass("container", boxed);
                if (boxed === true) {
                    var cont = $('body > .clearfix').after('<div class="container"></div>');
                    el.container.appendTo('body > .clearfix + .container');
                    if (this.isFooterFixed()) {
                        el.footerInner.wrap($('<div>').addClass('container'));
                    }
                    else {
                        el.footer.appendTo('body > .clearfix + .container');
                    }
                }
                else {
                    var cont = $('body > .clearfix + .container').children().unwrap();
                    if (this.isFooterFixed()) {
                        el.footerInner.unwrap();
                    }
                }
                this.app.emit('layout:page:boxed', boxed);
            };
            LayoutExtension.prototype.setEdged = function (edged) {
                if (edged && this.isBoxed()) {
                    this.setBoxed(false);
                }
                $body.ensureClass('page-edged', edged);
                this.app.emit('layout:page:edged');
            };
            LayoutExtension.prototype.setTheme = function (name) {
                var $ts = $('#theme-style');
                if ($ts.length === 0) {
                    $ts = codex.cre('link')
                        .attr('href', '#')
                        .attr('rel', 'stylesheet')
                        .attr('type', 'text/css');
                    $('head').append($ts);
                }
                $ts.attr('href', $ts.attr('href').replace(/(.*?\/styles\/themes\/theme)\-.*?\.css/, '$1-' + name + '.css'));
                return this;
            };
            LayoutExtension.prototype.reset = function () {
                $body.
                    removeClass("page-boxed").
                    removeClass("page-edged").
                    removeClass("page-footer-fixed").
                    removeClass("page-sidebar-fixed").
                    removeClass("page-header-fixed").
                    removeClass("page-sidebar-reversed");
                el.header.removeClass('navbar-fixed-top');
                el.headerInner.removeClass("container");
                if (el.container.parent(".container").size() === 1) {
                    el.container.insertAfter('body > .clearfix');
                }
                if ($('.page-footer > .container').size() === 1) {
                    el.footer.html($('.page-footer > .container').html());
                }
                else if (el.footer.parent(".container").size() === 1) {
                    el.footer.insertAfter(el.container);
                    $('.scroll-to-top').insertAfter(el.footer);
                }
                $('body > .container').remove();
            };
            LayoutExtension.prototype.scrollTo = function (ele, offset) {
                var $el = typeof (ele) === 'string' ? $(ele) : ele;
                var pos = ($el && $el.size() > 0) ? $el.offset().top : 0;
                if ($el) {
                    if ($body.hasClass('page-header-fixed')) {
                        pos = pos - el.header.height();
                    }
                    pos = pos + (offset ? offset : -1 * $el.height());
                }
                $('html,body').animate({
                    scrollTop: pos
                }, 'slow');
            };
            LayoutExtension.prototype.scrollTop = function () {
                this.scrollTo();
            };
            LayoutExtension.prototype.getBreakpoint = function (which) {
                return parseInt(this.config.get('layout.breakpoints4.' + which));
            };
            LayoutExtension.prototype.calculateViewportHeight = function () {
                var sidebarHeight = codex.getViewPort().height - el.header.outerHeight();
                if (this.isFooterFixed()) {
                    sidebarHeight = sidebarHeight - el.footer.outerHeight();
                }
                return sidebarHeight;
            };
            LayoutExtension.prototype.isHeaderFixed = function () {
                return $body.hasClass('page-header-fixed');
            };
            LayoutExtension.prototype.isFooterFixed = function () {
                return $body.hasClass('page-footer-fixed');
            };
            LayoutExtension.prototype.isBoxed = function () {
                return $body.hasClass('page-boxed');
            };
            LayoutExtension.prototype.isEdged = function () {
                return $body.hasClass('page-edged');
            };
            LayoutExtension.prototype.isSidebarClosed = function () {
                return $body.hasClass('page-sidebar-closed');
            };
            LayoutExtension.prototype.isSidebarHidden = function () {
                return $body.hasClass('page-sidebar-hide');
            };
            LayoutExtension.prototype.isSidebarFixed = function () {
                return $('.page-sidebar-fixed').size() !== 0;
            };
            LayoutExtension.prototype.isSidebarCondensed = function () {
                return $body.hasClass('page-sidebar-condensed');
            };
            LayoutExtension.prototype.isSidebarHover = function () {
                return el.sidebarMenu.hasClass('page-sidebar-menu-hover-submenu');
            };
            LayoutExtension.prototype.isSidebarReversed = function () {
                return $body.hasClass('page-sidebar-reversed');
            };
            LayoutExtension = __decorate([
                codex.extension('layout', defaultConfig)
            ], LayoutExtension);
            return LayoutExtension;
        })(extensions.Extension);
        extensions.LayoutExtension = LayoutExtension;
        var Loader = (function () {
            function Loader(name, el) {
                this.name = name;
                this.$el = typeof (el) === 'string' ? $(el) : el;
            }
            Loader.prototype.stop = function () {
                if (!this.started) {
                    return;
                }
                this.$el.removeClass(this.name + '-loader-content');
                this.$parent.removeClass(this.name + '-loading');
                this.$loader.remove();
                this.started = false;
            };
            Loader.prototype.start = function () {
                if (this.started) {
                    return;
                }
                this.$el.addClass(this.name + '-loader-content');
                this.$parent = this.$el.parent().addClass(this.name + '-loading');
                var $loaderInner = $('<div>').addClass('loader loader-' + this.name);
                this.$loader = $('<div>').addClass(this.name + '-loader');
                this.$loader.append($loaderInner).prependTo(this.$parent);
            };
            return Loader;
        })();
        extensions.Loader = Loader;
    })(extensions = codex.extensions || (codex.extensions = {}));
})(codex || (codex = {}));
var codex;
(function (codex) {
    var extensions;
    (function (extensions) {
        var defaultConfig = {
            'default': {
                layout: ['header-fixed', 'footer-fixed'],
                theme: 'default'
            },
            'condensed-dark': {
                layout: ['header-fixed', 'footer-fixed', 'page-edged', 'sidebar-condensed'],
                theme: 'dark-sidebar'
            }
        };
        var $body = $('body');
        var PresetsExtension = (function (_super) {
            __extends(PresetsExtension, _super);
            function PresetsExtension() {
                _super.apply(this, arguments);
            }
            PresetsExtension.prototype.init = function () {
                this.app.debug.log('PresetsComponent init');
                this.app.on('booted', function () {
                    codex.debug.log('PresetsComponent received event emitted from app: booted');
                });
            };
            PresetsExtension.prototype.boot = function () {
                var self = this;
                this._initLayoutApiActions();
            };
            PresetsExtension.prototype._initLayoutApiActions = function () {
                var _this = this;
                var self = this;
                var apiActions = {
                    'preset': function (presetName) {
                        console.log('preset', presetName, _this, self);
                        self.set(presetName);
                    }
                };
                self.layout.setApiActions(apiActions);
            };
            Object.defineProperty(PresetsExtension.prototype, "layout", {
                get: function () {
                    return this.extensions.get('layout');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(PresetsExtension.prototype, "quick_sidebar", {
                get: function () {
                    return this.extensions.get('quick_sidebar');
                },
                enumerable: true,
                configurable: true
            });
            PresetsExtension.prototype.set = function (name) {
                var _this = this;
                var presetsConfig = this.config('presets.' + name);
                Object.keys(presetsConfig).forEach(function (presetType) {
                    _this.applyPresetType(presetType, presetsConfig[presetType]);
                });
            };
            PresetsExtension.prototype.applyPresetType = function (name, config) {
                var _this = this;
                var self = this;
                switch (name) {
                    case 'theme':
                        this.layout.setTheme(config);
                        this.app.emit('layout:preset:theme', config);
                        break;
                    case 'layout':
                        this.layout.reset();
                        if (codex.kindOf(config) === 'string') {
                            config = [config];
                        }
                        config.forEach(function (actionName) {
                            self.layout.api(actionName);
                        });
                        this.app.emit('layout:preset:layout', config);
                        break;
                }
                this.app.on('resize', function () { console.log('apply preset refresh', _this); _this.quick_sidebar.refresh(); });
            };
            PresetsExtension.dependencies = ['layout', 'quick_sidebar'];
            PresetsExtension = __decorate([
                codex.extension('presets', defaultConfig)
            ], PresetsExtension);
            return PresetsExtension;
        })(extensions.Extension);
        extensions.PresetsExtension = PresetsExtension;
    })(extensions = codex.extensions || (codex.extensions = {}));
})(codex || (codex = {}));
var codex;
(function (codex) {
    var extensions;
    (function (extensions) {
        var defaultConfig = {
            transitionTime: 500
        };
        var $body = $('body');
        var QuickSidebarTabs = (function () {
            function QuickSidebarTabs(qs) {
                this.switching = false;
                this.switchingTimeout = false;
                var self = this;
                this.qs = qs;
                this.active = this.getFirst();
                this.previous = this.getLast();
                var style = {
                    width: this.$tabs.parent().width(),
                    height: this.$tabs.innerHeight() - 1,
                    float: 'left'
                };
                this.$content.each(function () {
                    var tab = $('<div>')
                        .addClass('qs-tab')
                        .text($(this).attr('data-name'))
                        .attr('data-target', '#' + $(this).attr('id'));
                    tab.appendTo(self.$tabs);
                });
                this.$wrapper.jcarousel({
                    list: '.qs-tabs',
                    items: '.qs-tab',
                    wrap: 'both'
                });
                $body.onClick('.quick-sidebar .qs-tab', function (e) {
                    self.openTab($(this).attr('data-target'));
                });
            }
            QuickSidebarTabs.prototype.find = function (find) {
                return this.qs.find(find);
            };
            Object.defineProperty(QuickSidebarTabs.prototype, "$wrapper", {
                get: function () {
                    return this.find('.qs-tabs-wrapper');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(QuickSidebarTabs.prototype, "$tabs", {
                get: function () {
                    return this.find('.qs-tabs');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(QuickSidebarTabs.prototype, "$content", {
                get: function () {
                    return this.find('.qs-content');
                },
                enumerable: true,
                configurable: true
            });
            QuickSidebarTabs.prototype.handleTabsMiddleResizing = function () {
                codex.debug.log('xs breakpoint:', this.qs.layout.getBreakpoint('sm'), 'viewport width', codex.getViewPort().width);
                var $middle = this.find('.qs-header .middle');
                var $header = this.find('.qs-header');
                if (codex.getViewPort().width >= this.qs.layout.getBreakpoint('sm') && codex.getViewPort().width <= this.qs.layout.getBreakpoint('md')) {
                    var width = $header.children().first().outerWidth();
                    width += $header.children().last().outerWidth();
                    width = $header.width() - width;
                    codex.debug.log('width: ', width);
                    if (this.$wrapper.closest('.qs-header').length == 0) {
                        this.$wrapper.appendTo($middle);
                    }
                    $middle.css('width', width);
                }
                else {
                    if (this.$wrapper.closest('.qs-header').length > 0) {
                        this.find('.qs-header').after(this.$wrapper);
                    }
                    $middle.attr('style', '');
                }
                return this;
            };
            QuickSidebarTabs.prototype.refresh = function () {
                this.handleTabsMiddleResizing()
                    .destroyContentScroll()
                    .initContentScroll();
            };
            QuickSidebarTabs.prototype.getContentScrollHeight = function () {
                return this.qs.$e.outerHeight()
                    - this.find('.qs-header').outerHeight()
                    - this.find('.qs-tabs-wrapper').outerHeight()
                    - this.find('.qs-seperator').outerHeight();
            };
            QuickSidebarTabs.prototype.initContentScroll = function ($content) {
                $content = codex.defined($content) ? $($content) : this.getTabContent(this.getActive());
                this.destroyContentScroll($content);
                codex.makeSlimScroll($content, {
                    height: this.getContentScrollHeight(),
                    wheelStep: codex.isTouchDevice() ? 60 : 20
                });
                if (this.qs.mouseOverContent) {
                    this.$content.trigger("mouseleave").trigger('mouseenter');
                }
                else {
                    this.$content.trigger("mouseleave");
                }
                return this;
            };
            QuickSidebarTabs.prototype.destroyContentScroll = function ($content) {
                $content = codex.defined($content) ? $($content) : this.getTabContent(this.getActive());
                codex.destroySlimScroll($content);
                this.find('.slimScrollBar, .slimScrollRail').remove();
                return this;
            };
            QuickSidebarTabs.prototype.closeTabs = function () {
                this.find('.qs-tab.active').removeClass('active');
                var $activeTabContent = this.find('.qs-content.active').removeClass('active');
                if ($activeTabContent.length) {
                    codex.destroySlimScroll($activeTabContent);
                    this.find('.slimScrollBar, .slimScrollRail').remove();
                }
                return this;
            };
            QuickSidebarTabs.prototype.openTab = function (id) {
                var _this = this;
                id = codex.defined(id) ? codex.util.str.lstrip(id, '#') : this.getFirst();
                var $tab = this.getTabNav(id);
                var $tabContent = this.getTabContent(id);
                if (this.switching) {
                    if (this.switchingTimeout = false) {
                        setTimeout(function () {
                            _this.openTab(id);
                            _this.switching = false;
                        }, this.qs.config('quick_sidebar.transitionTime'));
                        this.switchingTimeout = true;
                    }
                    return;
                }
                this.closeTabs();
                $tab.ensureClass('active', true);
                $tabContent.ensureClass('active', true);
                this.$wrapper.jcarousel('scroll', $tab);
                if (id !== this.active) {
                    this.previous = this.active;
                    this.active = id;
                }
                this.switching = true;
                setTimeout(function () {
                    _this.initContentScroll($tabContent);
                    _this.switching = false;
                }, this.qs.config('quick_sidebar.transitionTime'));
                return this;
            };
            QuickSidebarTabs.prototype.openPreviousTab = function () {
                this.openTab(this.getPrevious());
                return this;
            };
            QuickSidebarTabs.prototype.openNextTab = function () {
                this.openTab(this.getNext());
                return this;
            };
            QuickSidebarTabs.prototype.getActive = function () {
                return this.active;
            };
            QuickSidebarTabs.prototype.getPrevious = function () {
                var previous = this.getTabContent(this.getActive()).parent().prev('.qs-content:not(.active)').attr('id');
                if (!previous && this.hasTab(this.previous)) {
                    previous = this.previous;
                }
                else if (!previous) {
                    previous = this.getLast();
                }
                return previous;
            };
            QuickSidebarTabs.prototype.getNext = function () {
                var next = this.getTabContent(this.getActive()).parent().next('.qs-content:not(.active)').attr('id');
                if (!this.hasTab(next)) {
                    next = this.getFirst();
                }
                return next;
            };
            QuickSidebarTabs.prototype.getFirst = function () {
                return this.find('.qs-content').first().attr('id');
            };
            QuickSidebarTabs.prototype.getLast = function () {
                return this.find('.qs-content').last().attr('id');
            };
            QuickSidebarTabs.prototype.hasTab = function (id) {
                return this.find('.qs-content#' + id).length > 0;
            };
            QuickSidebarTabs.prototype.getTabNav = function (id) {
                return this.find('.qs-tabs .qs-tab[data-target="#' + id + '"]').first();
            };
            QuickSidebarTabs.prototype.getTabContent = function (id) {
                return this.find('.qs-content#' + id).first();
            };
            return QuickSidebarTabs;
        })();
        extensions.QuickSidebarTabs = QuickSidebarTabs;
        var QuickSidebarExtension = (function (_super) {
            __extends(QuickSidebarExtension, _super);
            function QuickSidebarExtension() {
                _super.apply(this, arguments);
                this.mouseOverContent = false;
            }
            QuickSidebarExtension.prototype.init = function () {
                this.app.debug.log('QuickSidebarComponent init');
                this.app.on('booted', function () {
                    codex.debug.log('QuickSidebarComponent received event emitted from app: booted');
                });
            };
            QuickSidebarExtension.prototype.boot = function () {
                codex.debug.log('QuickSidebarComponent boot');
                if (!this.exists()) {
                    codex.debug.log('QuickSidebarComponent does not exist');
                    return;
                }
                var ttOpts = _.merge(this.config('vendor.bootstrap.tooltip'), {
                    placement: 'left',
                    offset: '30px -40px',
                    trigger: 'hover focus',
                    selector: false
                });
                if (!codex.isTouchDevice()) {
                    this.$e.find('.qs-header .btn[data-quick-sidebar]').tooltip(ttOpts);
                }
                this.tabs = new QuickSidebarTabs(this);
                this._initBindings();
                this._initResizeHandler();
                this._initLayoutApiActions();
                if (!this.isClosed()) {
                    this.openNextTab();
                }
            };
            Object.defineProperty(QuickSidebarExtension.prototype, "layout", {
                get: function () {
                    return this.extensions.get('layout');
                },
                enumerable: true,
                configurable: true
            });
            Object.defineProperty(QuickSidebarExtension.prototype, "$e", {
                get: function () {
                    return $('.quick-sidebar');
                },
                enumerable: true,
                configurable: true
            });
            QuickSidebarExtension.prototype.find = function (find) {
                return this.$e.find(find);
            };
            QuickSidebarExtension.prototype._initLayoutApiActions = function () {
                var self = this;
                var apiActions = {
                    'qs-toggle': function (target) {
                        (self.isClosed() && self.show().openTab(target)) || self.hide();
                    },
                    'qs-show': function () {
                        self.show().openTab();
                    },
                    'qs-hide': function () {
                        self.hide();
                    },
                    'qs-open': function (target) {
                        self.openTab(target);
                    },
                    'qs-close': function () {
                        self.hide();
                    },
                    'qs-togglepin': function () {
                        !self.isPinned() && self.pin() || self.unpin();
                    },
                    'qs-pin': function () {
                        self.pin();
                    },
                    'qs-unpin': function () {
                        self.unpin();
                    },
                    'qs-next': function () {
                        self.openNextTab();
                    },
                    'qs-prev': function () {
                        self.openPreviousTab();
                    }
                };
                self.layout.setApiActions(apiActions);
            };
            QuickSidebarExtension.prototype._initBindings = function () {
                var _this = this;
                var self = this;
                $body.onClick('.quick-sidebar .qs-header button', function (e) {
                    var $this = $(this);
                    $this.blur();
                });
                $(document).onClick('.qs-shown', function (e) {
                    if ($(e.target).closest('.quick-sidebar').length > 0) {
                        return;
                    }
                    if (self.isPinned()) {
                        return;
                    }
                    self.hide();
                });
                $body.on('mouseenter', '.quick-sidebar .qs-content', function (e) {
                    _this.mouseOverContent = true;
                }).on('mouseleave', '.quick-sidebar .qs-content', function (e) {
                    _this.mouseOverContent = false;
                });
            };
            QuickSidebarExtension.prototype._initResizeHandler = function () {
                var self = this;
                var resizeHandler = function () {
                    if (self.isClosed()) {
                        return;
                    }
                    self.refresh();
                };
                this.app
                    .on('resize', resizeHandler)
                    .on('layout:footer:fixed', resizeHandler)
                    .on('layout:header:fixed', resizeHandler)
                    .on('layout:page:fixed', resizeHandler)
                    .on('layout:page:boxed', resizeHandler);
            };
            QuickSidebarExtension.prototype.refresh = function () {
                if (this.isClosed()) {
                    return;
                }
                this.tabs.refresh();
                this._emit('refresh');
                return this;
            };
            QuickSidebarExtension.prototype._emit = function (name) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
                this.app.emit('qs:' + name, [this].concat(args));
            };
            QuickSidebarExtension.prototype.show = function () {
                if (!this.exists()) {
                    return this;
                }
                $('body').ensureClass("qs-shown", true);
                this._emit('show');
                return this;
            };
            QuickSidebarExtension.prototype.hide = function () {
                if (!this.exists()) {
                    return;
                }
                if (this.isPinned()) {
                    this.unpin();
                }
                $body.ensureClass("qs-shown", false);
                this._emit('hide');
                return this;
            };
            QuickSidebarExtension.prototype.isClosed = function () {
                return !$body.hasClass("qs-shown");
            };
            QuickSidebarExtension.prototype.openTab = function (id) {
                this.tabs.openTab(id);
                this._emit('open');
                return this;
            };
            QuickSidebarExtension.prototype.openNextTab = function () {
                this.tabs.openNextTab();
                this._emit('next');
                return this;
            };
            QuickSidebarExtension.prototype.openPreviousTab = function () {
                this.tabs.openPreviousTab();
                this._emit('prev');
                return this;
            };
            QuickSidebarExtension.prototype.pin = function () {
                $body.ensureClass('qs-pinned', true);
                this._emit('pin');
                return this;
            };
            QuickSidebarExtension.prototype.unpin = function () {
                $body.removeClass('qs-pinned');
                this._emit('unpin');
                return this;
            };
            QuickSidebarExtension.prototype.isPinned = function () {
                return $body.hasClass('qs-pinned');
            };
            QuickSidebarExtension.prototype.exists = function () {
                return this.$e.length > 0;
            };
            QuickSidebarExtension.dependencies = ['layout'];
            QuickSidebarExtension = __decorate([
                codex.extension('quick_sidebar', defaultConfig)
            ], QuickSidebarExtension);
            return QuickSidebarExtension;
        })(extensions.Extension);
        extensions.QuickSidebarExtension = QuickSidebarExtension;
    })(extensions = codex.extensions || (codex.extensions = {}));
})(codex || (codex = {}));
var codex;
(function (codex) {
    var plugins;
    (function (plugins) {
        var TestPlugin = (function (_super) {
            __extends(TestPlugin, _super);
            function TestPlugin() {
                _super.apply(this, arguments);
            }
            TestPlugin.prototype._create = function () {
                console.log('TestPlugin create');
            };
            TestPlugin = __decorate([
                codex.plugin('testPlugin')
            ], TestPlugin);
            return TestPlugin;
        })(plugins.Plugin);
        plugins.TestPlugin = TestPlugin;
        plugins.Plugin.register('testPlugin', TestPlugin);
    })(plugins = codex.plugins || (codex.plugins = {}));
})(codex || (codex = {}));
var codex;
(function (codex) {
    var widgets;
    (function (widgets) {
        var progressbarWidget = (function (_super) {
            __extends(progressbarWidget, _super);
            function progressbarWidget() {
                _super.call(this);
                this.version = '1.0.0';
                this.widgetEventPrefix = 'progressbar.';
                this.options = {
                    transitionDelay: 300,
                    refreshSpeed: 50,
                    textDisplay: 'none',
                    textFormat: '{value} / {max} ({percent}%)',
                    value: 0
                };
                this.bs4 = false;
            }
            progressbarWidget.prototype._getDataAttributes = function () {
                var data = this.element.prefixedData('bar');
                return data;
            };
            progressbarWidget.prototype._formatAmount = function (val, percent, max, min) {
                return this.options.textFormat
                    .replace(/\{value\}/g, val)
                    .replace(/\{percent\}/g, percent)
                    .replace(/\{remaining\}/g, max - val)
                    .replace(/\{max\}/g, max)
                    .replace(/\{min\}/g, min);
            };
            progressbarWidget.prototype._updateBaseValues = function () {
                this.options = $.extend(true, this.options, this._getDataAttributes());
                var $el = this.element;
                this.$parent = $el.parent();
                this.targetValue = parseInt(this.options.value);
                this.minValue = parseInt($el.attr(this.bs4 ? 'min' : 'aria-valuemin')) || 0;
                this.maxValue = parseInt($el.attr(this.bs4 ? 'max' : 'aria-valuemax')) || 100;
                this.isVertical = this.$parent.hasClass('vertical');
                this.percentage = Math.round(100 * (this.targetValue - this.minValue) / (this.maxValue - this.minValue));
            };
            progressbarWidget.prototype._create = function () {
                var self = this;
                this.bs4 = this.element.get(0).nodeName.toLowerCase() === 'progress';
                this._updateBaseValues();
                if (isNaN(this.targetValue)) {
                    this._trigger('fail', ['data-transitiongoal not set']);
                    return;
                }
                if (this.options.textDisplay === 'center' && !this.$back_text && !this.$front_text) {
                    this.$back_text = $('<span>').addClass('progressbar-back-text').prependTo(this.$parent);
                    this.$front_text = $('<span>').addClass('progressbar-front-text').prependTo(this.element);
                    var parent_size;
                    if (this.isVertical) {
                        parent_size = this.$parent.css('height');
                        this.$back_text.css({ height: parent_size, 'line-height': parent_size });
                        this.$front_text.css({ height: parent_size, 'line-height': parent_size });
                        this._on(this.window, {
                            'resize': function (event) {
                                parent_size = this.$parent.css('height');
                                this.$back_text.css({ height: parent_size, 'line-height': parent_size });
                                this.$front_text.css({ height: parent_size, 'line-height': parent_size });
                            }
                        });
                    }
                    else {
                        parent_size = this.$parent.css('width');
                        this.$front_text.css({ width: parent_size });
                        this._on(this.window, {
                            resize: function (event) {
                                parent_size = this.$parent.css('width');
                                this.$front_text.css({ width: parent_size });
                            }
                        });
                    }
                }
                setTimeout(this._start.bind(this), this.options.transitionDelay);
            };
            progressbarWidget.prototype._start = function () {
                if (this.isVertical) {
                    this.element.css('height', this.percentage + '%');
                }
                else {
                    this.element.css('width', this.percentage + '%');
                }
                this.progressIntervalId = setInterval(this._update.bind(this), this.options.refreshSpeed);
            };
            progressbarWidget.prototype.update = function () {
                this._updateBaseValues();
                this._start();
            };
            progressbarWidget.prototype._update = function () {
                if (this.isVertical) {
                    this.this_size = this.element.height();
                    this.parent_size = this.$parent.height();
                }
                else {
                    this.this_size = this.element.width();
                    this.parent_size = this.$parent.width();
                }
                this.current_percentage = Math.round(100 * this.this_size / this.parent_size);
                this.current_value = Math.round(this.minValue + this.this_size / this.parent_size * (this.maxValue - this.minValue));
                if (this.current_percentage >= this.percentage) {
                    this.current_percentage = this.percentage;
                    this.current_value = this.targetValue;
                    this._trigger('done', [this.element]);
                    clearInterval(this.progressIntervalId);
                }
                if (this.options.textDisplay !== 'none') {
                    this.text = this._formatAmount(this.current_value, this.current_percentage, this.maxValue, this.minValue);
                    if (this.options.textDisplay === 'fill') {
                        this.element.text(this.text);
                    }
                    else if (this.options.textDisplay === 'center') {
                        this.$back_text.text(this.text);
                        this.$front_text.text(this.text);
                    }
                }
                this.element.attr('aria-valuenow', this.current_value);
                this._trigger('done', [this.current_percentage, this.element]);
            };
            progressbarWidget.prototype._destroy = function () {
            };
            progressbarWidget.prototype._init = function () {
                return undefined;
            };
            progressbarWidget.prototype._setOption = function (key, value) {
                var self = this;
                switch (key) {
                    case 'hidden':
                        break;
                }
                this._super(key, value);
                return this;
            };
            return progressbarWidget;
        })(widgets.Widget);
        widgets.progressbarWidget = progressbarWidget;
    })(widgets = codex.widgets || (codex.widgets = {}));
})(codex || (codex = {}));
var codex;
(function (codex) {
    var widgets;
    (function (widgets) {
        var TestWidget = (function (_super) {
            __extends(TestWidget, _super);
            function TestWidget() {
                _super.call(this);
                this.version = '1.0.0';
                this.widgetEventPrefix = 'test.';
                this.options = { 'test': 'yes' };
            }
            TestWidget.prototype._create = function () {
                console.log('TestWidget create');
            };
            TestWidget = __decorate([
                codex.widget('testWidget')
            ], TestWidget);
            return TestWidget;
        })(widgets.Widget);
        widgets.TestWidget = TestWidget;
    })(widgets = codex.widgets || (codex.widgets = {}));
})(codex || (codex = {}));
//# sourceMappingURL=addons.js.map