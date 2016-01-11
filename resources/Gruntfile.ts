///<reference path='src/scripts/types.d.ts'/>
import * as fs from 'fs-extra';
import * as globule from 'globule';
import * as path from 'path'
import * as _ from 'lodash';
import * as util from 'util';
import * as _s from 'underscore.string';
import * as sass from 'node-sass';
import * as chalk from 'chalk';


require('ts-node').register();

import {getVendorScripts, log, modifyGrunt} from './src/grunt/extras';

export = function (grunt:IGrunt) {

    //modifyGrunt(grunt);
    var watchTS = grunt.option('watcher') == 'ts';

    var targets = {
        dist: {name: 'dist', dest: 'assets', scripts: 'dist/js', styles: 'dist/css'},
        dev : {name: 'dev', dest: 'dev', scripts: 'dev/assets/scripts', styles: 'dev/assets/styles'},
    };

    function setTarget(name:string) {
        grunt.config.set('target', targets[name]);
    }

    function ifTarget(name:string, then:any, els:any = false):any {
        return () => grunt.config.get("target")['name'] === name ? then : els;
    }

    var vendorScripts:any = getVendorScripts([
        'lodash/lodash.js', 'eventemitter2/lib/eventemitter2.js', 'async/dist/async.js', 'underscore.string/dist/underscore.string.js', 'jade/runtime.js',
        'jquery/dist/jquery.js', 'jquery-migrate/jquery-migrate.js', 'jquery-ui/ui/widget.js', 'jquery-slimscroll/jquery.slimscroll.js', 'jcarousel/dist/jquery.jcarousel.js',
        'tether/dist/js/tether.js', 'bootstrap/dist/js/bootstrap.js', 'bootstrap-material-design/dist/js/material.js'
    ]);


    var config = {
        pkg: fs.readJSONSync('package.json'),

        target : targets[<string> grunt.option('target') || 'dev'],
        targets: targets,

        concat: {vendor: {src: vendorScripts, dest: '<%= target.dest %>/scripts/vendor.js'}},
        uglify: {
            vendor  : {files: {'<%= target.dest %>/scripts/vendor.min.js': '<%= target.dest %>/scripts/vendor.js'}},
            addons  : {files: {'<%= target.dest %>/scripts/addons.min.js': '<%= target.dest %>/scripts/addons.js'}},
            packadic: {files: {'<%= target.dest %>/scripts/packadic.min.js': '<%= target.dest %>/scripts/packadic.js'}}
        },

        clean: {
            all    : {src: '<%= target.dest %>'},
            views  : {src: '<%= target.dest %>/**/*.html'},
            basedir: {src: '{dev,dist,src}/**/.baseDir.*'}
        },

        copy: {
            ts   : {files: [{cwd: 'src/scripts', src: ['*.{js,js.map}'], dest: '<%= target.dest %>/scripts/', expand: true}]},
            bower: {files: [{cwd: 'bower_components', src: '**', dest: '<%= target.dest %>/bower_components/', expand: true}]},

            scss        : {files: [{cwd: 'src/styles', src: ['**'], dest: '<%= target.dest %>/scss/', expand: true}]},
            script_views: {options: {mtimeUpdate: true}, files: [{cwd: 'src/scripts', src: ['**/*.{jade,html}'], dest: '<%= target.scripts %>', expand: true}]}
        },

        jade: {
            options: {
                pretty: true, data: {_inspect: util.inspect, _target: '<%= target %>', baseHref: '/', _: _, _s: _s}
            },
            index  : {src: 'src/views/index.jade', dest: '<%= target.dest %>/index.html'}
        },


        sass: {
            options: {sourceMap: false, outputStyle: '<%= target.name === "dev" ? "expanded" : "compressed" %>'},
            styles : {
                files: {
                    '<%= target.dest %>/styles/stylesheet.css'          : 'src/styles/stylesheet.scss',
                    '<%= target.dest %>/styles/phpdoc.css'              : 'src/styles/phpdoc.scss',
                    '<%= target.dest %>/styles/themes/theme-default.css': 'src/styles/themes/theme-default.scss',
                    '<%= target.dest %>/styles/themes/theme-codex.css'  : 'src/styles/themes/theme-codex.scss'
                }
            }
        },


        ts: {
            options : {compiler: 'node_modules/typescript/bin/tsc', target: 'ES5', emitError: true, sourceMap: ifTarget('dev', true), experimentalDecorators: true},
            packadic: {
                options: {declaration: true, sourceMap: ifTarget('dev', true)},
                src    : ['src/scripts/packadic/@init.ts', 'src/scripts/packadic/{util,lib}/**/*.ts', 'src/scripts/packadic/~bootstrap.ts'],
                out    : 'src/scripts/packadic.js'
            },
            addons  : {
                options: {declaration: true, sourceMap: ifTarget('dev', true)},
                src    : ['src/scripts/addons/@init.ts', 'src/scripts/addons/{extensions,plugins,widgets}/**/*.ts'],
                out    : 'src/scripts/addons.js'
            }
        },

        connect: {dev: {options: {port: 8000, livereload: false, base: 'dev'}}},

        watch: {
            options    : {livereload: true},
            ts_packadic: {files: ['src/scripts/packadic/**/*.ts'], tasks: ['ts:packadic', 'copy:ts']},
            ts_addons  : {files: ['src/scripts/addons/**/*.ts'], tasks: ['ts:addons', 'copy:ts']},
            sass       : {files: ['src/styles/**/*.{sass,scss}'], tasks: ['sass:styles']}
        }
    };

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);

    grunt.initConfig(config);

    [
        ['default', 'Default task', ['build']],
        ['build', 'Build scripts', [
            'clean:all',
            'sass:styles',
            'jade:index',
            'ts:packadic',
            'ts:addons',
            'copy:ts',
            'bower',
            'concat:vendor',
            'uglify'
        ]],
        ['bower', '', function () {
            grunt.task.run(grunt.config('target.name') == 'dist' ? 'copy:bower' : 'link:bower');
        }],
        ['config', 'Show config', (target?:string) => log(grunt.config.get(target))],
        ['target', 'Set target trough task', (targ) => setTarget(targ)],
        ['link', 'Create a symlink into the target from the project dir', function (opt) {
            var target = grunt.config('target');

            function makeLink(to) {
                var cwd = process.cwd();
                grunt.log.ok(cwd);
                process.chdir(target.dest);
                var relPath = path.relative(
                    process.cwd(),
                    path.join(cwd, to)
                );
                if (fs.existsSync(path.join(process.cwd(), to))) {
                    grunt.log.warn('skipping ' + to + ' - already exists')
                } else {
                    fs.symlinkSync(relPath, to);
                    grunt.log.ok('symlink created: ' + relPath + ' -> ' + path.join(target.dest, 'assets', to));
                }
                process.chdir(cwd);
            }

            if (opt === 'bower') {
                makeLink('bower_components');
            } else if (opt === 'jspm') {
                makeLink('jspm_packages');
                makeLink('system.config.js');
            }
        }],
    ].forEach(function (simpleTask) {
        grunt.registerTask(simpleTask[0], simpleTask[1], simpleTask[2]);
    }.bind(this));

}
