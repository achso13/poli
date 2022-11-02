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
    $prefix = $prefix . "-";
    $zeroLength = $length - (strlen($prefix));
    return $prefix . str_pad($lastId, $zeroLength, '0', STR_PAD_LEFT);
}

function generateAppointmentId($model, $field, $prefix, $length, $date, $type = NULL)
{
    // Look for existing appointment id with date
    $lastId = $model->selectMax($field)->where('tanggal_kunjungan', $date)->get()->getRowArray();
    $lastId = $lastId[$field];

    if ($type === 'Online') {
        $prefix = $prefix . "02";
    } else {
        $prefix = $prefix . "01";
    }

    if ($lastId) {
        $lastId = substr($lastId, strlen($prefix . date('dmY', strtotime($date))));
        $lastId = (int) $lastId;
        $lastId++;
    } else {
        $lastId = 1;
    }

    $prefix = $prefix . date('dmY', strtotime($date));
    $zeroLength = $length - (strlen($prefix));

    $id = $prefix . str_pad($lastId, $zeroLength, '0', STR_PAD_LEFT);
    return $id;
}
