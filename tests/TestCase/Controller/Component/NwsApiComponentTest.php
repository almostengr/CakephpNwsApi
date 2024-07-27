<?php
declare(strict_types=1);

namespace NationalWeatherServiceApi\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use NationalWeatherServiceApi\Controller\Component\NwsApiComponent;

/**
 * NationalWeatherServiceApi\Controller\Component\NwsApiComponent Test Case
 */
class NwsApiComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \NationalWeatherServiceApi\Controller\Component\NwsApiComponent
     */
    protected $NwsApi;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->NwsApi = new NwsApiComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->NwsApi);

        parent::tearDown();
    }
}
