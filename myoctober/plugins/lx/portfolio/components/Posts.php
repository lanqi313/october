<?php namespace Lx\Portfolio\Components;

use Request;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Lx\Portfolio\Models\Post as PortfolioPost;
use Lx\Portfolio\Models\Category as PortfolioCategory;

class Posts extends ComponentBase
{

    public $posts;
    public $pageParam;
    public $category;
    public $noPostsMessage;
    public $postPage;
    public $categoryPage;
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'Posts Component',
            'description' => 'lx.portfolio::lang.settings.posts_description'
        ];
    }


    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'lx.portfolio::lang.settings.posts_pagination',
                'description' => 'lx.portfolio::lang.settings.posts_pagination_description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'categoryFilter' => [
                'title'       => 'lx.portfolio::lang.settings.posts_filter',
                'description' => 'lx.portfolio::lang.settings.posts_filter_description',
                'type'        => 'string',
                'default'     => ''
            ],
            'postsPerPage' => [
                'title'             => 'lx.portfolio::lang.settings.posts_per_page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'lx.portfolio::lang.settings.posts_per_page_validation',
                'default'           => '10',
            ],
            'noPostsMessage' => [
                'title'        => 'lx.portfolio::lang.settings.posts_no_posts',
                'description'  => 'lx.portfolio::lang.settings.posts_no_posts_description',
                'type'         => 'string',
                'default'      => 'No posts found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title'       => 'lx.portfolio::lang.settings.posts_order',
                'description' => 'lx.portfolio::lang.settings.posts_order_description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc'
            ],
            'categoryPage' => [
                'title'       => 'lx.portfolio::lang.settings.posts_category',
                'description' => 'lx.portfolio::lang.settings.posts_category_description',
                'type'        => 'dropdown',
                'default'     => '',
                'group'       => 'Links',
            ],
            'postPage' => [
                'title'       => 'lx.portfolio::lang.settings.posts_post',
                'description' => 'lx.portfolio::lang.settings.posts_post_description',
                'type'        => 'dropdown',
                'default'     => '',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getPostPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getSortOrderOptions()
    {
        return BlogPost::$allowedSortingOptions;
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->category = $this->page['category'] = $this->loadCategory();
        $this->posts = $this->page['posts'] = $this->listPosts();

        /*
         * If the page number is not valid, redirect
         */
       
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->posts->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noPostsMessage = $this->page['noPostsMessage'] = $this->property('noPostsMessage');

        /*
         * Page links
         */
        $this->postPage = $this->page['postPage'] = $this->property('postPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    protected function listPosts()
    {
        $categories = $this->category ? $this->category->id : null;

        /*
         * List all the posts, eager load their categories
         */
        $posts = PortfolioPost::with('categories')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('postsPerPage'),
            'categories' => $categories
        ]);

        /*
         * Add a "url" helper attribute for linking to each post and category
         */
        $posts->each(function($post){
            $post->setUrl($this->postPage, $this->controller);

            $post->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        });

        return $posts;
    }

    protected function loadCategory()
    {
        if (!$categoryId = $this->property('categoryFilter'))
            return null;

        if (!$category = PortfolioCategory::whereSlug($categoryId)->first())
            return null;

        return $category;
    }



}