<?php


class Instructions {
    private $steps_count;
    private $dependencies = [];
    private $parts = [];
    private $step_value = [];
    private $workers = [];

    private $possible = [];
    private $order = '';
    public function __construct(string $input){
        preg_match_all("/.* ([A-Z]) .* ([A-Z]) /", $input, $matches);
        $depends_matches = $matches[1];
        $step_matches = $matches[2];

        foreach($step_matches as $index => $step) {
            $depends = $depends_matches[$index];

            $this->dependencies[$step][] = $depends;
            $steps[$step] = [];
            $steps[$depends] = []; // make sure the steps without dependencies gets remembered
        }

        $this->steps_count = count($steps);
        // create empty dependencies for steps without them
        $missing = array_diff_key($steps, $this->dependencies);
        $this->dependencies = array_merge($this->dependencies, $missing);
        ksort($this->dependencies);

        $this->step_value = array_combine(array_keys($this->dependencies), range(61, 86)); // could do ord() - 4 but thats.. eh
        // 5 workers
        $worker[] = [];
        $worker[] = [];
        $worker[] = [];
        $worker[] = [];
        $worker[] = [];
    }

    protected function availableWorkers()
    {
        return array_filter($this->workers, function($e){return !empty($e);});
    }


    public function doSteps_part1()
    {
        while($this->steps_count != strlen($this->order)){
            $this->doStep();
        }
    }

    public function getOrder()
    {
        return $this->order;
    }

    private function doStep_part1()
    {
        // find all that has no dependencies
        $choice = array_keys(array_filter($this->dependencies, function($e){return empty($e);}));
        sort($choice);
        $current = $choice[0];
        $this->order .= $current;
        unset($this->dependencies[$current]);

        foreach($this->dependencies as $step => $dependency) {
            $this->dependencies[$step] = array_filter($dependency, function($e) use ($current){ return $e != $current;});
        }
    }
}

$instructions = new Instructions(file_get_contents('input-day7.txt'));
$instructions->doSteps_part1();
print $instructions->getOrder();