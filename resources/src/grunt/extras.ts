///<reference path='../scripts/types.d.ts'/>
import * as util from 'util';

export function log(...args:any[]) {
    args.forEach((arg:any) => {
        process.stdout.write(util.inspect(arg, <util.InspectOptions> {colors: true, showHidden: true}));
    })
}

export function getVendorScripts(vendorScripts) {
    var scripts = [];
    vendorScripts.forEach(function (file) {
        scripts.push('bower_components/' + file);
    });

    return scripts;
}

export function modifyGrunt(grunt) {

    var propStringTmplRe = /^<%=\s*([a-z0-9_$]+(?:\.[a-z0-9_$]+)*)\s*%>$/i;

    function process(raw:any) {
        return grunt.util.recurse(raw, function (value:any) {
            if (typeof value === 'function') {
                var called = value.apply();
                if (typeof called === 'object' || typeof called === 'array') {
                    value = process(called);
                } else {
                    value = called;
                }
            }

            // If the value is not a string, return it.
            if (typeof value !== 'string') {
                return value;
            }
            // If possible, access the specified property via config.get, in case it
            // doesn't refer to a string, but instead refers to an object or array.
            var matches = value.match(propStringTmplRe);
            var result;
            if (matches) {
                result = grunt.config.get(matches[1]);
                // If the result retrieved from the config data wasn't null or undefined,
                // return it.
                if (result != null) {
                    return result;
                }
            }
            // Process the string as a template.
            return grunt.template.process(value, {data: grunt.config.data});
        });
    }

    grunt.config.process = process;
}
