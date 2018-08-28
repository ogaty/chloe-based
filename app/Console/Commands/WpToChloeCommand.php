<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WpToChloeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chloe:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'wordpress to chloe';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = DB::connection('wordpress')->select('select * from wp_posts where post_status = \'publish\' and post_type = \'post\' limit 3');
        $convert = [];
        $i = 0;
        foreach ($posts as $post) {
            $convert[$i]['title'] = $post->post_title;
            $convert[$i]['slug'] = strtotime($post->post_date);
            $convert[$i]['subtitle'] = '';
            $convert[$i]['content_html'] = $post->post_content;
            $convert[$i]['content_raw'] = $post->post_content;
            $convert[$i]['description_html'] = '';
            $convert[$i]['description_raw'] = '';
            $convert[$i]['meta_description'] = '';
            $convert[$i]['page_image'] = '';
            $convert[$i]['is_published'] = 1;
            $convert[$i]['layout'] = 'default';
            $convert[$i]['created_at'] = $post->post_date;
            $convert[$i]['updated_at'] = $post->post_modified;
            $convert[$i]['published_at'] = $post->post_modified;
            $i++;
        }

        foreach ($convert as $value) {
                $posts = DB::connection('mysql')->insert('insert into posts (title, slug, subtitle, content_html, content_raw, description_html, description_raw, meta_description, page_image, is_published, layout, created_at, updated_at, published_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $value['title'],
            $value['slug'],
            $value['subtitle'], 
            $value['content_html'], 
            $value['content_raw'], 
            $value['description_html'], 
            $value['description_raw'], 
            $value['meta_description'], 
            $value['page_image'], 
            $value['is_published'], 
            $value['layout'], 
            $value['created_at'], 
            $value['updated_at'],
            $value['published_at']
            ]);
        }
    }
}
