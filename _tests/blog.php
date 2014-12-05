<?php

use Throwdown\Plugins\Blog as Blog;

class BlogTest extends PHPUnit_Framework_TestCase {

    public function testGetSet() {
        $a = 'pants';

        Blog::set('name', $a);

        $x = Blog::get('name');

        // Assert
        $this->assertEquals($a, $x);
    }
}
