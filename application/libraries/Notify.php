<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notify
{
    public function sendPushNotification($registration_ids, $title, $body, $id = null, $action = null)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = [
            'authorization: key=AAAATaTy5Fs:APA91bF9PnFynhl2wtTbsHlLa2jI2Lpw_D2u7fqP0wHu2wmVzqibHuGSv3tTLu43a7GOWWCDmMxltGtH80ZOYeXbdtdhCwhaCZTtA4kD-JenMZedchzPQ0k3zay68ZkUbRV2yzpiJdKr',
            'content-type: application/json'
        ];

        $notification = [
            'title' => $title,
            'body' => $body
        ];
        $extraNotificationData = ["message" => $notification, "id" => $id, 'action' => $action];

        $fcmNotification = [
            'registration_ids' => $registration_ids,
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;


        //     $curl = curl_init();

        //     $registration_ids = '[
        //         "eP-U2clfc7Y:APA91bH34h7-XBOkw3JWEIQFIKwEGCBH8MIhlysGYkff_n85keZz7nRkvfYATp5AJ42YDDK_8BeXd4dLmHQLAXJ_oSAHN_il8IDgNA8UcupjXQ0z7BQv2sVLB1GLm7SD8tyRI5yFxsGe",
        //         "eUVrhhHoOs8:APA91bE3P0siplYktnUUMY-VGIv6eTqB_VM5mYvW8WsXY4bkw8e7lfJn5mYu0GJhiBK0oi79RQ7L2_lOary4QXKstuIIF9hfn6BFUr9r41gHDxltcC-y2N7Fj_HHXWHC_lI6F08lKJXd"
        //     ]';

        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => "POST",
        //         CURLOPT_POSTFIELDS => '{
        //     "registration_ids": ' . $registration_ids . ',
        //     "notification": {
        //         "title": "' . $title . '",
        //         "body": "' . $body . '"
        //     }
        // }',
        //         CURLOPT_HTTPHEADER => array(
        //             "content-type: application/json",
        //             "authorization: key=AAAATaTy5Fs:APA91bF9PnFynhl2wtTbsHlLa2jI2Lpw_D2u7fqP0wHu2wmVzqibHuGSv3tTLu43a7GOWWCDmMxltGtH80ZOYeXbdtdhCwhaCZTtA4kD-JenMZedchzPQ0k3zay68ZkUbRV2yzpiJdKr"
        //         ),
        //     ));

        //     $response = curl_exec($curl);
        //     curl_close($curl);
        //     echo $response;
    }
}
