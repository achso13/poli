<?php

/**
 * Function used to generate custom id for primary key
 *
 * @param object $model
 * @param string $field
 * @param string $prefix
 * @param int $length total length of id
 * @return string
 */
function generateId($model, $field, $prefix, $length)
{
    $lastId = $model->selectMax($field)->get()->getRowArray();
    $lastId = $lastId[$field];
    if ($lastId) {
        $lastId = substr($lastId, strlen($prefix) + 1);
        $lastId = (int) $lastId;
        $lastId++;
    } else {
        $lastId = 1;
    }

    $zeroLength = $length - (strlen($prefix) + 1);
    return $prefix . "-" . str_pad($lastId, $zeroLength, '0', STR_PAD_LEFT);
}
