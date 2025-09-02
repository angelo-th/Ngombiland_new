// Exemple de data fictive (normalement récupérée depuis l’API backend)
const users = [
    { id: 1, name: "KEN Gessy", email: "yeuxdechat.com", phone: "699945676", role: "Propriétaire", status: "active" },
    { id: 2, name: "Franck Barthel", email: "franck.com", phone: "697778765", role: "Investisseur", status: "active" },
    { id: 3, name: "Sergio Cheubeu", email: "chebeulure.com", phone: "697458123", role: "Propriétaire", status: "inactive" },
];

// Rendu dynamique des utilisateurs dans le tableau
function renderUsers(data) {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = "";

    data.forEach(user => {
        const row = `
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">#${user.id}</td>
                <td class="py-3 px-4 flex items-center">
                    <img src="/user1.jpg" alt="User" class="w-8 h-8 rounded-full mr-2">
                    ${user.name}
                </td>
                <td class="py-3 px-4">${user.email}</td>
                <td class="py-3 px-4">${user.phone}</td>
                <td class="py-3 px-4">${user.role}</td>
                <td class="py-3 px-4">
                    <span class="py-1 px-2 rounded-full text-xs 
                        ${user.status === "active" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800"}">
                        ${user.status === "active" ? "Actif" : "Suspendu"}
                    </span>
                </td>
                <td class="py-3 px-4 flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                    <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    document.getElementById("userCount").textContent = `Affichage 1-${data.length} sur ${users.length}`;
}

// Gestion des filtres
document.querySelectorAll(".filter-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        const status = btn.dataset.status;
        if (status === "all") {
            renderUsers(users);
        } else {
            renderUsers(users.filter(u => u.status === status));
        }
    });
});

// Recherche utilisateur
document.getElementById("searchUser").addEventListener("input", (e) => {
    const keyword = e.target.value.toLowerCase();
    const filtered = users.filter(u => u.name.toLowerCase().includes(keyword));
    renderUsers(filtered);
});

// Initialisation
renderUsers(users);
