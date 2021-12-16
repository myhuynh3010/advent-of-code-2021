<?php

namespace App\Console\Commands\Day5;

use Illuminate\Console\Command;

class Day5Part2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day5:part2';

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
        $path = storage_path('app/inputs/day5.txt');
        $inputs = file($path);

        $inputCoordinates = [];

        foreach ($inputs as $input) {
            // $lineCoordinates = [];

            [$start, $end] = explode(' -> ', trim($input));

            [$x1, $y1] = explode(',', $start);
            [$x2, $y2] = explode(',', $end);

            $lineCoordinates = [
                (int) $x1,
                (int) $y1,
                (int) $x2,
                (int) $y2,
            ];

            if ($this->isHorizontal($lineCoordinates) || $this->isVertical($lineCoordinates) || $this->isDiagonal($lineCoordinates)) {
                $inputCoordinates[] = $lineCoordinates;
            }
        }

        // dd($inputCoordinates);

        $lines = [];

        foreach ($inputCoordinates as $coordinate) {
            $lines[] = $this->coverPoints($coordinate);
        }

        $allPoints = [];

        foreach ($lines as $line) {
            foreach ($line as $point) {
                $allPoints[] = $point;
            }
        }

        // dd($allPoints);

        $pointsAndHits = [];
        $arrayToStringPoints = [];
        foreach ($allPoints as $point) {
            $arrayToStringPoints[] = $point[0] . ',' . $point[1];
        }

        // dd($arrayToStringPoints);

        $pointsAndHits = (array_count_values($arrayToStringPoints));

        // dd($pointsAndHits);

        $solution = 0;

        foreach ($pointsAndHits as $point => $hit) {
            if ($hit >=2 ) {
                $solution += 1;
            }
        }

        dd($solution);

        return Command::SUCCESS;
    }

    private function isHorizontal($input) : bool
    {
        return $input[0] === $input[2];
    }

    private function isVertical($input) : bool
    {
        return $input[1] === $input[3];
    }

    private function isDiagonal($input) : bool
    {
        return ! $this->isHorizontal($input) && ! $this->isVertical($input);
    }

    private function coverPoints($input) : array
    {
        $coverPoints = [];

        if ($this->isHorizontal($input)) {
            $min = min($input[1], $input[3]);
            $max = max($input[1], $input[3]);

            for ($i = $min; $i <= $max ; $i++) {
                $coverPoints[] = [$input[0], $i];
            }
        } elseif ($this->isVertical($input)) {
            $min = min($input[0], $input[2]);
            $max = max($input[0], $input[2]);

            for ($i = $min; $i <= $max ; $i++) {
                $coverPoints[] = [$i, $input[1]];
            }
        } else {
            // diagonal
            $yRange = range($input[1], $input[3]);
            $xRange = range($input[0], $input[2]);
            // dump([
            //     $yRange,
            //     $xRange,
            // ]);
            for ($i=0; $i < count($yRange); $i++) {
                $coverPoints[] = [$xRange[$i], $yRange[$i]];
            }
        }

        // dd($coverPoints);

        // if ($input[0] === $input[1] && $input[2] === $input[3]) {
        //     $min = min($input[0], $input[2]);
        //     $max = max($input[0], $input[2]);

        //     for ($i = $min; $i <= $max; $i++) {
        //         $coverPoints[] = [$i, $i];
        //     }
        // }

        // if ($input[0] === $input[3] && $input[2] === $input[1]) {
        //     $min = min($input[0], $input[2]);
        //     $max = max($input[0], $input[2]);

        //     for ($i = 0; $i <= $max - $min; $i++) {
        //         $coverPoints[] = [$min + $i, $max - $i];
        //     }
        // }

        return $coverPoints;
    }
}
