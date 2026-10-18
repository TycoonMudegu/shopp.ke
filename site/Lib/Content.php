<?php

namespace ShoppKe\Lib;

use League\CommonMark\CommonMarkConverter;

class Content
{
    private CommonMarkConverter $converter;
    private string $contentPath;

    public function __construct()
    {
        $this->contentPath = __DIR__ . '/../content/seller-stories/';
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function getStory(string $slug): ?array
    {
        if (!preg_match('/^[a-z0-9-]+$/D', $slug)) {
            return null;
        }
        $file = $this->contentPath . $slug . '.md';
        return is_file($file) ? $this->parseFile($file) + ['slug' => $slug] : null;
    }

    public function getAllStories(): array
    {
        $stories = [];
        foreach (glob($this->contentPath . '*.md') as $file) {
            $stories[] = $this->parseFile($file) + ['slug' => basename($file, '.md')];
        }
        usort($stories, fn ($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));
        return $stories;
    }

    private function parseFile(string $file): array
    {
        $source = str_replace("\r\n", "\n", file_get_contents($file));
        $metadata = [];
        $markdown = $source;
        if (preg_match('/\A---\n(.*?)\n---\n(.*)\z/s', $source, $matches)) {
            $markdown = $matches[2];
            foreach (explode("\n", $matches[1]) as $line) {
                if (str_contains($line, ':')) {
                    [$key, $value] = explode(':', $line, 2);
                    $metadata[trim($key)] = trim($value);
                }
            }
        }
        return $metadata + ['content' => (string) $this->converter->convert($markdown)];
    }
}
