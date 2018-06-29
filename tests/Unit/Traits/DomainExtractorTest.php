<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\DomainExtractorTrait;

class DomainExtractorTest extends TestCase {

    use DomainExtractorTrait;

    /**
     * Test extracting domain from URL.
     */
    public function testDomainExtraction()
    {
        $this->assertEquals("youtube.com", $this->extractDomain("https://www.youtube.com/watch?v=WodNMNrZC30"));
        $this->assertEquals("udemy.com", $this->extractDomain("https://www.udemy.com/an-entire-mba-in-1-courseaward-winning-business-school-prof/?ccManual="));
        $this->assertEquals("blackbe.lt", $this->extractDomain("http://www.blackbe.lt"));
        $this->assertEquals("github.com", $this->extractDomain("https://gist.github.com/lancejpollard/1978404"));
        $this->assertEquals("example.com", $this->extractDomain("http://www.example.com"));
        $this->assertEquals("example.com", $this->extractDomain("http://subdomain.example.com"));
        $this->assertEquals("example.uk.com", $this->extractDomain("http://www.example.uk.com"));
    }

}
