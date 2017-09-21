<?php

use Faker\Factory as Faker;
use App\Models\Counter;
use App\Repositories\CounterRepository;

trait MakeCounterTrait
{
    /**
     * Create fake instance of Counter and save it in database
     *
     * @param array $counterFields
     * @return Counter
     */
    public function makeCounter($counterFields = [])
    {
        /** @var CounterRepository $counterRepo */
        $counterRepo = App::make(CounterRepository::class);
        $theme = $this->fakeCounterData($counterFields);
        return $counterRepo->create($theme);
    }

    /**
     * Get fake instance of Counter
     *
     * @param array $counterFields
     * @return Counter
     */
    public function fakeCounter($counterFields = [])
    {
        return new Counter($this->fakeCounterData($counterFields));
    }

    /**
     * Get fake data of Counter
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCounterData($counterFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'qty' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $counterFields);
    }
}
