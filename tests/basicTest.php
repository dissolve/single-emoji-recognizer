<?php
class basicTest extends PHPUnit_Framework_TestCase
{
    public function testSingleChars()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('😯'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('💩 '));

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
    public function testCountryFlag()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('🇯🇵'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji(' 🇺🇸 '));

    }

    public function testCompositeEmoji()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('👩‍❤️‍💋‍👩'));
    }

    public function testHTMLSpecialCharacters()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&spades;'));
    }

    public function testStandardLettersAreNot()
    {
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('j'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('US'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('jp'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('%gg'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('%aa'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('#aa'));
        $this->assertFalse(EmojiRecognizer::isSingleEmoji('#00'));
    }

    /*  this is not yet supported... PR?
    public function testAlternatHtml()
    {
        $this->assertTrue(EmojiRecognizer::isSingleEmojiHTML('&heart;'));
    }
     */
}

