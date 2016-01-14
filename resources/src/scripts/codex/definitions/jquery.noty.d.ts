interface NotyObjectStatic {
    init(options):NotyObjectStatic;
    _build():void;
    show():NotyObjectStatic;
    close():void;
    closeCleanUp():void;
    setText(text):NotyObjectStatic;
    setType(type):NotyObjectStatic;
    setTimeout(time):NotyObjectStatic;
    stopPropagation(evt):void;
    closed : boolean;
    showing: boolean;
    shown  : boolean;
}

interface NotyRendererStatic {
    init(options) : NotyObjectStatic;
    render() : void;
    show(notification) : void;
    createModalFor(notification) : void;
    getLayoutCountFor(notification) : void;
    setLayoutCountFor(notification, arg) : void;
    getModalCount() : void;
    setModalCount(arg) : void;
}

interface NotyLayoutContainer {
    selector?:string;
    object?:string;
    style?:Function;

}
interface NotyLayout {
    name?:string;
    container?:NotyLayoutContainer;
    parent?:any;
    css?:any;
    addClass?:string;
}

interface NotyTheme {
    name:string;
    modal?:any;
    style:Function;
    callback?:{[name:string]:Function}
}

interface NotyStatic {
    queue:Array<any>;
    ontap:boolean;
    layouts:{[key:string]:NotyLayout};
    themes:{[key:string]:NotyTheme};
    returns:string;
    store:any;
    get(id) : any;
    close(id) : any;
    clearQueue() : void;
    closeAll() : void;
}

interface JQueryStatic {
    notyRenderer: NotyRendererStatic;
}
