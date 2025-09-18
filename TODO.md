# TODO: Implement Auto Mark Absent Feature

## Steps:
- [x] Create Artisan command: AutoMarkAbsent
- [x] Edit command to check jadwal_kegiatan and create absensi 'alpa' for absent mahasiswa
- [x] Schedule command in Kernel.php to run every hour
- [x] Test the command manually
- [x] Verify scheduling works

## Notes:
- Command checks jadwal where tanggal == today and waktu_mulai + 1 hour < now
- For each such jadwal, create absensi 'alpa' for mahasiswa_baru not yet having absensi for that jadwal
