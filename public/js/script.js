const areasContainer = document.querySelector('.areas-container');
let isDragging1 = false;
let startX1 = 0;
let scrollLeft1 = 0;

areasContainer.addEventListener('mousedown', (e) => {
  isDragging1 = true;
  startX1 = e.pageX - areasContainer.offsetLeft;
  scrollLeft1 = areasContainer.scrollLeft;
  areasContainer.style.cursor = 'grabbing';
});

document.addEventListener('mouseup', () => {
  isDragging1 = false;
  areasContainer.style.cursor = 'grab';
});

document.addEventListener('mousemove', (e) => {
  if (!isDragging1) return;
  e.preventDefault();
  const x = e.pageX - areasContainer.offsetLeft;
  const walk = (x - startX1) * 2; // Ajuste a velocidade da rolagem aqui
  areasContainer.scrollLeft = scrollLeft1 - walk;
});


const servicosContainer = document.querySelector('.servicos-container');
let isDragging2 = false;
let startX2 = 0;
let scrollLeft2 = 0;

servicosContainer.addEventListener('mousedown', (e) => {
  isDragging2 = true;
  startX2 = e.pageX - servicosContainer.offsetLeft;
  scrollLeft2 = servicosContainer.scrollLeft;
  servicosContainer.style.cursor = 'grabbing';
});

document.addEventListener('mouseup', () => {
  isDragging2 = false;
  servicosContainer.style.cursor = 'grab';
});

document.addEventListener('mousemove', (e) => {
  if (!isDragging2) return;
  e.preventDefault();
  const x = e.pageX - servicosContainer.offsetLeft;
  const walk = (x - startX2) * 2; // Ajuste a velocidade da rolagem aqui
  servicosContainer.scrollLeft = scrollLeft2 - walk;
});


const clientesContainer = document.querySelector('.clientes-container');
let isDragging3 = false;
let startX3 = 0;
let scrollLeft3 = 0;

clientesContainer.addEventListener('mousedown', (e) => {
  isDragging3 = true;
  startX3 = e.pageX - clientesContainer.offsetLeft;
  scrollLeft3 = clientesContainer.scrollLeft;
  clientesContainer.style.cursor = 'grabbing';
});

document.addEventListener('mouseup', () => {
  isDragging3 = false;
  clientesContainer.style.cursor = 'grab';
});

document.addEventListener('mousemove', (e) => {
  if (!isDragging3) return;
  e.preventDefault();
  const x = e.pageX - clientesContainer.offsetLeft;
  const walk = (x - startX3) * 2; // Ajuste a velocidade da rolagem aqui
  clientesContainer.scrollLeft = scrollLeft3 - walk;
});
