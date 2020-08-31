<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function getZingMp3(Request $request)
    {
        if ($request->link == null) {
            return view('zingmp3')->with([
                'data' => null,
                'link' => null,
            ]);
        }
        
        $url = $request->link;
        $mobileURL = "";
        if (strpos($url, "//zingmp3")) {
            $cut = explode('//zingmp3', $url);
            $mobileURL = $cut[0] . "//m.zingmp3" . $cut[1];
        } else {
            $mobileURL = $url;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mobileURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $data = explode("\n", $response);
        $preURL = "";
        foreach ($data as $value) {
            if (strpos($value, "/media/get-source?type=audio&key=")) {
                $preURL = $value;
                break;
            }
        }

        $preURL = explode('" data-id=', explode('data-source="', $preURL)[1])[0];
        $url = "https://m.zingmp3.vn/xhr" . $preURL;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $data = curl_exec($curl);
        curl_close($curl);
        
        $quality = 128;
        $json = json_decode($data);
        $mp3 = "http://vnso-zn-23-tf-" . str_replace("//", "", $json->data->source->$quality);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $json->data->lyric,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $lyric = curl_exec($curl);
        curl_close($curl);

        $lyric = str_replace("\r\n", "<br>", $lyric);

        return view('zingmp3')->with([
            'data' => $json,
            'download' => $mp3,
            'lyric' => $lyric,
            'link' => $request->link,
        ]);
    }
}
