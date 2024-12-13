document.addEventListener('DOMContentLoaded', () => {
    const filterDropdown = document.getElementById('filter');
    const searchInput = document.getElementById('search-input');
    const items = document.querySelectorAll('tbody tr');

    let currentFilter = '';
    let currentOrder = 'asc';

    filterDropdown.addEventListener('change', () => {
        const selectedFilter = filterDropdown.value;

        if (currentFilter === selectedFilter) {
            currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        } else {
            currentOrder = 'asc';
        }

        currentFilter = selectedFilter;

        window.location.href = `?filter=${currentFilter}&order=${currentOrder}`;
    });

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();

        items.forEach((item) => {
            if (item.textContent.toLowerCase().includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    const deleteButtons = document.querySelectorAll('.delete-user');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const userId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-name');
            const userRole = button.getAttribute('data-role');

            if (userRole === 'mayor') {
                alert('Tidak dapat menghapus Mayor!');
            } else {
                const confirmation = confirm(`Ingin menghapus akun dengan nama ${userName}?`);
                if (confirmation) {
                    window.location.href = `?delete_id=${userId}`;
                }
            }
        });
    });
});
