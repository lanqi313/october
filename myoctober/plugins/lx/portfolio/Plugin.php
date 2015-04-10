<?php namespace Lx\Portfolio;

use Backend;
use Controller;
use System\Classes\PluginBase;
use Lx\Portfolio\Classes\TagProcessor;
use Lx\Portfolio\Models\Category;
use Event;

/**
 * Portfolio Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Portfolio',
            'description' => 'No description provided yet...',
            'author'      => 'Lx',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'Lx\Portfolio\Components\Post'       => 'portfolioPost',
            'Lx\Portfolio\Components\Posts'      => 'portfolioPosts',
            'Lx\Portfolio\Components\Categories' => 'portfolioCategories'
        ];
    }

public function registerPermissions()
    {
        return [
            'lx.portfolio.access_posts'       => ['tab' => 'Portfolio', 'label' => 'Manage the portfolio posts'],
            'lx.portfolio.access_categories'  => ['tab' => 'Portfolio', 'label' => 'Manage the portfolio categories'],
            'lx.portfolio.access_other_posts' => ['tab' => 'Portfolio', 'label' => 'Manage other users portfolio posts']
        ];
    }
    public function registerNavigation()
    {
        return [
            'portfolio' => [
                'label'       => 'Portfolio',
                'url'         => Backend::url('lx/portfolio/posts'),
                'icon'        => 'icon-pencil',
                'permissions' => ['lx.portfolio.*'],
                'order'       => 500,

                'sideMenu' => [
                    'posts' => [
                        'label'       => 'Posts',
                        'icon'        => 'icon-copy',
                        'url'         => Backend::url('lx/portfolio/posts'),
                        'permissions' => ['lx.portfolio.access_posts']
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'icon'        => 'icon-list-ul',
                        'url'         => Backend::url('lx/portfolio/categories'),
                        'permissions' => ['lx.portfolio.access_categories']
                    ],
                ]
            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Lx\Portfolio\FormWidgets\Preview' => [
                'label' => 'Preview',
                'code'  => 'preview'
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        /*
         * Register the image tag processing callback
         */
        TagProcessor::instance()->registerCallback(function($input, $preview){
            if (!$preview) return $input;

            return preg_replace('|\<img src="image" alt="([0-9]+)"([^>]*)\/>|m',
                '<span class="image-placeholder" data-index="$1">
                    <span class="upload-dropzone">
                        <span class="label">Click or drop an image...</span>
                        <span class="indicator"></span>
                    </span>
                </span>',
            $input);
        });
    }

    public function boot()
    {
        /*
         * Register menu items for the RainLab.Pages plugin
         */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'blog-category' => 'Blog category',
                'all-blog-categories' => 'All blog categories'
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'blog-category' || $type == 'all-blog-categories')
                return Category::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'blog-category' || $type == 'all-blog-categories')
                return Category::resolveMenuItem($item, $url, $theme);
        });
    }
}
