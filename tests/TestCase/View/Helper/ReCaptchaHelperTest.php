<?php
declare(strict_types=1);

namespace UtilCake\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use UtilCake\View\Helper\ReCaptchaHelper;

/**
 * UtilCake\View\Helper\ReCaptchaHelper Test Case
 */
class ReCaptchaHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \UtilCake\View\Helper\ReCaptchaHelper
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
        $view = new View();
        $this->ReCaptcha = new ReCaptchaHelper($view);
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
