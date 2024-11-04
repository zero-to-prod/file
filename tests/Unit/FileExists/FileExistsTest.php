<?php

namespace Tests\Unit\FileExists;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FileExistsTest extends TestCase
{
    #[Test] public function file_exists(): void
    {
        $BaseClass = new BaseClass();
        $BaseClass->filename = 'test.php';
        $BaseClass->directory = self::$test_dir;

        $BaseClass->put('test');

        self::assertTrue($BaseClass->fileExists());
    }

    #[Test] public function file_does_exist(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.php',
            'directory' => self::$test_dir
        ]);

        self::assertFalse($BaseClass->fileExists());
    }
}