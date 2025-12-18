<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialDbSetup extends Migration
{
    public function up()
    {
        // --- 1. Tabel Users [cite: 30] ---
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'kaprodi', 'mahasiswa', 'pimpinan'],
                'default'    => 'mahasiswa',
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users', true);

        // --- 2. Tabel Fakultas [cite: 31] ---
        $this->forge->addField([
            'id_fakultas' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_fakultas' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id_fakultas', true);
        $this->forge->createTable('fakultas', true);

        // --- 3. Tabel Jurusan [cite: 32] ---
        $this->forge->addField([
            'id_jurusan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_fakultas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_jurusan', true);
        $this->forge->addForeignKey('id_fakultas', 'fakultas', 'id_fakultas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jurusan', true);

        // --- 4. Tabel Prodi [cite: 33] ---
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_user_kaprodi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_jurusan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_prodi', true);
        $this->forge->addForeignKey('id_user_kaprodi', 'users', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_jurusan', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prodi', true);

        // --- 5. Tabel Mahasiswa [cite: 40] ---
        $this->forge->addField([
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama_mahasiswa' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_user' => [ 
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('nim', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->createTable('mahasiswa', true);

        // --- 6. Tabel Periode Kuisioner [cite: 34] ---
        $this->forge->addField([
            'id_periode' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'status_periode' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'non-aktif'],
                'default'    => 'aktif',
            ],
        ]);
        $this->forge->addKey('id_periode', true);
        $this->forge->createTable('periode_kuisioner', true);

        // --- 7. Tabel Pertanyaan [cite: 35] ---
        $this->forge->addField([
            'id_pertanyaan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pertanyaan' => [
                'type' => 'TEXT',
            ],
            'id_prodi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_pertanyaan', true);
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertanyaan', true);

        // --- 8. Tabel Pilihan Jawaban Pertanyaan [cite: 36, 37] ---
        $this->forge->addField([
            'id_pilihan_jawaban' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'deskripsi_pilihan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'id_pertanyaan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_pilihan_jawaban', true);
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pilihan_jawaban_pertanyaan', true);

        // --- 9. Tabel Pertanyaan Periode Kuisioner [cite: 38, 39] ---
        $this->forge->addField([
            'id_pertanyaan_periode_kuisioner' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_periode_kuisioner' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_pertanyaan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_pertanyaan_periode_kuisioner', true);
        $this->forge->addForeignKey('id_periode_kuisioner', 'periode_kuisioner', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertanyaan_periode_kuisioner', true);

        // --- 10. Tabel Jawaban [cite: 41] ---
        $this->forge->addField([
            'id_jawaban' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_pertanyaan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_pilihan_jawaban_pertanyaan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_periode' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id_jawaban', true);
        $this->forge->addForeignKey('nim', 'mahasiswa', 'nim', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pilihan_jawaban_pertanyaan', 'pilihan_jawaban_pertanyaan', 'id_pilihan_jawaban', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode_kuisioner', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban', true);
    }

    public function down()
    {
        $this->forge->dropTable('jawaban', true);
        $this->forge->dropTable('pertanyaan_periode_kuisioner', true);
        $this->forge->dropTable('pilihan_jawaban_pertanyaan', true);
        $this->forge->dropTable('pertanyaan', true);
        $this->forge->dropTable('periode_kuisioner', true);
        $this->forge->dropTable('mahasiswa', true);
        $this->forge->dropTable('prodi', true);
        $this->forge->dropTable('jurusan', true);
        $this->forge->dropTable('fakultas', true);
        $this->forge->dropTable('users', true);
    }
}