
// ============================================
// FUNGSI LOAD PROFILE DATA
// ============================================
function loadProfileData() {
    if (!currentUser) return;

    console.log('Loading profile data:', currentUser);

    // Update Tampilan Profil Kiri
    const initials = currentUser.fullname ? currentUser.fullname.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : '-';
    if (document.getElementById('profilAvatar')) document.getElementById('profilAvatar').innerText = initials;
    
    if (document.getElementById('profilNama')) document.getElementById('profilNama').innerText = currentUser.fullname || '-';
    // Role biarkan default "Pejabat Penghubung" atau sesuaikan jika perlu
    
    if (document.getElementById('profilNIPDisplay')) document.getElementById('profilNIPDisplay').innerText = currentUser.nip || '-';
    if (document.getElementById('profilInstansiDisplay')) document.getElementById('profilInstansiDisplay').innerText = currentUser.instansi || '-';
    if (document.getElementById('profilJabatanDisplay')) document.getElementById('profilJabatanDisplay').innerText = currentUser.jabatan || '-';

    // Update Form Edit Kanan
    if (document.getElementById('profil_nama')) document.getElementById('profil_nama').value = currentUser.fullname || '';
    if (document.getElementById('profil_nip')) document.getElementById('profil_nip').value = currentUser.nip || '';
    if (document.getElementById('profil_jabatan')) document.getElementById('profil_jabatan').value = currentUser.jabatan || '';
    if (document.getElementById('profil_telp')) document.getElementById('profil_telp').value = currentUser.no_hp || ''; // Note: session key is no_hp
    if (document.getElementById('profil_email')) document.getElementById('profil_email').value = currentUser.email || '';
    // Alamat tidak ada di session saat ini, biarkan kosong atau tambahkan jika ada di DB
}

// Panggil saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadProfileData();
    
    // Inisialisasi lainnya
    initDatabase();
    
    // ... event listeners lainnya
});
