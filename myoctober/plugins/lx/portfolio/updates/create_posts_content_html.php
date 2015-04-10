<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePostsContentHtml extends Migration
{

    public function up()
    {
        Schema::table('lx_portfolio_posts', function($table)
        {
            $table->text('content_html')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lx_portfolio_posts', function($table)
        {
            $table->dropColumn('content_html');
        });
    }
}
