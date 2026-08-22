// ============================================================
// PENDAFTARAN.JS — Step Wizard & Validation
// SIPP UPTD PUSKESMAS IPUH
// ============================================================

let currentStep = 1;
const totalSteps = 4;

document.addEventListener('DOMContentLoaded', () => {
  initStepNav();
  initPoliSelect();
  initKartuToggle();
  initDateValidation();
  initReview();
  initFormSubmit();
});

// ---- Step Navigation ------------------------------------
function initStepNav() {
  document.getElementById('next1Btn')?.addEventListener('click', () => {
    if (validateStep1()) goToStep(2);
  });
  document.getElementById('next2Btn')?.addEventListener('click', () => {
    if (validateStep2()) goToStep(3);
  });
  document.getElementById('next3Btn')?.addEventListener('click', () => {
    if (validateStep3()) { buildReview(); goToStep(4); }
  });
  document.getElementById('prev2Btn')?.addEventListener('click', () => goToStep(1));
  document.getElementById('prev3Btn')?.addEventListener('click', () => goToStep(2));
  document.getElementById('prev4Btn')?.addEventListener('click', () => goToStep(3));
}

function goToStep(step) {
  // Hide all steps
  document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
  document.getElementById(`form-step-${step}`)?.classList.add('active');

  // Update step indicator
  for (let i = 1; i <= totalSteps; i++) {
    const ind = document.getElementById(`step-ind-${i}`);
    if (!ind) continue;
    ind.classList.remove('active', 'done');
    if (i < step) ind.classList.add('done');
    else if (i === step) ind.classList.add('active');
  }

  currentStep = step;

  // Scroll to form top
  document.getElementById('stepIndicator')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ---- Validation Step 1 ----------------------------------
function validateStep1() {
  let valid = true;

  const nik = document.getElementById('nik');
  if (!validateNIK(nik.value)) {
    showFieldError('nik', 'nik-error'); valid = false;
  } else { clearFieldError('nik', 'nik-error'); }

  const nama = document.getElementById('nama');
  if (!nama.value.trim() || nama.value.trim().length < 3) {
    showFieldError('nama', 'nama-error'); valid = false;
  } else { clearFieldError('nama', 'nama-error'); }

  const hp = document.getElementById('no_hp');
  if (!validatePhone(hp.value)) {
    showFieldError('no_hp', 'hp-error'); valid = false;
  } else { clearFieldError('no_hp', 'hp-error'); }

  const kartu = document.getElementById('jenis_kartu');
  if (!kartu.value) {
    kartu.classList.add('is-invalid'); valid = false;
  } else { kartu.classList.remove('is-invalid'); }

  const alamat = document.getElementById('alamat');
  if (!alamat.value.trim()) {
    alamat.classList.add('is-invalid'); valid = false;
  } else { alamat.classList.remove('is-invalid'); }

  if (!valid) showToast('Harap lengkapi data diri dengan benar.', 'error');
  return valid;
}

function validateStep2() {
  const poli = document.querySelector('input[name="poli_id"]:checked');
  if (!poli) {
    document.getElementById('poli-error').style.display = 'block';
    showToast('Pilih poli terlebih dahulu.', 'error');
    return false;
  }
  document.getElementById('poli-error').style.display = 'none';
  return true;
}

function validateStep3() {
  const tgl = document.getElementById('tgl_kunjungan');
  if (!tgl.value) {
    tgl.classList.add('is-invalid');
    showToast('Pilih tanggal kunjungan.', 'error');
    return false;
  }
  tgl.classList.remove('is-invalid');

  // Check weekday (Mon-Fri)
  const d = new Date(tgl.value);
  const day = d.getUTCDay();
  if (day === 0 || day === 6) {
    tgl.classList.add('is-invalid');
    showToast('Puskesmas tutup pada hari Sabtu dan Minggu.', 'warning');
    return false;
  }
  return true;
}

// ---- Field Error Helpers --------------------------------
function showFieldError(fieldId, errorId) {
  document.getElementById(fieldId)?.classList.add('is-invalid');
  const err = document.getElementById(errorId);
  if (err) err.style.display = 'block';
}
function clearFieldError(fieldId, errorId) {
  document.getElementById(fieldId)?.classList.remove('is-invalid');
  const err = document.getElementById(errorId);
  if (err) err.style.display = 'none';
}

// ---- Real-time NIK Validation ---------------------------
document.addEventListener('DOMContentLoaded', () => {
  const nikInput = document.getElementById('nik');
  if (nikInput) {
    nikInput.addEventListener('input', () => {
      nikInput.value = nikInput.value.replace(/\D/g, '').substring(0, 16);
      if (nikInput.value.length === 16) {
        clearFieldError('nik', 'nik-error');
      }
    });
  }
});

// ---- Poli Select Card -----------------------------------
function initPoliSelect() {
  document.querySelectorAll('input[name="poli_id"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.getElementById('poli-error').style.display = 'none';
      updateKuota();
    });
  });
}

// ---- Kartu Toggle (show/hide nomor kartu) ---------------
function initKartuToggle() {
  const kartuSelect = document.getElementById('jenis_kartu');
  const noKartuGroup = document.getElementById('noKartuGroup');
  if (kartuSelect && noKartuGroup) {
    kartuSelect.addEventListener('change', () => {
      noKartuGroup.style.display = kartuSelect.value && kartuSelect.value !== 'Umum' ? 'grid' : 'none';
    });
  }
}

// ---- Date Validation (weekdays only) --------------------
function initDateValidation() {
  const tglInput = document.getElementById('tgl_kunjungan');
  if (!tglInput) return;

  tglInput.addEventListener('change', () => {
    const d = new Date(tglInput.value);
    const day = d.getUTCDay();
    if (day === 0 || day === 6) {
      tglInput.classList.add('is-invalid');
      showToast('Puskesmas tidak beroperasi pada hari Sabtu/Minggu. Pilih hari kerja.', 'warning');
    } else {
      tglInput.classList.remove('is-invalid');
      updateKuota();
    }
  });

  // Also update on sesi change
  document.querySelectorAll('input[name="sesi"]').forEach(r => {
    r.addEventListener('change', updateKuota);
  });
}

// ---- Update Kuota (via fetch) ---------------------------
function updateKuota() {
  const poliId  = document.querySelector('input[name="poli_id"]:checked')?.value;
  const tgl     = document.getElementById('tgl_kunjungan')?.value;

  if (!poliId || !tgl) return;

  fetch(`../process/get_kuota.php?poli_id=${poliId}&tgl=${tgl}`)
    .then(r => r.json())
    .then(data => {
      const kuotaPagi  = document.getElementById('kuota-pagi');
      const kuotaSiang = document.getElementById('kuota-siang');
      if (kuotaPagi)  kuotaPagi.textContent  = `Sisa kuota: ${data.pagi}`;
      if (kuotaSiang) kuotaSiang.textContent = `Sisa kuota: ${data.siang}`;
    })
    .catch(() => {});
}

// ---- Build Review Panel ---------------------------------
function initReview() {}

function buildReview() {
  const jenisPasien  = document.querySelector('input[name="jenis_pasien"]:checked')?.value;
  const nik          = document.getElementById('nik')?.value;
  const nama         = document.getElementById('nama')?.value;
  const tglLahir     = document.getElementById('tgl_lahir')?.value;
  const jk           = document.querySelector('input[name="jenis_kelamin"]:checked')?.value;
  const noHp         = document.getElementById('no_hp')?.value;
  const alamat       = document.getElementById('alamat')?.value;
  const jKartu       = document.getElementById('jenis_kartu')?.value;
  const noKartu      = document.getElementById('no_kartu')?.value;

  const poliRadio    = document.querySelector('input[name="poli_id"]:checked');
  const poliLabel    = poliRadio ? document.querySelector(`label[for="${poliRadio.id}"] .poli-select-name`)?.textContent?.trim() : '-';

  const tglKunjungan = document.getElementById('tgl_kunjungan')?.value;
  const sesi         = document.querySelector('input[name="sesi"]:checked')?.value;

  const rows = [
    ['Jenis Pasien',    jenisPasien || '-'],
    ['NIK',            nik || '-'],
    ['Nama Lengkap',   nama || '-'],
    ['Tanggal Lahir',  tglLahir ? formatDateID(tglLahir) : '-'],
    ['Jenis Kelamin',  jk === 'L' ? 'Laki-laki' : 'Perempuan'],
    ['Nomor HP',       noHp || '-'],
    ['Alamat',         alamat || '-'],
    ['Jenis Kartu',    jKartu || '-'],
    ['No. Kartu',      noKartu || '-'],
    ['Poli Tujuan',    poliLabel || '-'],
    ['Tanggal Kunjungan', tglKunjungan ? formatDateID(tglKunjungan) : '-'],
    ['Sesi',           sesi || '-'],
  ];

  const container = document.getElementById('reviewContent');
  if (!container) return;

  container.innerHTML = rows.map(([label, value]) => `
    <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:0.75rem 1rem;background:var(--clr-gray-50);border-radius:var(--radius-md);gap:1rem;">
      <span style="font-size:0.85rem;color:var(--clr-gray-500);min-width:150px;">${label}</span>
      <span style="font-size:0.9rem;font-weight:600;color:var(--clr-gray-800);text-align:right;">${value}</span>
    </div>
  `).join('');
}

function formatDateID(dateStr) {
  if (!dateStr) return '-';
  const bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni',
                     'Juli','Agustus','September','Oktober','November','Desember'];
  const [y, m, d] = dateStr.split('-');
  return `${parseInt(d)} ${bulan[parseInt(m)]} ${y}`;
}

// ---- Form Submit ----------------------------------------
function initFormSubmit() {
  const form   = document.getElementById('pendaftaranForm');
  const submit = document.getElementById('submitBtn');
  if (!form || !submit) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    setLoading(submit, true);

    const formData = new FormData(form);

    fetch(form.action, { method: 'POST', body: formData })
      .then(r => r.json())
      .then(data => {
        setLoading(submit, false);
        if (data.success) {
          showToast('Pendaftaran berhasil!', 'success');
          setTimeout(() => {
            window.location.href = `pendaftaran-sukses.php?no=${encodeURIComponent(data.no_antrian)}&nama=${encodeURIComponent(data.nama)}`;
          }, 800);
        } else {
          showToast(data.message || 'Terjadi kesalahan. Coba lagi.', 'error');
        }
      })
      .catch(() => {
        setLoading(submit, false);
        showToast('Gagal terhubung ke server. Periksa koneksi Anda.', 'error');
      });
  });
}
