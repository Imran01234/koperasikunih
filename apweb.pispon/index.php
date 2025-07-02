<html lang="id" class="scroll-smooth" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Koperasi Online - Manajemen Simpanan, Anggota, Pinjaman & Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .modal-bg {position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:1000;display:none;align-items:center;justify-content:center;}
    .modal {background:#fff;padding:2rem;border-radius:1rem;max-width:95vw;max-height:90vh;overflow:auto;}
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
  <!-- Login/Register Modal -->
  <div id="modalAuth" class="modal-bg flex">
    <div class="modal w-full max-w-sm">
      <h2 class="text-xl font-bold mb-4 text-blue-700">Login / Registrasi</h2>
      <form id="formAuth" class="space-y-4">
        <input type="text" id="authUsername" placeholder="Username" required class="w-full border rounded px-3 py-2" />
        <input type="password" id="authPassword" placeholder="Password" required class="w-full border rounded px-3 py-2" />
        <button type="submit" class="w-full bg-blue-700 text-white rounded px-4 py-2 font-semibold">Masuk / Daftar</button>
      </form>
      <div id="authMsg" class="text-sm text-red-600 mt-2"></div>
    </div>
  </div>
  <!-- Modal Riwayat Transaksi -->
  <div id="modalRiwayat" class="modal-bg flex">
    <div class="modal w-full max-w-2xl">
      <h2 class="text-xl font-bold mb-4 text-blue-700">Riwayat Transaksi Anggota</h2>
      <div id="riwayatContent"></div>
      <button onclick="closeModal('modalRiwayat')" class="mt-4 bg-blue-700 text-white px-4 py-2 rounded">Tutup</button>
    </div>
  </div>
  <!-- Modal Notifikasi -->
  <div id="modalNotif" class="modal-bg flex">
    <div class="modal w-full max-w-md">
      <h2 class="text-xl font-bold mb-4 text-yellow-700">Notifikasi Pembayaran</h2>
      <div id="notifContent"></div>
      <button onclick="closeModal('modalNotif')" class="mt-4 bg-yellow-700 text-white px-4 py-2 rounded">Tutup</button>
    </div>
  </div>

  <header class="bg-blue-700 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-semibold flex items-center gap-2">
        <i class="fas fa-university"></i> Koperasi Online
      </h1>
      <nav>
        <ul class="flex space-x-6 text-sm md:text-base font-medium">
          <li><a href="#dashboard" class="hover:text-yellow-300 transition">Dashboard</a></li>
          <li><a href="#anggota" class="hover:text-yellow-300 transition">Manajemen Anggota</a></li>
          <li><a href="#simpanan" class="hover:text-yellow-300 transition">Manajemen Simpanan</a></li>
          <li><a href="#pinjaman" class="hover:text-yellow-300 transition">Manajemen Pinjaman</a></li>
          <li><a href="#laporan" class="hover:text-yellow-300 transition">Laporan Keuangan</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="flex-grow container mx-auto px-4 py-8 max-w-7xl">
    <!-- Dashboard -->
    <section id="dashboard" class="mb-12">
      <h2 class="text-3xl font-semibold mb-6 text-blue-800 flex items-center gap-3">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
          <i class="fas fa-users fa-3x text-blue-600 mb-3"></i>
          <p class="text-gray-700 font-semibold">Total Anggota</p>
          <p id="totalAnggota" class="text-2xl font-bold text-blue-700">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
          <i class="fas fa-wallet fa-3x text-green-600 mb-3"></i>
          <p class="text-gray-700 font-semibold">Total Simpanan</p>
          <p id="totalSimpanan" class="text-2xl font-bold text-green-700">Rp 0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
          <i class="fas fa-hand-holding-usd fa-3x text-yellow-600 mb-3"></i>
          <p class="text-gray-700 font-semibold">Total Pinjaman</p>
          <p id="totalPinjaman" class="text-2xl font-bold text-yellow-700">Rp 0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
          <i class="fas fa-file-invoice-dollar fa-3x text-red-600 mb-3"></i>
          <p class="text-gray-700 font-semibold">Laba Bersih</p>
          <p id="labaBersih" class="text-2xl font-bold text-red-700">Rp 0</p>
        </div>
      </div>
    </section>

    <!-- Manajemen Anggota -->
    <section id="anggota" class="mb-12">
      <h2 class="text-3xl font-semibold mb-6 text-blue-800 flex items-center gap-3">
        <i class="fas fa-user-friends"></i> Manajemen Anggota
      </h2>
      <div class="bg-white rounded-lg shadow p-6">
        <form id="formAnggota" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <input
            type="text"
            id="namaAnggota"
            placeholder="Nama Lengkap"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="text"
            id="alamatAnggota"
            placeholder="Alamat"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <input
            type="tel"
            id="teleponAnggota"
            placeholder="No. Telepon"
            pattern="[0-9+ ]+"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <button
            type="submit"
            class="md:col-span-3 bg-blue-700 text-white rounded px-6 py-2 font-semibold hover:bg-blue-800 transition"
          >
            Tambah Anggota
          </button>
        </form>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse border border-gray-300">
            <thead class="bg-blue-100">
              <tr>
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Nama Lengkap</th>
                <th class="border border-gray-300 px-3 py-2">Alamat</th>
                <th class="border border-gray-300 px-3 py-2">No. Telepon</th>
                <th class="border border-gray-300 px-3 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelAnggota" class="bg-white"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Manajemen Simpanan -->
    <section id="simpanan" class="mb-12">
      <h2 class="text-3xl font-semibold mb-6 text-blue-800 flex items-center gap-3">
        <i class="fas fa-wallet"></i> Manajemen Simpanan
      </h2>
      <div class="bg-white rounded-lg shadow p-6">
        <form id="formSimpanan" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <select
            id="anggotaSimpanan"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option value="" disabled selected>Pilih Anggota</option>
          </select>
          <input
            type="number"
            id="jumlahSimpanan"
            placeholder="Jumlah Simpanan (Rp)"
            min="1"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <input
            type="date"
            id="tanggalSimpanan"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <button
            type="submit"
            class="bg-green-700 text-white rounded px-6 py-2 font-semibold hover:bg-green-800 transition"
          >
            Tambah Simpanan
          </button>
        </form>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse border border-gray-300">
            <thead class="bg-green-100">
              <tr>
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Nama Anggota</th>
                <th class="border border-gray-300 px-3 py-2">Jumlah (Rp)</th>
                <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelSimpanan" class="bg-white"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Manajemen Pinjaman -->
    <section id="pinjaman" class="mb-12">
      <h2 class="text-3xl font-semibold mb-6 text-blue-800 flex items-center gap-3">
        <i class="fas fa-hand-holding-usd"></i> Manajemen Pinjaman
      </h2>
      <div class="bg-white rounded-lg shadow p-6">
        <form id="formPinjaman" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
          <select
            id="anggotaPinjaman"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
          >
            <option value="" disabled selected>Pilih Anggota</option>
          </select>
          <input
            type="number"
            id="jumlahPinjaman"
            placeholder="Jumlah Pinjaman (Rp)"
            min="1"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
          />
          <input
            type="date"
            id="tanggalPinjaman"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
          />
          <input
            type="number"
            id="bungaPinjaman"
            placeholder="Bunga (%)"
            min="0"
            step="0.01"
            required
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
          />
          <button
            type="submit"
            class="bg-yellow-700 text-white rounded px-6 py-2 font-semibold hover:bg-yellow-800 transition"
          >
            Tambah Pinjaman
          </button>
        </form>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse border border-gray-300">
            <thead class="bg-yellow-100">
              <tr>
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Nama Anggota</th>
                <th class="border border-gray-300 px-3 py-2">Jumlah (Rp)</th>
                <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2">Bunga (%)</th>
                <th class="border border-gray-300 px-3 py-2">Total Bayar (Rp)</th>
                <th class="border border-gray-300 px-3 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelPinjaman" class="bg-white"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Laporan Keuangan -->
    <section id="laporan" class="mb-12">
      <h2 class="text-3xl font-semibold mb-6 text-blue-800 flex items-center gap-3">
        <i class="fas fa-file-invoice-dollar"></i> Laporan Keuangan
      </h2>
      <div class="bg-white rounded-lg shadow p-6">
        <button id="btnExport" class="bg-green-700 text-white px-4 py-2 rounded font-semibold mb-4">Export Excel</button>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse border border-gray-300 mb-6">
            <thead class="bg-red-100">
              <tr>
                <th class="border border-gray-300 px-3 py-2">Jenis</th>
                <th class="border border-gray-300 px-3 py-2">Jumlah (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="border border-gray-300 px-3 py-2 font-semibold">Total Simpanan</td>
                <td id="lapSimpanan" class="border border-gray-300 px-3 py-2">Rp 0</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2 font-semibold">Total Pinjaman</td>
                <td id="lapPinjaman" class="border border-gray-300 px-3 py-2">Rp 0</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2 font-semibold">Pendapatan Bunga</td>
                <td id="lapPendapatanBunga" class="border border-gray-300 px-3 py-2">Rp 0</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2 font-semibold">Laba Bersih</td>
                <td id="lapLabaBersih" class="border border-gray-300 px-3 py-2 font-bold text-red-700">Rp 0</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-center text-gray-600 text-sm">
          Data tersimpan secara lokal di browser Anda (LocalStorage). Data akan tetap ada selama Anda tidak menghapus cache browser.
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-blue-700 text-white py-4 text-center text-sm">
    &copy; 2024 Koperasi Online. Semua hak cipta dilindungi.
  </footer>

  <script>
    // Utility functions
    function formatRupiah(angka) {
      return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Data keys for localStorage
    const STORAGE_KEYS = {
      anggota: 'koperasi_anggota',
      simpanan: 'koperasi_simpanan',
      pinjaman: 'koperasi_pinjaman',
    };

    // Load data from localStorage or initialize empty arrays
    let anggotaList = JSON.parse(localStorage.getItem(STORAGE_KEYS.anggota)) || [];
    let simpananList = JSON.parse(localStorage.getItem(STORAGE_KEYS.simpanan)) || [];
    let pinjamanList = JSON.parse(localStorage.getItem(STORAGE_KEYS.pinjaman)) || [];

    // Elements
    const tabelAnggota = document.getElementById('tabelAnggota');
    const tabelSimpanan = document.getElementById('tabelSimpanan');
    const tabelPinjaman = document.getElementById('tabelPinjaman');
    const anggotaSimpananSelect = document.getElementById('anggotaSimpanan');
    const anggotaPinjamanSelect = document.getElementById('anggotaPinjaman');

    const totalAnggotaEl = document.getElementById('totalAnggota');
    const totalSimpananEl = document.getElementById('totalSimpanan');
    const totalPinjamanEl = document.getElementById('totalPinjaman');
    const labaBersihEl = document.getElementById('labaBersih');

    const lapSimpananEl = document.getElementById('lapSimpanan');
    const lapPinjamanEl = document.getElementById('lapPinjaman');
    const lapPendapatanBungaEl = document.getElementById('lapPendapatanBunga');
    const lapLabaBersihEl = document.getElementById('lapLabaBersih');

    // Generate unique ID
    function generateId(prefix) {
      return prefix + '_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
    }

    // Render anggota table and selects
    function renderAnggota() {
      tabelAnggota.innerHTML = '';
      anggotaSimpananSelect.innerHTML = '<option value="" disabled selected>Pilih Anggota</option>';
      anggotaPinjamanSelect.innerHTML = '<option value="" disabled selected>Pilih Anggota</option>';
      anggotaList.forEach((anggota, index) => {
        const tr = document.createElement('tr');
        tr.classList.add('hover:bg-gray-100');
        tr.innerHTML = `
          <td class="border border-gray-300 px-3 py-2">${index + 1}</td>
          <td class="border border-gray-300 px-3 py-2">${anggota.nama}</td>
          <td class="border border-gray-300 px-3 py-2">${anggota.alamat}</td>
          <td class="border border-gray-300 px-3 py-2">${anggota.telepon}</td>
          <td class="border border-gray-300 px-3 py-2 text-center">
            <button data-id="${anggota.id}" class="riwayat-anggota text-blue-600 hover:text-blue-800 mr-2" title="Riwayat"><i class="fas fa-history"></i></button>
            <button data-id="${anggota.id}" class="edit-anggota text-yellow-600 hover:text-yellow-800 mr-2" title="Edit"><i class="fas fa-edit"></i></button>
            <button data-id="${anggota.id}" class="hapus-anggota text-red-600 hover:text-red-800 focus:outline-none" title="Hapus"><i class="fas fa-trash-alt"></i></button>
          </td>
        `;
        tabelAnggota.appendChild(tr);

        // Add to selects
        const option1 = document.createElement('option');
        option1.value = anggota.id;
        option1.textContent = anggota.nama;
        anggotaSimpananSelect.appendChild(option1);

        const option2 = document.createElement('option');
        option2.value = anggota.id;
        option2.textContent = anggota.nama;
        anggotaPinjamanSelect.appendChild(option2);
      });
      totalAnggotaEl.textContent = anggotaList.length;
    }

    // Render simpanan table
    function renderSimpanan() {
      tabelSimpanan.innerHTML = '';
      simpananList.forEach((simpanan, index) => {
        const anggota = anggotaList.find(a => a.id === simpanan.anggotaId);
        const tr = document.createElement('tr');
        tr.classList.add('hover:bg-gray-100');
        tr.innerHTML = `
          <td class="border border-gray-300 px-3 py-2">${index + 1}</td>
          <td class="border border-gray-300 px-3 py-2">${anggota ? anggota.nama : 'Tidak Diketahui'}</td>
          <td class="border border-gray-300 px-3 py-2">${formatRupiah(simpanan.jumlah)}</td>
          <td class="border border-gray-300 px-3 py-2">${simpanan.tanggal}</td>
          <td class="border border-gray-300 px-3 py-2 text-center">
            <button data-id="${simpanan.id}" class="hapus-simpanan text-red-600 hover:text-red-800 focus:outline-none" title="Hapus Simpanan">
              <i class="fas fa-trash-alt"></i>
            </button>
          </td>
        `;
        tabelSimpanan.appendChild(tr);
      });

      const totalSimpanan = simpananList.reduce((acc, cur) => acc + cur.jumlah, 0);
      totalSimpananEl.textContent = formatRupiah(totalSimpanan);
      lapSimpananEl.textContent = formatRupiah(totalSimpanan);
    }

    // Render pinjaman table
    function renderPinjaman() {
      tabelPinjaman.innerHTML = '';
      pinjamanList.forEach((pinjaman, index) => {
        const anggota = anggotaList.find(a => a.id === pinjaman.anggotaId);
        const bungaDecimal = pinjaman.bunga / 100;
        const totalBayar = Math.round(pinjaman.jumlah + (pinjaman.jumlah * bungaDecimal));
        const tr = document.createElement('tr');
        tr.classList.add('hover:bg-gray-100');
        tr.innerHTML = `
          <td class="border border-gray-300 px-3 py-2">${index + 1}</td>
          <td class="border border-gray-300 px-3 py-2">${anggota ? anggota.nama : 'Tidak Diketahui'}</td>
          <td class="border border-gray-300 px-3 py-2">${formatRupiah(pinjaman.jumlah)}</td>
          <td class="border border-gray-300 px-3 py-2">${pinjaman.tanggal}</td>
          <td class="border border-gray-300 px-3 py-2">${pinjaman.bunga.toFixed(2)}%</td>
          <td class="border border-gray-300 px-3 py-2">${formatRupiah(totalBayar)}</td>
          <td class="border border-gray-300 px-3 py-2 text-center">
            <button data-id="${pinjaman.id}" class="hapus-pinjaman text-red-600 hover:text-red-800 focus:outline-none" title="Hapus Pinjaman">
              <i class="fas fa-trash-alt"></i>
            </button>
          </td>
        `;
        tabelPinjaman.appendChild(tr);
      });

      const totalPinjaman = pinjamanList.reduce((acc, cur) => acc + cur.jumlah, 0);
      const totalPendapatanBunga = pinjamanList.reduce((acc, cur) => acc + (cur.jumlah * (cur.bunga / 100)), 0);
      totalPinjamanEl.textContent = formatRupiah(totalPinjaman);
      lapPinjamanEl.textContent = formatRupiah(totalPinjaman);
      lapPendapatanBungaEl.textContent = formatRupiah(Math.round(totalPendapatanBunga));

      // Laba bersih = pendapatan bunga (as simple model)
      const labaBersih = Math.round(totalPendapatanBunga);
      labaBersihEl.textContent = formatRupiah(labaBersih);
      lapLabaBersihEl.textContent = formatRupiah(labaBersih);
    }

    // Save all data to localStorage
    function saveData() {
      localStorage.setItem(STORAGE_KEYS.anggota, JSON.stringify(anggotaList));
      localStorage.setItem(STORAGE_KEYS.simpanan, JSON.stringify(simpananList));
      localStorage.setItem(STORAGE_KEYS.pinjaman, JSON.stringify(pinjamanList));
    }

    // Event listeners for form submissions
    document.getElementById('formAnggota').addEventListener('submit', e => {
      e.preventDefault();
      const nama = document.getElementById('namaAnggota').value.trim();
      const alamat = document.getElementById('alamatAnggota').value.trim();
      const telepon = document.getElementById('teleponAnggota').value.trim();

      if (!nama || !alamat || !telepon) return;

      anggotaList.push({
        id: generateId('anggota'),
        nama,
        alamat,
        telepon,
      });

      saveData();
      renderAnggota();
      renderSimpanan(); // update dropdown anggota di simpanan
      renderPinjaman(); // update dropdown anggota di pinjaman

      e.target.reset();
    });

    document.getElementById('formSimpanan').addEventListener('submit', e => {
      e.preventDefault();
      const anggotaId = document.getElementById('anggotaSimpanan').value;
      const jumlah = parseInt(document.getElementById('jumlahSimpanan').value);
      const tanggal = document.getElementById('tanggalSimpanan').value;

      if (!anggotaId || !jumlah || !tanggal) return;

      simpananList.push({
        id: generateId('simpanan'),
        anggotaId,
        jumlah,
        tanggal,
      });

      saveData();
      renderSimpanan();
      renderDashboard();

      e.target.reset();
    });

    document.getElementById('formPinjaman').addEventListener('submit', e => {
      e.preventDefault();
      const anggotaId = document.getElementById('anggotaPinjaman').value;
      const jumlah = parseInt(document.getElementById('jumlahPinjaman').value);
      const tanggal = document.getElementById('tanggalPinjaman').value;
      const bunga = parseFloat(document.getElementById('bungaPinjaman').value);

      if (!anggotaId || !jumlah || !tanggal || isNaN(bunga)) return;

      pinjamanList.push({
        id: generateId('pinjaman'),
        anggotaId,
        jumlah,
        tanggal,
        bunga,
      });

      saveData();
      renderPinjaman();
      renderDashboard();

      e.target.reset();
    });

    // Event delegation for delete buttons
    document.body.addEventListener('click', e => {
      if (e.target.closest('.hapus-anggota')) {
        const id = e.target.closest('.hapus-anggota').dataset.id;
        // Remove anggota
        anggotaList = anggotaList.filter(a => a.id !== id);
        // Also remove simpanan and pinjaman related to anggota
        simpananList = simpananList.filter(s => s.anggotaId !== id);
        pinjamanList = pinjamanList.filter(p => p.anggotaId !== id);
        saveData();
        renderAnggota();
        renderSimpanan();
        renderPinjaman();
        renderDashboard();
      }
      if (e.target.closest('.hapus-simpanan')) {
        const id = e.target.closest('.hapus-simpanan').dataset.id;
        simpananList = simpananList.filter(s => s.id !== id);
        saveData();
        renderSimpanan();
        renderDashboard();
      }
      if (e.target.closest('.hapus-pinjaman')) {
        const id = e.target.closest('.hapus-pinjaman').dataset.id;
        pinjamanList = pinjamanList.filter(p => p.id !== id);
        saveData();
        renderPinjaman();
        renderDashboard();
      }
      if (e.target.closest('.edit-anggota')) {
        const id = e.target.closest('.edit-anggota').dataset.id;
        editAnggota(id);
      }
      if (e.target.closest('.riwayat-anggota')) {
        const id = e.target.closest('.riwayat-anggota').dataset.id;
        showRiwayat(id);
      }
    });

    // Render dashboard summary
    function renderDashboard() {
      const totalSimpanan = simpananList.reduce((acc, cur) => acc + cur.jumlah, 0);
      const totalPinjaman = pinjamanList.reduce((acc, cur) => acc + cur.jumlah, 0);
      const totalPendapatanBunga = pinjamanList.reduce((acc, cur) => acc + (cur.jumlah * (cur.bunga / 100)), 0);
      const labaBersih = Math.round(totalPendapatanBunga);

      totalAnggotaEl.textContent = anggotaList.length;
      totalSimpananEl.textContent = formatRupiah(totalSimpanan);
      totalPinjamanEl.textContent = formatRupiah(totalPinjaman);
      labaBersihEl.textContent = formatRupiah(labaBersih);

      lapSimpananEl.textContent = formatRupiah(totalSimpanan);
      lapPinjamanEl.textContent = formatRupiah(totalPinjaman);
      lapPendapatanBungaEl.textContent = formatRupiah(Math.round(totalPendapatanBunga));
      lapLabaBersihEl.textContent = formatRupiah(labaBersih);
    }

    // Initialize date inputs with today date
    function setDefaultDates() {
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('tanggalSimpanan').value = today;
      document.getElementById('tanggalPinjaman').value = today;
    }

    // ========== AUTHENTICATION =========
    const AUTH_KEY = 'koperasi_user';
    function showModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    function checkAuth() {
      const user = localStorage.getItem(AUTH_KEY);
      if (!user) showModal('modalAuth');
    }
    document.getElementById('formAuth').onsubmit = function(e) {
      e.preventDefault();
      const u = document.getElementById('authUsername').value.trim();
      const p = document.getElementById('authPassword').value.trim();
      if (!u || !p) return;
      let users = JSON.parse(localStorage.getItem('koperasi_users')||'[]');
      let found = users.find(x=>x.u===u);
      if (found) {
        if (found.p!==p) {
          document.getElementById('authMsg').textContent = 'Password salah!';
          return;
        }
      } else {
        users.push({u,p});
        localStorage.setItem('koperasi_users',JSON.stringify(users));
      }
      localStorage.setItem(AUTH_KEY, u);
      closeModal('modalAuth');
    };
    window.onload = checkAuth;
    // ========== END AUTH ==========

    // ========== EDIT ANGGOTA ==========
    function editAnggota(id) {
      const anggota = anggotaList.find(a=>a.id===id);
      if (!anggota) return;
      const nama = prompt('Edit Nama:', anggota.nama);
      if (nama===null) return;
      const alamat = prompt('Edit Alamat:', anggota.alamat);
      if (alamat===null) return;
      const telepon = prompt('Edit Telepon:', anggota.telepon);
      if (telepon===null) return;
      anggota.nama = nama; anggota.alamat = alamat; anggota.telepon = telepon;
      saveData(); renderAnggota();
    }
    // ========== END EDIT ANGGOTA ==========

    // ========== RIWAYAT TRANSAKSI ==========
    function showRiwayat(id) {
      const anggota = anggotaList.find(a=>a.id===id);
      if (!anggota) return;
      let html = `<div class='mb-2'><b>Nama:</b> ${anggota.nama}<br><b>Alamat:</b> ${anggota.alamat}<br><b>Telepon:</b> ${anggota.telepon}</div>`;
      html += '<h3 class="font-semibold text-blue-700 mt-2">Simpanan</h3>';
      const simpanan = simpananList.filter(s=>s.anggotaId===id);
      if (simpanan.length) {
        html += '<table class="w-full text-sm mb-2"><thead><tr><th class="border px-2">Tanggal</th><th class="border px-2">Jumlah</th></tr></thead><tbody>';
        simpanan.forEach(s=>{
          html += `<tr><td class='border px-2'>${s.tanggal}</td><td class='border px-2'>${formatRupiah(s.jumlah)}</td></tr>`;
        });
        html += '</tbody></table>';
      } else html += '<div class="text-gray-500">Tidak ada simpanan</div>';
      html += '<h3 class="font-semibold text-yellow-700 mt-4">Pinjaman</h3>';
      const pinjaman = pinjamanList.filter(p=>p.anggotaId===id);
      if (pinjaman.length) {
        html += '<table class="w-full text-sm mb-2"><thead><tr><th class="border px-2">Tanggal</th><th class="border px-2">Jumlah</th><th class="border px-2">Bunga</th><th class="border px-2">Total Bayar</th><th class="border px-2">Status</th></tr></thead><tbody>';
        pinjaman.forEach(p=>{
          const totalBayar = Math.round(p.jumlah + (p.jumlah * (p.bunga/100)));
          const tglPinjam = new Date(p.tanggal);
          const tglNow = new Date();
          const diff = Math.floor((tglNow-tglPinjam)/(1000*60*60*24));
          let status = diff>=30 ? '<span class="text-red-600 font-bold">Jatuh Tempo</span>' : '<span class="text-green-600">Aktif</span>';
          html += `<tr><td class='border px-2'>${p.tanggal}</td><td class='border px-2'>${formatRupiah(p.jumlah)}</td><td class='border px-2'>${p.bunga}%</td><td class='border px-2'>${formatRupiah(totalBayar)}</td><td class='border px-2'>${status}</td></tr>`;
        });
        html += '</tbody></table>';
      } else html += '<div class="text-gray-500">Tidak ada pinjaman</div>';
      document.getElementById('riwayatContent').innerHTML = html;
      showModal('modalRiwayat');
    }
    // ========== END RIWAYAT ==========

    // ========== NOTIFIKASI PINJAMAN ==========
    function cekNotifikasiPinjaman() {
      const today = new Date();
      let notif = [];
      pinjamanList.forEach(p => {
        const tgl = new Date(p.tanggal);
        const diff = Math.floor((today-tgl)/(1000*60*60*24));
        if (diff>=30) {
          const anggota = anggotaList.find(a=>a.id===p.anggotaId);
          notif.push(`<b>${anggota?anggota.nama:'Tidak Diketahui'}</b> pinjaman tanggal ${p.tanggal} <br>Jumlah: ${formatRupiah(p.jumlah)}<br>Bunga: ${p.bunga}%<br><span class='text-red-600 font-bold'>Sudah jatuh tempo!</span>`);
        }
      });
      if (notif.length) {
        document.getElementById('notifContent').innerHTML = notif.join('<hr>');
        showModal('modalNotif');
      }
    }
    setInterval(cekNotifikasiPinjaman, 10000); // cek tiap 10 detik
    // ========== END NOTIFIKASI ==========

    // ========== EXPORT EXCEL ==========
    document.getElementById('btnExport').onclick = function() {
      const wb = XLSX.utils.book_new();
      const ws1 = XLSX.utils.json_to_sheet(anggotaList.map((a,i)=>({No:i+1,Nama:a.nama,Alamat:a.alamat,Telepon:a.telepon})));
      XLSX.utils.book_append_sheet(wb, ws1, 'Anggota');
      const ws2 = XLSX.utils.json_to_sheet(simpananList.map((s,i)=>({No:i+1,Nama:(anggotaList.find(a=>a.id===s.anggotaId)||{}).nama,Jumlah:s.jumlah,Tanggal:s.tanggal})));
      XLSX.utils.book_append_sheet(wb, ws2, 'Simpanan');
      const ws3 = XLSX.utils.json_to_sheet(pinjamanList.map((p,i)=>({No:i+1,Nama:(anggotaList.find(a=>a.id===p.anggotaId)||{}).nama,Jumlah:p.jumlah,Tanggal:p.tanggal,Bunga:p.bunga})));
      XLSX.utils.book_append_sheet(wb, ws3, 'Pinjaman');
      XLSX.writeFile(wb, 'LaporanKoperasi.xlsx');
    };
    // ========== END EXPORT ==========
  </script>
</body>
</html>