<?php

namespace App\Http\Parsers;

class SimpleXLSParser
{
    private $fields;
    private $model;

    public function __construct(array $fields, object $model)
    {
        $this->fields = $fields;
        $this->model = $model;
    }

    /**
     * Form data and send the file
     *
     * @return void
     */
    public function getData(): void
    {
        $modelData = $this->model::select($this->fields)->get();

        if (!$modelData) {
            throw new \Exception('Failed to get data.');
        }

        $headers = $this->setTitles();
        $body = "";

        foreach ($modelData as $item) {
            $body .= "{$this->setRow($item)}\n";
        }

        if (!$headers || !$body) {
            throw new \Exception('Failed to get data.');
        }

        $this->downloadData($headers, $body);
    }

    /**
     * Forming a table row from model data
     *
     * @param object $item
     * @return string
     */
    private function setRow(object $item): string
    {
        $row = "";

        foreach ($this->fields as $field) {
            $row .= "{$item->$field}\t";
        }

        return trim($row);
    }

    /**
     * Form the table headers from the transmitted data
     *
     * @return string
     */
    private function setTitles(): string
    {
        $headers = "";

        foreach ($this->fields as $field) {
            $headers .= "{$field}\t";
        }

        return $headers;
    }

    /**
     * Setting send headers and sending data
     *
     * @param string $headers
     * @param string $body
     * @return void
     */
    private function downloadData(string $headers, string $body): void
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . class_basename($this->model) . '_export.xls"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        echo "{$headers}\n{$body}\n";
    }
}
