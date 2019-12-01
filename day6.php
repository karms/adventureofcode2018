<?php

class Universe
{
    private $points = [];
    private $coords = []; // keeps track of all filled coordinates
    private $width; // width of bounding box that contains the points
    private $height; // height of the bounding box that countains the points
    public function __construct(string $input)
    {
        $this->points = array_map(function ($line) {
            list($x, $y) = explode(', ', $line);
            return (object) ['x' => (int) $x, 'y' => (int) $y];
        }, explode(PHP_EOL, $input));

        // find bounding box
        $top = $left = 9999;
        $right = $bottom = 0;

        foreach ($this->points as $point) {
            if($point->x < $left) $left = $point->x;
            if($point->x > $right) $right = $point->x;
            if($point->y < $top) $top = $point->y;
            if($point->y > $bottom) $bottom = $point->y;
        }

        $this->width = $right - $left;
        $this->height = $bottom - $top;

        // normalize points
        foreach (array_keys($this->points) as $point) {
            $this->points[$point]->x -= $left;
            $this->points[$point]->y -= $top;
        }
    }
    
    public function calculateDistances() {
        for($x = 0; $x <= $this->width; $x++) {
            for($y = 0; $y <= $this->height; $y++) {
                $distances = 0;
                foreach($this->points as $point) {
                    if($point->x > $x) $distances += $point->x - $x;
                    else               $distances += $x - $point->x;
                    if($point->y > $y) $distances += $point->y - $y;
                    else               $distances += $y - $point->y;
                }

                $this->coords[$x][$y] = $distances;
            }
        }
    }

    public function count($distance_lower_than = 10000) {
        $total = 0;
        foreach($this->coords as $xs) {
            foreach($xs as $distance) {
                if($distance < $distance_lower_than) $total++;
            }
        }

        return $total;
    }
}

$universe = new Universe(file_get_contents('input-day6.txt'));
$universe->calculateDistances();
print $universe->count();