<?php

// Comprueba si hay una nueva versión del plugin disponible en GitHub
function check_for_plugin_update() {
    $gh_user = 'josprox'; // Nombre de usuario de GitHub
    $gh_repo = 'JosSecurity_Plugin'; // Nombre del repositorio de GitHub
    $plugin_slug = basename(dirname(__FILE__));

    // Obtiene información sobre la última versión del plugin en GitHub
    $response = wp_remote_get("https://api.github.com/repos/$gh_user/$gh_repo/releases/latest");
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
        $latest_release = json_decode(wp_remote_retrieve_body($response));
        $latest_version = $latest_release->tag_name;
        $download_url = $latest_release->zipball_url;
        $current_version = get_option('jossecurity_wp_version');
        if (version_compare($latest_version, $current_version, '>')) {
            // Si hay una nueva versión disponible, agrega una notificación de actualización en el panel de administración de WordPress
            $transient_name = 'jossecurity_wp_update_' . md5($plugin_slug);
            set_site_transient($transient_name, array(
                'new_version' => $latest_version,
                'url' => $download_url,
                'package' => $download_url
            ), 1800);
        }
    }
}
add_action('wp_version_check', 'check_for_plugin_update');

// Muestra una notificación de actualización en el panel de administración de WordPress
function show_update_notification($value) {
    $plugin_slug = basename(dirname(__FILE__));
    $transient_name = 'jossecurity_wp_update_' . md5($plugin_slug);
    if (get_site_transient($transient_name)) {
        $value->response[$plugin_slug] = get_site_transient($transient_name);
    }
    return $value;
}
add_filter('site_transient_update_plugins', 'show_update_notification');

// Descarga y instala la última versión del plugin desde GitHub
function plugin_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }
    $plugin_slug = basename(dirname(__FILE__));
    $transient_name = 'jossecurity_wp_update_' . md5($plugin_slug);
    if (get_site_transient($transient_name)) {
        $remote_version = get_site_transient($transient_name)['new_version'];
        $package = get_site_transient($transient_name)['package'];
        if (version_compare($remote_version, $current_version, '>')) {
            $transient->response[$plugin_slug] = array(
                'new_version' => $remote_version,
                'package' => $package,
                'url' => 'https://github.com/josprox/JosSecurity_Plugin'
            );
        }
    }
}
    
        
?>