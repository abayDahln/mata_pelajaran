<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    

    if (isset($_GET['id'])){
        if ($_GET['id'] != ""){
            $id = $_GET['id'];
            $mapel = $connect->query("SELECT * FROM mata_pelajaran WHERE id = '$id'");
            $data = $mapel->fetch_assoc();
            if ($data != null){
                $del = $connect->query("DELETE From mata_pelajaran WHERE id = '$id'");

                http_response_code(200);
                $array = [
                    'status' => 200,
                    'message' => 'delete success'
                ];
            }
            else {
                http_response_code(404);
                $array = [
                    'status' => 404,
                    'message' => 'not found'
                ];
            }

        }
        else {
            http_response_code(400);
            $array = [
                'status' => 400,
                'message' => 'bad request'
            ];
        }
    }
    else {
        http_response_code(400);
        $array = [
            'status' => 400,
            'message' => 'bad request'
        ];    
    }

}
else {
    http_response_code(405);
    $array = [
        'status' => 405,
        'message' => 'method not allowed'
    ];
}

echo json_encode($array);

?>