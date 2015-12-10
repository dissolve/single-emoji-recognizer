<?php

include '../src/emoji.php';

//echo html_entity_decode('&#x1f601;');
//echo '<br>---<br>&#x1f601;';
if( EmojiRecognizer::isSingleEmojiHTML('&#128513;'))
 echo 'yes';

