<?php

namespace App\Helpers;

use App\Exceptions\FileFormatException;
use App\Exceptions\SourceFileException;
use Illuminate\Database\Eloquent\Model;

class DataImporter
{

    protected string $filePath;
    protected string $modelName;

    protected FileReaderInterface $fileReader;

    private function __construct()
    {

    }

    /**
     * @throws SourceFileException
     */
    public static function from(string $filePath): self|SourceFileException
    {

        if (!file_exists($filePath)) {
            throw new SourceFileException();
        }

        $importer = new self();
        $importer->filePath = $filePath;

        return $importer;
    }

    // чтение файла

    /**
     * Функция создает модели из прочитанного файла
     *
     * @param string $modelName
     * @return void
     */
    public function import(string $modelName): void
    {
        $this->modelName = $modelName;
    }

    /**
     * Функция получает массив с прочитанными атрибутами для каждой модели
     *
     * @param string $modelName
     * @return array
     */
    public function getDataForModel(string $modelName): array
    {
        $this->modelName = $modelName;

        $this->setFileReader(pathinfo($this->filePath, PATHINFO_EXTENSION));
        $file = $this->fileReader->read($this->filePath);

        $attributes = $this->getModelAttributes();
        $columns = $this->fileReader->getColumns($file);
        $fillableAttributes = array_intersect($attributes, $columns);

        $data = [];
        foreach ($this->fileReader->getNextLine($file) as $line) {
            $newItem = [];
            $data[] = $line;
//            array_fill_keys($fillableAttributes, $newItem);
        }

        return $data;

    }

    private function getModelAttributes(): array
    {
        /** @var Model $model */
        $model = new $this->modelName();
        return $model->getFillable();
    }

    /**
     * @throws FileFormatException
     */
    private function setFileReader($fileType): void
    {
        $this->fileReader = match ($fileType) {
            'csv' => new CsvFileReader(),
            default => throw new FileFormatException("File type not supported: $fileType"),
        };
    }

}
