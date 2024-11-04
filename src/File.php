<?php

namespace Zerotoprod\File;

use RuntimeException;
use Zerotoprod\DataModel\Describe;

trait File
{
    /**
     * The filename of the file.
     */
    #[Describe(['required' => true])]
    public string $filename;

    /**
     * The directory of the file.
     *
     * Defaults to `.`
     */
    #[Describe(['default' => '.'])]
    public string $directory;

    /**
     *  The full path of the file including the directory path and filename.
     */
    public function path(): string
    {
        return rtrim($this->directory ?? '.', DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR
            .$this->filename;
    }

    /**
     * Returns information about the file path
     *
     * @link https://php.net/manual/en/function.pathinfo.php
     *
     * @param  int  $flags   [optional]
     *                       You can specify which elements are returned with
     *                       optional parameter options. It composes from
     *                       `PATHINFO_DIRNAME`, `PATHINFO_BASENAME`,
     *                       `PATHINFO_EXTENSION` and `PATHINFO_FILENAME`. It
     *                       defaults to return all elements.
     *                       </p>
     *
     * @return false|int|string|array{dirname: string, basename: string,
     *     extension:string, filename: string}
     *                                     The following associative array
     *                                     elements are returned: dirname,
     *                                     basename,
     *                                     (if any), and filename.
     *
     * If options is used, this function will return a
     * string if not all elements are requested.
     */
    public function pathinfo(int $flags = PATHINFO_ALL): false|int|string|array
    {
        return pathinfo($this->filename, $flags);
    }

    /**
     * The name of the file (without the extension) or directory.
     *
     * @link https://www.php.net/manual/en/function.pathinfo.php
     * @see  https://www.php.net/manual/en/filesystem.constants.php#constant.pathinfo-filename
     */
    public function filename(): array|string
    {
        return pathinfo($this->filename, PATHINFO_FILENAME);
    }

    /**
     * Writes data to the file.
     *
     * It will initialize the directory if it does not exist.
     *
     * @throws RuntimeException When overwriting a file unintentionally.
     */
    public function put(
        mixed $data = '',
        int $permissions = 0777,
        bool $overwrite = false
    ): string {
        if (!$overwrite && $this->fileExists()) {
            throw new RuntimeException("File already exists: {$this->path()}");
        }

        $this->initDirRecursively($permissions);

        return $this->filePutContents($data);
    }

    /**
     * Checks whether a file or directory exists
     *
     * Upon failure, an `E_WARNING` is emitted.
     *
     * @return bool Returns true if the file or directory specified by filename
     *              exists; false otherwise. This function will return false
     *              for symlinks pointing to non-existing files. The check is
     *              done using the real UID/GID instead of the effective one.
     *              Because PHP's integer type is signed and many platforms use
     *              32bit integers, some filesystem functions may return
     *              unexpected results for files which are larger than 2GB.
     *
     * @link https://www.php.net/manual/en/function.file-exists.php
     * @see  https://www.php.net/manual/en/errorfunc.constants.php#constant.e-warning
     */
    public function fileExists(): bool
    {
        return file_exists($this->path());
    }

    /**
     * Write data to a file.
     *
     * This function is identical to calling `fopen()`, `fwrite()` and
     * `fclose()` successively to write data to a file.
     *
     * If filename does not exist, the file is created. Otherwise, the existing
     * file is overwritten, unless the `FILE_APPEND` flag is set.
     *
     * @param  mixed     $data     The data to write. Can be either a string,
     *                             an array or a stream resource.
     *                             If data is a stream resource, the
     *                             remaining buffer of that
     *                             stream will
     *                             be copied to the specified file. This is
     *                             similar with using stream_copy_to_stream().
     *                             You can also specify the data parameter as a
     *                             single dimension array. This is equivalent
     *                             to file_put_contents($filename, implode('',
     *                             $array)).
     * @param  int       $flags    The value of flags can be any combination of
     *                             the following flags, joined with the binary
     *                             OR (|) operator. FILE_USE_INCLUDE_PATH
     *                             Search for filename in the include
     *                             directory. See include_path for more
     *                             information. FILE_APPEND    If file filename
     *                             already exists, append the data to the file
     *                             instead of overwriting it. LOCK_EX
     *                             Acquire an exclusive lock on the file while
     *                             proceeding to the writing. In other words, a
     *                             flock() call happens between the fopen()
     *                             call and the fwrite() call. This is not
     *                             identical to an fopen() call with mode "x".
     * @param  resource  $context  A valid context resource created with
     *                             stream_context_create().
     *
     * @return int|false This function returns the number of bytes that were
     *                   written to the file, or false on failure. This
     *                   function may return Boolean false, but may also return
     *                   a non-Boolean value which evaluates to false. Please
     *                   read the section on Booleans for more information. Use
     *                   the === operator for testing the return value of this
     *                   function.
     *
     * @link https://www.php.net/manual/en/function.file-put-contents.php
     * @see  https://www.php.net/manual/en/function.fopen.php
     * @see  https://www.php.net/manual/en/function.fwrite.php
     * @see  https://www.php.net/manual/en/function.fclose.php
     */
    public function filePutContents(
        mixed $data,
        int $flags = 0,
        $context = null
    ): int|false {
        return file_put_contents(
            $this->path(),
            $data,
            $flags,
            $context
        );
    }

    /**
     * Creates directories recursively if they do not exist for the file.
     */
    public function initDir(
        int $permissions = 0777,
        bool $recursive = false
    ): bool {
        return is_dir($this->directory)
            || mkdir(
                $this->directory,
                $permissions,
                $recursive
            )
            || is_dir($this->directory);
    }

    /**
     * Creates directories recursively if they do not exist for the file.
     */
    public function initDirRecursively(int $permissions = 0777): bool
    {
        return $this->initDir($permissions, true);
    }
}