<?php namespace Lx\Portfolio\Components;

use Db;
use App;
use Request;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Lx\Portfolio\Models\Category as PortfolioCategory;

class Categories extends ComponentBase
{

        /**
     * @var Collection A collection of categories to display
     */
    public $categories;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    /**
     * @var string Reference to the current category slug.
     */
    public $currentCategorySlug;

    public function componentDetails()
    {
        return [
            'name'        => 'lx.portfolio::lang.settings.category_title',
            'description' => 'lx.portfolio::lang.settings.category_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'lx.portfolio::lang.settings.category_slug',
                'description' => 'lx.portfolio::lang.settings.category_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'displayEmpty' => [
                'title'       => 'lx.portfolio::lang.settings.category_display_empty',
                'description' => 'lx.portfolio::lang.settings.category_display_empty_description',
                'type'        => 'checkbox',
                'default'     => 0
            ],
            'categoryPage' => [
                'title'       => 'lx.portfolio::lang.settings.category_page',
                'description' => 'lx.portfolio::lang.settings.category_page_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/category',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->currentCategorySlug = $this->page['currentCategorySlug'] = $this->property('slug');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->categories = $this->page['categories'] = $this->loadCategories();
    }

    protected function loadCategories()
    {
        $categories = BlogCategory::orderBy('name');
        if (!$this->property('displayEmpty')) {
            $categories->whereExists(function($query) {
                $query->select(Db::raw(1))
                ->from('lx_portfolio_posts_categories')
                ->join('lx_portfolio_posts', 'lx_portfolio_posts.id', '=', 'lx_portfolio_posts_categories.post_id')
                ->whereNotNull('lx_portfolio_posts.published')
                ->where('lx_portfolio_posts.published', '=', 1)
                ->whereRaw('lx_portfolio_categories.id = lx_portfolio_posts_categories.category_id');
            });
        }

        $categories = $categories->get();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        $categories->each(function($category){
            $category->setUrl($this->categoryPage, $this->controller);
        });

        return $categories;
    }
}