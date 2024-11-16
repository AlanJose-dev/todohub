<?php

namespace App\Facades;

class View
{
    private const string BASE_VIEWS_PATH = BASE_PATH . 'resources/views';

    private string $file;

    private array $data;

    public function __construct(string $file, array $data = [])
    {
        $this->file = str_replace('.', '/', $file) . '.view.php';
        $this->data = $data;
    }

    public static function make(string $file, array $data = []): self
    {
        return new self($file, $data);
    }

    public function render(): void
    {
        $file = self::BASE_VIEWS_PATH . "/$this->file";
        if(!file_exists($file)) {
            throw new \Exception("View file {$this->file} does not exist");
        }
        try
        {
            ob_start();
            extract($this->data);
            require $file;
            $output = ob_get_clean();
            echo $output;
        }
        catch(\Exception $exception)
        {
            ob_end_clean();
            throw $exception;
        }
    }
}
