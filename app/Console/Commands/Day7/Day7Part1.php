<?php

namespace App\Console\Commands\Day7;

use Illuminate\Console\Command;

class Day7Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day7:part1';

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
    //     $path = storage_path('app/inputs/day7.txt');
    //     $inputs = file($path);
    //     $inputs = trim($inputs[0]);

    //     $inputs = explode(",", $inputs);

    //     $position = [];

    //     for ($i=0; $i < count($inputs) ; $i++) {
    //         $position[] =(int) $inputs[$i];
    //     }

    //     //total fuel to jump to position i
    //     $arrayFuel = [];

    //     for ($i=0; $i < count($position); $i++) {
    //         $totalFuel = [];
    //         for ($j=0; $j < count($position); $j++) {
    //             $totalFuel[] = abs($position[$i] - $position[$j]);
    //         }

    //         $arrayFuel[] = array_sum($totalFuel);
    //     }

    //     dd(min($arrayFuel));


        $path = storage_path('app/inputs/day7.txt');
        $inputs = file($path);
        $inputs = trim($inputs[0]);

        $inputs = explode(",", $inputs);

        $crabs = [];

        for ($i=0; $i < count($inputs) ; $i++) {
            $crabs[] = (int) $inputs[$i];
        }

        // dump($crabs);

        //total fuel to jump to position i
        $arrayFuel = [];

        for ($position = min($crabs); $position <= max($crabs); $position++) {
            $fuelAllCrabsMoveToOnePosition = 0;
            foreach ($crabs as $crab) {
                $distance = abs($position - $crab);
                $fuel = ($distance * ($distance + 1)) / 2;
                // $fuel = array_sum(range(1, $distance));
                // for ($x=1; $x <= $distance ; $x++) {
                //     $fuel += $x;
                // }

                // dump([
                //     'crab' => $crab,
                //     'position' => $position,
                //     'distance' => $distance,
                //     'fuel' => $fuel,
                // ]);
                $fuelAllCrabsMoveToOnePosition += $fuel;
            }
            $arrayFuel[] = $fuelAllCrabsMoveToOnePosition;
        }
        dump(min($arrayFuel));

        return Command::SUCCESS;
    }
}
