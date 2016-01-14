
module codex.plugins {

    @plugin('testPlugin')
    export class TestPlugin extends Plugin {

        protected _create() {
            console.log('TestPlugin create');
        }
    }

    Plugin.register('testPlugin', TestPlugin);
}
