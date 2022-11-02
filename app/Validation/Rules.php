<?php

namespace App\Validation;

use Config\Database;

class Rules
{
    /**
     * Validate if the given jadwal dokter day is the same as given date day.
     * 
     * @param string $str
     * @param string $id
     * @param array $data
     * @param string $error
     * @return bool
     */
    public function same_days(string $str = null, string $id, array $data, string &$error = null): bool
    {
        // Get hari from id_jadwal_dokter
        $db = Database::connect($data['DBGroup'] ?? null);
        $row = $db->table('tb_jadwal_dokter')
            ->select('hari')
            ->where('id_jadwal_dokter', $id)
            ->limit(1);

        $result = $row->get()->getRow();

        if ($result == null) {
            return true;
        }

        $day = $result->hari;

        $dayName = $day;

        // Format day to number
        $days = [
            'Minggu' => 0,
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
        ];
        $day = $days[$day];
        $date = date('N', strtotime($str));

        if ($date == $day) {
            return true;
        }

        $error = lang("Hanya bisa memilih tanggal di hari $dayName sesuai jadwal dokter yang dipilih", ['days' => $day]);
        return false;
    }
}
