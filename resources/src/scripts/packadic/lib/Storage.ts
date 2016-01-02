/**
 * The storage module provides data storage providers
 */
module packadic.storage {
    import DeferredInterface = packadic.util.promise.DeferredInterface;
    import PromiseInterface = packadic.util.promise.PromiseInterface;


    export var bags:{[name:string]:IStorageBag} = {};

    export function hasBag(name:string):boolean {
        return typeof bags[name] !== 'undefined';
    }

    export function createBag(name:string, provider:IStorageProvider):IStorageBag {
        if (hasBag(name)) {
            throw new Error('StorageBag ' + name + ' already exists');
        }
        return bags[name] = new StorageBag(provider);
    }

    export function getBag(name:string):IStorageBag {
        if (!hasBag(name)) {
            throw new Error('StorageBag ' + name + ' does not exist');
        }
        return bags[name];
    }

    export interface IStorageProvider {
        length: number;
        onStoreEvent(callback:Function);
        clear(): void;
        getItem(key:string): any;
        key(index:number): string;
        removeItem(key:string): void;
        setItem(key:string, data:string): void;
        getSize(key:any):string;
    }

    export interface IStorageBag {
        get(key:any, options?:any);
        set(key:any, val:any, options?:any);
        on(callback:any);
        del(key:any);
        clear();
        getSize(key:any);
    }

    export class StorageBag implements IStorageBag {
        provider:IStorageProvider;

        constructor(provider:IStorageProvider) {
            this.provider = provider;
        }

        /**
         * Add a event listener for the 'onstorage' event
         * @param {function} callback
         */
        public on(callback:Function) {
            this.provider.onStoreEvent(callback);
            /*
             if (window.addEventListener) {
             window.addEventListener("storage", callback, false);
             } else {
             window.attachEvent("onstorage", callback);
             }*/
        }

        /**
         * @typedef StorageSetOptions
         * @type {object}
         * @property {boolean} [json=false] - Set to true if the value passed is a JSON object
         * @property {number|boolean} [expires=false] - Minutes until expired
         */
        /**
         * Save a value to the storage
         * @param {string|number} key               - The unique id to save the data on
         * @param {*} val                           - The value, can be any datatype. If it's an object, make sure to enable json in the options
         * @param {StorageSetOptions} [options]     - Additional options, check the docs
         */
        public set(key:any, val:any, options?:any) {
            var options:any = _.merge({json: false, expires: false}, options);
            if (options.json) {
                val = JSON.stringify(val);
            }
            if (options.expires) {
                var now = Math.floor((Date.now() / 1000) / 60);
                this.provider.setItem(key + ':expire', now + options.expires);
            }
            this.provider.setItem(key, val);
        }

        /**
         * @typedef StorageGetOptions
         * @type {object}
         * @property {boolean} [json=false]     - Set to true if the value is a JSON object
         * @property {*} [default=false]        - The default value to return if the requested key does not exist
         */
        /**
         * Get a value from the storage
         * @param key
         * @param {StorageGetOptions} [options] - Optional options, check the docs
         * @returns {*}
         */
        public get(key:any, options?:any) {
            var options:any = _.merge({json: false, def: null}, options);

            if (!defined(key)) {
                return options.def;
            }

            if (_.isString(this.provider.getItem(key))) {
                if (_.isString(this.provider.getItem(key + ':expire'))) {
                    var now = Math.floor((Date.now() / 1000) / 60);
                    var expires = parseInt(this.provider.getItem(key + ':expire'));
                    if (now > expires) {
                        this.del(key);
                        this.del(key + ':expire');
                    }
                }
            }

            var val:any = this.provider.getItem(key);

            if (!defined(val) || defined(val) && val == null) {
                return options.def;
            }

            if (options.json) {
                return JSON.parse(val);
            }
            return val;
        }


        /**
         * Delete a value from the storage
         * @param {string|number} key
         */
        public del(key) {
            this.provider.removeItem(key);
        }

        /**
         * Clear the storage, will clean all saved items
         */
        public clear() {
            this.provider.clear();
        }


        /**
         * Get total localstorage size in MB. If key is provided,
         * it will return size in MB only for the corresponding item.
         * @param [key]
         * @returns {string}
         */
        public getSize(key:any):string {
            return this.provider.getSize(key);
        }
    }

    export class LocalStorage implements IStorageProvider {
        public get length():number {
            return window.localStorage.length;
        }

        public getSize(key:any):string {
            key = key || false;
            if (key) {
                return ((window.localStorage[x].length * 2) / 1024 / 1024).toFixed(2);
            } else {
                var total = 0;
                for (var x in window.localStorage) {
                    total += (window.localStorage[x].length * 2) / 1024 / 1024;
                }
                return total.toFixed(2);
            }
        }

        onStoreEvent(callback:Function) {
            if (window.addEventListener) {
                window.addEventListener("storage", <any> callback, false);
            } else {
                window.attachEvent("onstorage", <any> callback);
            }
        }

        clear():void {
            window.localStorage.clear();
        }

        getItem(key:string):any {
            return window.localStorage.getItem(key);
        }

        key(index:number):string {
            return window.localStorage.key(index);
        }

        removeItem(key:string):void {
            window.localStorage.removeItem(key);
        }

        setItem(key:string, data:string):void {
            window.localStorage.setItem(key, data);
        }
    }

    export class SessionStorage implements IStorageProvider {
        public get length() {
            return window.sessionStorage.length;
        }

        public getSize(key:any):string {
            key = key || false;
            if (key) {
                return ((window.sessionStorage[x].length * 2) / 1024 / 1024).toFixed(2);
            } else {
                var total = 0;
                for (var x in window.sessionStorage) {
                    total += (window.sessionStorage[x].length * 2) / 1024 / 1024;
                }
                return total.toFixed(2);
            }
        }

        onStoreEvent(callback:Function) {
            if (window.addEventListener) {
                window.addEventListener("storage", <any> callback, false);
            } else {
                window.attachEvent("onstorage", <any> callback);
            }
        }

        clear():void {
            window.sessionStorage.clear();
        }

        getItem(key:string):any {
            return window.sessionStorage.getItem(key);
        }

        key(index:number):string {
            return window.sessionStorage.key(index);
        }

        removeItem(key:string):void {
            window.sessionStorage.removeItem(key);
        }

        setItem(key:string, data:string):void {
            window.sessionStorage.setItem(key, data);
        }
    }

    export class CookieStorage implements IStorageProvider {
        public get length() {
            return this.keys().length;
        }

        public getSize(key:any):string {
            key = key || false;
            if (key) {
                return ((window.sessionStorage[x].length * 2) / 1024 / 1024).toFixed(2);
            } else {
                var total = 0;
                for (var x in window.sessionStorage) {
                    total += (window.sessionStorage[x].length * 2) / 1024 / 1024;
                }
                return total.toFixed(2);
            }
        }
        cookieRegistry:any[] = [];

        protected listenCookieChange(cookieName, callback) {
            setInterval(() => {
                if (this.hasItem(cookieName)) {
                    if (this.getItem(cookieName) != this.cookieRegistry[cookieName]) {
                        // update registry so we dont get triggered again
                        this.cookieRegistry[cookieName] = this.getItem(cookieName);
                        return callback();
                    }
                } else {
                    this.cookieRegistry[cookieName] = this.getItem(cookieName);
                }
            }, 100);
        }


        onStoreEvent(callback:Function) {
            this.keys().forEach((name:string) => {
                this.listenCookieChange(name, callback);
            })
        }

        clear():void {
            this.keys().forEach((name:string)=> {
                this.removeItem(name);
            })
        }

        key(index:number):string {
            return this.keys()[index];
        }


        public getItem(sKey) {
            if (!sKey) {
                return null;
            }
            return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
        }

        public setItem(sKey:any, sValue:any, vEnd?:any, sPath?:any, sDomain?:any, bSecure?:any):void {
            if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
                return;
            }
            var sExpires = "";
            if (vEnd) {
                switch (vEnd.constructor) {
                    case Number:
                        sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
                        break;
                    case String:
                        sExpires = "; expires=" + vEnd;
                        break;
                    case Date:
                        sExpires = "; expires=" + vEnd.toUTCString();
                        break;
                }
            }
            document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
            return;
        }


        public removeItem(key:string, sPath?:any, sDomain?:any) {
            if (!this.hasItem(key)) {
                return false;
            }
            document.cookie = encodeURIComponent(key) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
            return true;
        }

        public hasItem(sKey) {
            if (!sKey) {
                return false;
            }
            return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
        }

        public keys() {
            var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
            for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) {
                aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
            }
            return aKeys;
        }

    }

    if (typeof window.localStorage !== 'undefined') {
        createBag('local', <IStorageProvider> new LocalStorage())
    }

    if (typeof window.sessionStorage !== 'undefined') {
        createBag('session', <IStorageProvider> new SessionStorage())
    }

    if (typeof window.document.cookie !== 'undefined') {
        createBag('cookie', <IStorageProvider> new CookieStorage())
    }

}
