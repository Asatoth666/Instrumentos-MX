// Contador de visitas (simulado con localStorage)
const contadorVisitas = document.getElementById('contador-visitas');
let visitas = localStorage.getItem('visitas') || 0;
visitas++;
localStorage.setItem('visitas', visitas);
contadorVisitas.textContent = visitas;