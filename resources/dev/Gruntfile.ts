///<reference path='assets/types/types.d.ts'/>
import * as fs from 'fs-extra';
import * as globule from 'globule';
import * as path from 'path'
import * as _ from 'lodash';
import * as util from 'util';
import * as _s from 'underscore.string';
import * as sass from 'node-sass';
import * as chalk from 'chalk';


require('ts-node').register();

export = function (grunt:IGrunt)
{
    var targets = {
        dist: {name: 'dist', dest: 'assets'},
        dev : {name: 'dev', dest: 'assets'},
    };

    function setTarget(name:string)
    {
        grunt.config.set('target', grunt.config('targets.' + name));
    }

    function ifTarget(name:string, then:any, els:any = false):any
    {
        return () => grunt.config.get("target")['name'] === name ? then : els;
    }


    function log(...args:any[])
    {
        args.forEach((arg:any) =>
        {
            process.stdout.write(util.inspect(arg, <util.InspectOptions> {colors: true, showHidden: true}));
        })
    }

    var config = {
        pkg    : fs.readJSONSync('package.json'),
        src    : 'resources/assets',
        bower_components: 'bower_components',
        target : targets[<string> grunt.option('target') || 'dev'],
        targets: targets,

        uglify: {
            codex: {files: {'<%= target.dest %>/scripts/vendor.min.js': '<%= target.dest %>/scripts/vendor.js'}},
        },

        concat: {scripts: {src: [
            '<%= bower_components %>/codemirror/lib/codemirror.js',
            '<%= bower_components %>/codemirror/mode/javascript/javascript.js',
            '<%= bower_components %>/bootstrap-sass/assets/javascripts/bootstrap/tab.js',
            '<%= target.dest %>/codex-debugbar.js'
        ], dest: '<%= target.dest %>/codex-debugbar.js'}},

        sass: {
            options: {sourceMap: false, outputStyle: '<%= target.name === "dev" ? "expanded" : "compressed" %>'},
            codex  : {files: {'<%= target.dest %>/codex-debugbar.css': '<%= src %>/codex-debugbar.scss'}}
        },

        ts   : {
            options: {compiler: 'node_modules/typescript/bin/tsc', target: 'ES5', emitError: true,experimentalDecorators: true},
            codex  : {
                options: {declaration: false, sourceMap: false},
                src    : ['<%= src %>/debugbar/@init.ts', '<%= src %>/debugbar/lib/**/*.ts','<%= src %>/debugbar/*.ts'],
                out    : '<%= target.dest %>/codex-debugbar.js'
            },
        },

        watch: {
            options: {livereload: 54154, spawn:false},
            ts     : {files: ['<%= src %>/**/*.ts'], tasks: ['scripts']},
            sass   : {files: ['<%= src %>/**/*.{sass,scss}'], tasks: ['sass']},
        }
    };

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);

    grunt.initConfig(config);

    [
        ['default', 'Default task', ['build']],
        ['scripts', 'Build scripts', [
            'ts:codex',
            'concat:scripts'
        ]],
        ['build', 'Build all', [
            'sass:styles',
            'scripts'
        ]],
        ['dist', 'Dist build', [
            'target:dist',
            'build',
            'uglify'
        ]],
    ].forEach(function (simpleTask)
    {
        grunt.registerTask(simpleTask[0], simpleTask[1], simpleTask[2]);
    }.bind(this));

}
