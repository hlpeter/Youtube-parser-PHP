<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__.'/../youtube-parser/youtube.php';

class YoutubeTest extends TestCase {
    public function testValidWatchUrl() {
        $yt = new Youtube('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        $this->assertTrue($yt->valid());
        $this->assertEquals('dQw4w9WgXcQ', $yt->get_id());
    }

    public function testValidEmbedUrl() {
        $yt = new Youtube('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ');
        $this->assertTrue($yt->valid());
        $this->assertEquals('dQw4w9WgXcQ', $yt->get_id());
    }

    public function testValidShortUrl() {
        $yt = new Youtube('https://youtu.be/dQw4w9WgXcQ?si=abc');
        $this->assertTrue($yt->valid());
        $this->assertEquals('dQw4w9WgXcQ', $yt->get_id());
    }

    public function testShortsUrl() {
        $yt = new Youtube('https://www.youtube.com/shorts/dQw4w9WgXcQ');
        $this->assertTrue($yt->valid());
        $this->assertEquals('dQw4w9WgXcQ', $yt->get_id());
    }

    public function testTimeParameter() {
        $yt = new Youtube('https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=22s');
        $this->assertEquals('22', $yt->get_time());
    }

    public function testTimeFragment() {
        $yt = new Youtube('https://www.youtube.com/watch?v=dQw4w9WgXcQ#t=22');
        $this->assertEquals('22', $yt->get_time());
    }

    public function testList() {
        $yt = new Youtube('https://youtu.be/dQw4w9WgXcQ?list=RDQMKKCg_1xxtsQ#t=22');
        $this->assertEquals('RDQMKKCg_1xxtsQ', $yt->get_list());
    }

    public function testInvalid() {
        $yt = new Youtube('https://www.example.com/watch?v=dQw4w9WgXcQ');
        $this->assertFalse($yt->valid());
        $this->assertNull($yt->get_id());
    }
}
