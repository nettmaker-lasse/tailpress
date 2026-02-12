<?php
/**
 * Shared helper functions.
 *
 * @package TailPress
 */

if (!function_exists('tailpress_asset_path_to_uri')) {
    function tailpress_asset_path_to_uri(string $absolute_path): string
    {
        return str_replace(TAILPRESS_PATH, TAILPRESS_URI, $absolute_path);
    }
}

if (!function_exists('tailpress_asset_version')) {
    function tailpress_asset_version(string $absolute_path): string
    {
        return file_exists($absolute_path) ? (string) filemtime($absolute_path) : TAILPRESS_VERSION;
    }
}

if (!function_exists('tailpress_get_dist_asset')) {
    /**
     * Resolve dist asset path and URI.
     *
     * @return array{path:string,uri:string,version:string}|null
     */
    function tailpress_get_dist_asset(string $relative_path): ?array
    {
        $path = TAILPRESS_PATH . '/' . ltrim($relative_path, '/');

        if (!file_exists($path)) {
            return null;
        }

        return [
            'path' => $path,
            'uri' => tailpress_asset_path_to_uri($path),
            'version' => tailpress_asset_version($path),
        ];
    }
}

if (!function_exists('tailpress_template_router')) {
    /**
     * Load the most specific template candidate for the current query context.
     */
    function tailpress_template_router(string $base = 'partials/content', bool $singular_check = false): void
    {
        $templates = [$base];

        if ($singular_check === false) {
            $base = $base . '-' . (is_singular() ? 'single' : 'index');
            $templates[] = $base;
        }

        $templates[] = $base . '-' . get_post_type();

        if (is_singular()) {
            $templates[] = $base . '-' . get_the_ID();
        }

        $templates = array_reverse($templates);

        array_walk($templates, static function (&$item): void {
            $item .= '.php';
        });

        locate_template($templates, true, false);
    }
}
