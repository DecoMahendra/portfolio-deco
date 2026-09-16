/*
  Menu hamburger di layar kecil.
  Hanya menukar kelas hidden/flex di <nav>; di layar >= md Tailwind memaksa
  nav selalu tampil (md:flex), jadi logika ini tidak berpengaruh di sana.
*/
const menuToggle = document.getElementById('menu-toggle');
const menu = document.getElementById('menu');

function setMenuOpen(isOpen) {
    menu.classList.toggle('flex', isOpen);
    menu.classList.toggle('hidden', !isOpen);
    menuToggle.setAttribute('aria-expanded', String(isOpen));
}

menuToggle?.addEventListener('click', () => {
    setMenuOpen(!menu.classList.contains('flex'));
});

// Klik di luar header (isi halaman) menutup menu yang sedang terbuka.
document.addEventListener('click', (event) => {
    const isOpen = menu?.classList.contains('flex');
    const isInsideHeader = event.target.closest('header');

    if (isOpen && !isInsideHeader) {
        setMenuOpen(false);
    }
});

/*
  Konfirmasi hapus memakai <dialog> supaya tampilannya mengikuti tema,
  bukan kotak confirm() bawaan browser.

  Alur: form hapus punya data-confirm="pesan" -> saat dikirim, ditahan dulu,
  dialog dibuka -> kalau pengguna menekan "Hapus" (returnValue = 'confirm'),
  form dikirim sungguhan lewat form.submit(), yang tidak memicu event submit
  lagi sehingga tidak berputar.
*/
const dialog = document.getElementById('confirm-dialog');
let pendingForm = null;

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        pendingForm = form;
        dialog.querySelector('p').textContent = form.dataset.confirm;
        dialog.showModal();
    });
});

dialog?.addEventListener('close', () => {
    if (dialog.returnValue === 'confirm') {
        pendingForm.submit();
    }
});
