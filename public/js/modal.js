
function openUserModal(data) {
  $('#edit-user-modal').modal('show')
  editUserModalFill(data);
}

function editUserModalFill(data) {
  if (!data.id) {
    const title = document.getElementById('editUserTitle');
    title.innerHTML = "Adicionar usuário";
    $(".modal-body #edit-user-id").val(null);
    $(".modal-body #edit-user-name").val(null);
    $(".modal-body #edit-user-cnpj").val(null);
    $(".modal-body #edit-user-role").val(null);
    $(".modal-body #edit-user-password").val(null);
    $(".modal-body #edit-user-password-confirm").val(null);
    $(".modal-body #disablePasswordFields").prop("checked", true);     
    $("#disablePasswordsDiv").hide();
    disablePasswordChange(document.getElementById("disablePasswordFields"));

  } else {
    const title = document.getElementById('editUserTitle');
    title.innerHTML = `Editar usuário ${data.name}`;
    $(".modal-body #edit-user-id").val(data.id);
    $(".modal-body #edit-user-name").val(data.name);
    $(".modal-body #edit-user-cnpj").val(data.cnpj);
    $(".modal-body #edit-user-role").val(data.role);
    $(".modal-body #edit-user-password").val(null);
    $(".modal-body #edit-user-password-confirm").val(null);
    $(".modal-body #disablePasswordFields").prop("checked", false);
    disablePasswordChange(document.getElementById("disablePasswordFields"));

    $("#disablePasswordsDiv").show();
  }

  var select = document.getElementById("edit-folder-parent-folder");

  for (var i = 0; i < select.options.length; i++) {
    if(select.options[i].value !== ""){
      if (select.options[i].value === data.id) {
        select.options[i].disabled = true;
        select.options[i].style.display = "none";
      }else{
        select.options[i].disabled = false;
        select.options[i].style.display = "block";
      }
    }
  }
}

function openFolderModal(data) {
  $('#edit-folder-modal').modal('show');
  editFolderModalFill(data);
}

function editFolderModalFill(data) {
  if (!data.id) {
    const title = document.getElementById('editFolderTitle');
    title.innerHTML = `Adicionar pasta para ${data.cliente}`;
    $(".modal-body #edit-folder-id").val(null);
    $(".modal-body #edit-folder-name").val(null);
    $(".modal-body #edit-folder-clienteId").val(data.clienteId);
    $(".modal-body #edit-folder-parent-folder").val(data.parentFolderId);
  } else {
    const title = document.getElementById('editFolderTitle');
    title.innerHTML = `Editar pasta ${data.name}`;
    $(".modal-body #edit-folder-name").val(data.name);
    $(".modal-body #edit-folder-id").val(data.id);
    $(".modal-body #edit-folder-clienteId").val(data.clienteId);
    $(".modal-body #edit-folder-parent-folder").val(data.parentFolderId);
  }

  var select = document.getElementById("edit-folder-parent-folder");

  for (var i = 0; i < select.options.length; i++) {
    if(select.options[i].value !== ""){
      if (select.options[i].value === data.id) {
        select.options[i].disabled = true;
        select.options[i].style.display = "none";
      }else{
        select.options[i].disabled = false;
        select.options[i].style.display = "block";
      }
    }
  }
}


function openFileModal(data) {
  $('#edit-file-modal').modal('show')
  editFileModalFill(data);
}

function editFileModalFill(data) {
  if (!data.id) {
    console.log(1)
    const title = document.getElementById('editFileTitle');
    title.innerHTML = `Adicionar arquivo para ${data.clienteName}`;
    $(".modal-body #edit-file-id").val(null);
    $(".modal-body #edit-file-description").val(null);
    $(".modal-body #edit-file-name").val(null);
    $(".modal-body #edit-file-file").val(null);
    $(".modal-body #edit-file-clienteId").val(data.clienteId);
    $(".modal-body #edit-file-folder").val(data.folderId);
  } else {
    const title = document.getElementById('editFileTitle');
    title.innerHTML = `Editar arquivo ${data.name}`;
    $(".modal-body #edit-file-id").val(data.id);
    $(".modal-body #edit-file-clienteId").val(data.clienteId);
    $(".modal-body #edit-file-name").val(data.name);
    $(".modal-body #edit-file-folder").val(data.folderId);
    $(".modal-body #edit-file-description").val(data.description);
    $(".modal-body #edit-file-file").val(data.file);
  }
}

// function openDocumentModal(data) {
//   console.log(data);
//   $('#document-modal').modal('show')
//   previewDocumentModalFill(data);
// }

// function previewDocumentModalFill(data) {
//   const fileExtensions = [
//     "pdf",
//     "doc",
//     "docx",
//     "xls",
//     "xlsx",
//     "ppt",
//     "pptx",
//     "jpg",
//     "jpeg",
//     "png",
//     "gif",
//     "bmp",
//     "txt",
//     "csv",
//     "xml",
//     "mp3",
//     "wav",
//     "mp4",
//     "avi"
//   ];
//   if (!data.file || !fileExtensions.includes(data.file.split('.')[1])) {
//     alert("Visualização não disponível");
//   } else {
    
//     const embed = document.getElementById('view-document');
//     const fileViewer = new Viewer({file: data.file});
//     fileViewer.render();
//   }
// }
