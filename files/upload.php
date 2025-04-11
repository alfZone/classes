<?php
$targetDir = "uploads/";

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true); // cria a pasta se não existir
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileName = basename($_FILES['file']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($fileTmp, $targetFile)) {
            echo json_encode(["message" => "Upload feito com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao mover o arquivo."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Nenhum arquivo enviado ou erro no upload."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido."]);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $fileName = "arquivo_recebido.bin"; // você pode definir dinamicamente se quiser
    $targetFile = $targetDir . $fileName;

    $putData = fopen("php://input", "rb");
    $outFile = fopen($targetFile, "wb");

    if ($putData && $outFile) {
        while ($chunk = fread($putData, 1024)) {
            fwrite($outFile, $chunk);
        }
        fclose($putData);
        fclose($outFile);
        echo json_encode(["message" => "Upload via PUT concluído com sucesso!"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao processar o arquivo."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido."]);
}
?>
