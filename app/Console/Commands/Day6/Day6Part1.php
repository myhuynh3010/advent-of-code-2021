<?php

namespace App\Console\Commands\Day6;

use Illuminate\Console\Command;

class Day6Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day6:part1';

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
        // $path = storage_path('app/inputs/day6.txt');
        // $inputs = file($path);
        // $inputs = trim($inputs[0]);

        // $arrayInputs = explode("," , $inputs);

        // $inputNumbers = [];

        // foreach ($arrayInputs as $input) {
        //     $inputNumbers[] = (int) $input;
        // }

        // dump($inputNumbers);

        // $days = 80;


        // while ( $days > 0) {
        //     foreach ($inputNumbers as $key => $input) {
        //         if ($input <= 8 && $input > 0) {
        //             //reduce 1 by 1 time;
        //             $inputNumbers[$key] = $input - 1;

        //         } elseif ($input === 0) {
        //             //append 8 to the list
        //             $inputNumbers[] = 8;
        //             $inputNumbers[$key] = 6;
        //         }
        //     }
        //     $days -= 1;
        // }

        // dd(count($inputNumbers));


        $path = storage_path('app/inputs/day6.txt');
        $inputs = file($path);
        $inputs = trim($inputs[0]);

        $internalTimePosition = [];

        for ($i = 0; $i < 9; $i++) {
            $internalTimePosition[] = substr_count($inputs, (string) $i);
        }

        // dump($internalTimePosition);

        $days = 256;

        while ($days > 0) {
            $newInternalTimePosition = [0, 0, 0, 0, 0, 0, 0, 0, 0];

            for ($i=0; $i < 9; $i++) {
                if ($i === 0) {
                    $newInternalTimePosition[8] = $internalTimePosition[0];
                    $newInternalTimePosition[6] = $internalTimePosition[0];
                } else {
                    $newInternalTimePosition[$i - 1] = $newInternalTimePosition[$i - 1] + $internalTimePosition[$i];
                }
            }

            // dump($newInternalTimePosition);

            $internalTimePosition = $newInternalTimePosition;

            $days -= 1;
        }

        $result = 0;
        foreach ($internalTimePosition as $value) {
            $result += $value;
        }

        dd($result);

        return Command::SUCCESS;
    }
}
