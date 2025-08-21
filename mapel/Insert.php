<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include ("../connect.php");

    $input = json_decode(file_get_contents("php://input"));
    

    if (isset($input) && !empty($input->name) && !empty($input->deskripsi) && !empty($input->guru)){
        $name = $input->name;
        $deskripsi = $input->deskripsi;
        $guru = $input->guru;
       
        $mapel = $connect->query("INSERT INTO mata_pelajaran (name, deskripsi, guru) VALUES ('$name', '$deskripsi', '$guru')");

        http_response_code(200);
        
        $array = [
            'status' => 201,
            'message' => 'success insert data'
        ];

        
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