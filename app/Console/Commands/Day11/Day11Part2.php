<?php

namespace App\Console\Commands\Day11;

use Illuminate\Console\Command;

class Day11Part2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day11:part2';

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

        for ($i = 0; $i < 1000; $i++) {
            [$grid, $flashed] = $this->performCycle($grid);
            if ($flashed === 100) {
                dd($i + 1);
                break;
            }
        }

        $this->displayGrid($grid);

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

        do {
            $octopussiesFlashed = 0;

            for ($y = 0; $y < count($grid); $y++) {
                for ($x = 0; $x < count($grid[$y]); $x++) {
                    if ($grid[$y][$x] > 9) {

                        if (! in_array($y . ',' . $x, $alreadyFlashed)) {
                            $octopussiesFlashed += 1;
                            $alreadyFlashed[] = $y . ',' . $x;

                            $adjacents = $this->findAdjacents($y, $x, $grid);

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
        }

        return $adjacentPositions;
    }
}
