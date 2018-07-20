<?php
require_once __DIR__ . '/AbstractDataManipulator.php';

/**
 * Class LineCounter.
 * Класс подсчитывающий среднее количество строк во всех файлах пользователя.
 */
class LineCounter extends AbstractDataManipulator
{
    /**
     * Подсчет среднего количества строк для всех людей.
     *
     * @throws Exception Если не удалось получить исходные данные.
     */
    public function countAverageLineCount()
    {
        $people = $this->dataParser->getData($this->userFile);
        foreach ($people as $human) {
            list($id, $name) = $human;
            echo $name . ' ';
            echo $this->countAverageForMan($id) . "\n";
        }
    }

    /**
     * Подсчёт среднего количества строк в файлах у человека с конкретным идентификатором.
     *
     * @param int $id идентификатор.
     *
     * @return float|int
     *
     * @throws Exception  Если не удалось открыть директорию с данными.
     */
    protected function countAverageForMan($id)
    {
        $files         = $this->getManFiles($id);
        $numberOfFiles = count($files);
        if (0 === $numberOfFiles) {
            return 0;
        }
        $fileLinesSum = 0;
        foreach ($files as $file) {
            $fileContent = file_get_contents($file);
            if (false === $fileContent || '' === $fileContent) {
                continue;
            }
            $fileLinesSum += count(explode("\n", $fileContent));
        }
        return $fileLinesSum / $numberOfFiles;
    }
}
