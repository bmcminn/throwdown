<?php

class AppTest extends PHPUnit_Framework_TestCase {

    public function testFilter() {
        // Arrange
        $a = [1, 2, 3, 4, 5];

        // Act
        $x = $a;

        // Assert
        $this->assertEquals(true, is_array($x));
    }

}
