/*
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */

(function($) {

    var csscls = PhpDebugBar.utils.makecsscls('phpdebugbar-widgets-');

    /**
     * Widget for the displaying mails data
     *
     * Options:
     *  - data
     */
    var MailsWidget = PhpDebugBar.Widgets.MailsWidget = PhpDebugBar.Widget.extend({

        className: csscls('mails'),

        render: function() {
            this.$list = new  PhpDebugBar.Widgets.ListWidget({ itemRenderer: function(li, mail) {
                $('<span />').addClass(csscls('subject')).text(mail.subject).appendTo(li);
                $('<span />').addClass(csscls('to')).text(mail.to).appendTo(li);
                if (mail.headers) {
                    var headers = $('<pre />').addClass(csscls('headers')).appendTo(li);
                    $('<code />').text(mail.headers).appendTo(headers);
                    li.click(function() {
                        if (headers.is(':visible')) {
                            headers.hide();
                        } else {
                            headers.show();
                        }
                    });
                }
            }});
            this.$list.$el.appendTo(this.$el);

            this.bindAttr('data', function(data) {
                this.$list.set('data', data);
            });
        }

    });

})(PhpDebugBar.$);
