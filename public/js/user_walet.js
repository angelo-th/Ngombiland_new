// === Initialisation des icônes Lucide ===
lucide.createIcons();

// === Navigation retour ===
function goBack() {
    console.log("Navigating back...");
    window.history.back();
}

// === Gestion des modales ===
function showRechargeModal() {
    document.getElementById('rechargeModal').classList.remove('hidden');
}
function hideRechargeModal() {
    document.getElementById('rechargeModal').classList.add('hidden');
}
function showWithdrawModal() {
    document.getElementById('withdrawModal').classList.remove('hidden');
}
function hideWithdrawModal() {
    document.getElementById('withdrawModal').classList.add('hidden');
}

// === Traitement Top Up ===
function processRecharge() {
    const amount = document.getElementById('rechargeAmount').value;
    const method = document.querySelector('input[name="paymentMethod"]:checked');

    if (!amount || !method) {
        alert('Please fill all fields');
        return;
    }

    hideRechargeModal();

    // Simulation traitement serveur
    setTimeout(() => {
        const currentBalance = 125750;
        const newBalance = currentBalance + parseInt(amount);
        document.getElementById('balance').textContent = `${newBalance.toLocaleString()} FCFA`;

        // Ajout transaction
        addTransaction({
            type: 'recharge',
            amount: `+${parseInt(amount).toLocaleString()} FCFA`,
            description: `${method.value.toUpperCase()} Top Up`,
            time: 'Just now',
            status: 'Confirmed'
        });

        alert("Top up successful!");
    }, 2000);
}

// === Traitement Withdraw ===
function processWithdraw() {
    const amount = document.getElementById('withdrawAmount').value;
    const phone = document.getElementById('withdrawPhone').value;

    if (!amount || !phone) {
        alert('Please fill all fields');
        return;
    }

    if (parseInt(amount) > 125750) {
        alert('Insufficient balance');
        return;
    }

    hideWithdrawModal();

    // Simulation traitement serveur
    setTimeout(() => {
        const currentBalance = 125750;
        const newBalance = currentBalance - parseInt(amount);
        document.getElementById('balance').textContent = `${newBalance.toLocaleString()} FCFA`;

        // Ajout transaction
        addTransaction({
            type: 'withdraw',
            amount: `-${parseInt(amount).toLocaleString()} FCFA`,
            description: `Withdrawal to ${phone}`,
            time: 'Just now',
            status: 'Processing'
        });

        alert("Withdrawal request submitted!");
    }, 2000);
}

// === Ajout dynamique d'une transaction ===
function addTransaction(transaction) {
    const transactionsList = document.getElementById('transactionsList');
    const transactionHTML = `
        <div class="p-6 hover:bg-gray-50 transition border-l-4 ${transaction.type === 'recharge' ? 'border-green-500' : 'border-red-500'} transaction-bounce">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="${transaction.type === 'recharge' ? 'bg-green-100' : 'bg-red-100'} p-2 rounded-full">
                        <i data-lucide="${transaction.type === 'recharge' ? 'arrow-down-right' : 'arrow-up-right'}" class="w-5 h-5 ${transaction.type === 'recharge' ? 'text-green-600' : 'text-red-600'}"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">${transaction.description}</p>
                        <p class="text-sm text-gray-500">${transaction.time}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold ${transaction.type === 'recharge' ? 'text-green-600' : 'text-red-600'}">${transaction.amount}</p>
                    <p class="text-sm text-gray-500">${transaction.status}</p>
                </div>
            </div>
        </div>
    `;
    transactionsList.insertAdjacentHTML('afterbegin', transactionHTML);
    lucide.createIcons(); // re-init icons
}
