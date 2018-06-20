<?php

namespace Tests\Unit\Services\APIs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\APIs\WebShrinkerClient;

class WebShrinkerClientTest extends TestCase {

    /**
     * @var WebShrinkerClient 
     */
    protected $webshrinkerClient;

    /**
     * Setting up things.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webshrinkerClient = app()->make(WebShrinkerClient::class);
    }

    /**
     * Test key and secret exist.
     *
     * @return void
     */
    public function testKeyAndSecret()
    {
        $this->assertTrue(!empty($this->webshrinkerClient->webshrinkerCredentials->getKey()));
        $this->assertTrue(!empty($this->webshrinkerClient->webshrinkerCredentials->getSecret()));
    }

    /**
     * Test URL encoding.
     * 
     * @return void
     */
    public function testUrlEncoding()
    {
        $this->assertEquals(
                "aHR0cHM6Ly93d3cueW91dHViZS5jb20vd2F0Y2g_dj05cTJoNm9HRDZVQSZpbmRleD0xMzYmbGlzdD1QTEw3V1BTZVEwLW92ME1qYVFMVEU4cC12NWVNOWlhdGFs",
                $this->webshrinkerClient->encodeUrl("https://www.youtube.com/watch?v=9q2h6oGD6UA&index=136&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal"));
        $this->assertEquals(
                "aHR0cHM6Ly9naXRodWIuY29tL29tYXJmdXJyZXIvYm9va21hcmsuaW8vY29tbWl0cy9kZXZlbG9wbWVudA==",
                $this->webshrinkerClient->encodeUrl("https://github.com/omarfurrer/bookmark.io/commits/development"));
    }

    /**
     * Test URL categorization.
     * 
     * @return void
     */
    public function testUrlCategorization()
    {
        $simpleCategories = $this
                        ->webshrinkerClient
                        ->categorize("https://www.youtube.com/watch?v=PXSVqk4YRAk&index=135&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal")
                ->data[0]
                ->categories;
        $this->assertTrue(!empty($simpleCategories));

        $iabCategories = $this
                        ->webshrinkerClient
                        ->categorize("https://www.youtube.com/watch?v=PXSVqk4YRAk&index=135&list=PLL7WPSeQ0-ov0MjaQLTE8p-v5eM9iatal", False)
                ->data[0]
                ->categories;
        $this->assertTrue(!empty($iabCategories));
    }

    /**
     * Test fetching all webshrinker and IAB categories.
     * 
     * @return void
     */
    public function testGetCategories()
    {
        $simpleCategories = $this
                        ->webshrinkerClient
                        ->getCategories()
                ->data
                ->categories;
        $this->assertTrue(!empty($simpleCategories));

        $iabCategories = $this
                        ->webshrinkerClient
                        ->getCategories(FALSE)
                ->data
                ->categories;
        $this->assertTrue(!empty($iabCategories));
    }

}
