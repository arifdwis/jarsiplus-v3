{{-- CHATBOT WIDGET ASISTEN AI JARSIPLUS --}}
<div id="jp-chatbot-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

    {{-- Chatbot Trigger Floating Action Button --}}
    <button type="button" id="jp-chatbot-fab" onclick="toggleJarsiChatbot()" 
            style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; background: linear-gradient(135deg, #0284C7 0%, #0F172A 100%); color: #FFFFFF; border: none; border-radius: 50px; box-shadow: 0 8px 24px rgba(2, 132, 199, 0.35), 0 0 0 1px rgba(255,255,255,0.2); cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); outline: none;">
        <div style="position: relative; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                <rect width="18" height="12" x="3" y="8" rx="2"/>
                <circle cx="9" cy="13" r="1" fill="currentColor"/>
                <circle cx="15" cy="13" r="1" fill="currentColor"/>
                <path d="M10 17h4"/>
            </svg>
            <span style="position: absolute; top: -2px; right: -2px; width: 9px; height: 9px; background: #22C55E; border: 2px solid #FFFFFF; border-radius: 50%;"></span>
        </div>
        <span style="font-weight: 600; font-size: 13.5px; letter-spacing: 0.2px;">Tanya AI JARSIPLUS</span>
    </button>

    {{-- Chatbot Window Modal --}}
    <div id="jp-chatbot-window" 
         style="display: none; flex-direction: column; width: 380px; max-width: calc(100vw - 32px); height: 540px; max-height: calc(100vh - 100px); background: #FFFFFF; border-radius: 18px; box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.28), 0 0 0 1px rgba(226, 232, 240, 0.8); overflow: hidden; transition: all 0.3s ease; position: absolute; bottom: 0; right: 0;">
        
        {{-- Header --}}
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #FFFFFF; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 36px; height: 36px; background: rgba(2, 132, 199, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #38BDF8;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                        <rect width="18" height="12" x="3" y="8" rx="2"/>
                        <circle cx="9" cy="13" r="1.5" fill="currentColor"/>
                        <circle cx="15" cy="13" r="1.5" fill="currentColor"/>
                        <path d="M10 17h4"/>
                    </svg>
                    <span style="position: absolute; bottom: -1px; right: -1px; width: 10px; height: 10px; background: #22C55E; border: 2px solid #0F172A; border-radius: 50%;"></span>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 14.5px; font-weight: 700; color: #F8FAFC; line-height: 1.2;">Asisten AI JARSIPLUS</h4>
                    <span style="font-size: 11px; color: #94A3B8; font-weight: 500;">Pemerintah Kota Samarinda</span>
                </div>
            </div>
            <button type="button" onclick="toggleJarsiChatbot()" 
                    style="background: transparent; border: none; color: #94A3B8; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: color 0.2s;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        {{-- Messages Body --}}
        <div id="jp-chatbot-body" style="flex: 1; padding: 16px; overflow-y: auto; background: #F8FAFC; display: flex; flex-direction: column; gap: 14px;">
            
            {{-- Initial Bot Welcome Bubble --}}
            <div style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 28px; height: 28px; background: #0284C7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFFFFF; flex-shrink: 0; margin-top: 2px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                        <rect width="18" height="12" x="3" y="8" rx="2"/>
                    </svg>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 12px 15px; border-radius: 4px 14px 14px 14px; max-width: 82%; font-size: 13px; color: #1E293B; line-height: 1.5; box-shadow: 0 1px 3px rgba(15,23,42,0.05);">
                    Halo! 👋 Saya <strong>Asisten AI Resmi JARSIPLUS</strong>. Ada yang bisa saya bantu seputar pendaftaran <strong>Lomba BAIMBAI 2026</strong>, indikator penilaian, atau layanan inovasi daerah Kota Samarinda?
                </div>
            </div>

            {{-- Quick Suggestion Chips --}}
            <div id="jp-chatbot-chips" style="display: flex; flex-wrap: wrap; gap: 6px; margin-left: 38px;">
                <button type="button" onclick="sendJarsiChatSuggestion('Apa itu JARSIPLUS Kota Samarinda?')" 
                        style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0284C7; padding: 6px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 500; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                    💡 Apa itu JARSIPLUS?
                </button>
                <button type="button" onclick="sendJarsiChatSuggestion('Bagaimana cara mendaftar Lomba Inovasi BAIMBAI 2026?')" 
                        style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0284C7; padding: 6px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 500; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                    🏆 Cara Daftar Lomba BAIMBAI
                </button>
                <button type="button" onclick="sendJarsiChatSuggestion('Apa saja berkas pendukung dan parameter indikator inovasi?')" 
                        style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0284C7; padding: 6px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 500; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                    📋 Berkas & Indikator Inovasi
                </button>
            </div>

        </div>

        {{-- Footer Input Area --}}
        <div style="padding: 12px 14px; background: #FFFFFF; border-top: 1px solid #E2E8F0;">
            <form id="jp-chatbot-form" onsubmit="handleJarsiChatSubmit(event)" style="display: flex; align-items: center; gap: 8px; margin: 0;">
                <input type="text" id="jp-chatbot-input" placeholder="Ketik pertanyaan seputar JARSIPLUS..." 
                       autocomplete="off" 
                       style="flex: 1; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 10px; font-size: 13px; outline: none; transition: border-color 0.2s; background: #F8FAFC;">
                <button type="submit" id="jp-chatbot-send-btn" 
                        style="width: 38px; height: 38px; background: #0284C7; border: none; border-radius: 10px; color: #FFFFFF; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s; flex-shrink: 0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
            <div style="margin-top: 6px; text-align: center; font-size: 10.5px; color: #94A3B8;">
                🔒 Terproteksi Domain JARSIPLUS • Powered by Groq AI
            </div>
        </div>

    </div>
</div>

<script>
    let jarsiChatHistory = [];
    let isJarsiChatWaiting = false;

    function toggleJarsiChatbot() {
        const win = document.getElementById('jp-chatbot-window');
        const fab = document.getElementById('jp-chatbot-fab');
        if (win.style.display === 'none' || win.style.display === '') {
            win.style.display = 'flex';
            fab.style.display = 'none';
            document.getElementById('jp-chatbot-input').focus();
        } else {
            win.style.display = 'none';
            fab.style.display = 'flex';
        }
    }

    function sendJarsiChatSuggestion(text) {
        document.getElementById('jp-chatbot-input').value = text;
        handleJarsiChatSubmit(new Event('submit'));
    }

    function formatMarkdownText(text) {
        if (!text) return '';
        let formatted = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>');
        return formatted;
    }

    function appendUserMessage(text) {
        const body = document.getElementById('jp-chatbot-body');
        const userHtml = `
            <div style="display: flex; justify-content: flex-end; margin-bottom: 4px;">
                <div style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: #FFFFFF; padding: 10px 14px; border-radius: 14px 14px 4px 14px; max-width: 80%; font-size: 13px; line-height: 1.4; box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2);">
                    ${escapeHtml(text)}
                </div>
            </div>
        `;
        body.insertAdjacentHTML('beforeend', userHtml);
        body.scrollTop = body.scrollHeight;
    }

    function appendBotTypingIndicator() {
        const body = document.getElementById('jp-chatbot-body');
        const typingHtml = `
            <div id="jp-chatbot-typing" style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 28px; height: 28px; background: #0284C7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFFFFF; flex-shrink: 0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                        <rect width="18" height="12" x="3" y="8" rx="2"/>
                    </svg>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 14px; border-radius: 4px 14px 14px 14px; font-size: 13px; color: #64748B; display: flex; align-items: center; gap: 4px;">
                    <span style="animation: blink 1.4s infinite; font-weight: bold;">•</span>
                    <span style="animation: blink 1.4s infinite 0.2s; font-weight: bold;">•</span>
                    <span style="animation: blink 1.4s infinite 0.4s; font-weight: bold;">•</span>
                </div>
            </div>
        `;
        body.insertAdjacentHTML('beforeend', typingHtml);
        body.scrollTop = body.scrollHeight;
    }

    function removeBotTypingIndicator() {
        const typing = document.getElementById('jp-chatbot-typing');
        if (typing) typing.remove();
    }

    function appendBotMessage(text) {
        const body = document.getElementById('jp-chatbot-body');
        const formatted = formatMarkdownText(text);
        const botHtml = `
            <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 4px;">
                <div style="width: 28px; height: 28px; background: #0284C7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFFFFF; flex-shrink: 0; margin-top: 2px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                        <rect width="18" height="12" x="3" y="8" rx="2"/>
                    </svg>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 12px 15px; border-radius: 4px 14px 14px 14px; max-width: 82%; font-size: 13px; color: #1E293B; line-height: 1.5; box-shadow: 0 1px 3px rgba(15,23,42,0.05);">
                    ${formatted}
                </div>
            </div>
        `;
        body.insertAdjacentHTML('beforeend', botHtml);
        body.scrollTop = body.scrollHeight;
    }

    function escapeHtml(string) {
        return String(string).replace(/[&<>"']/g, function(s) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[s];
        });
    }

    async function handleJarsiChatSubmit(event) {
        event.preventDefault();
        if (isJarsiChatWaiting) return;

        const input = document.getElementById('jp-chatbot-input');
        const userMsg = input.value.trim();
        if (!userMsg) return;

        // Hide chips on first user message
        const chips = document.getElementById('jp-chatbot-chips');
        if (chips) chips.style.display = 'none';

        appendUserMessage(userMsg);
        input.value = '';
        isJarsiChatWaiting = true;

        appendBotTypingIndicator();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const response = await fetch('{{ route("chatbot.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    message: userMsg,
                    history: jarsiChatHistory
                })
            });

            removeBotTypingIndicator();

            const data = await response.json();
            if (data && data.reply) {
                appendBotMessage(data.reply);
                jarsiChatHistory.push({ role: 'user', content: userMsg });
                jarsiChatHistory.push({ role: 'assistant', content: data.reply });
                if (jarsiChatHistory.length > 10) jarsiChatHistory = jarsiChatHistory.slice(-10);
            } else {
                appendBotMessage('Mohon maaf, sistem tidak menerima respon valid saat ini.');
            }
        } catch (err) {
            console.error('Chatbot error:', err);
            removeBotTypingIndicator();
            appendBotMessage('Maaf, jaringan sedang sibuk. Silakan coba beberapa saat lagi.');
        } finally {
            isJarsiChatWaiting = false;
        }
    }
</script>
<style>
    @keyframes blink {
        0% { opacity: 0.2; }
        20% { opacity: 1; }
        100% { opacity: 0.2; }
    }
</style>
