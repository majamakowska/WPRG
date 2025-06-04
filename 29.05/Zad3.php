<?php
trait A {
    public function smallTalk() {
        echo 'a';
    }
    public function bigTalk() {
        echo 'A';
    }
}
trait B {
    public function smallTalk() {
        echo 'b';
    }
    public function bigTalk() {
        echo 'B';
    }
}

class Talker {
    use A, B {
        A::smallTalk insteadof B;
        A::bigTalk insteadof B;
        B::smallTalk as smallTalkB;
        B::bigTalk as bigTalkB;
    }
}

$talker = new Talker();
$talker->smallTalk();
$talker->bigTalk();
$talker->smallTalkB();
$talker->bigTalkB();
?>