this["JST"] = this["JST"] || {};

this["JST"]["src/templates/customizer"] = function template(locals) {
var buf = [];
var jade_mixins = {};
var jade_interp;
;var locals_for_with = (locals || {});(function (definitions, prefs, undefined) {
var jade_indent = [];
buf.push("\n<div class=\"preferences panel panel-default\">\n  <button class=\"btn btn-primary withoutripple customizer-toggler\"><i class=\"fa fa-cog\"></i></button>\n  <div class=\"panel-heading\">Preferences</div>\n  <div class=\"panel-body panel-form-container\">\n    <form class=\"form-horizontal\">");
// iterate definitions
;(function(){
  var $$obj = definitions;
  if ('number' == typeof $$obj.length) {

    for (var $index = 0, $$l = $$obj.length; $index < $$l; $index++) {
      var pref = $$obj[$index];

buf.push("\n      <div class=\"form-group\">");
if ( pref.type == 'header')
{
buf.push("\n        <div class=\"col-xs-6 text-right\">\n          <h5 class=\"mb-n\">" + (jade.escape(null == (jade_interp = pref.title) ? "" : jade_interp)) + "</h5>\n        </div>");
}
if ( pref.type == 'boolean')
{
buf.push("\n        <label" + (jade.attr("for", 'pref_' + pref.name, true, false)) + " class=\"col-xs-6 fs-10 control-label\">" + (jade.escape(null == (jade_interp = pref.title) ? "" : jade_interp)) + "</label>\n        <div class=\"col-xs-6\">\n          <input type=\"checkbox\"" + (jade.attr("data-preference", pref, true, false)) + (jade.attr("name", 'pref_' + pref.name, true, false)) + (jade.attr("id", 'pref_' + pref.name, true, false)) + (jade.attr("checked", prefs[pref.name], true, false)) + " data-size=\"mini\" class=\"switch\"/>\n        </div>");
}
buf.push("\n      </div>");
    }

  } else {
    var $$l = 0;
    for (var $index in $$obj) {
      $$l++;      var pref = $$obj[$index];

buf.push("\n      <div class=\"form-group\">");
if ( pref.type == 'header')
{
buf.push("\n        <div class=\"col-xs-6 text-right\">\n          <h5 class=\"mb-n\">" + (jade.escape(null == (jade_interp = pref.title) ? "" : jade_interp)) + "</h5>\n        </div>");
}
if ( pref.type == 'boolean')
{
buf.push("\n        <label" + (jade.attr("for", 'pref_' + pref.name, true, false)) + " class=\"col-xs-6 fs-10 control-label\">" + (jade.escape(null == (jade_interp = pref.title) ? "" : jade_interp)) + "</label>\n        <div class=\"col-xs-6\">\n          <input type=\"checkbox\"" + (jade.attr("data-preference", pref, true, false)) + (jade.attr("name", 'pref_' + pref.name, true, false)) + (jade.attr("id", 'pref_' + pref.name, true, false)) + (jade.attr("checked", prefs[pref.name], true, false)) + " data-size=\"mini\" class=\"switch\"/>\n        </div>");
}
buf.push("\n      </div>");
    }

  }
}).call(this);

buf.push("\n    </form>\n  </div>\n</div>");}.call(this,"definitions" in locals_for_with?locals_for_with.definitions:typeof definitions!=="undefined"?definitions:undefined,"prefs" in locals_for_with?locals_for_with.prefs:typeof prefs!=="undefined"?prefs:undefined,"undefined" in locals_for_with?locals_for_with.undefined:typeof undefined!=="undefined"?undefined:undefined));;return buf.join("");
};