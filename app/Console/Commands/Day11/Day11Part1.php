<?php

namespace App\Console\Commands\Day11;

use Illuminate\Console\Command;

class Day11Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day11:part1';

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
        $path = storage_path('app/inputs/day11.txt');
        $inputs = file($path);

        $grid = $this->parseGrid($inputs);

        $totalFlashed = 0;

        for ($i = 0; $i < 100; $i++) {
            [$grid, $flashed] = $this->performCycle($grid);

            $totalFlashed += $flashed;
        }

        $this->displayGrid($grid);

        dump($totalFlashed);

        return Command::SUCCESS;
    }

    private function performCycle($grid)
    {
        $alreadyFlashed = [];

        // First, the energy level of each octopus increases by 1.
        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
                // y is column, x is row

                $grid[$y][$x] += 1;
            }
        }

        // Then, any octopus with an energy level greater than 9 flashes.
        // This increases the energy level of all adjacent octopuses by 1,
        // including octopuses that are diagonally adjacent.
        // If this causes an octopus to have an energy level greater than 9,
        // it also flashes.
        // This process continues as long as new octopuses keep having their
        // energy level increased beyond 9.
        // (An octopus can only flash at most once per step.)

        // while atleast one octopus flashed, repeat this
        do {
            $octopussiesFlashed = 0;

            for ($y = 0; $y < count($grid); $y++) {
                for ($x = 0; $x < count($grid[$y]); $x++) {
                    if ($grid[$y][$x] > 9) {
                        // energy level is above 9, this octopus FLASHES!
                        // (An octopus can only flash at most once per step.)

                        // check if this octopus have already flashed
                        // $alreadyFlashed = false;

                        if (! in_array($y . ',' . $x, $alreadyFlashed)) {
                            $octopussiesFlashed += 1;
                            $alreadyFlashed[] = $y . ',' . $x;
                            // todo: remember that this y+x flashed

                            $adjacents = $this->findAdjacents($y, $x, $grid);
                            // dump($adjacents);

                            // increase value of all adjacent octopuses
                            foreach ($adjacents as $adjacent) {
                                $adjacentX = $adjacent['x'];
                                $adjacentY = $adjacent['y'];
                                $grid[$adjacentY][$adjacentX] += 1;
                            }
                        }
                    }
                }
            }
        } while ($octopussiesFlashed > 0);

        // Finally, any octopus that flashed during this step has its energy
        // level set to 0, as it used all of its energy to flash.

        // TODO!
        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
               if ($grid[$y][$x] > 9) {
                    $grid[$y][$x] = 0;
               }

            }
        }

        return [$grid, count($alreadyFlashed)];
    }

    private function displayGrid($grid)
    {
        for ($y = 0; $y < count($grid); $y++) {
            $this->line(implode('', $grid[$y]));
        }
    }

    private function parseGrid($inputs) : array
    {
        $grid = [];

        for ($y = 0; $y < count($inputs); $y++) {
            $row = [];

            for ($x = 0; $x < strlen(trim($inputs[0])); $x++) {
                $row[] = (int) $inputs[$y][$x];
            }

            $grid[] = $row;
        }

        return $grid;
    }

    private function findAdjacents($row, $column, $grid) : array
    {
        //y is column, x is row
        // dump('$row = ' . $row, '$column = ' . $column, '$grid[$row][$column] = ' . $grid[$row][$column]);

        $adjacents = [];
        $adjacentPositions = [];

        if ($column > 0) {
            $adjacents[] = $grid[$row][$column - 1];
            $adjacentPositions[] = [
                'y' => $row, // y (index 0)
                'x' => $column - 1, // x (index 1)
            ];
            // dump($adjacents);

            if ($row > 0) {
                $adjacents[] = $grid[$row - 1][$column - 1];
                $adjacentPositions[] = [
                    'y' => $row - 1,
                    'x' => $column - 1,
                ];
                // dump($adjacents);
            }

            if ($row < count($grid[$column]) - 1) {
                $adjacents[] = $grid[$row + 1][$column - 1];
                $adjacentPositions[] = [
                    'y' => $row + 1,
                    'x' => $column - 1,
                ];
                // dump($adjacents);
            }
        }

        if ($column < count($grid) - 1) {
            $adjacents[] = $grid[$row][$column + 1];
            $adjacentPositions[] = [
                'y' => $row,
                'x' => $column + 1,
            ];
            // dump($adjacents);

            if (($row < count($grid[0]) - 1)) {
                $adjacents[] = $grid[$row + 1][$column + 1];
                $adjacentPositions[] = [
                    'y' => $row + 1,
                    'x' => $column + 1,
                ];
                // dump($adjacents);
            }

            if ($row > 0) {
                $adjacents[] = $grid[$row - 1][$column + 1];
                $adjacentPositions[] = [
                    'y' => $row - 1,
                    'x' => $column + 1,
                ];
                // dump($adjacents);
            }
        }

        if ($row > 0) {
            $adjacents[] = $grid[$row - 1][$column];
            $adjacentPositions[] = [
                'y' => $row - 1,
                'x' => $column,
            ];
            // dump($adjacents);
        }

        if ($row < count($grid[$column]) - 1) {
            $adjacents[] = $grid[$row + 1][$column];
            $adjacentPositions[] = [
                'y' => $row + 1,
                'x' => $column,
            ];
            // dump($adjacents);
            // dump($adjacentPositions);
        }

        return $adjacentPositions;
    }
}
