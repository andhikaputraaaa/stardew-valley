document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const items = document.querySelectorAll('tbody tr');
  
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
});

document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const totalPages = document.querySelectorAll('tbody[data-page]').length;

    function showPage(page) {
        document.querySelectorAll('tbody[data-page]').forEach(function(tbody) {
            tbody.classList.add('hidden');
        });
        document.querySelector(`tbody[data-page="${page}"]`).classList.remove('hidden');
    }

    document.getElementById('prev').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.getElementById('next').addEventListener('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Event listener untuk tombol halaman langsung
    document.querySelectorAll('.nav.num').forEach(function(button) {
        button.addEventListener('click', function() {
            const page = parseInt(this.textContent);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                showPage(currentPage);
            }
        });
    });

    showPage(currentPage);
});