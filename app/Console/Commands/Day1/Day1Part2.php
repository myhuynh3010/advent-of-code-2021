<?php

namespace App\Console\Commands\Day1;

use Illuminate\Console\Command;

class Day1Part2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day1:part2';

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
     * @return int
     */
    public function handle()
    {
        $path = storage_path('app/inputs/day1.txt');
        $input = file($path);

        $arrayCount = count($input);

        $slidingWindowArray = [];


        for ($i=0; $i < $arrayCount - 2; $i++) {
            $slidingWindowArray[] = (int) $input[$i] + (int) $input[$i + 1] + (int) $input[$i + 2];
        }

        $max = count($slidingWindowArray);

        $output = 0;

        for ($i=0; $i < $max - 1; $i++) {
            if ($slidingWindowArray[$i] < $slidingWindowArray[$i + 1]) {
                $output += 1;
            }
        }

        dd($output);


        return Command::SUCCESS;
    }
}
