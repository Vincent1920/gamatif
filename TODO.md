# TODO: Fix jadwal_kegiatan_id in Absensi QR

1. [x] Modify AbsenQR.php submit method to find jadwal_kegiatan where tanggal == today().
2. [x] If jadwal found, set jadwal_kegiatan_id and proceed with firstOrCreate using both mahasiswa_baru_id and jadwal_kegiatan_id.
3. [x] If not found, show notification "tidak ada kegiatan hari ini".
4. [x] Test the QR absensi page to ensure it works.
