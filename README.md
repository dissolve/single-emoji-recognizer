# single-emoji-recognizer
determine if some text contains a single emoji or not.  useful in determining if a reply is a "reacji" or actual text


## Install

This library can be installed easily with composer
```
composer require dissolve/single-emoji-recognizer
```

then from within your code
```
require_once( 'vendor/dissolve/single-emoji-recognizer/src/emoji.php');
```


## Examples

This library offers up a single function, isSingleEmoji.  You can call it like this

```
$is_emoji = EmojiRecognizer::isSingleEmoji('😯')  // => true
$is_emoji = EmojiRecognizer::isSingleEmoji('foo')  // => false
```
