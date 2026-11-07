<?php

namespace App\Helpers;

use App\Exceptions\FileFormatException;
use App\Exceptions\SourceFileException;
use SplFileObject;

class CsvFileReader implements FileReaderInterface
{

    /**
     * @throws SourceFileException
     */
    public function read(string $fileName): SourceFileException|SplFileObject
    {
        try {
            $file =  new SplFileObject($fileName, 'r');
        } catch (\Throwable $e) {
            throw new SourceFileException("Unable to open file '$fileName'.");
        }
        return $file;
    }

    /**
     * @throws FileFormatException
     */
    public function getColumns(SplFileObject $file): array|FileFormatException
    {
        $file->rewind();
        if (!($columns = $file->fgetcsv())) {
            $fileName = $file->getFilename();
            throw new FileFormatException("Unable to get columns from file '$fileName'.");
        }
        return $columns;
    }

    public function getNextLine(SplFileObject $file): ?iterable
    {
        while (!$file->eof()) {
            yield $file->fgetcsv();
        }
    }
}
