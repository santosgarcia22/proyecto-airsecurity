<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chatbot Laravel</title>
  <style>
    #chatbot-box {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 300px;
      height: 400px;
      border: 1px solid #ccc;
      background: #f9f9f9;
      padding: 10px;
      overflow-y: auto;
      display: none;
    }
    #chatbot-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .bot, .user {
      margin: 5px 0;
    }
    .bot {
      color: green;
    }
    .user {
      text-align: right;
      color: blue;
    }
  </style>
</head>
<body>

<button id="chatbot-toggle">Chat</button>

<div id="chatbot-box">
  <div id="chatbot-messages"></div>
  <input id="chatbot-input" type="text" placeholder="Escribe aquí..." />
  <button onclick="enviarMensaje()">Enviar</button>
</div>

<script>
  const toggle = document.getElementById('chatbot-toggle');
  const box = document.getElementById('chatbot-box');
  const input = document.getElementById('chatbot-input');
  const messages = document.getElementById('chatbot-messages');

  toggle.onclick = () => {
    box.style.display = box.style.display === 'none' ? 'block' : 'none';
  };

  async function enviarMensaje() {
    const texto = input.value.trim();
    if (!texto) return;

    messages.innerHTML += `<div class="user">${texto}</div>`;
    input.value = '';

    const res = await fetch('/api/chatbot', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ mensaje: texto })
    });

    const data = await res.json();
    messages.innerHTML += `<div class="bot">${data.respuesta}</div>`;
    messages.scrollTop = messages.scrollHeight;
  }
</script>

</body>
</html>
