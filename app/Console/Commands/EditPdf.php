<?php
/**
 * @author Leo<jiangwenhua@yoyohr.com>
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class EditPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edit_pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'edit pdf';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '汉字';
    }

}
