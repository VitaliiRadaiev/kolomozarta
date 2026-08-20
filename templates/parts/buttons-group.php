<?php
$classes = $args['classes'] ?? '';
$attributes = $args['attributes'] ?? '';
$buttons = $args['buttons'] ?? [];

if (check($buttons)):
?>
    <div class="main-buttons-group <?= $classes ?>" <?= $attributes ?>>
        <?php foreach($buttons as $button_data) {
            get_template_part(get_part_path('button'), null, ['button_data' => $button_data['button']]);
        }?>
    </div>
<?php endif; ?>