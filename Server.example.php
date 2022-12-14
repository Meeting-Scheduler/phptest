<?php
/**
 * @author Amir Sanni <amirsanni@gmail.com>
 * @date 4th November 2019
 */

class Server
{
    public function index()
    {
        $servers = $this->getIceServers();

        header('Content-Type: Application/json');
        
        echo json_encode(json_decode($servers)->v->iceServers);
    }


    private function getIceServers()
    {
        // PHP Get ICE STUN and TURN list
        $data = ["format"=>"urls"];
        $json_data = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Content-Length: " . strlen($json_data)],
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_URL => "https://global.xirsys.net/_turn/MyFirstApp",//Replace 'YOUR-CHANNEL-NAME' with the name of your xirsys channel
            CURLOPT_USERPWD => "meetingschedulerteam:33b32a80-17f9-11ed-82a3-0242ac130003",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => TRUE
        ]);

        $res = curl_exec($curl);
        
        if(curl_error($curl)){
            echo "Curl error: " . curl_error($curl);
        };

        curl_close($curl);
        
        return $res;
    }
}


$server = new Server;

$server->index();