<?php

if (! defined('_S_VERSION')) {
  // Replace the version number of the theme on each release.
  define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hazze_setup()
{
  /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on hazze, use a find and replace
		* to change 'hazze' to the name of your theme in all the template files.
		*/
  load_theme_textdomain('hazze', get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
  add_theme_support('title-tag');

  /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
  add_theme_support('post-thumbnails');

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus(array(
    'header'    => 'header',    //Название месторасположения меню в шаблоне
    'footer' => 'footer'      //Название другого месторасположения меню в шаблоне
  ));

  /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );

  // Set up the WordPress core custom background feature.
  add_theme_support(
    'custom-background',
    apply_filters(
      'hazze_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'hazze_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hazze_widgets_init()
{
  register_sidebar(
    array(
      'name'          => esc_html__('Sidebar', 'hazze'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'hazze'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action('widgets_init', 'hazze_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function hazze_scripts()
{

  wp_enqueue_style('hazze-style', get_stylesheet_uri(), array(), _S_VERSION);

  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Libre+Franklin:400,500,600,700,800,900&display=swap', array(), _S_VERSION);
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), _S_VERSION);
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), _S_VERSION);
  wp_enqueue_style('themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), _S_VERSION);
  wp_enqueue_style('carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), _S_VERSION);
  wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), _S_VERSION);
  wp_enqueue_style('slicknav', get_template_directory_uri() . '/css/slicknav.min.css', array(), _S_VERSION);
  wp_enqueue_style('haxe-style__main', get_template_directory_uri() . '/css/style.css', array(), _S_VERSION);



  wp_deregister_script('jquery');
  wp_register_script('jquery',get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), _S_VERSION, true);
  wp_enqueue_script('jquery');


  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), _S_VERSION, true);
  wp_enqueue_script('magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), _S_VERSION, true);
  wp_enqueue_script('mixitup', get_template_directory_uri() . '/js/mixitup.min.js', array(), _S_VERSION, true);
  wp_enqueue_script('slicknav', get_template_directory_uri() . '/js/jquery.slicknav.js', array('jquery'), _S_VERSION, true);
  wp_enqueue_script('carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), _S_VERSION, true);
  wp_enqueue_script('hazze-main', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'hazze_scripts');

if (function_exists('acf_add_options_page')) {

  acf_add_options_page(array(
    'page_title'   => 'Основные настройки',
    'menu_title'  => 'Настройки темы',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => true
  ));

  acf_add_options_sub_page(array(
    'page_title'   => 'Настройки шапки',
    'menu_title'  => 'header',
    'parent_slug'  => 'theme-general-settings',
  ));

  acf_add_options_sub_page(array(
    'page_title'   => 'Настройки подвала',
    'menu_title'  => 'footer',
    'parent_slug'  => 'theme-general-settings',
  ));
}

function add_custom_class_to_submenu_links($atts, $item, $args, $depth)
{
  // Проверяем, находится ли элемент на вложенном уровне (depth > 0)
  if ($depth > 0) {
    // Добавляем дополнительный класс
    if (isset($atts['class'])) {
      $atts['class'] .= ' custom-submenu-link'; // Добавить класс, если уже есть другие классы
    } else {
      $atts['class'] = 'custom-submenu-link'; // Установить класс, если его не было
    }
  }
  return $atts;
}

add_filter('nav_menu_link_attributes', 'add_custom_class_to_submenu_links', 10, 4);

function add_custom_class_to_submenu_items($classes, $item, $args, $depth)
{
  // Проверяем, находится ли элемент на вложенном уровне (depth > 0)
  if ($depth > 0) {
    $classes[] = 'custom-submenu-item'; // Добавляем класс
  }
  return $classes;
}

add_filter('nav_menu_css_class', 'add_custom_class_to_submenu_items', 10, 4);