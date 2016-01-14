
module codex.extensions {


    var defaultConfig:any = {
        transitionTime: 500
    };

    var $body:JQuery = $('body');

    /**
     *
     * ## The Quick Sidebar Component
     * ##### API actions:
     * - `qs-open`, `qs-close`, `qs-toggle`
     * - `qs-next`, `qs-prev`, `qs-first`, `qs-last`
     * - `qs-pin`, `qs-unpin`, `qs-togglepin`
     *
     * ##### Events:
     * - `layout:qs:open`, `layout:qs:close`, `layout:qs:toggle`
     * - `layout:qs:next`, `layout:qs:prev`, `layout:qs:first`, `layout:qs:last`
     * - `layout:qs:pin`, `layout:qs:unpin`, `layout:qs:togglepin`
     *
     *
     * ##### Usage example JS
     * ```typescript
     * app.components.get('quick_sidebar').open();
     * app.components.quick_sidebar.open('themes');
     * app.components.layout.api('qs-open', 'themes');
     * app.on('layout:qs:open', function(){
     *      console.log(this, arguments);
     * });
     * ```
     *
     * ##### Usage example HTML5 data-attributes
     * ```html
     * <a href="#" data-layout-api="qs-open">Open sidebar</a>
     * <a href="#" data-layout-api="qs-open" data-layout-api-args="themes">Open sidebar tab 'themes'</a>
     * ```
     *
     */
    export class QuickSidebarTabs {
        qs:QuickSidebarExtension;

        switching:boolean = false;
        switchingTimeout:boolean = false;
        active:string;
        previous:string;


        constructor(qs:QuickSidebarExtension) {
            var self:QuickSidebarTabs = this;
            this.qs = qs;
            this.active = this.getFirst();
            this.previous = this.getLast();

            var style:Object = {
                width: this.$tabs.parent().width(),
                height: this.$tabs.innerHeight() - 1,
                float: 'left'
            };

            this.$content.each(function () {
                var tab = $('<div>')
                    .addClass('qs-tab')
                    .text($(this).attr('data-name'))
                    .attr('data-target', '#' + $(this).attr('id'));

                tab.appendTo(self.$tabs)
            });

            this.$wrapper.jcarousel({
                list: '.qs-tabs',
                items: '.qs-tab',
                wrap: 'both'
            });

            // Clicking the heading tab names opens a new tab
            $body.onClick('.quick-sidebar .qs-tab', function (e) {
                self.openTab($(this).attr('data-target'));
            });

        }

        public find(find:any):JQuery {
            return this.qs.find(find);
        }

        public get $wrapper():JQuery {
            return this.find('.qs-tabs-wrapper');
        }

        public get $tabs():JQuery {
            return this.find('.qs-tabs');
        }

        public get $content():JQuery {
            return this.find('.qs-content');
        }

        protected handleTabsMiddleResizing():QuickSidebarTabs { debug.log('xs breakpoint:', this.qs.layout.getBreakpoint('sm'), 'viewport width', getViewPort().width);
            var $middle = this.find('.qs-header .middle');
            var $header = this.find('.qs-header');
            if (getViewPort().width >= this.qs.layout.getBreakpoint('sm') && getViewPort().width <= this.qs.layout.getBreakpoint('md')) {

                var width = $header.children().first().outerWidth();
                width += $header.children().last().outerWidth();
                width = $header.width() - width;
                debug.log('width: ', width);

                if (this.$wrapper.closest('.qs-header').length == 0) {
                    this.$wrapper.appendTo($middle);
                }
                $middle.css('width', width);

            } else {
                if (this.$wrapper.closest('.qs-header').length > 0) {
                    this.find('.qs-header').after(this.$wrapper);
                }
                $middle.attr('style', ''); // remove width css
            }
            return this;
        }

        public refresh(){
            this.handleTabsMiddleResizing()
                .destroyContentScroll()
                .initContentScroll();
        }

        public getContentScrollHeight():number {
            return this.qs.$e.outerHeight()
                - this.find('.qs-header').outerHeight()
                - this.find('.qs-tabs-wrapper').outerHeight()
                - this.find('.qs-seperator').outerHeight();
        }

        public initContentScroll($content?:JQuery|string):QuickSidebarTabs {
            $content = defined($content) ? $($content) : this.getTabContent(this.getActive());

            this.destroyContentScroll($content);
            makeSlimScroll($content, {
                height: this.getContentScrollHeight(),
                wheelStep: isTouchDevice() ? 60 : 20
            });
            if (this.qs.mouseOverContent) {
                this.$content.trigger("mouseleave").trigger('mouseenter');
            } else {
                this.$content.trigger("mouseleave");
            }
            return this;
        }

        public destroyContentScroll($content?:JQuery|string):QuickSidebarTabs {
            $content = defined($content) ? $($content) : this.getTabContent(this.getActive());

            destroySlimScroll($content);
            this.find('.slimScrollBar, .slimScrollRail').remove();
            return this;
        }



        public closeTabs():QuickSidebarTabs {
            this.find('.qs-tab.active').removeClass('active');
            var $activeTabContent = this.find('.qs-content.active').removeClass('active');

            if ($activeTabContent.length) {
                destroySlimScroll($activeTabContent);
                this.find('.slimScrollBar, .slimScrollRail').remove();
            }

            return this;
        }

        public openTab(id?:string):QuickSidebarTabs {
            id = defined(id) ? util.str.lstrip(id, '#') : this.getFirst();
            var $tab:JQuery = this.getTabNav(id);
            var $tabContent:JQuery = this.getTabContent(id);

            // making sure we're not opening something already
            if (this.switching) {
                if (this.switchingTimeout = false) {
                    setTimeout(() => {
                        this.openTab(id);
                        this.switching = false
                    }, this.qs.config('quick_sidebar.transitionTime'));
                    this.switchingTimeout = true;
                }
                return;
            }

            this.closeTabs();
            $tab.ensureClass('active', true);
            $tabContent.ensureClass('active', true);
            this.$wrapper.jcarousel('scroll', $tab);
            if(id !== this.active) {
                this.previous = this.active;
                this.active = id;
            }

            this.switching = true;
            setTimeout(() => {
                this.initContentScroll($tabContent);
                this.switching = false;
            }, this.qs.config('quick_sidebar.transitionTime'));

            return this;
        }

        public openPreviousTab():QuickSidebarTabs {
            this.openTab(this.getPrevious());
            return this;
        }

        public openNextTab():QuickSidebarTabs {
            this.openTab(this.getNext());
            return this;
        }


        public getActive():string {
            return this.active;
        }

        public getPrevious():string {
            var previous:string = this.getTabContent(this.getActive()).parent().prev('.qs-content:not(.active)').attr('id');

            if(!previous && this.hasTab(this.previous)) {
                previous = this.previous;
            } else if(!previous) {
                previous = this.getLast();
            }

            return previous;
        }

        public getNext():string {
            var next = this.getTabContent(this.getActive()).parent().next('.qs-content:not(.active)').attr('id');

            if(!this.hasTab(next)){
                next = this.getFirst();
            }
            return next;
        }

        public getFirst():string {
            return this.find('.qs-content').first().attr('id');
        }

        public getLast():string {
            return this.find('.qs-content').last().attr('id');
        }

        public hasTab(id:string):boolean {
            return this.find('.qs-content#' + id).length > 0;
        }

        public getTabNav(id:string):JQuery {
            return this.find('.qs-tabs .qs-tab[data-target="#' + id + '"]').first();
        }

        public getTabContent(id:string):JQuery {
            return this.find('.qs-content#' + id).first();
        }
    }


    @extension('quick_sidebar', defaultConfig)
    export class QuickSidebarExtension extends Extension {


        protected tabs:QuickSidebarTabs;

        public static dependencies:string[] = ['layout'];

        mouseOverContent:boolean = false;


        public init() {
            this.app.debug.log('QuickSidebarComponent init');
            this.app.on('booted', () => {
                debug.log('QuickSidebarComponent received event emitted from app: booted');
            });
        }

        public boot() {
            debug.log('QuickSidebarComponent boot');
            if (!this.exists()) {
                debug.log('QuickSidebarComponent does not exist');
                return;
            }

            // init header button tooltips
            var ttOpts:any = _.merge(this.config('vendor.bootstrap.tooltip'), {
                placement: 'left',
                offset: '30px -40px',
                trigger: 'hover focus',
                selector: false
            });

            if (!isTouchDevice()) {
                this.$e.find('.qs-header .btn[data-quick-sidebar]').tooltip(ttOpts);
            }

            this.tabs = new QuickSidebarTabs(this);
            this._initBindings();
            this._initResizeHandler();
            this._initLayoutApiActions();

            if (!this.isClosed()) {
                this.openNextTab();
            }
        }

        public get layout():LayoutExtension {
            return <LayoutExtension> this.extensions.get('layout'); // this.app['layout'];
        }

        public get $e():JQuery {
            return $('.quick-sidebar');
        }

        public find(find:any):JQuery {
            return this.$e.find(find);
        }


        protected _initLayoutApiActions() {
            var self:QuickSidebarExtension = this;
            var apiActions:any = {
                'qs-toggle': (target?:string) => {
                    (self.isClosed() && self.show().openTab(target)) || self.hide();
                },
                'qs-show': () => {
                    self.show().openTab();
                },
                'qs-hide': () => {
                    self.hide();
                },
                'qs-open': (target?:string) => {
                    self.openTab(target);
                },
                'qs-close': () => {
                    self.hide();
                },
                'qs-togglepin': () => {
                    !self.isPinned() && self.pin() || self.unpin();
                },
                'qs-pin': () => {
                    self.pin();
                },
                'qs-unpin': () => {
                    self.unpin();
                },
                'qs-next': () => {
                    self.openNextTab();
                },
                'qs-prev': () => {
                    self.openPreviousTab();
                }
            };

            self.layout.setApiActions(apiActions);
        }

        /**
         * Initialises event bindings
         * @private
         */
        protected _initBindings() {
            var self:QuickSidebarExtension = this;

            // Blur the pressed header buttons automaticly
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

            // check if mouse is over any .qs-content. detection is required to fix openTarget timeout that creates the slimScroll
            $body.on('mouseenter', '.quick-sidebar .qs-content', (e) => {
                this.mouseOverContent = true;
            }).on('mouseleave', '.quick-sidebar .qs-content', (e) => {
                this.mouseOverContent = false;
            })
        }

        protected _initResizeHandler() {
            var self:QuickSidebarExtension = this;
            var resizeHandler = function () {
                if(self.isClosed()){
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
        }


        public refresh():QuickSidebarExtension {
            if (this.isClosed()) {
                return;
            }
            this.tabs.refresh();
            this._emit('refresh');
            return this;
        }

        protected _emit(name:string, ...args:any[]){
            this.app.emit('qs:' + name, [this].concat(args));
        }

        public show():QuickSidebarExtension {
            if (!this.exists()) {
                return this;
            }
            $('body').ensureClass("qs-shown", true);
            this._emit('show');
            return this;
        }

        public hide():QuickSidebarExtension {
            if (!this.exists()) {
                return;
            }
            if (this.isPinned()) {
                this.unpin();
            }
            $body.ensureClass("qs-shown", false);
            this._emit('hide');
            return this;
        }

        public isClosed():boolean {
            return !$body.hasClass("qs-shown");
        }



        public openTab(id?:string):QuickSidebarExtension {
            this.tabs.openTab(id);
            this._emit('open');
            return this;
        }

        public openNextTab():QuickSidebarExtension {
            this.tabs.openNextTab();
            this._emit('next');
            return this;
        }

        public openPreviousTab():QuickSidebarExtension {
            this.tabs.openPreviousTab();
            this._emit('prev');
            return this;
        }


        /**
         * Pin the QS so it will not close when clicking elsewhere
         */
        public pin():QuickSidebarExtension {
            $body.ensureClass('qs-pinned', true);
            this._emit('pin');
            return this;
        }

        public unpin():QuickSidebarExtension {
            $body.removeClass('qs-pinned');
            this._emit('unpin');
            return this;
        }

        public isPinned():boolean {
            return $body.hasClass('qs-pinned');

        }


        /**
         * Checks if the quick sidebar is present in the DOM
         */
        public exists():boolean {
            return this.$e.length > 0;
        }

    }

    //Extensions.register('', QuickSidebarExtension, defaultConfig);

}
