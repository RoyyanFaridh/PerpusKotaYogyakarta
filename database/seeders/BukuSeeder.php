<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // lokasi_id: 1=Kotabaru, 2=PEVITA, 3=Bank Buku
        // is_visible: false untuk menyembunyikan buku dari katalog publik
        // paket_id: null = buku tanpa paket (visibility dikontrol is_visible)
        // cover_url belum ada di skema, ditambahkan setelah migration siap

        $buku = [
            [
                'judul'         => 'Sapiens: Riwayat Singkat Umat Manusia',
                'pengarang'     => 'Yuval Noah Harari',
                'penerbit'      => 'KPG (Kepustakaan Populer Gramedia)',
                'isbn'          => '9786024243432',
                'tahun_terbit'  => 2017,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Buku ini mengisahkan perjalanan panjang umat manusia dari zaman batu hingga era modern.',
                'stok'          => 3,
                'kategori'      => 'Geografi & Sejarah',
                'lokasi_id'     => 1,
                'user_id'       => 1,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Atomic Habits',
                'pengarang'     => 'James Clear',
                'penerbit'      => 'Gramedia Pustaka Utama',
                'isbn'          => '9786020638775',
                'tahun_terbit'  => 2019,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'stok'          => 2,
                'kategori'      => 'Filsafat & Psikologi',
                'lokasi_id'     => 1,
                'user_id'       => 1,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Homo Deus: Masa Depan Umat Manusia',
                'pengarang'     => 'Yuval Noah Harari',
                'penerbit'      => 'KPG (Kepustakaan Populer Gramedia)',
                'isbn'          => '9786024244484',
                'tahun_terbit'  => 2018,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Eksplorasi tentang masa depan umat manusia di era kecerdasan buatan dan bioteknologi.',
                'stok'          => 2,
                'kategori'      => 'Sains & Matematika',
                'lokasi_id'     => 2,
                'user_id'       => 1,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Laskar Pelangi',
                'pengarang'     => 'Andrea Hirata',
                'penerbit'      => 'Bentang Pustaka',
                'isbn'          => '9789791227462',
                'tahun_terbit'  => 2005,
                'tempat_terbit' => 'Yogyakarta',
                'resume'        => 'Kisah inspiratif tentang sepuluh anak Belitung yang berjuang meraih mimpi di tengah keterbatasan.',
                'stok'          => 5,
                'kategori'      => 'Literatur & Sastra',
                'lokasi_id'     => 1,
                'user_id'       => 2,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Bumi Manusia',
                'pengarang'     => 'Pramoedya Ananta Toer',
                'penerbit'      => 'Lentera Dipantara',
                'isbn'          => '9789799731999',
                'tahun_terbit'  => 2005,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Novel sejarah tentang perjuangan Minke di era kolonial Hindia Belanda.',
                'stok'          => 4,
                'kategori'      => 'Literatur & Sastra',
                'lokasi_id'     => 2,
                'user_id'       => 2,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Rich Dad Poor Dad',
                'pengarang'     => 'Robert T. Kiyosaki',
                'penerbit'      => 'Gramedia Pustaka Utama',
                'isbn'          => '9786020321448',
                'tahun_terbit'  => 2015,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Pelajaran tentang keuangan dan investasi dari dua sudut pandang ayah yang berbeda.',
                'stok'          => 3,
                'kategori'      => 'Ilmu Sosial',
                'lokasi_id'     => 1,
                'user_id'       => 1,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Sejarah Peradaban Islam',
                'pengarang'     => 'Badri Yatim',
                'penerbit'      => 'Rajawali Pers',
                'isbn'          => '9789797690458',
                'tahun_terbit'  => 2014,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Telaah komprehensif tentang sejarah dan perkembangan peradaban Islam dari masa ke masa.',
                'stok'          => 2,
                'kategori'      => 'Agama',
                'lokasi_id'     => 2,
                'user_id'       => 3,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Filosofi Teras',
                'pengarang'     => 'Henry Manampiring',
                'penerbit'      => 'Kompas',
                'isbn'          => '9786024125103',
                'tahun_terbit'  => 2018,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Penerapan filsafat Stoa dalam kehidupan modern untuk menghadapi tekanan dan kecemasan.',
                'stok'          => 4,
                'kategori'      => 'Filsafat & Psikologi',
                'lokasi_id'     => 1,
                'user_id'       => 2,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Pengantar Ilmu Komputer',
                'pengarang'     => 'Rinaldi Munir',
                'penerbit'      => 'Informatika',
                'isbn'          => '9789798455124',
                'tahun_terbit'  => 2016,
                'tempat_terbit' => 'Bandung',
                'resume'        => 'Pengenalan konsep dasar ilmu komputer untuk mahasiswa tingkat awal.',
                'stok'          => 6,
                'kategori'      => 'Umum/Komputer',
                'lokasi_id'     => 2,
                'user_id'       => 3,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
            [
                'judul'         => 'Negeri 5 Menara',
                'pengarang'     => 'Ahmad Fuadi',
                'penerbit'      => 'Gramedia Pustaka Utama',
                'isbn'          => '9789792278965',
                'tahun_terbit'  => 2009,
                'tempat_terbit' => 'Jakarta',
                'resume'        => 'Kisah enam santri dari pelosok nusantara yang bermimpi meraih cita-cita setinggi langit.',
                'stok'          => 3,
                'kategori'      => 'Literatur & Sastra',
                'lokasi_id'     => 1,
                'user_id'       => 1,
                'paket_id'      => null,
                'is_visible'    => true,
            ],
        ];

        foreach ($buku as $item) {
            Buku::create($item);
        }
    }
}