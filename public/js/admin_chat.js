document.addEventListener('DOMContentLoaded', function() {
    const chatBox = document.getElementById('chat-box');
    const sendBtn = document.getElementById('send-btn');
    const messageInput = document.getElementById('message-input');
    const userList = document.querySelectorAll('#user-list li');

    let currentUser = 1; // utilisateur sélectionné par défaut
    let messages = {
        1: [{sender: 'user', text: 'Bonjour, j\'ai besoin d\'aide.'}],
        2: [{sender: 'user', text: 'Problème de connexion.'}],
        3: [{sender: 'user', text: 'Je veux investir.'}]
    };

    function renderMessages() {
        chatBox.innerHTML = '';
        messages[currentUser].forEach(msg => {
            const div = document.createElement('div');
            div.classList.add('message', msg.sender);
            div.textContent = msg.text;
            chatBox.appendChild(div);
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    userList.forEach(li => {
        li.addEventListener('click', function() {
            userList.forEach(l => l.classList.remove('selected'));
            li.classList.add('selected');
            currentUser = parseInt(li.dataset.user);
            renderMessages();
        });
    });

    sendBtn.addEventListener('click', function() {
        const text = messageInput.value.trim();
        if(text === '') return;
        messages[currentUser].push({sender: 'admin', text});
        messageInput.value = '';
        renderMessages();
    });

    renderMessages();
});
