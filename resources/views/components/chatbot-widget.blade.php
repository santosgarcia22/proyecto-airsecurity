<style>
#chatbot-widget {
    position: fixed;
    bottom: 80px;
    right: 40px;
    width: 420px;
    max-height: 400px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 9999;
    border: 1px solid #007bff;
    font-family: Arial, sans-serif;
}

#chatbot-header {
    background: #007bff;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
}

#chatbot-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    font-size: 16px;
    height: 350px;
}

#chatbot-buttons {
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    justify-content: flex-start;
}

#chatbot-buttons button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

#chatbot-buttons button:hover {
    background-color: #0056b3;
}

#chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #007bff;
    color: white;
    width: 50px;
    height: 50px;
    font-size: 22px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

<style>
/* Igual que antes, omito estilos para enfocarnos en la lógica */

#chatbot-messages div {
    margin-bottom: 5px;
}
</style>


<!-- Botón flotante -->
<button id="chatbot-toggle">💬</button>

<!-- Widget de chatbot -->
<!-- Widget de chatbot -->
<div id="chatbot-widget">
  <div id="chatbot-header">Asistente Virtual</div>
  <div id="chatbot-messages"></div>
  <div id="chatbot-buttons"></div>
  <div id="chatbot-input-container" style="display:none; padding: 10px;">
    <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." style="width: 70%; padding: 6px;" />
    <button onclick="procesarEntrada()" style="padding: 6px 10px; margin-left: 5px;">Enviar</button>
  </div>
</div>


<script>
let currentNode = null;
let inicioMostrado = false;
let botonInicialMostrado = false;

document.getElementById('chatbot-input-container').style.display = 'block';
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('chatbot-toggle');
    const widget = document.getElementById('chatbot-widget');

    toggle.addEventListener('click', () => {
        const visible = widget.style.display === 'flex';
        widget.style.display = visible ? 'none' : 'flex';

        if (!visible && !inicioMostrado) {
            iniciarConversacion();
            inicioMostrado = true;
        }
    });
});

function iniciarConversacion() {
    const mensajes = document.getElementById('chatbot-messages');
    const botones = document.getElementById('chatbot-buttons');

    mensajes.innerHTML = '';
    botones.innerHTML = '';
    currentNode = null;
    botonInicialMostrado = false;

    mostrarBotonInicial();
}

function mostrarBotonInicial() {
    if (botonInicialMostrado) return;

    const botones = document.getElementById('chatbot-buttons');
    const btn = document.createElement('button');
    btn.innerText = '¿Sobre qué tema necesitas ayuda?';
    btn.onclick = () => {
        agregarMensaje('¿Sobre qué tema necesitas ayuda?', 'Tú'); // ✅ Solo usuario
        agregarMensaje('Selecciona una opción:', 'Bot');
        botones.innerHTML = ''; // ✅ elimina el botón después del clic
        cargarOpciones(1);
    };

    botones.appendChild(btn);
    botonInicialMostrado = true;
}



function cargarOpciones(parentId) {
    fetch(`/chatbot/opciones?parent_id=${parentId ?? ''}`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('chatbot-buttons');
            container.innerHTML = "";

            let finales = data.filter(op => op.es_final && !op.texto.startsWith('http'));
            let opciones = data.filter(op => !op.es_final || op.texto.startsWith('http'));

            // Mostrar mensajes finales como texto del Bot
            finales.forEach(op => {
                agregarMensaje(op.texto, 'Bot');
            });

            // Mostrar botones para opciones
            opciones.forEach(op => {
                const btn = crearBoton(
                    op.texto.startsWith('http') ? 'Contactar por WhatsApp' : op.texto,
                    () => {
                        agregarMensaje(op.texto.startsWith('http') ? 'Contactar por WhatsApp' : op
                            .texto, 'Tú');
                        if (op.texto.startsWith('http')) {

                            window.open(op.texto, '_blank');

                            const numero = "50378239293";
                            const mensaje = "Hola, necesito ayuda con mi reserva.";
                            const url = 'htts://wa.me/${numero}?text=${encodeURIComponent(mensaje)}';
                            window.open(url, "_blank");

                        } else {
                            seleccionarOpcion(op);
                        }
                    }
                );
                container.appendChild(btn);
            });

            // Si no hay más opciones, mostrar botón para reiniciar
            if (finales.length === 0 && opciones.length === 0) {
                agregarMensaje('No hay opciones disponibles para continuar.', 'Bot');
                mostrarReinicio();
            } else if (opciones.length === 0) {
                mostrarReinicio();
            }
        })
        .catch(err => console.error('Error al cargar opciones:', err));
}



function seleccionarOpcion(opcion) {
  //  agregarMensaje(opcion.texto, 'Tú');
    const botones = document.getElementById('chatbot-buttons');
    botones.innerHTML = '';

    if (opcion.es_final) {
        // Si es final, no buscamos más hijos, solo mostramos el mensaje final
        fetch(`/chatbot/mensaje-final/${opcion.id}`)
            .then(res => res.json())
            .then(data => {
                const respuestas = Array.isArray(data.mensaje) ? data.mensaje : [data.mensaje];
                respuestas.forEach(mensaje => agregarMensaje(mensaje, 'Bot'));
                mostrarReinicio();
            });
    } else {
        // Buscar hijos
        fetch(`/chatbot/opciones?parent_id=${opcion.id}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    agregarMensaje('Estas son las opciones disponibles:', 'Bot');
                    currentNode = opcion.id;
                    cargarOpciones(opcion.id);
                } else {
                    // Si no hay hijos y no es final, tratamos como final
                    agregarMensaje('No hay opciones disponibles para continuar.', 'Bot');
                    mostrarReinicio();
                }
            });
    }
}


function crearBoton(texto, accion) {
    const btn = document.createElement('button');
    btn.innerText = texto;
    btn.onclick = accion;
    return btn;
}

function agregarMensaje(mensaje, remitente) {
    const chat = document.getElementById('chatbot-messages');
    const div = document.createElement('div');
    div.innerHTML = `<strong>${remitente}:</strong> ${mensaje}`;
    chat.appendChild(div);
    chat.scrollTop = chat.scrollHeight;
}

function mostrarReinicio() {
    const container = document.getElementById('chatbot-buttons');
    container.innerHTML = '';
    const btn = crearBoton('Volver al inicio', () => {
        inicioMostrado = false;
        iniciarConversacion();
    });
    container.appendChild(btn);
}

function procesarEntrada() {
    const input = document.getElementById('chatbot-input');
    const mensaje = input.value.trim();
    if (!mensaje) return;

    agregarMensaje(mensaje, 'Tú');

    // 👇 Aquí decides cómo responder según lo que escribió el usuario
    if (mensaje.toLowerCase().includes('precio')) {
        agregarMensaje('Los precios dependen del tipo de servicio. ¿Deseas más información sobre vuelos VIP o transporte de carga?', 'Bot');
    } else if (mensaje.toLowerCase().includes('horario')) {
        agregarMensaje('Los vuelos operan de 8:00 a.m. a 5:00 p.m. y el mantenimiento está disponible 24/7.', 'Bot');
    } else {
        agregarMensaje('Gracias por tu mensaje. Un agente se comunicará contigo si es necesario.', 'Bot');
    }

    input.value = ''; // Limpiar campo
    mostrarReinicio(); // Si quieres mostrar el botón "Volver al inicio"
}




</script>