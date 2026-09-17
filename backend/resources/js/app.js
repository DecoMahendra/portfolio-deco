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
        setLoading(pendingForm);
        pendingForm.submit();
    }
});

/*
  Status loading: begitu form dikirim, tombol kirimnya dinonaktifkan dan
  teksnya diganti, supaya pengguna tahu sedang diproses (unggah gambar bisa
  beberapa detik) dan tidak mengklik dua kali.

  Tombol bisa ada di dalam form, atau di luar form tapi menunjuknya lewat
  atribut form="..." (tombol Hapus gambar) — keduanya dicari.
*/
function setLoading(form) {
    const buttons = [
        ...form.querySelectorAll('button[type="submit"]'),
        ...(form.id ? document.querySelectorAll(`button[form="${form.id}"]`) : []),
    ];

    buttons.forEach((button) => {
        button.disabled = true;
        button.textContent = 'Mohon tunggu…';
    });
}

// Form biasa. Form dengan data-confirm sudah menahan submit (defaultPrevented)
// dan menangani loading-nya sendiri setelah dialog dikonfirmasi.
document.addEventListener('submit', (event) => {
    if (! event.defaultPrevented) {
        setLoading(event.target);
    }
});

/*
  Pratinjau file yang dipilih, sebelum diunggah.
  Input file dengan data-preview="<id>" -> gambar yang dipilih ditampilkan
  ke elemen dengan id itu. URL.createObjectURL membuat alamat sementara
  ke file di komputer pengguna, jadi tidak ada yang dikirim ke server.
*/
document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
    const target = document.getElementById(input.dataset.preview);
    const label = input.closest('[data-dropzone]')?.querySelector('[data-dropzone-label]');

    input.addEventListener('change', () => {
        target.replaceChildren(
            ...[...input.files].map((file) => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = '';
                // Satu file: tampil sebesar aslinya (dibatasi lebar kotak). Banyak file: deretan thumbnail.
                img.className = input.multiple ? 'h-auto w-40 rounded-md' : 'h-auto max-w-full rounded-md';
                return img;
            }),
        );

        if (label) {
            label.textContent = input.files.length ? label.dataset.labelFilled : label.dataset.labelEmpty;
        }
    });
});

/*
  Kotak unggah tarik-lepas (<label data-dropzone> membungkus input file).
  Browser secara bawaan MEMBUKA file yang dijatuhkan ke halaman, jadi
  dragover dan drop harus dicegah (preventDefault) dulu. File yang dijatuhkan
  dimasukkan ke input.files, lalu event "change" dipicu supaya pratinjau
  di atas ikut jalan — sama seperti kalau file dipilih lewat dialog.
*/
document.querySelectorAll('[data-dropzone]').forEach((zone) => {
    const input = zone.querySelector('input[type="file"]');

    zone.addEventListener('dragover', (event) => {
        event.preventDefault();
        zone.dataset.dragging = '';
    });

    zone.addEventListener('dragleave', () => {
        delete zone.dataset.dragging;
    });

    zone.addEventListener('drop', (event) => {
        event.preventDefault();
        delete zone.dataset.dragging;

        // Input tanpa "multiple" hanya boleh menerima satu file: ambil yang pertama.
        const files = input.multiple ? [...event.dataTransfer.files] : [...event.dataTransfer.files].slice(0, 1);
        const transfer = new DataTransfer();
        files.forEach((file) => transfer.items.add(file));

        input.files = transfer.files;
        input.dispatchEvent(new Event('change'));
    });
});
