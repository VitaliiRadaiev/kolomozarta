(function () {
    tinymce.PluginManager.add('custom_buttons', function (editor, url) {

        // Списки классов должны совпадать 1:1 с $wysiwyg-colors / $wysiwyg-margin
        // и утилитами из src/scss/base/_wysiwyg-content.scss.

        const titleSizeClasses = [
            'text-h1',
            'text-h2',
            'text-h3',
            'text-h4',
            'text-h5',
            'text-h6',
        ];
        editor.addButton('title_font_sizes', {
            type: 'menubutton',
            text: 'Розмір тексту',
            icon: false,
            tooltip: 'Задати розмір тексту',
            menu: titleSizeClasses.map((className) => ({
                text: className,
                onclick: () => wrapSelection(className, titleSizeClasses)
            }))
        });

        const colorClasses = [
            'text-color-primary',
            'text-color-primary-medium',
            'text-color-primary-dark',
            'text-color-default',
            'text-color-dark',
            'text-color-accent',
            'text-color-white',
        ];
        editor.addButton('colors', {
            type: 'menubutton',
            text: 'Колір тексту',
            icon: false,
            tooltip: 'Задати колір тексту',
            menu: colorClasses.map((className) => ({
                text: className,
                onclick: () => wrapSelection(className, colorClasses)
            }))
        });

        const textTransformClasses = [
            'uppercase',
            'lowercase',
            'font-normal',
            'font-semibold',
            'font-bold',
        ];
        editor.addButton('text_transform', {
            type: 'menubutton',
            text: 'Стиль тексту',
            icon: false,
            tooltip: 'Задати регістр та насиченість тексту',
            menu: textTransformClasses.map((className) => ({
                text: className,
                onclick: () => wrapSelection(className, textTransformClasses)
            }))
        });

        const spaceTopClasses = [
            'mt-0',
            'mt-sm',
            'mt-md',
            'mt-lg',
            'mt-xl',
            'mt-2xl',
        ];
        editor.addButton('space_top', {
            type: 'menubutton',
            text: 'Відступ зверху',
            icon: false,
            tooltip: 'Задати відступ зверху на батьківському блоці',
            menu: spaceTopClasses.map((className) => ({
                text: className,
                onclick: () => applyBlockSpacing(className, spaceTopClasses)
            }))
        });

        const spaceBottomClasses = [
            'mb-0',
            'mb-sm',
            'mb-md',
            'mb-lg',
            'mb-xl',
            'mb-2xl',
        ];
        editor.addButton('space_bottom', {
            type: 'menubutton',
            text: 'Відступ знизу',
            icon: false,
            tooltip: 'Задати відступ знизу на батьківському блоці',
            menu: spaceBottomClasses.map((className) => ({
                text: className,
                onclick: () => applyBlockSpacing(className, spaceBottomClasses)
            }))
        });

        editor.addButton('clear_formatting', {
            icon: false,
            text: 'Очистити',
            tooltip: 'Очистити форматування тексту',
            onclick: clearSelectionFormatting
        });

        function clearSelectionFormatting() {
            const selected_text = editor.selection.getContent({ format: "text" });
            editor.execCommand("mceReplaceContent", false, editor.dom.encode(selected_text));
        }

        function applyBlockSpacing(className, activeClasses = []) {
            const parent = getSelectionBlockParent();

            if (!parent) {
                return;
            }

            parent.classList.remove(...activeClasses);
            parent.classList.add(className);
        }

        function getSelectionBlockParent() {
            const body = editor.getBody();
            let node = editor.selection.getNode();

            while (node && node !== body) {
                if (editor.dom.isBlock(node)) {
                    return node;
                }
                node = node.parentNode;
            }

            return null;
        }

        function wrapSelection(className, activeClasses = []) {
            const wrapper = getSelectionWrapper();

            if (wrapper) {
                wrapper.classList.remove(...activeClasses);
                wrapper.classList.add(className);
                return;
            }

            const selected_text = editor.selection.getContent({ format: "html" });
            editor.execCommand(
                "mceReplaceContent",
                false,
                `<span data-text-wrapper class="${className}">${selected_text}</span>`
            );
        }

        function getSelectionWrapper() {
            const rng = editor.selection.getRng();
            const startWrapper = editor.dom.getParent(rng.startContainer, '[data-text-wrapper]');
            const endWrapper = editor.dom.getParent(rng.endContainer, '[data-text-wrapper]');

            if (!startWrapper || startWrapper !== endWrapper) {
                return null;
            }

            const wrapperRange = editor.dom.createRng();
            wrapperRange.selectNodeContents(startWrapper);

            const coversWholeWrapper =
                rng.compareBoundaryPoints(rng.START_TO_START, wrapperRange) === 0 &&
                rng.compareBoundaryPoints(rng.END_TO_END, wrapperRange) === 0;

            return coversWholeWrapper ? startWrapper : null;
        }
    });
})();
