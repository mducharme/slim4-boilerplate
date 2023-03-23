<?php

declare(strict_types=1);

namespace App\Views;

class Home
{
    private $title = 'Home from view controller';


    public function __invoke(): array
    {
        return [
            'title' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}