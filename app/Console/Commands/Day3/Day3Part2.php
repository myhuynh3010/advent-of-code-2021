<?php

namespace App\Console\Commands\Day3;

use Illuminate\Console\Command;

class Day3Part2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day3:part2';

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

        $maxRow = count($inputs);
        $maxColumn = strlen($inputs[0]);

        for ($i=0; $i < $maxColumn; $i++) {
            $count0 = 0;
            $count1 = 0;

            $array0 = [];
            $array1 = [];


            for ($j=0; $j < count($inputs); $j++) {

                if ($inputs[$j][$i] === '0') {
                    $count0 += 1;
                    $array0[] = $inputs[$j];

                } else {
                    $count1 += 1;
                    $array1[] = $inputs[$j];
                }
            }

            if ($count0 > $count1) {
                $inputs = $array0;
            } else {
                $inputs = $array1;
            }

        }

        dd(bindec($inputs[0]) * 3375);  //23


        // $path = storage_path('app/inputs/day3.txt');
        // $inputs = file($path);

        // $maxRow = count($inputs);
        // $maxColumn = strlen($inputs[0]);

        // for ($i=0; $i < $maxColumn; $i++) {
        //     $count0 = 0;
        //     $count1 = 0;

        //     $array0 = [];
        //     $array1 = [];


        //     for ($j=0; $j < count($inputs); $j++) {

        //         if ($inputs[$j][$i] === '0') {
        //             $count0 += 1;
        //             $array0[] = $inputs[$j];

        //         } else {
        //             $count1 += 1;
        //             $array1[] = $inputs[$j];
        //         }
        //     }



        //     if ($count0 <= $count1) {
        //         $inputs = $array0;
        //     } else {
        //         $inputs = $array1;
        //     }
        //     dump($inputs);

        // }
        // dd(bindec('110100101111')); //3375

        // dd(bindec($inputs[0]));  //10

        return Command::SUCCESS;
    }
}
