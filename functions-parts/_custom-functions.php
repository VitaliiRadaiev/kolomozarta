<?php
function arrays_have_common_element(array $array1, array $array2): bool
{
    return !empty(array_intersect($array1, $array2));
}

function build_menu_hierarchy($items, $parent = 0)
{
    $menu = array();
    foreach ($items as $item) {
        if ($item->menu_item_parent == $parent) {
            $children = build_menu_hierarchy($items, $item->ID);
            if ($children) {
                $item->children = $children;
            }
            $menu[] = $item;
        }
    }
    return $menu;
}

function render_menu_link($menu, $classes = '', $attr = '')
{
?>
    <a href="<?= $menu->url ?>" target="<?= $menu->target ? '_blank' : '_self' ?>" <?= $attr ?> class="<?= $classes ?>">
        <?= $menu->title ?>
    </a>
<?php
}

function get_image($image_id, $classes = '', $echo = true, $size = 'full', $attributes = [])
// thumbnail, medium, large, full
{

    if ($image_id) {
        $image_html = wp_get_attachment_image(
            $image_id,
            $size,
            false,
            array_merge(
                ['class' => $classes],
                [
                    'sizes' => '
                        (max-width: 480px) 100vw,
                        (max-width: 768px) 120vw,
                        (max-width: 1024px) 150vw,
                        2048px'
                ],
                $attributes
            )
        );

        if ($echo) {
            echo $image_html;
        } else {
            return $image_html;
        }
    } else {
        return false;
    }
}

function check($var)
{
  if (is_string($var)) {
    $var = trim($var);
  }

  return $var && isset($var) && !empty($var);
}

function add_inner_wrap_to_li($text)
{
    $value = preg_replace('/<li([^>]*)>(.*?)<\/li>/is', '<li$1><div>$2</div></li>', $text);

    return $value;
}
