<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChloeFirstCommand extends DbSet
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chloe:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chloe Initialize';

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
        $this->comment(PHP_EOL.'<info>Step 1/3: Admin user account</info>');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $firstName = $this->ask('First name');
        $lastName = $this->ask('Last name');
        $this->line('<info>[✔]</info> Success! Your admin user account has been created.');

        $blogTitle = $this->ask('Step 2/3: Blog title');
        $this->title($blogTitle);
        $this->line('<info>[✔]</info> Success! The title of the blog has been saved.');

        $blogSubtitle = $this->ask('Step 3/3: Blog subtitle');
        $this->subtitle($blogSubtitle);
        $this->line('<info>[✔]</info> Success! The subtitle of the blog has been saved.');
    }

}
