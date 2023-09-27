<div class="modal fade" id="document-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content document-modal-body">
            <div class="document-modal-content" id="documentModalContent" style="max-height: 80vh; overflow-y: auto;">
                <div id="fileViewer"></div>
            </div>
            <div class="div-modal-vertical" style="background: black"></div>
            <div class="document-modal-information">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel">Informações</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <ul class="file-info">
                    <li class="preview-item"><b>Nome</b>
                        <p id="file-name"></p>
                    </li>
                    <li class="preview-item"><b>Cliente</b>
                        <p id="file-cliente"></p>
                    </li>
                    <li class="preview-item"><b>Última modificação</b>
                        <p id="file-updated"></p>
                    </li>
                    <li class="preview-item"><b>Comentários</b>
                        <p id="file-description"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function openDocumentModal(data) {
        console.log(data);
        $('#document-modal').modal('show')
        previewDocumentModalFill(data);
    }

    function previewDocumentModalFill(data) {
        displayFile(data.path);

        $(".preview-item #file-cliente").text(data.cliente);
        $(".preview-item #file-folder").text(data.folder);
        $(".preview-item #file-name").text(data.name);
        $(".preview-item #file-description").text(data.description);
        $(".preview-item #file-updated").text(data.updatedAt);
        $(".preview-item #file-size").text(data.size);
        $(".preview-item #file-extension").text(data.file.split('.')[1]);
    }

    function displayFile(fileURL) {
        const fileViewer = document.getElementById('fileViewer');
        const fileExtension = fileURL.split('.').pop().toLowerCase();

        if (fileExtension === 'pdf' ||
            fileExtension === 'doc' ||
            fileExtension === 'docx' ||
            fileExtension === 'xls' ||
            fileExtension === 'xlsx' ||
            fileExtension === 'ppt' ||
            fileExtension === 'pptx') {
            document.getElementById('documentModalContent').style.overflow = 'hidden';

            fileViewer.innerHTML = `<iframe src="${fileURL}" width="100%" height="500px"></iframe>`;
        } else if (fileExtension === 'jpg' ||
            fileExtension === 'jpeg' ||
            fileExtension === 'png' ||
            fileExtension === 'gif' ||
            fileExtension === 'bmp') {
            // Exibir imagens
            fileViewer.innerHTML = `<img src="${fileURL}" alt="Imagem" width: '100%'>`;
        } else if (fileExtension === 'txt' ||
            fileExtension === 'csv' ||
            fileExtension === 'xml') {
            // Exibir texto - aqui você pode fazer uma solicitação para o arquivo de texto e exibir o conteúdo
            fetch(fileURL)
                .then(response => response.text())
                .then(data => {
                    fileViewer.innerText = data;
                })
                .catch(error => {
                    console.error(error);
                });
        } else if (fileExtension === 'mp3' ||
            fileExtension === 'wav' ||
            fileExtension === 'mp4' ||
            fileExtension === 'avi') {
            // Exibir áudio e vídeo
            fileViewer.innerHTML = `<video controls width="100%"><source src="${fileURL}" type="video/mp4"></video>`;
        } else {
            // Tipo de arquivo não suportado
            fileViewer.innerText = 'Tipo de arquivo não suportado.';
        }
    }
</script>