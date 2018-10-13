<?php

namespace App\Helpers;

class Velocity {
	protected $_scores;

	public function __construct($scores, $numSprints = 6) {
		$this->_scores = array_slice($scores, max(count($scores) - $numSprints, 0));
	}

	public function getAverage() {
		return array_sum($this->_scores) / count($this->_scores);
	}

	public function getVariance() {
		return $this->stddev($this->_scores);
	}

	public function getMax() {
		return max($this->_scores);
	}

	public function getMin() {
		return min($this->_scores);
	}

	public function toJson() {
		return
'{
    "average": '.$this->getAverage().',
    "variance": '.$this->getVariance().',
    "min": '.$this->getMin().',
    "max": '.$this->getMax().'
}';
	}

	protected function stddev($arr) {
		// https://www.geeksforgeeks.org/php-program-find-standard-deviation-array
        $num_of_elements = count($arr); 
        $variance = 0.0; 
        $average = array_sum($arr)/$num_of_elements;           

        foreach($arr as $i) 
        { 
            // sum of squares of differences between  
            // all numbers and means. 
            $variance += pow(($i - $average), 2); 
        } 
          
        return (float)sqrt($variance/$num_of_elements); 
	}
}



