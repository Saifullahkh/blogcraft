import './bootstrap';

const toggleHidden = (element) => element?.classList.toggle('hidden');

document.addEventListener('click', (event) => {
    const dropdownButton = event.target.closest('[data-dropdown-button]');
    document.querySelectorAll('[data-dropdown] .dropdown-menu').forEach((menu) => {
        if (!dropdownButton || !menu.closest('[data-dropdown]').contains(dropdownButton)) {
            menu.classList.add('hidden');
        }
    });
    if (dropdownButton) {
        toggleHidden(dropdownButton.closest('[data-dropdown]').querySelector('.dropdown-menu'));
    }

    const replyButton = event.target.closest('[data-reply-button]');
    if (replyButton) {
        toggleHidden(document.querySelector(`[data-reply-form="${replyButton.dataset.replyButton}"]`));
    }
});

const mobileButton = document.querySelector('[data-mobile-button]');
const mobileMenu = document.querySelector('[data-mobile-menu]');
const setMobileMenuState = (isOpen) => {
    mobileButton?.setAttribute('aria-expanded', String(isOpen));
    mobileButton?.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
    const mobileLabel = mobileButton?.querySelector('[data-mobile-label]');
    if (mobileLabel) mobileLabel.textContent = isOpen ? 'Close menu' : 'Open menu';
    mobileButton?.querySelector('[data-mobile-icon-open]')?.classList.toggle('hidden', isOpen);
    mobileButton?.querySelector('[data-mobile-icon-close]')?.classList.toggle('hidden', !isOpen);
};

mobileButton?.addEventListener('click', () => {
    if (!mobileMenu) return;
    const isOpen = !mobileMenu.classList.toggle('hidden');
    setMobileMenuState(isOpen);
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        setMobileMenuState(false);
    }
});
document.querySelector('[data-admin-menu-button]')?.addEventListener('click', () => toggleHidden(document.querySelector('[data-admin-sidebar]')));

document.querySelectorAll('[data-confirm]').forEach((element) => {
    element.addEventListener('click', (event) => {
        if (! window.confirm(element.dataset.confirm || 'Are you sure?')) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-slug-source]').forEach((input) => {
    const target = document.querySelector(input.dataset.slugSource);
    if (!target) return;
    input.addEventListener('input', () => {
        if (target.dataset.touched === 'true') return;
        target.value = input.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    });
    target.addEventListener('input', () => target.dataset.touched = 'true');
});

document.querySelectorAll('[data-editor]').forEach((editor) => {
    const textarea = document.querySelector(editor.dataset.editor);
    const sync = () => textarea.value = editor.innerHTML;
    editor.addEventListener('input', sync);
    editor.closest('form')?.addEventListener('submit', sync);
});

document.querySelectorAll('[data-command]').forEach((button) => {
    button.addEventListener('click', () => {
        document.execCommand(button.dataset.command, false, button.dataset.value || null);
    });
});
const chatbot = document.querySelector('[data-chatbot]');
if (chatbot) {
    const panel = chatbot.querySelector('[data-chatbot-panel]');
    const toggleButton = chatbot.querySelector('[data-chatbot-toggle]');
    const closeButton = chatbot.querySelector('[data-chatbot-close]');
    const form = chatbot.querySelector('[data-chatbot-form]');
    const input = chatbot.querySelector('[data-chatbot-input]');
    const messages = chatbot.querySelector('[data-chatbot-messages]');
    const submitButton = chatbot.querySelector('[data-chatbot-submit]');
    const endpoint = form?.dataset.chatbotEndpoint?.trim();

    const setChatbotState = (isOpen) => {
        panel?.classList.toggle('hidden', !isOpen);
        toggleButton?.setAttribute('aria-expanded', String(isOpen));
        toggleButton?.setAttribute('aria-label', isOpen ? 'Close AI chat' : 'Open AI chat');
        toggleButton?.querySelector('[data-chatbot-icon-open]')?.classList.toggle('hidden', isOpen);
        toggleButton?.querySelector('[data-chatbot-icon-close]')?.classList.toggle('hidden', !isOpen);
        if (isOpen) window.setTimeout(() => input?.focus(), 50);
    };

    const appendChatbotMessage = (message, type = 'assistant') => {
        if (!messages) return null;

        const row = document.createElement('div');
        row.className = type === 'user' ? 'flex justify-end' : 'flex justify-start';

        const bubble = document.createElement('div');
        bubble.className = type === 'user'
            ? 'max-w-[85%] rounded-2xl rounded-br-sm bg-[#654A32] px-4 py-3 text-sm leading-6 text-[#FBF7F0]'
            : 'max-w-[85%] rounded-2xl rounded-bl-sm bg-[#F1E4D3] px-4 py-3 text-sm leading-6 text-[#30271F]';
        bubble.textContent = message;

        row.appendChild(bubble);
        messages.appendChild(row);
        messages.scrollTop = messages.scrollHeight;

        return bubble;
    };

    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const getReplyText = (data) => {
        if (typeof data === 'string') return data;
        return data?.reply || data?.message || data?.answer || data?.output || 'Response received.';
    };

    const setBusy = (isBusy) => {
        if (submitButton) submitButton.disabled = isBusy;
        if (input) input.disabled = isBusy;
    };

    const resizeInput = () => {
        if (!input) return;
        input.style.height = 'auto';
        input.style.height = `${Math.min(input.scrollHeight, 112)}px`;
    };

    toggleButton?.addEventListener('click', () => {
        const isOpen = panel?.classList.contains('hidden');
        setChatbotState(Boolean(isOpen));
    });

    closeButton?.addEventListener('click', () => setChatbotState(false));

    chatbot.querySelectorAll('[data-chatbot-suggestion]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!input) return;
            input.value = button.dataset.chatbotSuggestion || '';
            resizeInput();
            input.focus();
        });
    });

    input?.addEventListener('input', resizeInput);
    input?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            form?.requestSubmit();
        }
    });

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const message = input?.value.trim();
        if (!message) return;

        appendChatbotMessage(message, 'user');
        input.value = '';
        resizeInput();

        const pendingBubble = appendChatbotMessage('Typing...', 'assistant');
        setBusy(true);

        try {
            if (!endpoint) {
                pendingBubble.textContent = 'AI backend abhi connect nahi hai. n8n webhook/Laravel route add karne ke baad yahan live jawab ayega.';
                return;
            }

            const response = window.axios
                ? await window.axios.post(endpoint, { message }, { headers: { 'X-CSRF-TOKEN': getCsrfToken() } })
                : await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ message }),
                }).then((result) => result.json());

            pendingBubble.textContent = getReplyText(response.data || response);
        } catch (error) {
            pendingBubble.textContent = error.response?.data?.reply || 'Sorry, chatbot se connect nahi ho saka. Thori der baad dobara try karein.';
        } finally {
            setBusy(false);
            input?.focus();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && panel && !panel.classList.contains('hidden')) {
            setChatbotState(false);
        }
    });
}
