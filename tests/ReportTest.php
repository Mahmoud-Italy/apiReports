<?php
use App\JsonFile\Report;

class ReportTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_load_json_file()
    {
        // just test for loading json File successfully
        $data = new Report;
        $data->pagination(10);

        // Send request
        $response = $this->json('GET', '/v1/reports');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }


    public function test_search_by_bankName()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?bankName=murray');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_search_by_bankBIC()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?bankBIC=anxistc1');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_search_by_type()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?type=primary');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_search_by_published()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?published=1');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_search_between_scores()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?score_from=50&score_to=100');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_bankName()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=bankName');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_bankBIC()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=bankBIC');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_reportScore()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=reportScore');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_type()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=type');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_createdAt()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=createdAt');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_sort_by_publishedAt()
    {
        // Send request
        $response = $this->json('GET', '/v1/reports?sort=desc&sort_by=publishedAt');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }
}
