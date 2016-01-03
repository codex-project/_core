module packadic {
    export class StyleStuff {

        protected _styles:{[key: string]: string};

        constructor() {
            this._styles = {};
        }


        public addMSC(name:string[]|string, variant:any = '500'):StyleStuff {
            if (typeof name === 'string') {
                if (variant !== '500') {
                    name += variant.toString();
                }
                this._styles[(<string>name).toString()] = 'color: ' + util.material.color((<string>name).toString(), variant);
            } else {
                (<string[]> name).forEach(function (n:string) {
                    this.addMSC(n, variant);
                }.bind(this))
            }
            return this;
        }

        public addFont(name:string, ff:string):StyleStuff {
            this._styles[name] = 'font-family: ' + ff;
            return this;
        }

        public add(name:string, val:string|string[]):StyleStuff {
            if (typeof val === 'string') {
                this._styles[name] = val;
            } else {
                var css = '';
                val.forEach(function (v:string) {
                    if (typeof this._styles[v] === 'string') {
                        css += this._styles[v] + ';';
                    } else {
                        css += v + ';';
                    }
                }.bind(this));
                this._styles[name] = css;
            }
            return this;
        }

        public all():any {
            return this._styles;
        }

        public get(name:string):any {
            return this._styles[name];
        }

        public has(name:string):boolean {
            return typeof this._styles[name] === 'string';
        }
    }


    export class Debug {
        protected enabled:boolean;
        protected matcher:RegExp = /\[style\=([\w\d\_\-\,]*?)\](.*?)\[style\]/g;
        protected start:Date;
        protected styles:StyleStuff;

        constructor() {
            this.start = new Date;
            this.styles = new StyleStuff();
            this.enabled = false;

            for (var i = 8; i < 30; i++) {
                this.styles.add('fs' + i.toString(), 'font-size: ' + i.toString() + 'px');
            }
            this.styles
                .add('bold', 'font-weight:bold')
                .add('code-box', 'background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1); line-height: 18px')
                .addMSC(Object.keys(util.material.colors))
                .addFont('code', '"Source Code Pro", "Courier New", Courier, monospace')
                .addFont('arial', 'Arial, Helvetica, sans-serif')
                .addFont('verdana', 'Verdana, Geneva, sans-serif');
        }

        public printTitle() {
            this.out('[style=orange,fs25]Packadic Framework[style] [style=yellow]1.0.0[style]');
        }

        public log(...args:any[]) {
            var elapsedTime:number = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = util.num.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]): '].concat(args));
        }

        public logEvent(eventName:string, ...args:any[]) {

            var elapsedTime:number = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = util.num.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]):[style=teal,fs10]EVENT[style]([style=blue,fs8]' + eventName + '[style]): '].concat(args));
        }

        public out(message:string, ...args:any[]) {
            var self:Debug = this;
            var applyArgs = [];
            applyArgs.push(message.replace(this.matcher, '%c$2%c'));

            var matched;
            while ((matched = this.matcher.exec(message)) !== null) {
                var css = '';
                matched[1].split(',').forEach(function (style) {
                    css += self.styles.get(style) + ';'
                });
                applyArgs.push(css);
                applyArgs.push(''); // push extra empty to reset styles for second %c
            }
            if (this.enabled) {
                console.log.apply(console, applyArgs.concat(args));
            }
        }


        public enable() {
            if (this.enabled) {
                return;
            }
            this.enabled = true;
            this.printTitle();
        }

        public isEnabled():boolean {
            return this.enabled;
        }

        public setStartDate(start:Date):Debug {
            this.start = start;
            return this;
        }

    }
}
