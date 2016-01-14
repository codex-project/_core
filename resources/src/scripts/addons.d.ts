/// <reference path="types.d.ts" />
/// <reference path="codex.d.ts" />
declare module codex {
}
declare module codex.extensions {
    class LayoutExtension extends Extension {
        openCloseInProgress: boolean;
        closing: boolean;
        protected _apiCallbacks: {
            [actionName: string]: Function;
        };
        init(): void;
        boot(): void;
        protected _initLayoutApiActions(): void;
        setApiAction(actionName: string, callbackFn: Function): void;
        setApiActions(apiActions: {
            [name: string]: Function;
        }): void;
        api(action: string, ...args: any[]): void;
        removePageLoader(): void;
        createLoader(name: any, el: any): Loader;
        e(selectorName: string): JQuery;
        protected _initResizeEvent(): void;
        protected _initSidebarResizeListener(): void;
        protected _initEdgedHeightResizeListener(): void;
        protected _initHeader(): void;
        fixBreadcrumb(): void;
        protected _initGoTop(): void;
        protected _initFixed(): void;
        protected _initSidebarSubmenus(): void;
        protected _initToggleButton(): void;
        protected _initFixedHovered(): void;
        protected setSidebarClosed(closed?: boolean): void;
        closeSubmenus(): void;
        closeSidebar(callback?: any): JQueryPromise<any>;
        openSidebar(callback?: any): JQueryPromise<any>;
        hideSidebar(): void;
        showSidebar(): void;
        protected sidebarResolveActive(): void;
        setSidebarFixed(fixed: boolean): void;
        setSidebarCondensed(condensed: boolean): void;
        setSidebarHover(hover: boolean): void;
        setSidebarReversed(reversed: boolean): void;
        setHeaderFixed(fixed: boolean): void;
        setFooterFixed(fixed: boolean): void;
        setBoxed(boxed: boolean): void;
        setEdged(edged: boolean): void;
        setTheme(name: string): LayoutExtension;
        reset(): void;
        scrollTo(ele?: any, offset?: number): void;
        scrollTop(): void;
        getBreakpoint(which: string): number;
        calculateViewportHeight(): number;
        isHeaderFixed(): boolean;
        isFooterFixed(): boolean;
        isBoxed(): boolean;
        isEdged(): boolean;
        isSidebarClosed(): boolean;
        isSidebarHidden(): boolean;
        isSidebarFixed(): boolean;
        isSidebarCondensed(): boolean;
        isSidebarHover(): boolean;
        isSidebarReversed(): boolean;
    }
    class Loader {
        private name;
        private $el;
        private $loader;
        private $parent;
        private started;
        constructor(name: string, el: any);
        stop(): void;
        start(): void;
    }
}
declare module codex.extensions {
    class PresetsExtension extends Extension {
        static dependencies: string[];
        init(): void;
        boot(): void;
        protected _initLayoutApiActions(): void;
        protected layout: LayoutExtension;
        protected quick_sidebar: QuickSidebarExtension;
        set(name: string): void;
        protected applyPresetType(name: string, config?: any): void;
    }
}
declare module codex.extensions {
    class QuickSidebarTabs {
        qs: QuickSidebarExtension;
        switching: boolean;
        switchingTimeout: boolean;
        active: string;
        previous: string;
        constructor(qs: QuickSidebarExtension);
        find(find: any): JQuery;
        $wrapper: JQuery;
        $tabs: JQuery;
        $content: JQuery;
        protected handleTabsMiddleResizing(): QuickSidebarTabs;
        refresh(): void;
        getContentScrollHeight(): number;
        initContentScroll($content?: JQuery | string): QuickSidebarTabs;
        destroyContentScroll($content?: JQuery | string): QuickSidebarTabs;
        closeTabs(): QuickSidebarTabs;
        openTab(id?: string): QuickSidebarTabs;
        openPreviousTab(): QuickSidebarTabs;
        openNextTab(): QuickSidebarTabs;
        getActive(): string;
        getPrevious(): string;
        getNext(): string;
        getFirst(): string;
        getLast(): string;
        hasTab(id: string): boolean;
        getTabNav(id: string): JQuery;
        getTabContent(id: string): JQuery;
    }
    class QuickSidebarExtension extends Extension {
        protected tabs: QuickSidebarTabs;
        static dependencies: string[];
        mouseOverContent: boolean;
        init(): void;
        boot(): void;
        layout: LayoutExtension;
        $e: JQuery;
        find(find: any): JQuery;
        protected _initLayoutApiActions(): void;
        protected _initBindings(): void;
        protected _initResizeHandler(): void;
        refresh(): QuickSidebarExtension;
        protected _emit(name: string, ...args: any[]): void;
        show(): QuickSidebarExtension;
        hide(): QuickSidebarExtension;
        isClosed(): boolean;
        openTab(id?: string): QuickSidebarExtension;
        openNextTab(): QuickSidebarExtension;
        openPreviousTab(): QuickSidebarExtension;
        pin(): QuickSidebarExtension;
        unpin(): QuickSidebarExtension;
        isPinned(): boolean;
        exists(): boolean;
    }
}
declare module codex.plugins {
    class TestPlugin extends Plugin {
        protected _create(): void;
    }
}
declare module codex.widgets {
    class progressbarWidget extends Widget {
        version: string;
        widgetEventPrefix: string;
        options: any;
        $back_text: JQuery;
        $front_text: JQuery;
        $parent: JQuery;
        isVertical: boolean;
        minValue: number;
        maxValue: number;
        targetValue: number;
        percentage: number;
        current_percentage: number;
        current_value: number;
        this_size: number;
        parent_size: number;
        text: string;
        progressIntervalId: number;
        bs4: boolean;
        constructor();
        _getDataAttributes(): any;
        _formatAmount(val: any, percent: any, max: any, min: any): string;
        _updateBaseValues(): void;
        _create(): void;
        _start(): void;
        update(): void;
        _update(): void;
        _destroy(): void;
        _init(): any;
        _setOption(key: string, value: any): any;
    }
}
declare module codex.widgets {
    class TestWidget extends Widget {
        version: string;
        widgetEventPrefix: string;
        options: any;
        constructor();
        _create(): any;
    }
}
