<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CounterApiTest extends TestCase
{
    use MakeCounterTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCounter()
    {
        $counter = $this->fakeCounterData();
        $this->json('POST', '/api/v1/counters', $counter);

        $this->assertApiResponse($counter);
    }

    /**
     * @test
     */
    public function testReadCounter()
    {
        $counter = $this->makeCounter();
        $this->json('GET', '/api/v1/counters/'.$counter->id);

        $this->assertApiResponse($counter->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCounter()
    {
        $counter = $this->makeCounter();
        $editedCounter = $this->fakeCounterData();

        $this->json('PUT', '/api/v1/counters/'.$counter->id, $editedCounter);

        $this->assertApiResponse($editedCounter);
    }

    /**
     * @test
     */
    public function testDeleteCounter()
    {
        $counter = $this->makeCounter();
        $this->json('DELETE', '/api/v1/counters/'.$counter->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/counters/'.$counter->id);

        $this->assertResponseStatus(404);
    }
}
