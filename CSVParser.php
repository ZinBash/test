<?php

require_once __DIR__ . '/interfaces/DataParserInterface.php';

/**
 * Class CSVParser.
 * Класс помога.щий получить даные из csv-файлов.
 */
class CSVParser implements DataParserInterface
{
    /**
     * Разделитель колонок.
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Путь до файла.
     *
     * @var string
     */
    protected $dataPath;

    /**
     * CSVParser constructor.
     *
     * @param $delimiter
     */
    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Возвращает данные из входного источника в виде массива.
     *
     * @param string $source Путь до файла.
     *
     * @return array
     *
     * @throws Exception Если не удалось получить данные.
     */
    public function getData($source) : array
    {
        if (false === ($handle = fopen($source, 'rb'))) {
            throw new Exception('Cannot open input CSV file');
        }
        $result = [];
        while (false !== ($data = fgetcsv($handle, 0, $this->delimiter))) {
            $result[] = $data;
        }
        fclose($handle);
        return $result;
    }

    /**
     * Сэттер для разделителя.
     *
     * @param string $delimiter
     */
    public function setDelimiter($delimiter) : void
    {
        $this->delimiter = $delimiter;
    }
}
