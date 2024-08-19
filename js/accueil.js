document.getElementById('menuToggle').addEventListener('click', function() {
    const navbar = document.getElementById('navbar');
    navbar.classList.toggle('active'); // Ajouter ou retirer la classe active
});
document.querySelector('.dropdown i').addEventListener('click', function() {
    const dropdownMenu = this.nextElementSibling;
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});
function toggleDropdown(event) {
    event.stopPropagation(); // Empêche la propagation de l'événement
    const dropdownMenu = event.currentTarget.nextElementSibling;
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(event) {
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    dropdownMenus.forEach(dropdownMenu => {
        if (!dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
});