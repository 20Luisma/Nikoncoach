/**
 * Utilidades puras de formateo y escape HTML para respuestas del Mentor IA.
 */

/**
 * Escapa caracteres HTML para prevenir inyección XSS al renderizar texto plano.
 * @param {string} text
 * @returns {string}
 */
export function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Convierte sintaxis **negrita** a etiquetas <strong>.
 * @param {string} str
 * @returns {string}
 */
export function formatMarkdownBold(str) {
    return str.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
}

/**
 * Formatea una respuesta Markdown ligera del mentor a HTML seguro.
 * @param {string} raw
 * @returns {string}
 */
export function formatChatMessageText(raw) {
    let text = escapeHtml(raw);
    text = text.replace(/^###\s*(.*?)$/gm, '<h4 class="analysis-subhead">$1</h4>');
    text = text.replace(/^##\s*(.*?)$/gm, '<h3 class="analysis-head">$1</h3>');
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');

    const paragraphs = text.split('\n\n').map((p) => {
        const trimmed = p.trim();
        if (trimmed.startsWith('<h3') || trimmed.startsWith('<h4')) {
            return trimmed;
        }
        const lines = p.split('\n');
        const isBulletList =
            lines.length > 0 &&
            lines.every(
                (l) =>
                    l.trim().startsWith('- ') ||
                    l.trim().startsWith('• ') ||
                    l.trim().startsWith('* ')
            );
        if (isBulletList) {
            const items = lines.map((l) => `<li>${l.replace(/^[-•*]\s*/, '')}</li>`).join('');
            return `<ul>${items}</ul>`;
        }
        return `<p>${lines.join('<br>')}</p>`;
    });

    return paragraphs.join('');
}
