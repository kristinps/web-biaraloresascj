<?php

namespace Database\Seeders;

use App\Models\Biaya;
use App\Models\BiayaTagihan;
use App\Models\KehadiranKursus;
use App\Models\MateriKursus;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Models\PesanDashboard;
use App\Models\SuratKelulusan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Akun penting (super admin + user demo)
        $this->call([
            SuperAdminSeeder::class,
            UserDemoSeeder::class,
        ]);

        $superAdmin = User::where('role', User::ROLE_SUPER_ADMIN)->first();

        // User biasa
        $users = User::factory()
            ->count(25)
            ->create([
                'role'     => User::ROLE_USER,
                'is_admin' => false,
            ]);

        // Periode pernikahan (beberapa aktif, beberapa selesai)
        $periodes = collect();
        for ($i = 0; $i < 4; $i++) {
            $start = Carbon::now()->subMonths(2)->addWeeks($i * 2);
            $end = (clone $start)->addWeeks(4);
            $status = $i < 2 ? 'aktif' : 'selesai';

            $periodes->push(
                PeriodePernikahan::create([
                    'nama'             => 'Periode ' . $start->translatedFormat('F Y'),
                    'tanggal_mulai'    => $start,
                    'tanggal_selesai'  => $status === 'selesai' ? $end : null,
                    'status'           => $status,
                    'catatan'          => $faker->optional()->sentence(10),
                ])
            );
        }

        // Materi kursus untuk setiap periode
        $materiSemuaPeriode = collect();
        foreach ($periodes as $periode) {
            for ($urutan = 1; $urutan <= 6; $urutan++) {
                $tanggalPelaksanaan = $periode->tanggal_mulai
                    ? Carbon::parse($periode->tanggal_mulai)->addDays($urutan * 3)
                    : Carbon::now()->addDays($urutan * 3);

                $materiSemuaPeriode->push(
                    MateriKursus::create([
                        'periode_id'           => $periode->id,
                        'judul'                => 'Sesi ' . $urutan . ' - ' . $faker->sentence(3),
                        'nama_pemateri'        => $faker->name(),
                        'deskripsi'            => $faker->paragraph(3),
                        'file_materi'          => null,
                        'zoom_link'            => $faker->optional()->url(),
                        'tanggal_pelaksanaan'  => $tanggalPelaksanaan,
                        'urutan'               => $urutan,
                        'terkirim_materi'      => $faker->boolean(70),
                        'terkirim_zoom'        => $faker->boolean(70),
                    ])
                );
            }
        }

        // Pendaftaran pernikahan (relasi ke user & periode)
        $pendaftaranSemua = collect();
        foreach ($users as $user) {
            // Tidak semua user harus mendaftar
            if ($faker->boolean(75)) {
                /** @var \App\Models\PeriodePernikahan $periode */
                $periode = $periodes->random();

                $tanggalLahirPria = $faker->dateTimeBetween('-40 years', '-25 years');
                $tanggalLahirWanita = $faker->dateTimeBetween('-38 years', '-23 years');
                $tanggalPernikahan = Carbon::parse($periode->tanggal_mulai ?? Carbon::now())
                    ->addWeeks($faker->numberBetween(1, 6));

                $status = $faker->randomElement(['pending', 'proses', 'selesai']);
                $statusDokumen = $faker->randomElement(['belum_diperiksa', 'perlu_perbaikan', 'disetujui']);
                $statusKursus = $faker->randomElement(['terjadwal', 'berjalan', 'selesai']);
                $statusPembayaran = $faker->randomElement(['belum_bayar', 'lunas', 'menunggu']);

                $pendaftaranSemua->push(
                    PendaftaranPernikahan::create([
                        'user_id'                => $user->id,
                        'periode_id'             => $periode->id,
                        'nama_pria'              => $faker->name('male'),
                        'tempat_lahir_pria'      => $faker->city(),
                        'tanggal_lahir_pria'     => $tanggalLahirPria,
                        'nik_pria'               => $faker->numerify('################'),
                        'agama_pria'             => 'Katolik',
                        'pekerjaan_pria'         => $faker->jobTitle(),
                        'alamat_pria'            => $faker->address(),
                        'nama_ayah_pria'         => $faker->name('male'),
                        'nama_ibu_pria'          => $faker->name('female'),
                        'nama_wanita'            => $faker->name('female'),
                        'tempat_lahir_wanita'    => $faker->city(),
                        'tanggal_lahir_wanita'   => $tanggalLahirWanita,
                        'nik_wanita'             => $faker->numerify('################'),
                        'agama_wanita'           => 'Katolik',
                        'pekerjaan_wanita'       => $faker->jobTitle(),
                        'alamat_wanita'          => $faker->address(),
                        'nama_ayah_wanita'       => $faker->name('male'),
                        'nama_ibu_wanita'        => $faker->name('female'),
                        'tanggal_pernikahan'     => $tanggalPernikahan,
                        'tempat_pernikahan'      => 'Gereja ' . $faker->city(),
                        'email'                  => $user->email,
                        'nomor_hp'               => $faker->phoneNumber(),
                        'ktp_pria'               => null,
                        'ktp_wanita'             => null,
                        'surat_baptis_pria'      => null,
                        'surat_baptis_wanita'    => null,
                        'surat_pengantar_kombas_pria'   => null,
                        'surat_pengantar_kombas_wanita' => null,
                        'status'                 => $status,
                        'catatan'                => $faker->optional()->sentence(8),
                        'status_dokumen'         => $statusDokumen,
                        'catatan_dokumen'        => $faker->optional()->sentence(10),
                        'perbaikan_dokumen_user' => $faker->optional()->paragraph(),
                        'status_kursus'          => $statusKursus,
                        'status_pembayaran'      => $statusPembayaran,
                        'midtrans_order_id'      => $faker->optional(40)->uuid(),
                        'midtrans_snap_token'    => $faker->optional(40)->sha1(),
                        'midtrans_transaction_id'=> $faker->optional(40)->uuid(),
                        'qris_url'               => $faker->optional(40)->url(),
                        'qris_expired_at'        => $faker->optional()->dateTimeBetween('now', '+1 month'),
                        'email_konfirmasi_pembayaran_sent_at' => $faker->optional(40)->dateTimeBetween('-1 week', 'now'),
                    ])
                );
            }
        }

        // User demo: satu pendaftaran kursus pernikahan lengkap dengan semua data
        $userDemo = User::where('email', 'user@gmail.com')->first();
        if ($userDemo) {
            $periodeDemo = $periodes->firstWhere('status', 'aktif') ?? $periodes->first();
            $tanggalLahirPria = $faker->dateTimeBetween('-35 years', '-28 years');
            $tanggalLahirWanita = $faker->dateTimeBetween('-33 years', '-26 years');
            $tanggalPernikahan = Carbon::parse($periodeDemo->tanggal_mulai ?? Carbon::now())->addWeeks(3);

            $pendaftaranDemo = PendaftaranPernikahan::create([
                'user_id'                => $userDemo->id,
                'periode_id'             => $periodeDemo->id,
                'nama_pria'              => 'Budi Santoso',
                'tempat_lahir_pria'      => 'Jakarta',
                'tanggal_lahir_pria'     => $tanggalLahirPria,
                'nik_pria'               => '3171011501890001',
                'agama_pria'             => 'Katolik',
                'pekerjaan_pria'         => 'Karyawan Swasta',
                'alamat_pria'            => 'Jl. Sudirman No. 45, Jakarta Pusat',
                'nama_ayah_pria'         => 'Bambang Santoso',
                'nama_ibu_pria'          => 'Siti Aminah',
                'nama_wanita'            => 'Dewi Lestari',
                'tempat_lahir_wanita'    => 'Bandung',
                'tanggal_lahir_wanita'   => $tanggalLahirWanita,
                'nik_wanita'             => '3201015502920002',
                'agama_wanita'           => 'Katolik',
                'pekerjaan_wanita'       => 'Guru',
                'alamat_wanita'          => 'Jl. Merdeka No. 12, Bandung',
                'nama_ayah_wanita'       => 'Ahmad Wijaya',
                'nama_ibu_wanita'        => 'Maria Susanti',
                'tanggal_pernikahan'     => $tanggalPernikahan,
                'tempat_pernikahan'      => 'Gereja Katedral Jakarta',
                'email'                  => $userDemo->email,
                'nomor_hp'               => '081234567890',
                'ktp_pria'               => null,
                'ktp_wanita'             => null,
                'surat_baptis_pria'      => null,
                'surat_baptis_wanita'    => null,
                'surat_pengantar_kombas_pria'   => null,
                'surat_pengantar_kombas_wanita' => null,
                'status'                 => 'proses',
                'catatan'                => 'Pendaftaran demo untuk testing.',
                'status_dokumen'         => 'disetujui',
                'catatan_dokumen'        => null,
                'perbaikan_dokumen_user' => null,
                'status_kursus'          => 'berjalan',
                'status_pembayaran'      => 'lunas',
                'midtrans_order_id'      => null,
                'midtrans_snap_token'    => null,
                'midtrans_transaction_id'=> null,
                'qris_url'               => null,
                'qris_expired_at'        => null,
                'email_konfirmasi_pembayaran_sent_at' => now(),
            ]);
            $pendaftaranSemua->push($pendaftaranDemo);
        }

        // Biaya per periode
        $biayaSemua = collect();
        foreach ($periodes as $periode) {
            // Biaya utama pendaftaran
            $biayaSemua->push(
                Biaya::create([
                    'jenis'      => 'pendaftaran',
                    'nama'       => 'Biaya Kursus ' . $periode->nama,
                    'nominal'    => $faker->numberBetween(250000, 750000),
                    'keterangan' => 'Biaya utama kursus persiapan pernikahan',
                    'periode_id' => $periode->id,
                    'aktif'      => true,
                ])
            );

            // Biaya tambahan
            for ($i = 0; $i < 2; $i++) {
                $biayaSemua->push(
                    Biaya::create([
                        'jenis'      => 'tambahan',
                        'nama'       => 'Biaya Tambahan ' . ($i + 1) . ' - ' . $periode->nama,
                        'nominal'    => $faker->numberBetween(50000, 200000),
                        'keterangan' => $faker->sentence(6),
                        'periode_id' => $periode->id,
                        'aktif'      => $faker->boolean(80),
                    ])
                );
            }
        }

        // Tagihan biaya untuk setiap pendaftaran
        foreach ($pendaftaranSemua as $pendaftaran) {
            $biayaPerPeriode = $biayaSemua->where('periode_id', $pendaftaran->periode_id)->values();
            if ($biayaPerPeriode->isEmpty()) {
                continue;
            }

            // Satu tagihan utama + kemungkinan satu tagihan tambahan
            $biayaUtama = $biayaPerPeriode->firstWhere('jenis', 'pendaftaran') ?? $biayaPerPeriode->first();
            $biayaTambahan = $biayaPerPeriode->where('jenis', 'tambahan');

            $daftarBiaya = collect([$biayaUtama]);
            if ($biayaTambahan->isNotEmpty() && $faker->boolean(60)) {
                $daftarBiaya->push($biayaTambahan->random());
            }

            foreach ($daftarBiaya as $biaya) {
                $statusTagihan = $faker->randomElement(['belum_bayar', 'menunggu', 'lunas', 'gagal']);

                BiayaTagihan::create([
                    'biaya_id'               => $biaya->id,
                    'pendaftaran_id'         => $pendaftaran->id,
                    'status'                 => $statusTagihan,
                    'midtrans_order_id'      => $faker->optional(40)->uuid(),
                    'midtrans_transaction_id'=> $faker->optional(40)->uuid(),
                    'qris_url'               => $faker->optional(40)->url(),
                    'qris_expired_at'        => $faker->optional()->dateTimeBetween('now', '+1 month'),
                ]);
            }
        }

        // Kehadiran kursus (untuk setiap kombinasi pendaftaran & materi di periode yang sama)
        foreach ($pendaftaranSemua as $pendaftaran) {
            $materiPeriode = $materiSemuaPeriode->where('periode_id', $pendaftaran->periode_id);
            foreach ($materiPeriode as $materi) {
                KehadiranKursus::create([
                    'pendaftaran_id'  => $pendaftaran->id,
                    'materi_kursus_id'=> $materi->id,
                    'hadir_tatap_muka'=> $faker->boolean(60),
                    'hadir_zoom'      => $faker->boolean(40),
                    'catatan'         => $faker->optional(30)->sentence(8),
                ]);
            }
        }

        // Surat kelulusan untuk pendaftaran yang status kursus/pendaftaran sudah selesai
        foreach ($pendaftaranSemua->filter(function ($p) {
            return $p->status === 'selesai' || $p->status_kursus === 'selesai';
        }) as $pendaftaran) {
            SuratKelulusan::create([
                'pendaftaran_id' => $pendaftaran->id,
                'file'           => 'surat_kelulusan/surat-' . $pendaftaran->id . '.pdf',
                'nama_surat'     => 'Surat Kelulusan - ' . $pendaftaran->namaLengkap(),
            ]);
        }

        // Pesan dashboard ke beberapa user dari super admin (jika ada)
        if ($superAdmin) {
            foreach ($users->take(10) as $user) {
                PesanDashboard::create([
                    'user_id'      => $user->id,
                    'dari_user_id' => $superAdmin->id,
                    'judul'        => 'Selamat datang di portal kursus',
                    'isi'          => $faker->paragraph(2),
                    'dibaca_at'    => $faker->optional(50)->dateTimeBetween('-3 days', 'now'),
                ]);
            }
            // Pesan untuk user demo
            if ($userDemo) {
                PesanDashboard::create([
                    'user_id'      => $userDemo->id,
                    'dari_user_id' => $superAdmin->id,
                    'judul'        => 'Selamat datang di portal kursus',
                    'isi'          => 'Ini adalah akun demo. Data pendaftaran kursus pernikahan Anda sudah terisi lengkap untuk keperluan testing.',
                    'dibaca_at'    => null,
                ]);
            }
        }
    }
}
