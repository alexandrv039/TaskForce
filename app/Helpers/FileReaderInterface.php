<?php

namespace App\Helpers;

use App\Exceptions\FileFormatException;
use App\Exceptions\SourceFileException;
use SplFileObject;

interface FileReaderInterface
{
    public function read(string $fileName): SourceFileException|SplFileObject;

    public function getColumns(SplFileObject $file): array|FileFormatException;

    public function getNextLine(SplFileObject $file): ?iterable;
}
