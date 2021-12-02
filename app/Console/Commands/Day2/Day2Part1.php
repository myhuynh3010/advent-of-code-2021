<?php

namespace App\Console\Commands\Day2;

use Illuminate\Console\Command;

class Day2Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day2:part1';

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
        $path = storage_path('app/inputs/day2.txt');
        $inputs = file($path);

        $horizontal = 0;
        $depth = 0;

        foreach ($inputs as $input) {
            $slipDirection = explode(" ", $input);
            if ($slipDirection[0] === 'forward') {
                $horizontal +=  (int) $slipDirection[1];
            }
            if ($slipDirection[0] === 'down') {
                $depth +=  (int) $slipDirection[1];
            }
            if ($slipDirection[0] === 'up') {
                $depth -=  (int) $slipDirection[1];
            }
        }

        dd($horizontal * $depth);


        // dd($input);

        return Command::SUCCESS;
    }
}
