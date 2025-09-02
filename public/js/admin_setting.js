// Example users data (in real app fetch from API)
const users = [
    {name: 'John Doe', email: 'john@example.com', role: 'Admin'},
    {name: 'Jane Smith', email: 'jane@example.com', role: 'Support'},
    {name: 'Bob Martin', email: 'bob@example.com', role: 'Agent'}
];

// Populate user table
const usersTable = document.getElementById('usersTable');
users.forEach(user => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.email}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.role}</td>
        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
            <button class="btn btn-edit" onclick="editUser('${user.email}')">Edit</button>
            <button class="btn btn-delete" onclick="deleteUser('${user.email}')">Delete</button>
        </td>
    `;
    usersTable.appendChild(row);
});

// Functions for editing and deleting users
function editUser(email) {
    alert('Edit user: ' + email);
}

function deleteUser(email) {
    if(confirm('Are you sure you want to delete ' + email + '?')) {
        alert('User deleted: ' + email);
    }
}
