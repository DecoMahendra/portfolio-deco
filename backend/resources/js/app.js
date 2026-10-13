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
  Tampilkan/sembunyikan password di halaman login.
  Caranya cukup menukar type input: "password" (titik-titik) <-> "text" (terbaca).
  Label tombol ikut ditukar supaya pembaca layar menyebut aksi yang benar,
  dan ikon mata ditukar supaya keadaannya terlihat.
*/
const passwordToggle = document.getElementById('password-toggle');

passwordToggle?.addEventListener('click', () => {
    const input = document.getElementById(passwordToggle.getAttribute('aria-controls'));
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';
    passwordToggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    passwordToggle.querySelector('[data-icon="show"]').classList.toggle('hidden', isHidden);
    passwordToggle.querySelector('[data-icon="hide"]').classList.toggle('hidden', !isHidden);
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

/*
  Potong gambar jadi persegi sebelum diunggah (input dengan data-crop).

  Alurnya:
  1. Gambar dipilih/dijatuhkan -> jendela potong dibuka.
  2. Gambar digeser (mouse, jari, atau tombol panah) dan diperbesar (penggeser).
     Yang terlihat di kotak = yang nanti tampil di website.
  3. "Pakai foto ini" -> bagian di dalam kotak digambar ulang ke <canvas>
     berukuran 800x800, dijadikan file JPG, lalu MENGGANTIKAN file asli di
     input. Jadi yang terkirim ke server hanya hasil potongannya.
  "Batal" atau tombol Esc -> pilihan file dikosongkan.

  Posisi disimpan sebagai x, y (pojok kiri atas gambar, relatif ke kotak)
  dan scale (perbesaran). Gambar selalu menutupi kotak penuh: x dan y dibatasi
  supaya tidak pernah ada celah kosong di pinggir.
*/
const CROP_SIZE = 800; // sama dengan ukuran foto yang diminta About.jsx dari Cloudinary
const KEY_STEP = 10; // pergeseran per tekan tombol panah, dalam px

document.querySelectorAll('input[type="file"][data-crop]').forEach((input) => {
    const dialog = document.getElementById(input.dataset.crop);
    const frame = dialog.querySelector('[data-crop-frame]');
    const image = dialog.querySelector('[data-crop-image]');
    const zoom = dialog.querySelector('[data-crop-zoom]');

    let frameSize = 0;
    let baseScale = 1; // perbesaran terkecil yang masih menutupi kotak penuh
    let scale = 1;
    let x = 0;
    let y = 0;
    let isConfirmed = false;
    let isApplyingCrop = false; // true saat file hasil potongan sedang dipasang ke input

    // Jaga supaya gambar selalu menutupi kotak, lalu gambar ulang posisinya.
    function render() {
        x = Math.min(0, Math.max(frameSize - image.naturalWidth * scale, x));
        y = Math.min(0, Math.max(frameSize - image.naturalHeight * scale, y));
        image.style.transform = `translate(${x}px, ${y}px) scale(${scale})`;
    }

    // Ubah perbesaran dengan titik tengah kotak tetap di tempat.
    function setZoom(value) {
        const centerX = (frameSize / 2 - x) / scale;
        const centerY = (frameSize / 2 - y) / scale;

        zoom.value = Math.min(zoom.max, Math.max(zoom.min, value));
        scale = baseScale * zoom.value;
        x = frameSize / 2 - centerX * scale;
        y = frameSize / 2 - centerY * scale;
        render();
    }

    function clearSelection() {
        input.value = '';
        input.dispatchEvent(new Event('change')); // pratinjau & label dropzone ikut kosong
    }

    input.addEventListener('change', () => {
        // Perubahan ini dipicu oleh kita sendiri (hasil potongan dipasang): jangan buka lagi.
        if (isApplyingCrop) {
            isApplyingCrop = false;
            return;
        }

        const [file] = input.files;
        if (!file) return;

        image.onload = () => {
            isConfirmed = false;
            dialog.showModal();

            // Ukuran kotak baru bisa diukur setelah dialog tampil.
            frameSize = frame.getBoundingClientRect().width;
            baseScale = frameSize / Math.min(image.naturalWidth, image.naturalHeight);
            image.style.width = `${image.naturalWidth}px`;
            image.style.height = `${image.naturalHeight}px`;

            // Mulai dari ukuran terkecil, gambar di tengah.
            zoom.value = 1;
            scale = baseScale;
            x = (frameSize - image.naturalWidth * scale) / 2;
            y = (frameSize - image.naturalHeight * scale) / 2;
            render();
            frame.focus();
        };
        // Berkas yang ternyata bukan gambar: tidak bisa dipotong, kosongkan saja.
        image.onerror = clearSelection;
        image.src = URL.createObjectURL(file);
    });

    zoom.addEventListener('input', () => setZoom(Number(zoom.value)));

    // Geser dengan mouse atau jari. setPointerCapture: gerakan tetap terbaca
    // walau kursor keluar dari kotak saat sedang menggeser.
    let dragStart = null;

    frame.addEventListener('pointerdown', (event) => {
        frame.setPointerCapture(event.pointerId);
        dragStart = { pointerX: event.clientX, pointerY: event.clientY, x, y };
    });

    frame.addEventListener('pointermove', (event) => {
        if (!dragStart) return;
        x = dragStart.x + event.clientX - dragStart.pointerX;
        y = dragStart.y + event.clientY - dragStart.pointerY;
        render();
    });

    // pointercancel: sentuhan terputus (misalnya ada notifikasi) — anggap selesai juga.
    const endDrag = () => {
        dragStart = null;
    };
    frame.addEventListener('pointerup', endDrag);
    frame.addEventListener('pointercancel', endDrag);

    // Roda mouse untuk memperbesar. preventDefault: halaman di belakang tidak ikut bergulir.
    frame.addEventListener('wheel', (event) => {
        event.preventDefault();
        setZoom(Number(zoom.value) - Math.sign(event.deltaY) * 0.1);
    }, { passive: false });

    // Keyboard: panah menggeser, + dan - memperbesar/memperkecil.
    frame.addEventListener('keydown', (event) => {
        const moves = {
            ArrowLeft: [KEY_STEP, 0],
            ArrowRight: [-KEY_STEP, 0],
            ArrowUp: [0, KEY_STEP],
            ArrowDown: [0, -KEY_STEP],
        };

        if (moves[event.key]) {
            event.preventDefault();
            x += moves[event.key][0];
            y += moves[event.key][1];
            render();
        } else if (event.key === '+' || event.key === '=') {
            setZoom(Number(zoom.value) + 0.1);
        } else if (event.key === '-') {
            setZoom(Number(zoom.value) - 0.1);
        }
    });

    dialog.querySelector('[data-crop-cancel]').addEventListener('click', () => dialog.close());

    dialog.querySelector('[data-crop-confirm]').addEventListener('click', async () => {
        // Bagian gambar asli yang sedang terlihat di kotak, dalam ukuran asli gambar.
        const sourceX = -x / scale;
        const sourceY = -y / scale;
        const sourceSize = frameSize / scale;

        const canvas = document.createElement('canvas');
        canvas.width = CROP_SIZE;
        canvas.height = CROP_SIZE;
        canvas.getContext('2d').drawImage(image, sourceX, sourceY, sourceSize, sourceSize, 0, 0, CROP_SIZE, CROP_SIZE);

        /*
          toDataURL, bukan toBlob: toBlob dikerjakan Chrome di "waktu senggang"
          browser, jadi bisa tertunda sampai sekitar 1 detik tanpa tanda apa pun —
          tombolnya terasa tidak bereaksi. toDataURL langsung selesai; fetch()
          di bawah hanya mengubah teks "data:..." itu menjadi isi file.

          JPG: didukung semua browser, dan untuk foto jauh lebih kecil daripada PNG.
        */
        const blob = await (await fetch(canvas.toDataURL('image/jpeg', 0.9))).blob();

        const transfer = new DataTransfer();
        transfer.items.add(new File([blob], 'foto-profil.jpg', { type: 'image/jpeg' }));

        isConfirmed = true;
        isApplyingCrop = true;
        input.files = transfer.files;
        input.dispatchEvent(new Event('change')); // pratinjau menampilkan hasil potongan
        dialog.close();
    });

    // Ditutup tanpa "Pakai foto ini" (Batal atau Esc): pilihan dibatalkan.
    dialog.addEventListener('close', () => {
        if (!isConfirmed) clearSelection();
    });
});
