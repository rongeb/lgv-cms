<?php

//ini_set('display_errors', 1);
namespace ExtLib;

final class Utils
{

    public function tri_par_cle($tableauEnArrivee, $indexTableau)
    {

        $tableauTriIntermediaire = array();

        //préparation d'un nouveau tableau basé sur la clé à trier
        foreach ($tableauEnArrivee as $cle => $valeur) {
            $tableauTriIntermediaire[$cle] = $valeur[$indexTableau];
        }

        //tri par ordre naturel et insensible à la casse
        natcasesort($tableauTriIntermediaire);

        //formation du nouveau tableau trié selon la clé
        $output = array();

        foreach ($tableauTriIntermediaire as $cle => $valeur) {
            $TableauEnSortie[] = $tableauEnArrivee[$cle];
        }

        return $TableauEnSortie;
    }

    /**
     *
     * @param type $str : string to filter
     * @param type bool $striptag : strip_tag
     * @param type bool $htmlChar : replace html char
     * @param type bool $trim : trim
     * @return filterer $string
     */
    public function stripTags_replaceHtmlChar_trim($str, $striptag, $htmlChar, $trim)
    {

        if ($trim) {
            //variable pour indiquer les caractères à retirer	                         
            $echap = array("\n", "\r");
            //Retirer les caractères spécifiés dans $echap
            $str = str_replace($echap, " ", $str);
            $str = trim($str);
        }

        if ($striptag) {
            //Retirer les balises HTML du texte
            $str = strip_tags($str);
        }

        if ($htmlChar) {
            //Remplacer les caractères sous format HTML et les remplacer  
            $str = html_entity_decode($str);
            $str = str_replace('&rsquo;', "'", $str);
            $str = str_replace('&lsquo;', "'", $str);
            $str = str_replace('&hellip;', '...', $str);
            $str = str_replace('&bull;', '- ', $str);
            $str = str_replace('&ndash;', '- ', $str);
            $str = str_replace('&reg;', '®', $str);
            $str = str_replace('&oelig;', 'œ', $str);
            $str = str_replace('&euro;', '€', $str);
            $str = str_replace('&amp;', '&', $str);
            $str = str_replace('"', "'", $str);
            $str = str_replace("&ldquo;", '"', $str);
            $str = str_replace("&rdquo;", '"', $str);
            $str = str_replace("&mdash;", '_', $str);
            $str = str_replace('&trade;', "", $str);
            $str = str_replace("&agrave;", "à", $str);
            $str = str_replace("&Agrave;", "À", $str);
            $str = str_replace("&aacute;", "á", $str);
            $str = str_replace("&Aacute;", "Á", $str);
            $str = str_replace("&acirc;", "â", $str);
            $str = str_replace("&Acirc;", "Â", $str);
            $str = str_replace("&auml;", "ä", $str);
            $str = str_replace("&Auml;", "Ä", $str);
            $str = str_replace("&atilde;", "ã", $str);
            $str = str_replace("&Atilde;", "Ã", $str);
            $str = str_replace("&egrave;", "è", $str);
            $str = str_replace("&Egrave;", "È", $str);
            $str = str_replace("&eacute;", "é", $str);
            $str = str_replace("&Eacute;", "É", $str);
            $str = str_replace("&ecirc;", "ê", $str);
            $str = str_replace("&Ecirc;", "Ê", $str);
            $str = str_replace("&euml;", "ë", $str);
            $str = str_replace("&Euml;", "Ë", $str);
            $str = str_replace("&igrave;", "ì", $str);
            $str = str_replace("&Igrave;", "Ì", $str);
            $str = str_replace("&iacute;", "í", $str);
            $str = str_replace("&Iacute;", "Í", $str);
            $str = str_replace("&icirc;", "î", $str);
            $str = str_replace("&Icirc;", "Î", $str);
            $str = str_replace("&iuml;", "ï", $str);
            $str = str_replace("&Iuml;", "Ï", $str);
            $str = str_replace("&ograve;", "ò", $str);
            $str = str_replace("&Ograve;", "Ò", $str);
            $str = str_replace("&oacute;", "ó", $str);
            $str = str_replace("&Oacute;", "Ó", $str);
            $str = str_replace("&ocirc;", "ô", $str);
            $str = str_replace("&Ocirc;", "Ô", $str);
            $str = str_replace("&otilde;", "ö", $str);
            $str = str_replace("&Otilde;", "Ö", $str);
            $str = str_replace("&ugrave;", "ù", $str);
            $str = str_replace("&Ugrave;", "Ù", $str);
            $str = str_replace("&uacute;", "ú", $str);
            $str = str_replace("&Uacute;", "Ú", $str);
            $str = str_replace("&ucirc;", "û", $str);
            $str = str_replace("&Ucirc;", "Û", $str);
            $str = str_replace("&Uuml;", "ü", $str);
            $str = str_replace("&Uuml;", "Ü", $str);
            $str = str_replace("&Yuml;", "Ÿ", $str);
            $str = str_replace("&yuml;", "ÿ", $str);
            $str = str_replace("&ccedil;", "ç", $str);
            $str = str_replace("&Ccedil;", "Ç", $str);
        }
        return $str;
    }

    function date_fr($format, $timestamp = false)
    {

        if (!$timestamp)
            $date_en = date($format);
        else
            $date_en = date($format, $timestamp);

        $texte_en = array(
            "Monday", "Tuesday", "Wednesday", "Thursday",
            "Friday", "Saturday", "Sunday", "January",
            "February", "March", "April", "May",
            "June", "July", "August", "September",
            "October", "November", "December"
        );
        $texte_fr = array(
            "Lundi", "Mardi", "Mercredi", "Jeudi",
            "Vendredi", "Samedi", "Dimanche", "Janvier",
            "F&eacute;vrier", "Mars", "Avril", "Mai",
            "Juin", "Juillet", "Ao&ucirc;t", "Septembre",
            "Octobre", "Novembre", "D&eacute;cembre"
        );
        $date_fr = str_replace($texte_en, $texte_fr, $date_en);

        $texte_en = array(
            "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun",
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
            "Aug", "Sep", "Oct", "Nov", "Dec"
        );
        $texte_fr = array(
            "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
            "Jan", "F&eacute;v", "Mar", "Avr", "Mai", "Jui",
            "Jui", "Ao&ucirc;", "Sep", "Oct", "Nov", "D&eacute;c"
        );
        $date_fr = str_replace($texte_en, $texte_fr, $date_fr);

        return $date_fr;
    }

    //For php version < 5.40 to unescape unicode, 
    //http://stackoverflow.com/questions/16498286/why-does-the-php-json-encode-function-convert-utf-8-strings-to-hexadecimal-entit
    function raw_json_encode($input)
    {

        return preg_replace_callback(
            '/\\\\u([0-9a-zA-Z]{4})/',
            function ($matches) {
                return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
            },
            json_encode($input)
        );

    }

    /**
     *
     * hack to translate label in form class
     *       */
    function translate($str)
    {
        return $str;
    }

}

?>