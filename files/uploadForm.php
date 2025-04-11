<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<input type="file" id="fileInput">
<button id="uploadButton">Fazer Upload</button>
</body>

<script>

const uploadFile1 = async () => {
    const fileInput = document.querySelector("#fileInput");
    const file = fileInput.files[0];

    if (!file) {
        console.error("Nenhum arquivo selecionado!");
        return;
    }

    const formData = new FormData();
    formData.append("file", file);

    try {
        const response = await fetch("https://galeria.esmonserrate.org/classes/files/upload.php", {
            method: "POST",
            body: formData,
        });

        if (!response.ok) throw new Error("Erro ao fazer upload");

        const result = await response.json();
        console.log("Sucesso:", result);
    } catch (error) {
        console.error("Erro:", error);
    }
};


    const uploadFile = async () => {
        alert("Fazendo upload do arquivo...");
        const fileInput = document.querySelector("#fileInput");
        const file = fileInput.files[0];

        if (!file) {
            console.error("Nenhum arquivo selecionado!");
            return;
        }

        try {
            const response = await fetch("https://galeria.esmonserrate.org/classes/files/upload.php", {
                method: "PUT",
                headers: {
                    "Content-Type": file.type, // Define o tipo de conteúdo
                },
                body: file, // Envia o arquivo diretamente
            });

            if (!response.ok) throw new Error("Erro ao fazer upload");

            const result = await response.json();
            console.log("Sucesso:", result);
        } catch (error) {
            console.error("Erro:", error);
        }
    };
    
    document.querySelector("#uploadButton").addEventListener("click", uploadFile);
</script>
    
</html>
