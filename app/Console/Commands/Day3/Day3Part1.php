<?php

namespace App\Console\Commands\Day3;

use Illuminate\Console\Command;

class Day3Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day3:part1';

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
        $path = storage_path('app/inputs/day3.txt');
        $inputs = file($path);

        $gamma = '';
        $epsilon = '';

        for ($j=0; $j < 12; $j++) {
        $zero = 0;
        $one = 0;

            for ($i=0; $i < count($inputs); $i++) {
                if ($inputs[$i][$j] === '0') {
                    $zero += 1;
                } elseif ($inputs[$i][$j] === '1') {
                    $one += 1;
                }
            }

            if ($zero > $one) {
                $gamma .= '0';
                $epsilon .= '1';
            }

            if ($zero < $one) {
                $gamma .= '1';
                $epsilon .= '0';
            }
        }


        dd(bindec($gamma) * bindec($epsilon));

        return Command::SUCCESS;
    }
}
