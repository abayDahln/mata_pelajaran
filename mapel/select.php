<?php 


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    include("../connect.php");

    if (isset($_GET['id'])){
        if ($_GET['id'] == ""){

            http_response_code(400);

            $array =[
                'status' => 400,
                'message' => 'bad request'
            ];
        }
        else{

            $id = $_GET['id'];
            $mapel = $connect->query("SELECT * FROM mata_pelajaran WHERE id = '$id'");
            $data = $mapel->fetch_assoc();
            if ($data == null){
                http_response_code(404);
                $array  = [
                    'status' => 404,
                    'message' => 'not found'

                ];
            }
            else {


                http_response_code(200);

                
                
                $array = [
                    'status' => 200,
                    'message' => 'success',
                    'data' => $data
                ];
            }
        }
        
    }
    else {
        $get = $connect->query("SELECT * FROM mata_pelajaran");
        $data = $get->fetch_all(MYSQLI_ASSOC);

        http_response_code(200);
        $array = [
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ];
    }


}
else {
    http_response_code(405);

    $array =[
        'status' => 405,
        'message' => 'method not allowed'
    ];
}

echo json_encode($array);

?>