<?php

interface DataParserInterface
{
    /**
     * Возвращает данные из файла в виде массива.
     *
     * @param mixed $source Источник данных.
     *
     * @return array
     *
     * @throws Exception
     */
    public function getData($source) : array;
}
