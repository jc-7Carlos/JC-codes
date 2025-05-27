document.addEventListener("DOMContentLoaded", () => {
    const chatWindow = document.getElementById("chatWindow");
    const messageInput = document.getElementById("messageInput");
    const messageForm = document.getElementById("messageForm");
    const sendGeneralButton = document.getElementById("sendGeneralMessage");
  
    // Enviar mensaje individual
    messageForm.addEventListener("submit", () => {
      const message = messageInput.value.trim();
      if (message) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("mb-2", "text-right");
        messageDiv.innerHTML = `<span class="font-bold">Tú:</span> ${message}`;
        chatWindow.appendChild(messageDiv);
  
        messageInput.value = "";
        chatWindow.scrollTop = chatWindow.scrollHeight;
      }
    });
  
    // Enviar mensaje general
    sendGeneralButton.addEventListener("click", () => {
      const message = messageInput.value.trim();
      if (message) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("mb-2", "text-center", "text-green-700", "font-semibold");
        messageDiv.innerHTML = `<span class="font-bold">Mensaje general:</span> ${message}`;
        chatWindow.appendChild(messageDiv);
  
        messageInput.value = "";
        chatWindow.scrollTop = chatWindow.scrollHeight;
      }
    });
  });
  