import { formatChatMessageText } from './formatters.js';

/**
 * Módulo Chat del Mentor IA (Gemini 3.8 Flash).
 * @param {string} basePath
 */
export function initMentorChat(basePath) {
    const chatForm = /** @type {HTMLFormElement | null} */ (document.getElementById('chat-form'));
    const chatInput = /** @type {HTMLInputElement | null} */ (document.getElementById('chat-input'));
    const chatMessages = document.getElementById('chat-messages');
    const chips = document.querySelectorAll('.chip');

    if (!chatForm || !chatInput || !chatMessages) return;

    /**
     * @param {'user' | 'coach'} sender
     * @param {string} text
     */
    function appendChatMessage(sender, text) {
        if (!chatMessages) return;
        const msgDiv = document.createElement('div');
        msgDiv.className = `chat-msg ${sender === 'user' ? 'user-msg' : 'coach-msg'}`;
        const avatar = sender === 'user' ? '👤' : '📸';
        msgDiv.innerHTML = `<div class="msg-avatar">${avatar}</div><div class="msg-body">${formatChatMessageText(text)}</div>`;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    /**
     * @returns {string}
     */
    function appendTypingIndicator() {
        const id = `typing-${Date.now()}`;
        if (!chatMessages) return id;
        const msgDiv = document.createElement('div');
        msgDiv.id = id;
        msgDiv.className = 'chat-msg coach-msg';
        msgDiv.innerHTML = '<div class="msg-avatar">📸</div><div class="msg-body"><em>El coach está preparando la receta... ⏳</em></div>';
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return id;
    }

    chips.forEach((chip) => {
        chip.addEventListener('click', () => {
            const prompt = /** @type {HTMLElement} */ (chip).dataset.prompt;
            if (prompt) {
                chatInput.value = prompt;
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const question = chatInput.value.trim();
        if (!question) return;

        appendChatMessage('user', question);
        chatInput.value = '';

        const typingId = appendTypingIndicator();

        try {
            const response = await fetch(`${basePath}/api/mentor-chat`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    question,
                    context: {
                        camera: 'Nikon D5500',
                        lenses: ['18-55mm VR II', '18-200mm VR I']
                    }
                })
            });
            const data = await response.json();
            document.getElementById(typingId)?.remove();

            appendChatMessage(
                'coach',
                data.reply || 'Se me complicó la respuesta che, probá de nuevo en un segundo.'
            );
        } catch {
            document.getElementById(typingId)?.remove();
            appendChatMessage('coach', 'Error al conectar con el servidor del coach.');
        }
    });
}
