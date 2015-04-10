<?php namespace Lx\Portfolio\Models;

use App;
use Str;
use Lang;
use Model;
use Markdown;
use ValidationException;
use Lx\Portfolio\Classes\TagProcessor;
use Backend\Models\User;

/**
 * Post Model
 */
class Post extends Model
{

    /**
     * @var string The database table used by the model.
     */
    use \October\Rain\Database\Traits\Validation;

    public $table = 'lx_portfolio_posts';
    public $rules = [
            'title' => 'required',
            'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'],
            'content' => 'required',
            'excerpt' => ''
        ];
    protected $dates = ['published_at'];
    public static $allowedSortingOptions = array(
        'title asc' => 'Title (ascending)',
        'title desc' => 'Title (descending)',
        'created_at asc' => 'Created (ascending)',
        'created_at desc' => 'Created (descending)',
        'updated_at asc' => 'Updated (ascending)',
        'updated_at desc' => 'Updated (descending)',
        'published_at asc' => 'Published (ascending)',
        'published_at desc' => 'Published (descending)',
    );

    /**
     * @var array Guarded fields
     */

    /**
     * @var array Fillable fields
     */

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
    'user' => ['Backend\Models\User']
    ];
    public $belongsToMany = [
        'categories' => ['Lx\Portfolio\Models\Category', 'table' => 'lx_portfolio_posts_categories', 'order' => 'name']
    ];
    protected $appends = ['summary', 'has_summary'];
    public $preview = null;

    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File']
    ];

    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'sort'       => 'created_at',
            'categories' => null,
            'search'     => '',
            'published'  => true
        ], $options));

        $searchableFields = ['title', 'slug', 'excerpt', 'content'];

        if ($published)
            $query->isPublished();

        /*
         * Sorting
         */
        if (!is_array($sort)) $sort = [$sort];
        foreach ($sort as $_sort) {

            if (in_array($_sort, array_keys(self::$allowedSortingOptions))) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) array_push($parts, 'desc');
                list($sortField, $sortDirection) = $parts;

                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        /*
         * Categories
         */
        if ($categories !== null) {
            if (!is_array($categories)) $categories = [$categories];
            $query->whereHas('categories', function($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        return $query->paginate($perPage, $page);
    }

    /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
        {
            return $query->whereHas('categories', function($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

    public static function formatHtml($input, $preview = false)
        {
            $result = Markdown::parse(trim($input));

            if ($preview)
                $result = str_replace('<pre>', '<pre class="prettyprint">', $result);

            $result = TagProcessor::instance()->processTags($result, $preview);

            return $result;
        }

    public function afterValidate()
        {
            if ($this->published && !$this->published_at) {
                throw new ValidationException([
                   'published_at' => Lang::get('rainlab.blog::lang.post.published_validation')
                ]);
            }
        }

    public function scopeIsPublished($query)
        {
            return $query
                ->whereNotNull('published')
                ->where('published', true)
            ;
        }

    public function beforeSave()
        {
            $this->content_html = self::formatHtml($this->content);
        }

    /**
     * Used by "has_summary", returns true if this post uses a summary (more tag)
     * @return boolean
     */
    public function getHasSummaryAttribute()
        {
            return strlen($this->getSummaryAttribute()) < strlen($this->content_html);
        }

    /**
     * Used by "summary", returns the HTML content before the <!-- more --> tag
     * @return string
     */
    public function getStatusOptions($keyValue = null)
        {
            return [
            'icon fa-area-chart major' => 'chart',
            'icon fa-refresh major' => 'refresh',
            'icon fa-cog major' => 'fa-cog', 
            ];
        }
    public function getSummaryAttribute()
        {
            $more = '<!-- more -->';
            $parts = explode($more, $this->content_html);
            return array_get($parts, 0);
        }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
        {
            $params = [
                'id' => $this->id,
                'slug' => $this->slug,
            ];

            if (array_key_exists('categories', $this->getRelations())) {
                $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
            }

            return $this->url = $controller->pageUrl($pageName, $params);
        }

    /**
     * Used to test if a certain user has permission to edit post,
     * returns TRUE if the user is the owner or has other posts access.
     * @param User $user
     * @return bool
     */
    public function canEdit(User $user)
        {
            return ($this->user_id == $user->id) || $user->hasAnyAccess(['rainlab.blog.access_other_posts']);
        }

}