<?php

namespace Tests\Unit\FilePutContents;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FilePutContentsTest extends TestCase
{
    #[Test] public function put(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.php',
            'directory' => self::$test_dir
        ]);

        $BaseClass->initDirRecursively();

        $BaseClass->filePutContents('test');

        self::assertStringEqualsFile(
            self::$test_dir.'/test.php',
            'test'
        );
    }
}