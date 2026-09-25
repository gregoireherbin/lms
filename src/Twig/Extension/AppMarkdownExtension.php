<?php

namespace App\Twig\Extension;

use League\CommonMark\CommonMarkConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppMarkdownExtension extends AbstractExtension
{
    private CommonMarkConverter $converter;

    public function __construct()
    {
        // Initialisation du convertisseur CommonMark
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip', // Sécurité : supprime le HTML malveillant brut
            'allow_unsafe_links' => false,
        ]);
    }

    public function getFilters(): array
    {
        return [
            // Crée le filtre |markdown utilisable dans tes templates
            new TwigFilter('markdown', [$this, 'toMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function toMarkdown(string $value): string
    {
        return $this->converter->convert($value)->getContent();
    }
}