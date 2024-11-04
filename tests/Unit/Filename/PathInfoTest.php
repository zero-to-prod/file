<?php

namespace Tests\Unit\Filename;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PathInfoTest extends TestCase
{
    #[Test] public function path_info_all(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.php',
        ]);

        self::assertEquals('test', $BaseClass->filename());
    }
}