<?php

namespace Tests\Unit\InitDir;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InitDirTest extends TestCase
{
    #[Test] public function put(): void
    {
        $BaseClass = BaseClass::from([
            'filename' => 'test.php',
            'directory' => self::$test_dir
        ]);
        self::assertDirectoryDoesNotExist(self::$test_dir);

        $BaseClass->initDir();

        self::assertDirectoryExists(self::$test_dir);
    }
}