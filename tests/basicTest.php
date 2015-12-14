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
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&hearts;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&clubs;'));
        $this->assertTrue(EmojiRecognizer::isSingleEmoji('&diams;'));
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

}

