<?php

namespace App\Console\Commands\Day4;

use Illuminate\Console\Command;

class Day4Part1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day4:part1';

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
        $path = storage_path('app/inputs/day4.txt');
        $inputs = file($path);

        $numbers = explode(",", trim(array_shift($inputs))); //first line of the file contains drawned numbers

        foreach ($numbers as $key => $number) {
            $numbers[$key] = (int) $number;
        }

        $boards = [];

        $boardChunks = array_chunk($inputs, 6);

        foreach ($boardChunks as $boardChunk) {
            array_shift($boardChunk);
            $boards[] = $this->readBoard($boardChunk); //read the big board (including all the boards)
        }

        // simulate numbers being drawn, one at a time
        $drawns = [];
        $winners = [];
        for ($i=0; $i < count($numbers); $i++) { //check one number at the time
            $drawns[] = $numbers[$i];
            foreach ($boards as $n => $board) {
                if ($this->isWinner($drawns, $board)) {
                    $winners[] = $board;
                    break 2; // break 2 break 2 loops
                }
            }
        }

        $winner = $winners[0];
        $score = $this->calculateScore($winner, $drawns);

        dump($winner, $score);

        return Command::SUCCESS;
    }

    private function readBoard($input) : array // read invidial board, return a board has 5 rows, each row contains 5 integers
    {
        $output = [];

        foreach ($input as $row) {
            $line = [];
            $rowElements = explode(" ", trim($row));

            foreach ($rowElements as $element) {
                if ($element !== '') {
                    $line[] = (int) trim($element);
                }
            }
            $output[] = $line;
        }

        return $output;
    }

    private function bingoCandidates($board): array //return 10 candidates, each candidate is a row contains 5 integers
    {
        $candidatesArray = $board;

        for ($i=0; $i < count($board) ; $i++) {
            $column = [];
            for ($j=0; $j < count($board[0]) ; $j++) {

                $column[] = $board[$j][$i];
            }
            $candidatesArray[] = $column;
        }
        return $candidatesArray;
    }

    private function isWinner($drawns, $board) : bool //return true if the board contains the correct candidate.
    {
        $candidates = $this->bingoCandidates($board); // from the input board, find all the candidate rows.

        foreach ($candidates as $candidate) {
            if ($this->candidateIsWinner($drawns, $candidate)) {
                return true;
            }
        }

        return false;
    }

    private function candidateIsWinner($drawns, $candidate) : bool //if all the numbers in the candidate is in dawns then retun true
    {
        foreach ($candidate as $candidateNumber) {
            if (! in_array($candidateNumber, $drawns)) {
                return false;
            }
        }

        return true;
    }

    private function calculateScore($board, $drawns) : int //
    {
        $uncalledNumbers = [];

        $extractBoard = [];

        //from $board, get all the integer, put into the array
        foreach ($board as $row) {
            foreach ($row as $column) {
                $extractBoard[] = $column;
            }
        }

        //create the array that includes all uncallNumbers
        foreach ($extractBoard as $number) {
            if (! in_array($number, $drawns)) {
                $uncalledNumbers[] = $number;
            }
        }

        $lastCalled = array_pop($drawns);

        $sum = array_sum($uncalledNumbers);

        return ($lastCalled * $sum);
    }
}
