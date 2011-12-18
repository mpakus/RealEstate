<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Хэлпер для работы с данными приходящими от пользователя
 * администрирования наполнения
 * 
 * @version 2.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2009-2012, AOmega.ru
 */

/**
* Взять реверсивные параметры из post или model('request') запроса
* по умолчанию фильтруется сразу же XSS и html теги
*
* @param string	$name		название параметра
* @param bool	$clean		флаг очистки от XSS
* @param bool	$clean_html	флаг очистки от html ntujd
* @return string
*/
function rparam($name, $xss = TRUE, $clean_html = TRUE  ){
    return CI()->request_mod->param( $name, $xss, $clean_html, TRUE );
}

/**
* Взять параметры из post или model('request') запроса
* по умолчанию фильтруется сразу же XSS и html теги
*
* @param string	$name		название параметра
* @param bool	$clean		флаг очистки от XSS
* @param bool	$clean_html	флаг очистки от html ntujd
* @return string
*/
function param($name, $xss = TRUE, $clean_html = TRUE  ){
    return CI()->request_mod->param( $name, $xss, $clean_html );
}

/**
* Взять реверсивне параметры c помощью функции param для целого массива
* по умолчанию фильтруется сразу же XSS и html теги
*
* @param array	$params		массив названий нужных параметров
* @param bool	$xss		флаг очистки от XSS
* @param bool	$clean_html	флаг очистки от html ntujd
* @return array
*/
function rparams( $params, $xss = TRUE, $clean_html = FALSE ){
    if( !is_array($params) ){
        return CI()->request_mod->param( $params, $xss, $clean_html, TRUE );
    }else{
        return CI()->request_mod->params( $params, $xss, $clean_html, TRUE );
    }
}

/**
* Взять параметры c помощью функции param для целого массива
* по умолчанию фильтруется сразу же XSS и html теги
*
* @param array	$params		массив названий нужных параметров
* @param bool	$xss		флаг очистки от XSS
* @param bool	$clean_html	флаг очистки от html ntujd
* @return array
*/
function params( $params, $xss = TRUE, $clean_html = FALSE ){
    if( is_array($params) ){
        return CI()->request_mod->params( $params, $xss, $clean_html );
    }elseif( is_string($params) ){
        return CI()->request_mod->params( $params, $xss, $clean_html );
    }
    return '';
}


/**
* Проверяет откуда нас вызвали из ajax или нет
*
* @param	void
* @return	void
*/
function is_ajax(){
    return get_instance()->model('request')->ajax;
}


/**
* Перевод строки из windows-1251 в кодировку utf8
*
* @param string $string
* @return mixed
*/
function win2utf( $string = '' ){
    if( empty($string) ) return $string;
    return iconv( 'WINDOWS-1251', 'UTF-8', $string );
}
function utf2win( $string = '' ){
    if( empty($string) ) return $string;
    return iconv( 'UTF-8', 'WINDOWS-1251', $string );
}

/**
 * Разобьем CSV строку
 *
 * @param  string $line
 * @param  string $glue
 * @return array
 */
function explode_csv( $line, $glue = ';' ){
    $row = explode( $glue, trim($line) );
    for( $i=0; $i<count($row); $i++ ){
        $row[$i] = trim( $row[$i], '"' );
    }
    return $row;
}