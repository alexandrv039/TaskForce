<?php

namespace src\database;

use mysqli;
use RuntimeException;
use SplFileObject;
use src\exceptions\DatabaseException;
use src\exceptions\FileFormatException;
use src\exceptions\SourceFileException;

class DataImporterCSV
{
    private string $filename;
    private array $columns;
    private string $sourceTable;
    private $fileObject;

    private $result = [];
    private $error = null;

    /**
     * @param string $filename - Полный путь к файлу
     * @param string[] $columns - Имена колонок (должны совпадать в файле и в БД)
     * @param string $sourceTable - Имя целевой таблицы, куда будут загружены данные
     */
    public function __construct(string $filename, array $columns, string $sourceTable)
    {
        $this->filename = $filename;
        $this->columns = $columns;
        $this->sourceTable = $sourceTable;
    }

    /**
     * Функция загрузит данные из файла в базу данных
     *
     * @return void
     * @throws FileFormatException|SourceFileException|DatabaseException
     */
    public function import(): void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        } catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $header_data = $this->getHeaderData();

        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов: " . implode(", ", array_diff($this->columns, $header_data)));
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

        if (empty($this->result)) {
            throw new FileFormatException("В файле нет данных");
        }

        $this->loadToDatabase();

    }

    public function getData(): array
    {
        return $this->result;
    }

    private function getHeaderData(): ?array
    {
        $this->fileObject->rewind();
        return $this->fileObject->fgetcsv();
    }

    private function getNextLine(): ?iterable
    {
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return null;
    }

    private function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     *
     * Функция загружает полученный из файла результат в базу данных
     *
     * @return void
     * @throws DatabaseException
     */
    private function loadToDatabase(): void
    {

        $connection = new mysqli('mysqldb', 'root', 'root', 'psr_test');
        $connection->set_charset('utf8mb4');

        /** @var mysqli $link */
        if ($connection->connect_error) {
            throw new DatabaseException($connection->connect_error);
        }

        $columnNames = implode(', ', $this->columns);
        $query = "INSERT INTO " . $this->sourceTable . "(" . $columnNames . ") VALUES ";

        $arrayData = [];
        foreach ($this->result as $i=>$value) {
            $values = array_filter($value);
            if (empty($values)) continue;

            $values = array_map(function ($value) {
                if (gettype($value) == 'string') {
                    return "'" . $value . "'";
                }
                return $value;
            }, $values);

            $values = implode(', ', $values);
            $arrayData[] = "({$values})";
        }
        $query .= implode(', ', $arrayData);

        $result = $connection->query($query);

        $connection->close();

        if(!$result) {
            throw new DatabaseException($connection->error);
        }

    }
}
