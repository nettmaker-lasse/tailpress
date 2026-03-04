<?php
/**
 * Custom walker for accessible navigation with explicit submenu toggles.
 *
 * @package TailPress
 */

if (!class_exists('TailPress_Nav_Walker')) {
    class TailPress_Nav_Walker extends Walker_Nav_Menu
    {
        /**
         * Track parent IDs so start_lvl can assign deterministic submenu IDs.
         *
         * @var array<int,int>
         */
        private array $submenu_parent_ids = [];

        public function start_el(
            &$output,
            $item,
            $depth = 0,
            $args = null,
            $id = 0
        ): void {
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes, true);
            $this->submenu_parent_ids[$depth] = (int) $item->ID;

            parent::start_el($output, $item, $depth, $args, $id);

            if (!$has_children) {
                return;
            }

            $item_title = trim(wp_strip_all_tags((string) $item->title));
            $submenu_id = 'submenu-' . (int) $item->ID;
            $aria_label = sprintf(
                /* translators: %s: parent menu item title. */
                __('Toggle submenu for %s', 'tailpress'),
                $item_title ?: __('menu item', 'tailpress')
            );

            $output .= '<button type="button" class="submenu-toggle" aria-expanded="false" aria-controls="' . esc_attr($submenu_id) . '" aria-label="' . esc_attr($aria_label) . '">';
            $output .= '<span class="submenu-toggle-icon" aria-hidden="true"></span>';
            $output .= '</button>';
        }

        public function start_lvl(&$output, $depth = 0, $args = null): void
        {
            $submenu_id = 'submenu-' . ($this->submenu_parent_ids[$depth] ?? ('depth-' . $depth));
            $output .= "\n<ul id=\"" . esc_attr($submenu_id) . "\" class=\"sub-menu\" hidden>\n";
        }
    }
}
