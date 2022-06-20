<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEmailVerificationColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateEmailVerificationColumn:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify email ID';

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
     * @return int
     */
    public function handle()
    {
        \DB::table('users')->where('id', '=',5)->update(['office_id' => 2]);
    }
}
