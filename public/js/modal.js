// Função para abrir o modal com o ID correto
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.style.display = 'block';
}

// Adicione o evento de clique a todos os botões
const buttons = document.querySelectorAll('button[id^="meuBotao"]');
buttons.forEach((button) => {
  const modalId = button.id.replace('meuBotao', 'meuModal');
  button.addEventListener('click', () => openModal(modalId));
});

// Fechar o modal quando o botão Fechar (X) ou área externa é clicado
const modals = document.querySelectorAll('.modal');
modals.forEach((modal) => {
  const closeModalButton = modal.querySelector('.fechar');
  closeModalButton.addEventListener('click', () => {
      modal.style.display = 'none';
  });
  window.addEventListener('click', (event) => {
      if (event.target === modal) {
          modal.style.display = 'none';
      }
  });
});