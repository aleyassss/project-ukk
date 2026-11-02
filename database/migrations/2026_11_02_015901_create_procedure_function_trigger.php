<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS hitung_denda');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_pinjam_alat');

        DB::unprepared("
        CREATE FUNCTION hitung_denda(p_rencana DATE, p_real DATE)
        RETURNS INT DETERMINISTIC
        BEGIN
            IF p_real > p_rencana THEN
                RETURN DATEDIFF(p_real, p_rencana) * 5000;
            END IF;
            RETURN 0;
        END");

        DB::unprepared("
        CREATE PROCEDURE sp_pinjam_alat(
            IN p_user_id BIGINT UNSIGNED,
            IN p_alat_id BIGINT UNSIGNED,
            IN p_jumlah INT,
            IN p_tgl_kembali DATE)
        BEGIN
            DECLARE v_stok INT DEFAULT 0;
            START TRANSACTION;
            SELECT stok INTO v_stok FROM alat WHERE id = p_alat_id FOR UPDATE;
            IF v_stok < p_jumlah THEN
                ROLLBACK;
                SELECT 'gagal' AS status, 'Stok Tidak Cukup' AS pesan;
            ELSE
                INSERT INTO peminjaman
                    (user_id, alat_id, jumlah, tgl_pinjam, tgl_kembali_rencana, status, denda, created_at, updated_at)
                VALUES
                    (p_user_id, p_alat_id, p_jumlah, CURDATE(), p_tgl_kembali, 'menunggu', 0, NOW(), NOW());
                COMMIT;
                SELECT 'sukses' AS status, 'Pengajuan berhasil' AS pesan;
            END IF;
        END");

        DB::unprepared("
        CREATE TRIGGER trg_kurangi_stok AFTER UPDATE ON peminjaman
        FOR EACH ROW
        BEGIN
            IF OLD.status = 'menunggu' AND NEW.status = 'disetujui' THEN
                UPDATE alat SET stok = stok - NEW.jumlah WHERE id = NEW.alat_id;
            END IF;
        END");

        DB::unprepared("
        CREATE TRIGGER trg_kembalikan_stok AFTER UPDATE ON peminjaman
        FOR EACH ROW
        BEGIN
            IF OLD.status = 'disetujui' AND NEW.status = 'selesai' THEN
                UPDATE alat SET stok = stok + NEW.jumlah WHERE id = NEW.alat_id;
            END IF;
        END");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_kembalikan_stok');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_kurangi_stok');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_pinjam_alat');
        DB::unprepared('DROP FUNCTION IF EXISTS hitung_denda');
    }
};