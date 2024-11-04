<?php

namespace Tests\Unit\Put;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PutTest extends TestCase
{
    #[Test] public function put(): void
    {
        BaseClass::from([
            'filename' => 'test.php',
            'directory' => self::$test_dir
        ])->put('test');

        self::assertStringEqualsFile(
            self::$test_dir.'/test.php',
            'test'
        );
    }
}