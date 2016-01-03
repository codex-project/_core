
module packadic.widgets {

    // @todo: transform to bs4
    //@widget('progressbar')
    export class progressbarWidget extends Widget {
        public version:string = '1.0.0';
        public widgetEventPrefix:string = 'progressbar.';

        public options:any = {
            transitionDelay: 300,
            refreshSpeed: 50,
            textDisplay: 'none',
            textFormat: '{value} / {max} ({percent}%)',
            value: 0
        };

        public $back_text:JQuery;
        public $front_text:JQuery;
        public $parent:JQuery;
        public isVertical:boolean;
        public minValue:number;
        public maxValue:number;
        public targetValue:number;
        public percentage:number;
        public current_percentage:number;
        public current_value:number;
        public this_size:number;
        public parent_size:number;
        public text:string;
        public progressIntervalId:number;
        public bs4:boolean = false;

        constructor() {
            super();
        }

        public  _getDataAttributes() {
            var data:any = this.element.prefixedData('bar');
            return data;
        }


        public _formatAmount(val, percent, max, min):string {
            return this.options.textFormat
                .replace(/\{value\}/g, val)
                .replace(/\{percent\}/g, percent)
                .replace(/\{remaining\}/g, max - val)
                .replace(/\{max\}/g, max)
                .replace(/\{min\}/g, min);
        }

        public _updateBaseValues() {
            this.options = $.extend(true, this.options, this._getDataAttributes());
            var $el:JQuery = this.element;
            this.$parent = $el.parent();
            this.targetValue = parseInt(this.options.value);
            this.minValue = parseInt($el.attr(this.bs4 ? 'min' : 'aria-valuemin')) || 0;
            this.maxValue = parseInt($el.attr(this.bs4 ? 'max' : 'aria-valuemax')) || 100;
            this.isVertical = this.$parent.hasClass('vertical');
            this.percentage = Math.round(100 * (this.targetValue - this.minValue) / (this.maxValue - this.minValue));
        }

        public  _create() {
            var self:progressbarWidget = this;
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
                    this.$back_text.css({height: parent_size, 'line-height': parent_size});
                    this.$front_text.css({height: parent_size, 'line-height': parent_size});

                    // normal resizing would brick the structure because width is in px
                    this._on(this.window, {
                        'resize': function (event) {
                            parent_size = this.$parent.css('height');
                            this.$back_text.css({height: parent_size, 'line-height': parent_size});
                            this.$front_text.css({height: parent_size, 'line-height': parent_size});
                        }
                    });
                }
                else {
                    parent_size = this.$parent.css('width');
                    this.$front_text.css({width: parent_size});

                    // normal resizing would brick the structure because width is in px
                    this._on(this.window, {
                        resize: function (event) {
                            parent_size = this.$parent.css('width');
                            this.$front_text.css({width: parent_size});
                        }
                    });
                }
            }


            setTimeout(this._start.bind(this), this.options.transitionDelay);
        }


        public _start() {

            if (this.isVertical) {
                this.element.css('height', this.percentage + '%');
            }
            else {
                this.element.css('width', this.percentage + '%');
            }

            this.progressIntervalId = setInterval(this._update.bind(this), this.options.refreshSpeed);
        }

        public update() {
            this._updateBaseValues();
            this._start();
        }

        public _update() {
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
        }


        public _destroy() {

        }

        //  Any time the plugin is alled with no arguments or with only an option hash,
        // the widget is initialized; this includes when the widget is created.
        public _init():any {
            return undefined;
        }

        public _setOption(key:string, value:any):any {
            var self:progressbarWidget = this;
            switch (key) {
                case 'hidden':
                    break;
            }
            this._super(key, value);
            return this;
        }

    }



}
