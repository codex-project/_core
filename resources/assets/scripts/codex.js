(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define(["packadic"], function (a0) {
      return (root['packadic'] = factory(a0));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("packadic"));
  } else {
    root['packadic'] = factory(packadic);
  }
}(this, function (packadic) {

/// <reference path="./../../../node_modules/packadic-site/src/ts/types.d.ts" />
/// <reference path="./../../../node_modules/packadic-site/src/ts/packadic.d.ts" />
/// <reference path="./../../../node_modules/packadic-site/src/ts/addons.d.ts" />
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
var docit;
(function (docit) {
    var extensions;
    (function (extensions) {
        var Extension = packadic.extensions.Extension;
        var extension = packadic.extension;
        var DocitExtension = (function (_super) {
            __extends(DocitExtension, _super);
            function DocitExtension() {
                _super.apply(this, arguments);
            }
            DocitExtension.prototype.init = function () {
                packadic.debug.log('DocitExtension init');
            };
            DocitExtension.prototype.boot = function () {
                packadic.debug.log('DocitExtension boot');
            };
            DocitExtension = __decorate([
                extension('docit')
            ], DocitExtension);
            return DocitExtension;
        })(Extension);
        extensions.DocitExtension = DocitExtension;
    })(extensions = docit.extensions || (docit.extensions = {}));
})(docit || (docit = {}));

return packadic;

}));
