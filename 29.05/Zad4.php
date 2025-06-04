<?php
trait Speed {
    private $speed = 0;

    public function increaseSpeed($value) {
        $this->speed += $value;
    }
    public function decreaseSpeed($value) {
        if ($this->speed < $value) {
            $this->speed = 0;
        } else {
            $this->speed -= $value;
        }
    }
}
class Car {
    use Speed;
    public function start() {
        $this->speed = 0;
        $this->increaseSpeed(10);
    }
}
?>