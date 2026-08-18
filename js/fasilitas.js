// ============================================================
// FASILITAS.JS — Refresh & Live Update
// SIPP UPTD PUSKESMAS IPUH
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
  const refreshBtn  = document.getElementById('refreshBtn');
  const lastUpdate  = document.getElementById('lastUpdateText');

  if (!refreshBtn) return;

  refreshBtn.addEventListener('click', () => {
    refreshBtn.classList.add('refreshing');
    refreshBtn.disabled = true;

    // Simulate a refresh (reload page after brief delay)
    setTimeout(() => {
      window.location.reload();
    }, 800);
  });

  // Auto-refresh every 5 minutes
  setTimeout(() => {
    if (lastUpdate) {
      lastUpdate.textContent = 'Memuat ulang...';
    }
    window.location.reload();
  }, 5 * 60 * 1000);

  // Update "last updated" time display live
  if (lastUpdate) {
    setInterval(() => {
      const now = new Date();
      const h   = String(now.getHours()).padStart(2, '0');
      const m   = String(now.getMinutes()).padStart(2, '0');
      const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
      lastUpdate.textContent = `${h}:${m} WIB, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    }, 60000);
  }
});
