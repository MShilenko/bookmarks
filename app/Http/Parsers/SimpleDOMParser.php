<?php

namespace App\Http\Parsers;

class SimpleDOMParser
{
    private $xpath;
    private $tags;

    public function __construct(string $url, array $tags)
    {
        $doc = new \DOMDocument();
        @$doc->loadHTMLFile($url);
        $this->xpath = new \DOMXpath($doc);
        $this->url = $url;
        $this->tags = $tags;
    }

    /**
     * Iterate over the tags and get the values ​​we need
     *
     * @return array
     */
    public function getData(): array
    {
        $result = [];

        foreach ($this->tags as $key => $tag) {
            $query = is_array($tag) ? $this->getQueryString($tag) : "//{$tag}/text()";
            $element = $this->xpath->query($query);

            $result[$key] = $element->item(0) ? $this->getText($element->item(0)) : null;
        }

        return $result;
    }

    /**
     * Get the query string for tags with attributes
     *
     * @param array $tag
     * @return string
     */
    private function getQueryString(array $tag): string
    {
        $parts = explode('.', $tag[1]);

        if (!is_array($parts)) {
            throw new \Exception('Attribute passed incorrectly to find the tag. Must be "attribute.Its_value"');
        }

        return "//{$tag[0]}[@{$parts[0]}='{$parts[1]}']/@{$tag[2]}";
    }

    /**
     * Depending on the type of node, we get the desired value
     *
     * @param object $element
     * @return void
     */
    private function getText(object $element)
    {
        $text = '';

        if ($element instanceof \DOMText) {
            $text = $element->data;
        }

        if ($element instanceof \DOMAttr) {
            $text = $element->nodeValue;
        }

        return mb_convert_encoding(clearString($text), "UTF-8", "auto");
    }
}
