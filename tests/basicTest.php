<?php
class basicTest extends PHPUnit_Framework_TestCase
{
    public function testSingleChars()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&#128513;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&#128169;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji(urlencode('😯')));
    }
    public function testSingleCharsWithSpaces()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&#128513; '));
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('  &#128169;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('  &#128169;'));
    }

    /*  this is not yet supported... PR?
    public function testAlternatHtml()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&heart;'));
    }
     */
}

