<?php

include '../src/emoji.php';

//echo html_entity_decode('&#x1f601;');
//echo '<br>---<br>&#x1f601;';
if( EmojiRecognizer::is_single_emoji(html_entity_decode('&#128513;')))
 echo 'yes';

