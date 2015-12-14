<?php
class basicTest extends PHPUnit_Framework_TestCase
{
    public function testSingleChars()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('😯'));
    }
    public function testSingleCharsOfHTML()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&#128513;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&#128169;'));

        // add spaces
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&#128513; '));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('  &#128169;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('  &#128169;'));
    }

    /*  this is not yet supported... PR?
    public function testAlternatHtml()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&heart;'));
    }
     */
}

