// JavaScript untuk mengelola dropdown profil
    document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('profileDropdownTrigger');
    const menu = document.getElementById('profileDropdownMenu');

    // Toggle dropdown saat ikon diklik
    trigger.addEventListener('click', function(e) {
        e.stopPropagation(); // Mencegah event bubbling
        const isHidden = menu.style.display === 'none' || menu.style.display === '';
        menu.style.display = isHidden ? 'flex' : 'none';
    });

    // Tutup dropdown jika mengklik di luar area profil
    document.addEventListener('click', function(e) {
        if (!trigger.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
});