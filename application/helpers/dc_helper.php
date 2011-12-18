<?php

/**
 * Помощник со вспомогательными функциями
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 */


/**
 * Переведём дату и время из формата 30.12.09 11:00 в нашу 2009-s12-30 11:00:00
 *
 * @param string $date дата
 * @param string $time время
 * @return mixed
 */
function transform_date( $date, $time='' ) {
    if( preg_match("/\A(\d+)\.(\d+)\.(\d{4})\Z/", $date) ) {
        $date = preg_replace("/(\d+)\.(\d+)\.(\d+)/", "20\\3-\\2-\\1", $date);
    }else {
        if( preg_match("/\A(\d+)\.(\d+)\.(\d{4}+)\Z/", $date) ) {
            $date = preg_replace("/(\d+)\.(\d+)\.(\d+)/", "\\3-\\2-\\1", $date);
        }
    }
    if( preg_match("/\A(\d{4}+)\-(\d+)\-(\d+)\Z/", $date) ) {
        if( !empty($time) ) {
            $date .=' '.$time;
        }
        return date( 'Y-m-d H:i:s', strtotime($date) );
    }else {
        return '';
    }
}

/**
 * Correctly convert user's date to SQL datetime format
 *
 * @param  string $date
 * @return string
 */
function mysql_date( $date ) {
	$date = new DateTime( $date );
	return (string)$date->format( 'Y-m-d H:i:s' );
    //return date( 'Y-m-d H:i:s', strtotime($date) );	// fuck Y2K38
}

/**
 * Забивание нулями до нужного формата, у нас это 8 разрядов
 *
 * @param	int		$num число
 * @return	string
 */
function zero_fill( $num ) {
    return sprintf('%08d', $num);
}

/**
 * Человекопонятная русская дата (и время)
 *
 * @param string $date_input Что-то хоть как-то похожее на дату
 * @param bool $time Показывать время
 * @return string
 */
function date_smart($date_input, $time=false) {
    $monthes = array(
            '', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
    );
    $date = strtotime($date_input);

    //Время
    if($time) $time = ' G:i';
    else $time = '';

    //Сегодня, вчера, завтра
    if(date('Y') == date('Y',$date)) {
        if(date('z') == date('z', $date)) {
            $result_date = date('Сегодня'.$time, $date);
        } elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+1,date('Y',$date)))) {
            $result_date = date('Вчера'.$time, $date);
        } elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)-1,date('Y',$date)))) {
            $result_date = date('Завтра'.$time, $date);
        }

        if(isset($result_date)) return $result_date;
    }

    //Месяца
    $month = $monthes[date('n',$date)];

    //Года
    if(date('Y') != date('Y', $date)) $year = 'Y г.';
    else $year = '';

    $result_date = date('j '.$month.' '.$year.$time, $date);
    return $result_date;
}

/**
 * Очеловечиваем mysql дату
 *
 * @param	string	$date дата
 * @return	string	уже очеловеченная дата
 */
function human_date( $date ) {
    if( strtotime($date) == '' ) return '';
    return date( 'd.m.Y', strtotime($date) );
}

function human_date_s( $date ) {
    if( strtotime($date) == '' ) return '';
    return date( 'H:i:s d.m.Y', strtotime($date) );
}

/**
 * Отделим только дату
 *
 * @param	string	$date дата
 * @return	string	уже дата
 */
function _d( $date ) {
	$date = explode(' ', $date);
	return $date[0];
    #if( strtotime($date) == '' ) return '';
    #return date( 'm.d.Y', strtotime($date) );
}

/**
 * Отделим только время
 *
 * @param	string	$date дата
 * @return	string	уже время
 */
function _t( $date ) {
    if( strtotime($date) == '' ) return '';
    return date( 'H:i', strtotime($date) );
}

/**
 * Если первый параметр не пустой, возвращает второй
 *
 * @param string	$var1	что проверяем на пустоту
 * @param bool	$var2	что вернуть в случае пустоты
 * @return string
 */
function not_empty( $var1 = '', $var2 = '' ) {
    if( !empty($var1) ) {
        return $var1;
    }else {
        return $var2;
    }
}

/**
 * Если первый параметр пустой, то возвращает второй
 *
 * @param string	$var1	что проверяем на пустоту
 * @param bool	$var2	что вернуть в случае пустоты
 * @return string
 */
function is_empty( $var1 = '', $var2 = '' ) {
    if( empty($var1) ) {
        return $var2;
    }else {
        return $var1;
    }
}

function add_css( $file, $module='', $media='all' ) {
    $CI     = get_instance();
    if( !empty($module) ) {
        $common  = $CI->config->item('common');
        $file = $common['modules'].$module.'/css/'.$file.'.css';
    }

    $CI->template_lib->after(
            'css',
            '<link rel="stylesheet" href="'.$file.'" type="text/css" media="'.$media.'" />'."\n"
    );
}

function add_js( $file, $module='' ) {
    $CI     = get_instance();
    if( !empty($module) ) {
        $common  = $CI->config->item('common');
        $file = $common['modules'].$module.'/js/'.$file.'.js';
    }

    $CI->template_lib->after(
            'js',
            '<script language="JavaScript" type="text/javascript" src="'.$file.'"></script>'."\n"
    );
}

/**
 * Дата для mysql текущая или нужная из timestamp
 *
 * @param	int		$timestamp	временя нужное для перевода, если пусто, то текущее
 * @return	string
 */
function now2mysql( $timestamp='' ) {
    if( empty($timestamp) ) $timestamp = time();
//		$timestamp = local_to_gmt( $timestamp );
    return date( 'Y-m-d H:i:s', $timestamp );
}

function CI() {
    return get_instance();
}

function up_array( $array, $name='title', $key='id' ) {
    $data = array();
    foreach( $array as $line ) {
        $data[ $line[$key] ] = $line[ $name ];
    }
    return $data;
}

/*
 * Транслитерация и облагораживание текста
 * @param string $title
*/
function nice_title( $title ) {
    $title = trim( $title );
    $trans = array(
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l", "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya",
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E", "Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L","М"=>"M","Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y","Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh", "Ы"=>"I","Э"=>"E","Ю"=>"U","Я"=>"Ya",
            "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>""," "=>"-"," "=>"-"
    );
    $title = strtolower( strtr($title, $trans));
    $title = preg_replace( '/\W+/', '-', $title );
    $title = preg_replace( '/\s+/', '-', $title );
    $title = trim( $title, '-' );
    return $title;
}

function _plural( $numeric, $many, $one, $two ) {
    $numeric = (int) abs($numeric);
    if ( $numeric % 100 == 1 || ($numeric % 100 > 20) && ( $numeric % 10 == 1 ) ) return $one;
    if ( $numeric % 100 == 2 || ($numeric % 100 > 20) && ( $numeric % 10 == 2 ) ) return $two;
    if ( $numeric % 100 == 3 || ($numeric % 100 > 20) && ( $numeric % 10 == 3 ) ) return $two;
    if ( $numeric % 100 == 4 || ($numeric % 100 > 20) && ( $numeric % 10 == 4 ) ) return $two;
    return $many;
}

function _highlight_text( &$text, $string='', $class='yellow' ) {
    if( empty($string) ) return $text;
    $words = str_replace(' ', '|', $string);
    $words = '/(' . $words . ')/';
    $text = preg_replace( $words, '<span class="'.$class.'">$1</span>', $text );
    return $text;
}

/**
 * Сохраним наш лог действий пользователя
 *
 * @param mixed|string  $log
 * @param string        $comment
 */
function log_action( $log='', $comment='' ) {
    $site = CI()->config->item('site');
    if( !$site['log_action'] ) return;

    if( !is_string($log) ) $log = TextDump($log);
    $debug  = debug_backtrace();
    #dump( $debug );
    $user   = CI()->user_mod->get_all();
    $data = array(
            'date_at'   =>  (string)now2mysql(),
            'login'     =>  (string)$user['login'],
            'file'      =>  (string)$debug[0]['file'],
            'func'      =>  (string)$debug[1]['function'],
            'line'      =>  (string)$debug[0]['line'],
            'log'       =>  (string)$log,
            'comment'   =>  (string)$comment
    );

    CI()->log_mod->save( $data );
}

/**
 * Вычищает текст от html, css, xml, script тэгов
 *
 * @param   string $htmlText    текст который нужно вычестить
 * @return  string
 */
function strip_tags_regular($htmlText) {
    $search = array (
        "'<script[^>]*?>.*?</script>'si",  // Remove javaScript
        "'<style[^>]*?>.*?</style>'si",  // Remove styles
        "'<xml[^>]*?>.*?</xml>'si",  // Remove xml tags
        "'<[\/\!]*?[^<>]*?>'si",           // Remove HTML-tags
        "'([\r\n])[\s] '",                 // Remove spaces
        "'&ndash;'i",                 // Replace HTML special chars
        "'&mdash;'i",                 // Replace HTML special chars
        "'&raquo;'i",                 // Replace HTML special chars
        "'&laquo;'i",                 // Replace HTML special chars
        "'&(quot|#34);'i",                 // Replace HTML special chars
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d );'e"
    );                    // write as php

    $replace = array (
        "",
        "",
        "",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)"
    );

    return preg_replace($search, $replace, $htmlText);
}

/**
 * Round by the 2 digits after ,
 */
function _r( $num ){
	return sprintf('%.2f', $num);
}