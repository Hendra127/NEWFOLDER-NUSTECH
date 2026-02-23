/* public/js/nav-modal.js */
function openNavModal() {
    const modal = document.getElementById("navModal");
    if (modal) {
        modal.style.display = "block";
        console.log("Modal opened"); // Cek di console (F12) untuk memastikan fungsi jalan
    } else {
        console.error("Elemen navModal tidak ditemukan di halaman ini");
    }
}

function closeNavModal() {
    const modal = document.getElementById("navModal");
    if(modal) modal.style.display = "none";
}

// Tutup jika klik di luar area putih modal
window.addEventListener('click', function(event) {
    const modal = document.getElementById("navModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
});