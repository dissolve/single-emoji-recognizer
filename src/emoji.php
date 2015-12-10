<?php

class EmojiRecognizer
{

    private static function is_emoji_char($intvalue)
    {
        return (
           ($intvalue >= 0x1F300 && $intvalue <= 0x1F5FF ) //supplemental symbols and pictographs
        || ($intvalue >= 0x1F600 && $intvalue <= 0x1F64F) //emoticons
        || ($intvalue >= 0x1F680 && $intvalue <= 0x1F6FF) //transport map symbols
        || ($intvalue >= 0x2600  && $intvalue <= 0x26FF ) // misc symbols
        || ($intvalue >= 0x2700  && $intvalue <= 0x27BF ) //dingbats
        || ($intvalue >= 0xE000  && $intvalue <= 0xF8FF ) //private use area??
        );
    }

    private static function is_non_spacing_mark($intvalue)
    {
         return (
           ($intvalue >= 0x0300 && $intvalue <= 0x036F )
        || ($intvalue >= 0x1AB0 && $intvalue <= 0x1ABD )
        || ($intvalue >= 0x1DC0 && $intvalue <= 0x1DFF )
        || ($intvalue >= 0x20D0 && $intvalue <= 0x20F0 )
        || ($intvalue >= 0x2CEF && $intvalue <= 0x2CF1 )
        || ($intvalue >= 0xFE20 && $intvalue <= 0xFE2F )
        || ($intvalue >= 0x1DA01 && $intvalue <= 0x1DA6C )  // signwriting?
        || ($intvalue == 0x1DA75) // signwriting?
        || ($intvalue == 0x1DA84) // signwriting?
        || ($intvalue >= 0x1DA9B && $intvalue <= 0x1DAAF )  // signwriting?
         );
    }

    private static function is_modifier($intvalue)
    {
        return (
           ($intvalue == 0x005E)
        || ($intvalue == 0x0060)
        || ($intvalue == 0x00A8)
        || ($intvalue == 0x00AF)
        || ($intvalue >= 0x02C2 && $intvalue <= 0x02C5)
        || ($intvalue >= 0x02D2 && $intvalue <= 0x02DF)
        || ($intvalue >= 0x02E5 && $intvalue <= 0x02FF)
        || ($intvalue >= 0x1FBD && $intvalue <= 0x1FC1)
        || ($intvalue >= 0x1FCD && $intvalue <= 0x1FCF)
        || ($intvalue >= 0x1FDD && $intvalue <= 0x1FDF)
        || ($intvalue >= 0x1FED && $intvalue <= 0x1FEF)
        || ($intvalue >= 0x1FFD && $intvalue <= 0x1FFE)
        || ($intvalue >= 0x309B && $intvalue <= 0x309C)
        || ($intvalue >= 0xA700 && $intvalue <= 0xA721)
        || ($intvalue >= 0xA789 && $intvalue <= 0xA78A)
        || ($intvalue == 0xAB5B)
        || ($intvalue >= 0xFBB2 && $intvalue <= 0xFBC1)
        || ($intvalue == 0xFF3E)
        || ($intvalue == 0xFF40)
        || ($intvalue == 0xFFE3)
        || ($intvalue >= 0x1F3FB && $intvalue <= 0x1F3FF)
        );
    }

    private static function is_variation_selector($intvalue)
    {
        return (
           ($intvalue >= 0xFE00  && $intvalue <= 0xFE0F  ) // variation selectors 1-16
        || ($intvalue >= 0xE0100 && $intvalue <= 0xE01EF ) // variation selectors 17-256
        );
    }

    private static function is_flag_char($intvalue)
    {
         return ($intvalue >= 0x1F1E6  && $intvalue <= 0x1F1FF);
    }

    private static function is_zwj($intvalue)
    {
        return ($intvalue == 0x200D);
    }

// much of this is based on what i could understand from
// http://www.unicode.org/reports/tr51/index.html#def_emoji_modifier_base

    private static function parse_emoji_core_sequence($input, $position)
    {
        //remove leading char
        if (self::is_emoji_char($input[$position]) ) {
            $position++;
            //modifiers and variation selectors come after characters
            if (self::is_variation_selector($input[$position])) {
                $position++;
            }
            while (self::is_non_spacing_mark($input[$position])) {
                $position++;
            }
            if (self::is_modifier($input[$position])) {
                $position++;
            }
        } elseif ( self::is_flag_char($input[$position]) && self::is_flag_char($input[$position + 1])) {
            $position = $position + 2;
        }

        if (count($input) == $position ) {
            return true;
        }

        if ( self::is_zwj($input[$position])) {
            $position++;
            return self::parse_emoji_core_sequence($input, $position);
        }

        return false;

    }

    private static function parse_emoji_sequence($input)
    {
        if (!is_array($input)) {
            return self::is_emoji_char($input);
        }
        $position = 0;

        //allowed to start with one of these types of characters i think
        //if so, we skip it
        if (self::is_modifier($input[$position]) || self::is_variation_selector($input[$position]) || self::is_zwj($input[$position]) ) {
            $position++;
        }

        if (self::is_emoji_char($input[$position])  || self::is_flag_char($input[$position])) {
            return self::parse_emoji_core_sequence($input, $position);
        }
        return false;
    }


    public static function is_single_emoji($text)
    {
        $text = trim($text);
        $text = htmlentities($text);

        $a = preg_match_all('/^(\&amp;\#\d+;)+$/', $text, $matches);

        if(empty($matches) || !isset($matches[0]) || !isset($matches[0][0])){
            //$a = preg_match_all('/^(\&(amp;)?x[\da-fA-F]+;)+$/', $text, $matches);
            //if(empty($matches) || !isset($matches[0]) || !isset($matches[0][0])){
                //var_dump($matches);
                //var_dump($text);
                return false;
            }
        }
        
        $matched =($matches[0][0]);
        $a = preg_match_all('/\&amp;\#(\d+);/', $matched, $matches);
        $int_vals = array();
        foreach ($matches[1] as $str) {
            $int_vals[] = intval($str);
        }

        return self::parse_emoji_sequence($int_vals);

    }

    public static function is_single_emoji_html($text)
    {
        $text = html_entity_decode($text);
        return self::is_single_emoji($text);
    }


}




