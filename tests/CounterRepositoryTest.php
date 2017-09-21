<?php

use App\Models\Counter;
use App\Repositories\CounterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CounterRepositoryTest extends TestCase
{
    use MakeCounterTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CounterRepository
     */
    protected $counterRepo;

    public function setUp()
    {
        parent::setUp();
        $this->counterRepo = App::make(CounterRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCounter()
    {
        $counter = $this->fakeCounterData();
        $createdCounter = $this->counterRepo->create($counter);
        $createdCounter = $createdCounter->toArray();
        $this->assertArrayHasKey('id', $createdCounter);
        $this->assertNotNull($createdCounter['id'], 'Created Counter must have id specified');
        $this->assertNotNull(Counter::find($createdCounter['id']), 'Counter with given id must be in DB');
        $this->assertModelData($counter, $createdCounter);
    }

    /**
     * @test read
     */
    public function testReadCounter()
    {
        $counter = $this->makeCounter();
        $dbCounter = $this->counterRepo->find($counter->id);
        $dbCounter = $dbCounter->toArray();
        $this->assertModelData($counter->toArray(), $dbCounter);
    }

    /**
     * @test update
     */
    public function testUpdateCounter()
    {
        $counter = $this->makeCounter();
        $fakeCounter = $this->fakeCounterData();
        $updatedCounter = $this->counterRepo->update($fakeCounter, $counter->id);
        $this->assertModelData($fakeCounter, $updatedCounter->toArray());
        $dbCounter = $this->counterRepo->find($counter->id);
        $this->assertModelData($fakeCounter, $dbCounter->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCounter()
    {
        $counter = $this->makeCounter();
        $resp = $this->counterRepo->delete($counter->id);
        $this->assertTrue($resp);
        $this->assertNull(Counter::find($counter->id), 'Counter should not exist in DB');
    }
}
