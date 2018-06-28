<?php
namespace UHAlerts\Base\Api;

/**
 * Settings API.
 *
 * @package UHAlerts
 */
class Settings
{
    /**
     * @var array
     */
    public $admin_pages = array();

    /**
     * @var array
     */
    public $sub_pages = array();

    /**
     * @var array
     */
    public $settings = array();

    /**
     * @var array
     */
    public $sections = array();

    /**
     * @var array
     */
    public $fields = array();

    /**
     * Register the menus and custom fields.
     */
    public function register()
    {
        if (!empty($this->admin_pages)) {
            add_action('admin_menu', array($this, 'addAdminMenu'));
        }

        if (!empty($this->settings)) {
            add_action('admin_init', array($this, 'registerCustomFields'));
        }
    }

    /**
     * Set the pages.
     *
     * @param array $pages
     * @return $this
     */
    public function addPages(array $pages)
    {
        $this->admin_pages = $pages;

        return $this;
    }

    /**
     * Include the sub pages with an optional title.
     *
     * @param string $title Title
     * @return $this
     */
    public function withSubPage($title = null)
    {
        if (!empty($this->admin_pages)) {
            $admin_page      = $this->admin_pages[0];
            $sub_pages       = array(
                array(
                    'parent_slug' => $admin_page['menu_slug'],
                    'page_title'  => $admin_page['page_title'],
                    'menu_title'  => $title ? $title : $admin_page['menu_title'],
                    'capability'  => $admin_page['capability'],
                    'menu_slug'   => $admin_page['menu_slug'],
                    'callback'    => $admin_page['callback'],
                ),
            );
            $this->sub_pages = $sub_pages;
        }
        return $this;
    }

    /**
     * Add sub pages to the list of sub pages.
     *
     * @param array $pages Sub pages
     * @return $this
     */
    public function addSubPages(array $pages)
    {
        $this->sub_pages = array_merge($this->sub_pages, $pages);
        return $this;
    }

    /**
     * Register the admin and sub pages with WordPress.
     *
     * @return $this;
     */
    public function addAdminMenu()
    {
        foreach ($this->admin_pages as $page) {
            add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
        }
        foreach ($this->sub_pages as $page) {
            add_submenu_page($page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback']);
        }
        return $this;
    }

    /**
     * Set the custom settings.
     *
     * @param array $settings Settings
     * @return $this
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * Set the custom sections.
     *
     * @param array $sections Sections
     * @return $this
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;
        return $this;
    }

    /**
     * Set the custom fields.
     *
     * @param array $fields Fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Register all the custom settings, sections, and fields to WordPress.
     *
     * @return $this
     */
    public function registerCustomFields()
    {
        foreach ($this->settings as $setting) {
            // register setting
            register_setting($setting['option_group'], $setting['option_name'], isset($setting['callback']) ? $setting['callback'] : '');
        }

        foreach ($this->sections as $section) {
            // add settings section
            add_settings_section($section['id'], $section['title'], isset($section['callback']) ? $section['callback'] : '', $section['page']);
        }

        foreach ($this->fields as $field) {
            // add settings field
            add_settings_field($field['id'], $field['title'], isset($field['callback']) ? $field['callback'] : '', $field['page'], $field['section'], isset($field['args']) ? $field['args'] : '');
        }
        return $this;
    }
}
