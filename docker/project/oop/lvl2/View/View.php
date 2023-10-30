<?php

namespace View;

class View
{
    private string $templatesPath;
    private array $extraVars = [];

    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }
    public function renderHtml(string $templateName, array $vars = [], int $code = 200): void
    {
        http_response_code($code);

        extract($this->extraVars);
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }
}