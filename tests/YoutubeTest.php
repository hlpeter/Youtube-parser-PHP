<?php
use PHPUnit\Framework\TestCase;

class YoutubeTest extends TestCase
{
    public function testValidUrl()
    {
        $yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w');
        $this->assertTrue($yt->valid());
    }

    public function testInvalidUrl()
    {
        $yt = new Youtube('https://www.example.com/watch?v=123');
        $this->assertFalse($yt->valid());
    }

    public function testGetId()
    {
        $yt = new Youtube('https://youtu.be/ef-4Bv5Ng0w');
        $this->assertSame('ef-4Bv5Ng0w', $yt->get_id());
    }

    public function testGetTime()
    {
        $yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w&t=22');
        $this->assertSame('22', $yt->get_time());
    }

    public function testGetList()
    {
        $yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ');
        $this->assertSame('RDQMKKCg_1xxtsQ', $yt->get_list());
    }
}
