<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $mysqli = new \mysqli(env('DB_HOST'), env('DB_USERNAME'),  env('DB_PASSWORD')
            , env('DB_DATABASE'));
        $mysqli->query('SET foreign_key_checks = 0');
        if ($result = $mysqli->query("SHOW TABLES"))
        {
            while($row = $result->fetch_array(MYSQLI_NUM))
            {
                $mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
            }
        }

        $mysqli->query('SET foreign_key_checks = 1');
        $mysqli->close();

        $file = $this->argument('file');

        $command = "".env('MYSQL_PATH')." -u " . env('DB_USERNAME') .
             " -h " . env('DB_HOST') .
            " " . env('DB_DATABASE') . "  < " . $file;

//dd($command);
        $returnVar = NULL;
        $output = NULL;


       exec($command, $output, $returnVar);
    }
}
