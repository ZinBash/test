<?php
require_once __DIR__ . '/DataManipulator.php';

class LineCounter extends DataManipulator
{
    /**
     * Подсчет среднего количества строк для всех людей.
     *
     * @throws Exception Если не удалось получить данные.
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
     * @throws Exception
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
