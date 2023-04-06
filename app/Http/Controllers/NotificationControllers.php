<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationControllers extends Controller
{

function getNotify () {
   // inisialisasi koneksi cURL
$ch = curl_init();

// set opsi koneksi cURL
curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: key=YOUR_API_KEY",
    "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

// set data notifikasi
$data = array(
    "to" => "FCM_TOKEN",
    "notification" => array(
        "title" => "Judul Notifikasi",
        "body" => "Isi Notifikasi"
    ),
    "data" => array(
        "key1" => "value1",
        "key2" => "value2"
    )
);
$json_data = json_encode($data);

// tambahkan data notifikasi ke permintaan
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

// eksekusi permintaan notifikasi
$result = curl_exec($ch);

// tampilkan respons dari server
echo $result;

// tutup koneksi cURL
curl_close($ch);

}
}