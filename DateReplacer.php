<?php

require_once __DIR__ . '/DataManipulator.php';

class DateReplacer extends DataManipulator
{
    /**
     * Путь до директории с результирующими текстами.
     *
     * @var string
     */
    protected $outputPath = __DIR__ . '/output_texts';

    /**
     * Метод производит замену дат формата dd/mm/yy на mm-dd-yyyy в текстах людей.
     * Записывает результирующие файлы в отдельную директорию.
     *
     * @throws Exception
     */
    public function replaceDates()
    {
        $people = $this->dataParser->getData($this->userFile);
        foreach ($people as $human) {
            list($id, $name) = $human;
            echo $name . ' ';
            echo $this->replaceDatesForMan($id) . "\n";
        }
    }

    /**
     * Осуществляет замену дат и запись файла для конкретного человека.
     *
     * @param int $id Идентификатор человека для определения имени файла.
     *
     * @return int
     *
     * @throws Exception
     */
    protected function replaceDatesForMan($id)
    {
        $files             = $this->getManFiles($id);
        $replacementsCount = 0;
        foreach ($files as $file) {
            $fileContent = file_get_contents($file);
            if (false === $fileContent || '' === $fileContent) {
                continue;
            }
            $pattern     = '/(?!=\d)([0-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{2})(?!\d)/';
            $replacement = '${2}-${1}-20${3}';
            $count       = 0;
            $data        = preg_replace($pattern, $replacement, $fileContent, - 1, $count);
            preg_match('/\d+\-\d+\.txt/', $file, $matches);
            $this->putFileContents($matches[0], $data);
            $replacementsCount += $count;
        }
        return $replacementsCount;
    }

    /**
     * Осущевствляет запись файла сновыми данными.
     *
     * @param string $fileName Имя исходного файла.
     * @param string $data     Данные для записи.
     *
     * @return bool|int
     *
     * @throws Exception
     */
    protected function putFileContents($fileName, $data)
    {
        if (! file_exists($this->outputPath)) {
            mkdir($this->outputPath);
        }
        if (! is_dir($this->outputPath) || ! is_writable($this->outputPath)) {
            throw new Exception('Директория ' . $this->outputPath . ' не доступна для записи');
        }
        $fileName = $this->outputPath . '/' . $fileName;
        return file_put_contents($fileName, $data);
    }
}
