<?php

namespace App\Console\Commands\Day9;

use Illuminate\Console\Command;

class Day9Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day9:part1';

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
        $path = storage_path('app/inputs/day9.txt');
        $inputs = file($path);

        $heightMap = [];

        $riskLevel = 0;

        for ($i = 0; $i < count($inputs); $i++) {
            $heightMap[] = $this->readBoard($inputs[$i]);
        }

        // dd($this->findAdjacents(6, 4, $heightMap));

        for ($y = 0; $y < count($heightMap); $y++){
            for ($x = 0; $x < count($heightMap[$y]); $x++)  {
                $adjacents = $this->findAdjacents($x, $y, $heightMap);

                // dump($this->lowestPoints($heightMap[$x][$y], $adjacents));
                if ($this->lowestPoints($heightMap[$y][$x], $adjacents)) {
                    // dump($heightMap[$x][$y]);
                    dump('x = ' . $x, 'y = ' . $y);
                    dump('$heightMap[$y][$x] = ' . $heightMap[$y][$x]);
                    dump($adjacents);
                    $riskLevel += $heightMap[$y][$x] + 1;
                }
            }
        }

        dd($riskLevel);

        return Command::SUCCESS;
    }

    private function readBoard($input) : array
    {
        for ($i = 0; $i < strlen($input); $i++) {
            if (is_numeric($input[$i])) {
                $row[] = (int) $input[$i];
            }
        }

        return $row;
    }

    private function findAdjacents($x, $y, $map)
    {
        $adjacents = [];

        if ($y > 0) {
            $adjacents[] = $map[$y - 1][$x];
        }

        if ($x < count($map[$y]) - 1) {
            $adjacents[] = $map[$y][$x + 1];
        }

        if ($y < count($map) - 1) {
            $adjacents[] = $map[$y + 1][$x];
        }

        if ($x > 0) {
            $adjacents[] = $map[$y][$x - 1];
        }

        return $adjacents;
    }

    private function lowestPoints($point, $adjacents)
    {
        foreach ($adjacents as $adjacent) {
            if ($adjacent <= $point) {
                return false;
            }
        }

        return true;
    }
}
