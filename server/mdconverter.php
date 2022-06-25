<?php
use League\HTMLToMarkdown\HtmlConverter;
use League\CommonMark\CommonMarkConverter;

class Converter {
    public function __construct(
        public $hConverter = new HtmlConverter(),
        public $mConverter = new CommonMarkConverter()
    ) {}

    public function isHTML($text): bool {
        return preg_match("/<[^<]+>/", $text) !== 0;
    }

    public function md2HTML($text): string {
        return $this->mConverter->convert($text)->getContent();
    }

    public function HTML2Md($text): string {
        return $this->hConverter->convert($text);
    }

    public function convert2Another($text): string {
        return match($this->isHTML($text)) {
            true => $this->HTML2Md($text),
            false => $this->md2HTML($text)
        };
    }
}

