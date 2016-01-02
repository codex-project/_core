
module packadic.widgets {

    @widget('testWidget')
    export class TestWidget extends Widget {

        public version:string = '1.0.0';
        public widgetEventPrefix:string = 'test.';

        public options:any = { 'test' : 'yes' };

        constructor() {
            super();
        }

        _create():any {
            console.log('TestWidget create');
        }

    }

    //createWidget('testWidget', TestWidget);
}
