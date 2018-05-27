<?php
namespace Tests\Unit\Forum;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function check_for_invalid_keywords()
    {
        // Invalid keyword
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function checks_for_key_help_down()
    {
        // check for key held down
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('Hello aaaaaaaaaaaaaaaaaa');
    }
}
