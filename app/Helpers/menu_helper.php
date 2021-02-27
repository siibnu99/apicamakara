<?php

use Faker\Guesser\Name;

function jenisTryout($id = null)
{
    $data = [
        ['SAINTEK', 1],
        ['SOSHUM', 2,]
    ];
    if ($id) {
        return $data[$id - 1][0];
    }
    return $data;
}
function catTryout($id = null)
{
    $data = [
        ['Tryout UTBK', 1],
        ['Tryout Bebas', 2],
        ['Tryout Lama', 3],
    ];
    if ($id == '0') {
        return 'Tidak terkategori';
    }
    if ($id) {
        return $data[$id - 1][0];
    }
    return $data;
}
function paymentMethod($id = null)
{
    $data = [
        ['Gratis', 1],
        ['Berbayar', 2],
        ['Bebas', 3],
    ];
    if ($id) {
        return $data[$id - 1][0];
    }
    return $data;
}
function catTryoutChecked($arr, $x)
{
    foreach ($arr as $item) {
        if ($item == $x) {
            return 'checked';
        }
    }
}
function mapel($type, $arr)
{
    if ($type == 1) {
        $data = [
            ['Penalaran Umum', $arr['q_penalaran'], $arr['t_penalaran'], 'q_penalaran'],
            ['Pemahamnan Bacaan dan Menulis', $arr['q_pemahaman'], $arr['t_pemahaman'], 'q_pemahaman'],
            ['Pengetahuan dan Pemahaman Umum', $arr['q_pengetahuan'], $arr['t_pengetahuan'], 'q_pengetahuan'],
            ['Pengetahuan Kuantitatif', $arr['q_pengetahuank'], $arr['t_pengetahuank'], 'q_pengetahuank'],
            ['Kimia', $arr['q_kimia'], $arr['t_kimia'], 'q_kimia'],
            ['Fisika', $arr['q_fisika'], $arr['t_fisika'], 'q_fisika'],
            ['Biologi', $arr['q_biologi'], $arr['t_biologi'], 'q_biologi'],
            ['Matematika', $arr['q_matematika'], $arr['t_matematika'], 'q_matematika'],
        ];
        return $data;
    } else if ($type == 2) {
        $data = [
            ['Penalaran Umum', $arr['q_penalaran'], $arr['t_penalaran'], 'q_penalaran'],
            ['Pemahamnan Bacaan dan Menulis', $arr['q_pemahaman'], $arr['t_pemahaman'], 'q_pemahaman'],
            ['Pengetahuan dan Pemahaman Umum', $arr['q_pengetahuan'], $arr['t_pengetahuan'], 'q_pengetahuan'],
            ['Pengetahuan Kuantitatif', $arr['q_pengetahuank'], $arr['t_pengetahuank'], 'q_pengetahuank'],
            ['Sejarah', $arr['q_sejarah'], $arr['t_sejarah'], 'q_sejarah'],
            ['Geografi', $arr['q_geografi'], $arr['t_geografi'], 'q_geografi'],
            ['Sosiologi', $arr['q_sosiologi'], $arr['t_sosiologi'], 'q_sosiologi'],
            ['Ekonomi', $arr['q_ekonomi'], $arr['t_ekonomi'], 'q_ekonomi'],
        ];
        return $data;
    }
}
