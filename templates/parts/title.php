<?php
$title_data = $args['title_data'] ?? [];
$classes = $args['classes'] ?? 'text-gradient-blue';
$attributes = $args['attributes'] ?? '';
$size = $args['size'] ?? 'h2';

$title_data = wp_parse_args($title_data, [
    'html_tag' => 'h2',
    'size' => 'h2',
    'text_align' => 'center',
    'is_bottom_line' => true,
    'text' => ''
]);

if (check($title_data['text'])):
?>
    <<?= $title_data['html_tag'] ?> <?= $attributes ?> class="<?= $title_data['size'] . ' ' . 'text-' . $title_data['text_align'] ?> <?= !$title_data['is_bottom_line'] ?: 'bottom-line' ?> <?= $classes ?>">
        <?= $title_data['text'] ?>
    </<?= $title_data['html_tag'] ?>>
<?php endif; ?>