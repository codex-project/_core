
module packadic.extensions {


    var defaultConfig:any = {
        'default': {
            layout: ['header-fixed', 'footer-fixed'],
            theme: 'default'
        },
        'condensed-dark': {
            layout: ['header-fixed', 'footer-fixed', 'page-edged', 'sidebar-condensed'],
            theme: 'dark-sidebar'
        }
    };


    var $body:JQuery = $('body');


    @extension('presets', defaultConfig)
    export class PresetsExtension extends Extension {

        public static dependencies:string[] = ['layout', 'quick_sidebar'];


        public init() {
            this.app.debug.log('PresetsComponent init');
            this.app.on('booted', () => {
                debug.log('PresetsComponent received event emitted from app: booted');
            });
        }

        public boot() {
            var self:PresetsExtension = this;
            this._initLayoutApiActions();
        }

        protected _initLayoutApiActions() {
            var self:PresetsExtension = this;
            var apiActions:any = {
                'preset': (presetName:string) => {
                    console.log('preset', presetName, this, self);
                    self.set(presetName);
                }
            };
            self.layout.setApiActions(apiActions);
        }

        protected get layout():LayoutExtension {
            return <LayoutExtension> this.extensions.get('layout'); // this.app['layout'];
        }

        protected get quick_sidebar():QuickSidebarExtension {
            return <QuickSidebarExtension> this.extensions.get('quick_sidebar'); //this.app['quick_sidebar'];
        }

        public set(name:string) {
            var presetsConfig:any = this.config('presets.' + name);
            Object.keys(presetsConfig).forEach((presetType:string) => {
                this.applyPresetType(presetType, presetsConfig[presetType]);
            });
        }

        protected applyPresetType(name:string, config?:any) {
            var self:PresetsExtension = this;
            switch (name) {
                case 'theme':
                    this.layout.setTheme(config);
                    this.app.emit('layout:preset:theme', config);
                    break;
                case 'layout':
                    this.layout.reset();
                    if(kindOf(config) === 'string'){
                        config = [config];
                    }
                    config.forEach((actionName:string) => {
                        self.layout.api(actionName);
                    });
                    this.app.emit('layout:preset:layout', config);
                    break;
            }
            this.app.on('resize', () => { console.log('apply preset refresh', this); this.quick_sidebar.refresh() });
        }
    }

    //Extensions.register('presets', PresetsExtension, defaultConfig);

}
