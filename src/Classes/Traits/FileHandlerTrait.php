<?php

declare(strict_types=1);

namespace Flexi\Contracts\Classes\Traits;

use Flexi\Contracts\Classes\Traits\OSDetectorTrait;

trait FileHandlerTrait
{
    use OSDetectorTrait;

    /**
     * @param int $flags see https://www.php.net/manual/en/function.file-put-contents.php
     *
     * @throws \RuntimeException
     */
    public function writeToFile(string $file_path, string $content, int $flags = 0, bool $try_create_it = false): void
    {
        $file_path = $this->normalize($file_path);
        if ($try_create_it && !$this->fileExists($file_path)) {
            $this->createFile($file_path);
        }
        if (!$this->canWriteToFile($file_path) || false === file_put_contents($file_path, $content, $flags)) {
            throw new \RuntimeException("Could not write to file: $file_path");
        }
    }

    public function normalize(string $relative_path): string
    {
        if ($this->isAbsolutePath($relative_path)) {
            return $relative_path;
        }

        $rootDir = $this->findProjectRoot();
        $fullPath = $rootDir.DIRECTORY_SEPARATOR.$relative_path;
        $segments = preg_split('/[\/\\\\]+/', $fullPath);
        $normalizedSegments = [];

        foreach ($segments as $segment) {
            if ('' === $segment || '.' === $segment) {
                continue;
            }

            if ('..' === $segment) {
                array_pop($normalizedSegments);
            } else {
                $normalizedSegments[] = $segment;
            }
        }

        $normalizedPath = implode(DIRECTORY_SEPARATOR, $normalizedSegments);

        return $this->isWindows() ? $normalizedPath : DIRECTORY_SEPARATOR.$normalizedPath;
    }

    /**
     * Find the project root directory
     * Assumes the trait is in vendor/flexi/contracts/src/Classes/Traits
     */
    private function findProjectRoot(): string
    {
        // From vendor/flexi/contracts/src/Classes/Traits, go up 6 levels to reach project root
        $rootDir = dirname(__DIR__, 6);

        // Verify that composer.json exists in this directory
        if (file_exists($rootDir . DIRECTORY_SEPARATOR . 'composer.json')) {
            return $rootDir;
        }

        // Fallback: find vendor directory in the path and go one level up
        $vendorPos = strpos(__DIR__, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);
        if (false !== $vendorPos) {
            return substr(__DIR__, 0, $vendorPos);
        }

        // Last resort: use current working directory
        return getcwd() ?: __DIR__;
    }

    private function isAbsolutePath(string $path): bool
    {
        if ($this->isUnix()) {
            // Check for Unix absolute paths
            return str_starts_with($path, '/') || str_starts_with($path, '~');
        }

        if ($this->isWindows()) {
            // Check for Windows absolute paths
            return preg_match('/^[a-zA-Z]:\\\\/', $path) || str_starts_with($path, '\\\\');
        }

        return false;
    }

    protected function fileExists(string $file_path): bool
    {
        return file_exists($file_path);
    }

    /**
     * @throws \RuntimeException
     */
    protected function createFile(string $file_path): void
    {
        $directory = dirname($file_path);
        if (!$this->directoryExists($directory)) {
            $this->createDirectory($directory);
        }
        try {
            touch($file_path);
        } catch (\Exception $e) {
            throw new \RuntimeException("Could not create file: $file_path");
        }
    }

    protected function directoryExists(string $dir_path): bool
    {
        return is_dir($dir_path);
    }

    protected function createDirectory(string $dir_path): void
    {
        if (!is_dir($dir_path) && !mkdir($dir_path, 0750, true) && !is_dir($dir_path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir_path));
        }
    }

    /**
     * @return void
     */
    private function canWriteToFile(string $file_path): bool
    {
        return is_writable($file_path);
    }

    public function readFromFile(string $file_path): string
    {
        $this->ensureFileExists($file_path);
        $contents = file_get_contents($file_path);

        if (false === $contents) {
            throw new \RuntimeException("Could not read from file: $file_path");
        }

        return $contents;
    }

    public function ensureFileExists(string &$file_path): void
    {
        $file_path = $this->normalize($file_path);

        if (!$this->fileExists($file_path)) {
            throw new \RuntimeException('File '.$file_path.' does not exist');
        }
    }
}
