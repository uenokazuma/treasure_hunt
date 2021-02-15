<?php
    Class TreasureHunt {
		const UP = 'up';
		const DOWN = 'down';
		const LEFT = 'left';
		const RIGHT = 'right';
		
		private $width;
		private $height;
		private $positionX;
		private $positionY;
		private $moveX;
		private $moveY;
		private $cell;
			
		public function __construct() {
			$this->width = 8;
			$this->height = 6;
		}
		
		public function run() {
		    system('stty cbreak');
		    
		    $stdin = fopen('php://stdin', 'r');
		    // stream_set_blocking($stdin, 0);
			
		    // while(1) {
		        // $key = ord(fgetc($stdin));
		        
		        // switch($key) {
		            // case ord('A'): case ord('a'): $this->setDirection('up'); break;
		            // case ord('B'): case ord('b'): $this->setDirection('right'); break;
		            // case ord('C'): case ord('c'): $this->setDirection('down'); break;
		        // }
		    // }
			// echo 'a';
		    
		    $this->showGame();
		}
		
		public function setDirection($direction) {
		    switch($direction) {
		        case self::UP :
		            $this->moveX = 0;
		            $this->moveY = 1;
		        case self::DOWN :
		            $this->moveX = 0;
		            $this->moveY = -1;
		        case self::RIGHT :
		            $this->moveX = 1;
		            $this->moveY = 0;
		    }
		}
		
		public function grid() {
		    for($i=1; $i <= $this->height; $i++) {
		        for($j=1; $j <= $this->width; $j++) {
					if($this->obstacle($i, $j)) {
						$this->cell[$i][$j] = '#';
					} else {
						$this->cell[$i][$j] = '.';
					}
		        }
		    }
		}
		
		public function obstacle($i, $j) {
			
			$result = false;
			if($i == 1 || $j == 1 || $i == $this->height || $j == $this->width || ($i == 3 && in_array($j, array(3, 4, 5)))
			|| ($i == 4 && in_array($j, array(5, 7))) || ($i == 5 && $j == 3)) {
				$result = true;
			}
			
			return $result;
		}
		
		public function player() {
			$this->cell[5][2] = 'X';
		}
		
		public function treasure() {
			$x = rand(1, $this->width);
			$y = rand(1, $this->height);
			
			if($this->cell[$y][$x] == '#') {
				$this->treasure();
			} else {
				$this->cell[$y][$x] = '$';
			}
		}
		
		public function showGame() {
			$this->grid();
			$this->player();
			$this->treasure();
			
		    for($y=1; $y <= $this->height; $y++) {
		        $line = implode('', $this->cell[$y]);
		        echo $line.PHP_EOL;
		    }
			
		}
	}
?>