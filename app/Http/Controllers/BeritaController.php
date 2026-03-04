<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    private function getAllBerita()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Perayaan Hari Raya Hati Kudus Yesus',
                'tanggal' => '15 Juni 2024',
                'penulis' => 'Admin Biara',
                'kategori' => 'Liturgi',
                'ringkasan' => 'Komunitas Biara Loresa SCJ merayakan Hari Raya Hati Kudus Yesus dengan penuh sukacita dan devosi yang mendalam.',
                'isi' => 'Pada hari Jumat, 15 Juni 2024, Komunitas Biara Loresa SCJ merayakan Hari Raya Hati Kudus Yesus dengan penuh kekhidmatan. Perayaan ini dimulai dengan Ibadat Pagi bersama seluruh anggota komunitas, dilanjutkan dengan Perayaan Ekaristi meriah yang dipimpin oleh Superior Komunitas. Seluruh umat paroki turut ambil bagian dalam perayaan yang penuh devosi ini. Hati Kudus Yesus merupakan lambang kasih Allah yang tak terbatas kepada manusia, dan inilah spiritualitas yang menjadi dasar kongregasi SCJ.',
                'gambar' => 'https://images.unsplash.com/photo-1438232992991-995b671e4b8d?w=800&h=500&fit=crop',
            ],
            [
                'id' => 2,
                'judul' => 'Retret Tahunan Komunitas SCJ',
                'tanggal' => '5 Juli 2024',
                'penulis' => 'Rm. Antonius, SCJ',
                'kategori' => 'Komunitas',
                'ringkasan' => 'Para frater dan imam SCJ mengikuti retret tahunan sebagai sarana pembaruan spiritual dan komunitas.',
                'isi' => 'Selama tiga hari penuh, dari tanggal 3 hingga 5 Juli 2024, seluruh anggota Komunitas Biara Loresa SCJ mengikuti Retret Tahunan. Retret kali ini bertema "Dipanggil untuk Mencintai" yang membawa setiap anggota komunitas untuk merenungkan panggilan mereka sebagai anggota SCJ. Retret dipandu oleh Rm. Markus Wijaya, SJ, seorang pembimbing retret berpengalaman. Momen ini menjadi kesempatan berharga untuk mempererat tali persaudaraan dan memperbarui semangat pelayanan.',
                'gambar' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=800&h=500&fit=crop',
            ],
            [
                'id' => 3,
                'judul' => 'Penerimaan Novisiat Angkatan Baru',
                'tanggal' => '20 Agustus 2024',
                'penulis' => 'Admin Biara',
                'kategori' => 'Pembinaan',
                'ringkasan' => 'Biara Loresa SCJ menyambut dengan gembira para calon novis baru yang memulai perjalanan panggilan mereka.',
                'isi' => 'Pada tanggal 20 Agustus 2024, Biara Loresa SCJ mengadakan upacara penerimaan novisiat untuk 8 orang calon novis baru. Mereka datang dari berbagai daerah di Indonesia dengan semangat yang membara untuk menapaki jalan panggilan sebagai anggota Serikat Imam-imam Hati Kudus Yesus (SCJ). Upacara penerimaan dipimpin oleh Superior Provinsi Indonesia. Para novis baru ini akan menjalani masa pembinaan selama dua tahun di bawah bimbingan Magister Novis.',
                'gambar' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=800&h=500&fit=crop',
            ],
            [
                'id' => 4,
                'judul' => 'Bakti Sosial di Desa Sekitar Biara',
                'tanggal' => '10 September 2024',
                'penulis' => 'Rm. Yohanes, SCJ',
                'kategori' => 'Sosial',
                'ringkasan' => 'Komunitas SCJ mengadakan bakti sosial berupa pembagian sembako dan pengobatan gratis bagi warga sekitar biara.',
                'isi' => 'Sebagai wujud nyata semangat kasih Hati Kudus Yesus, Komunitas Biara Loresa SCJ bersama para umat paroki mengadakan bakti sosial di Desa Sukamaju pada tanggal 10 September 2024. Kegiatan meliputi pembagian paket sembako untuk 200 keluarga kurang mampu, pelayanan kesehatan gratis, dan donor darah. Kegiatan ini merupakan bagian dari misi pelayanan SCJ kepada masyarakat yang membutuhkan, sebagai bentuk pewartaan Injil yang nyata.',
                'gambar' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&h=500&fit=crop',
            ],
            [
                'id' => 5,
                'judul' => 'Peringatan 25 Tahun Biara Loresa SCJ',
                'tanggal' => '1 Oktober 2024',
                'penulis' => 'Admin Biara',
                'kategori' => 'Perayaan',
                'ringkasan' => 'Biara Loresa SCJ merayakan ulang tahun ke-25 dengan berbagai kegiatan spiritual dan budaya yang meriah.',
                'isi' => 'Pada tanggal 1 Oktober 2024, Biara Loresa SCJ merayakan Dies Natalis ke-25 dengan penuh syukur. Perayaan diawali dengan Misa Syukur agung yang dihadiri oleh para imam, frater, bruder, dan umat dari berbagai paroki. Hadir pula perwakilan dari provinsi-provinsi SCJ di seluruh Indonesia. Momen jubileum ini menjadi kesempatan untuk mengenang sejarah, mensyukuri berkat Tuhan, dan memperbarui semangat misi komunitas ke depan.',
                'gambar' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=500&fit=crop',
            ],
            [
                'id' => 6,
                'judul' => 'Kunjungan Pastoral ke Umat Terpencil',
                'tanggal' => '15 Oktober 2024',
                'penulis' => 'Rm. Petrus, SCJ',
                'kategori' => 'Pastoral',
                'ringkasan' => 'Tim pastoral biara melakukan kunjungan ke umat yang tinggal di daerah terpencil untuk memberikan pelayanan sakramen.',
                'isi' => 'Tim pastoral dari Biara Loresa SCJ melakukan kunjungan pastoral selama 5 hari ke beberapa desa terpencil di pegunungan. Kunjungan ini membawa sukacita yang besar bagi umat yang sudah lama tidak mendapatkan pelayanan pastoral. Berbagai sakramen diberikan, termasuk baptis, ekaristi, tobat, dan pengurapan orang sakit. Momen ini mengingatkan kembali akan pentingnya karya misi SCJ di daerah-daerah yang belum terjangkau pelayanan Gereja.',
                'gambar' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=500&fit=crop',
            ],
        ];
    }

    public function index()
    {
        $berita = $this->getAllBerita();
        return view('berita.index', compact('berita'));
    }

    public function show($id)
    {
        $allBerita = $this->getAllBerita();
        $berita = collect($allBerita)->firstWhere('id', (int)$id);

        if (!$berita) {
            abort(404);
        }

        $beritaLainnya = collect($allBerita)->where('id', '!=', (int)$id)->take(3)->values()->toArray();

        return view('berita.show', compact('berita', 'beritaLainnya'));
    }
}
