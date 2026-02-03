(function () {
    tinymce.PluginManager.add('custom_buttons', function (editor, url) {

        editor.addButton('change_to_div', {
            text: 'div',
            tooltip: 'Обернути в div',
            onclick: function () {
                let selected_text = editor.selection.getContent({
                    format: "html",
                });

                editor.execCommand("mceReplaceContent", false, `<div class="text-div-wrapper">${selected_text}</div>`);
            }
        });
    });
})();
