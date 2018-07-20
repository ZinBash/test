<?php

/**
 * Class AbstractDataManipulator.
 * Класс помогающий манипулировать данными пользователя.
 */
abstract class AbstractDataManipulator
{
    /**
     * Объект парсера данных.
     *
     * @var DataParserInterface
     */
    protected $dataParser;

    /**
     * Путь до файла с информацией о людях.
     *
     * @var string
     */
    protected $userFile = __DIR__ . '/people.csv';

    /**
     * Путь до директории с текстами.
     *
     * @var string
     */
    protected $pathToPeopleTexts = __DIR__ . '/texts';

    /**
     * Все файлы пользователей, которые удалось получить из соответствующей директории.
     *
     * @var array
     */
    protected $allPeopleFiles;

    /**
     * DataManipulator constructor.
     *
     * @param DataParserInterface $parser
     */
    public function __construct($parser)
    {
        $this->dataParser = $parser;
    }

    /**
     * Поиск всех файлов пользователя.
     *
     * @param integer $id Идентификатор человека.
     *
     * @return array
     *
     * @throws Exception Если не удалось открыть директорию.
     */
    protected function getManFiles($id)
    {
        $files     = $this->getAllPeopleFiles();
        $userFiles = [];
        foreach ($files as $file) {
            if (preg_match('/' . $id . '\-\d{3}\.txt/', $file)) {
                $userFiles[] = $this->pathToPeopleTexts . '/' . $file;
            }
        }
        return $userFiles;
    }

    /**
     * Возвращает массив со всеми названиями файлов в директории $pathToPeopleText.
     *
     * @return array
     *
     * @throws Exception Если не удалось открыть директорию.
     */
    protected function getAllPeopleFiles()
    {
        if (! isset($this->allPeopleFiles)) {
            $files = scandir($this->pathToPeopleTexts);
            if (false === $files) {
                throw new Exception('Не удалось открыть директорию ' . $this->pathToPeopleTexts);
            }
            $this->allPeopleFiles = $files;
        }
        return $this->allPeopleFiles;
    }

    /**
     * Сэттер для парсера данных.
     *
     * @param DataParserInterface $value
     */
    public function setDataParser(DataParserInterface $value)
    {
        $this->dataParser = $value;
    }
}
