<?php
declare(strict_types=1);

namespace UtilCake\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use UtilCake\Controller\Component\ReCaptchaComponent;

/**
 * UtilCake\Controller\Component\ReCaptchaComponent Test Case
 */
class ReCaptchaComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \UtilCake\Controller\Component\ReCaptchaComponent
     */
    protected $ReCaptcha;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ReCaptcha = new ReCaptchaComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReCaptcha);

        parent::tearDown();
    }
}
