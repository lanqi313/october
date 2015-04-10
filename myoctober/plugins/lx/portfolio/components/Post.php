<?php namespace Lx\Portfolio\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Lx\Portfolio\Models\Post as PortfolioPost;

class Post extends ComponentBase
{

    public $post;   
    public $categoryPage;
    public function componentDetails()
    {
        return [
            'name'        => 'lx.portfolio::lang.settings.post_title',
            'description' => 'lx.portfolio::lang.settings.post_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'lx.portfolio::lang.settings.post_slug',
                'description' => 'lx.portfolio::lang.settings.post_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'lx.portfolio::lang.settings.post_category',
                'description' => 'lx.portfolio::lang.settings.post_category_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/category',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->post = $this->page['post'] = $this->loadPost();
    }

    protected function loadPost()
    {
        $slug = $this->property('slug');
        $post = PortfolioPost::isPublished()->where('slug', $slug)->first();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        if ($post && $post->categories->count()) {
            $post->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        return $post;
    }

}