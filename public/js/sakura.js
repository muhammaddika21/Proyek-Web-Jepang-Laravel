// assets/js/sakura.js
document.addEventListener("DOMContentLoaded", () => {
  const elements = {
    container: document.querySelector(".sakura-container"),
    footer: document.querySelector("footer"),
    tree: document.querySelector(".pixel-sakura")
  };

  // Guard clause jika elemen tidak ditemukan
  if (!elements.container || !elements.footer || !elements.tree) return;

  const CONFIG = {
    petals: ["*", "·"],
    normalRate: 100,
    fastRate: 50,
    normalSpeed: "7s",
    fastSpeed: "5s"
  };

  let spawnInterval = null;

  /**
   * Fungsi untuk membuat satu kelopak sakura
   * @param {boolean} isBurst - Apakah ini bagian dari efek burst (dari kanopi saja)
   */
const spawnSakura = (isBurst = false) => {
  const petal = document.createElement("span");
  
  // Probabilitas: 70% dari dahan pohon, 30% dari pojok kanan atas
  const isFromTree = isBurst || Math.random() < 1;

  let spawnTop, spawnRight;

  if (isFromTree) {
    // 1. Ambil Lebar Layar Saat Ini
    const screenWidth = window.innerWidth;
    // jika ukuran layar kurang dari 800px fungsi akan return dan menonaktifkan fungsi ini
    if (screenWidth <= 800) return;
    // Variabel untuk menyimpan angka pengali
    let positionMultiplier; 

    // --- PENGATURAN POSISI MANUAL (IF-ELSE) ---
  // [MODE TABLET & LAPTOP KECIL]
        // Ini adalah area "rawan menceng".
        // Kalau Desktop (0.80) pas, tapi Laptop agak ke kiri/kanan, ubah angka ini.
        // Saran: Coba angka di antara 0.75 sampai 0.85.
        // Jika bunga terlalu KANAN -> Turunkan (misal 0.75)
        // Jika bunga terlalu KIRI -> Naikkan (misal 0.78)
    if (screenWidth <= 950) {
        positionMultiplier = 0.85; 
    }
    else if (screenWidth <= 1100) {
        positionMultiplier = 0.84; 
    }
    else if (screenWidth <= 1200) {
        positionMultiplier = 0.85; 
    }
    else if (screenWidth <= 1420) {
        positionMultiplier = 0.82; 
    }
    
    else {
        // [MODE DESKTOP / LAYAR LEBAR] 
        // INI SWEET SPOT ANDA. JANGAN DIUBAH.
        positionMultiplier = 0.80;
    }

    // ---------------------------------------------------
    // RUMUS MATEMATIKA (JANGAN DIUBAH)
    // ---------------------------------------------------

    // 2. Hitung Titik Pusat Pohon
    const treeCenter = screenWidth * positionMultiplier;

    // 3. Variasi Sebaran (Agar natural)
    // Angka 80 = Bunga menyebar sejauh 40px ke kiri & 40px ke kanan dari titik pusat
    const variation = (Math.random() * 80) - 40; 

    // 4. Eksekusi Posisi Horizontal (RIGHT)
    // Rumus: Lebar Layar - (Titik Pusat + Variasi)
    spawnRight = screenWidth - (treeCenter + variation);

    // 5. Posisi Vertikal (Top)
    if (screenWidth) {
      
    }
    spawnTop = Math.random() * 50 + 35;
  }

  // --- PENYESUAIAN WARNA AGAR MIRIP POHON ---
  const colors = [
    "#fbd0f0", // Pink sangat muda
    "#f7b6e4", // Pink standar pohon
    "#ffb3ba", // Sakura pink (variabel)
    "#fdbaef", // Pink cerah
    "#f4b6e2", // Pink lembut
    "#ffd4f7"  // Pink dahan atas
  ];
  const randomColor = colors[Math.floor(Math.random() * colors.length)];

  petal.className = "sakura";
  petal.textContent = CONFIG.petals[Math.floor(Math.random() * CONFIG.petals.length)];
  
  const size = Math.random() * 5 + 10;
  const delay = Math.random() * 1;

  petal.style.fontSize = `${size}px`;
  petal.style.color = randomColor; // Set warna acak ke elemen
  petal.style.setProperty("--start-right", `${spawnRight}px`);
  petal.style.setProperty("--start-top", `${spawnTop}px`);
  petal.style.setProperty("--delay", `${delay}s`);

  elements.container.appendChild(petal);
  
  petal.addEventListener("animationend", () => petal.remove(), { once: true });
}; 
/**
   * Mengatur kecepatan produksi sakura
   */
  const setSpawnRate = (rate) => {
    if (spawnInterval) clearInterval(spawnInterval);
    spawnInterval = setInterval(() => spawnSakura(), rate);
  };

  /**
   * Efek ledakan kelopak bunga
   */
  const burst = (count = 8) => {
    for (let i = 0; i < count; i++) {
      // Delay sedikit antar kelopak dalam burst agar lebih alami
      setTimeout(() => spawnSakura(true), i * 50);
    }
  };

  /**
   * Handler untuk interaksi (Hover/Touch)
   */
  const handleInteractionStart = (e) => {
    // Hindari trigger ganda pada mobile (touch + mouse)
    if (e.type === 'touchstart') e.preventDefault(); 
    
    burst(10);
    elements.footer.style.setProperty("--spawn-speed", CONFIG.fastSpeed);
    setSpawnRate(CONFIG.fastRate);
  };

  const handleInteractionEnd = () => {
    elements.footer.style.setProperty("--spawn-speed", CONFIG.normalSpeed);
    setSpawnRate(CONFIG.normalRate);
  };

  // Event Listeners
  elements.tree.addEventListener("mouseenter", handleInteractionStart);
  elements.tree.addEventListener("mouseleave", handleInteractionEnd);
  
  // Mobile Support
  elements.tree.addEventListener("touchstart", handleInteractionStart, { passive: false });
  elements.tree.addEventListener("touchend", handleInteractionEnd);

  // Jalankan siklus awal
  setSpawnRate(CONFIG.normalRate);
});