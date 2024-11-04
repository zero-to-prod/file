<?php

namespace Tests\Unit\ResolvePath;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResolvePathTest extends TestCase
{
    #[Test] public function sets_default_path(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.txt',
        ]);

        self::assertEquals('./test.txt', $BaseClass->path);
    }

    #[Test] public function sets_path(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.txt',
            'directory' => '/app'
        ]);

        self::assertEquals('/app/test.txt', $BaseClass->path);
    }
}