<?php

namespace Tests\Unit\InitDirRecursively;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InitDirRecursivelyTest extends TestCase
{
    #[Test] public function put(): void
    {
        $dir = self::$test_dir.'/1/2/3';
        $BaseClass = BaseClass::from([
            'filename' => 'test.php',
            'directory' => $dir
        ]);
        self::assertDirectoryDoesNotExist($dir);

        $BaseClass->initDirRecursively();

        self::assertDirectoryExists($dir);
    }
}