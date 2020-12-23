<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ChartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_pie_chart()
    {
        // Send request
        $response = $this->json('GET', '/v1/pieChart');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_line_chart_monthly()
    {
        // Send request
        $response = $this->json('GET', '/v1/lineChart/monthly');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_line_chart_yearly()
    {
        // Send request
        $response = $this->json('GET', '/v1/lineChart/yearly');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }

    public function test_bar_chart()
    {
        // Send request
        $response = $this->json('GET', '/v1/barChart');

        // Assert Status was successful
        $this->assertEquals(200, $this->response->status());
    }
}
