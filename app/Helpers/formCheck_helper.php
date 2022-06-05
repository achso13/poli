<?php

//	BEGIN of TIME FORMAT
function time_format($the_time, $format)
{
    date_default_timezone_set('Etc/GMT-7');
    return date($format, strtotime($the_time));
}
//	END of TIME FORMAT

// 	BEGIN of SMART FORM
function selectSet($form_value, $exist_value)
{
    if ($form_value == $exist_value) {
        return ' selected="selected"';
    }
}

function checkSet($form_value, $exist_value)
{
    if (is_array($exist_value)) {
        foreach ($exist_value as $ev) {
            if ($form_value == $ev) {
                return ' checked="checked"';
                //break;
            }
        }
    } else {
        if ($form_value == $exist_value) {
            return ' checked="checked"';
        }
    }
}

function radioSet($form_value, $exist_value)
{
    if ($form_value == $exist_value) {
        return ' checked="checked"';
        //break;
    }
}
//	END of SMART FORM 
