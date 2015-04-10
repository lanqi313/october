<?php namespace RainLab\Blog\Updates;

use RainLab\Blog\Models\Category;
use October\Rain\Database\Updates\Seeder;

class SeedAllTables extends Seeder
{

    public function run()
    {
        //
        // @todo
        //
        // Add a Welcome post or something
        //

        Category::create([
            'name' => trans('lx.portfolio::lang.categories.uncategorized'),
            'slug' => 'uncategorized',
        ]);
    }

}
