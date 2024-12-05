<?php
add_action( 'wp_enqueue_scripts', 'hold_on_tide_theme_enqueue_styles' );
function hold_on_tide_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
// Fix Hamburger Menu
function add_ac_scripts(){
   wp_register_script('elementor-hamburger-fix', get_stylesheet_directory_uri() . '/js/elementor-hamburger-fix.js', false, '', true);
   wp_enqueue_script('elementor-hamburger-fix');
}
add_action('wp_enqueue_scripts', 'add_ac_scripts', 10);

#region Entwickler Dashboard
function ac_entwickler_widget() {
	wp_add_dashboard_widget('ac_dev_info', 'Designer & Entwickler Info', 'ac_entwickler_widget_text');
}
add_action('wp_dashboard_setup', 'ac_entwickler_widget' );
function ac_entwickler_widget_text() {
    echo '<ul>
    <li><strong>Entwickel von ALEXEJ Conception</strong></li>
    <li><strong>web:</strong> <a href="https://alexej-conception.de">alexej-conception.de</a>
    <li><strong>telefon:</strong> <a href="tel:tel:+4915792506130">+49 (0) 1579 250 6130</a>
    <li><strong>eMail:</strong> <a href="mailto:mail@alexej-conception.de">mail@alexej-conception.de</a>
    </ul>';
}
#endregion Entwickler Dashboard 

#region Sanitize File Upload Names
function sanitize_upload_name($filename)
{
  $sanitized_filename = remove_accents($filename); // Convert to ASCII

  // Standard replacements
  $invalid = array(
    ' ' => '-',
    '%20' => '-',
    '_' => '-',
  );
  $sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $sanitized_filename);

  // Remove all non-alphanumeric except .
  $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename);
  // Remove all but last .
  $sanitized_filename = preg_replace('/\.(?=.*\.)/', '-', $sanitized_filename);
  // Replace any more than one - in a row
  $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename);
  // Remove last - if at the end
  $sanitized_filename = str_replace('-.', '.', $sanitized_filename);
  // Lowercase
  $sanitized_filename = strtolower($sanitized_filename);
  return $sanitized_filename;
}
add_filter("sanitize_file_name", "sanitize_upload_name", 10, 1);
#endregion Sanitize File Upload Names 

#region Custom Login
/* Loding Custom Login Style */
function ac_custom_login() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/wp-login.css' );
}
add_action( 'login_enqueue_scripts', 'ac_custom_login' );
#endregion Custom Login

###region Einbindung DR Plano
// Wird nur auf den Seiten "Kurse" ID 2611 aufgerufen.
function hot_drplano() {
    if (is_page(2611)) {
        echo '<script id="drp-script" src="https://www.dr-plano.com/de/static/booking-plugin/code.js" data-backend-url="https://backend.dr-plano.com" data-id="321978790" data-frontend-url="https://www.dr-plano.com/de"></script>';
    }
}
add_action('wp_head', 'hot_drplano', 50);
#endregion Einbindung DR Plano 

#region Boulderado API Call
// Call Boulderado API & Server Side Proxy for API Call
function fetch_boulder_counter_data() {
    $url = 'https://backend.boulderado.app/api/gethc?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjdXN0b21lciI6IlRoZVRpZGVIZWR3aWdlbmtvb2cyODIzIn0.uLSXuX6dkmy8b3hJ97k_GQFsmDe5jtfB-JY_QVhM3Fk&sector=Boulderhalle';
//TODO: Script & Server auf SSL Abruf updaten
    $args = array(
        'sslverify' => false,  // SSL-Zertifikatsüberprüfung deaktivieren
    );

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        echo 'Fehler: ' . $response->get_error_message();
        die();
    }

    $body = wp_remote_retrieve_body($response);
    echo $body;
    die();
}
add_action('wp_ajax_get_boulder_counter', 'fetch_boulder_counter_data');
add_action('wp_ajax_nopriv_get_boulder_counter', 'fetch_boulder_counter_data');

// Einbinde von Script
function enqueue_boulder_counter_script() {
    wp_enqueue_script('boulder-counter-script', get_stylesheet_directory_uri() . '/js/boulder-counter.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_boulder_counter_script');

//Add HTML to Footer
function add_boulder_counter_div() {
    echo '<div id="boulder-counter">Lade Besucherzahlen...</div>';
}
add_action('wp_footer', 'add_boulder_counter_div');
#endregion Boulderado API Call 