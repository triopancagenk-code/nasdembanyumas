<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Seed initial articles for DPD Partai NasDem Banyumas.
     */
    public function run(): void
    {
        Article::query()->delete();

        $articles = [
            [
                'title' => 'DPD NasDem Banyumas Gelar Konsolidasi Akbar 27 Kecamatan Songsong Kemenangan 2029',
                'category' => 'Konsolidasi & Kaderisasi',
                'excerpt' => 'Rapat koordinasi daerah dihadiri seluruh pengurus DPC 27 kecamatan dan perwakilan 331 DPRt desa se-Kabupaten Banyumas guna memperkuat struktur teritorial hingga tingkat akar rumput.',
                'content' => "<p><strong>PURWOKERTO</strong> – Dewan Pimpinan Daerah (DPD) Partai NasDem Kabupaten Banyumas menggelar Rapat Koordinasi dan Konsolidasi Akbar yang dihadiri oleh seluruh jajaran pengurus DPC dari 27 kecamatan serta perwakilan DPRt dari 331 desa dan kelurahan se-Kabupaten Banyumas.</p>
<p>Ketua DPD Partai NasDem Banyumas, <strong>Edris Santoso, S.E.</strong>, dalam sambutannya menegaskan pentingnya menjaga soliditas dan militansi kader setelah keberhasilan menempatkan wakil di DPRD Kabupaten Banyumas periode 2024–2029. Konsolidasi ini menjadi tonggak awal percepatan penguatan struktur hingga tingkat TPS.</p>
<p><em>\"Partai NasDem di Banyumas adalah rumah besar perjuangan restorasi. Kita telah membuktikan bahwa dengan kerja keras dan pendekatan humanis, masyarakat Banyumas menaruh kepercayaan besar kepada kita. Kini tugas kita melipatgandakan kerja nyata, turun ke desa-desa, dan hadir mendengar denyut nadi rakyat,\"</em> ujar Edris di hadapan ratusan kader yang memadati aula pertemuan.</p>
<p>Dalam agenda ini, DPD juga meluncurkan program pemutakhiran KTA digital terintegrasi yang mempermudah interaksi warga dengan kantor DPD dan DPC setempat.</p>",
                'image' => 'images/slider_1.jpg',
                'author_name' => 'Administrator DPD NasDem',
                'published_at' => '2026-09-15',
                'status' => 'Published',
                'views_count' => 342,
            ],
            [
                'title' => 'Fraksi NasDem DPRD Banyumas Kawal Aspirasi Infrastruktur & Kesejahteraan Petani di Banyumas Barat',
                'category' => 'Fraksi NasDem',
                'excerpt' => 'Anggota DPRD Banyumas Fraksi NasDem Nartam Andrea Nusa menegaskan komitmen pengawalan alokasi anggaran irigasi teknis dan distribusi pupuk bersubsidi bagi para petani.',
                'content' => "<p><strong>BANYUMAS</strong> – Anggota Dewan Perwakilan Rakyat Daerah (DPRD) Kabupaten Banyumas dari Fraksi Partai NasDem, <strong>Nartam Andrea Nusa</strong>, kembali turun langsung ke daerah pemilihannya untuk menyerap aspirasi kelompok tani dan warga perdesaan.</p>
<p>Dalam dialog terbuka bersama gabungan kelompok tani (Gapoktan) di kawasan Banyumas Barat, isu utama yang diangkat meliputi ketersediaan pupuk bersubsidi, normalisasi saluran irigasi primer, serta perbaikan akses jalan usaha tani guna memangkas biaya distribusi hasil panen gabah.</p>
<p><em>\"Sebagai wakil rakyat dari Partai NasDem, kami berikhtiar sekuat tenaga agar APBD Banyumas benar-benar berpihak pada sektor pertanian dan ekonomi rakyat kecil. Setiap keluhan bapak-ibu petani akan kami bawa ke rapat komisi dan banggar untuk diwujudkan dalam program nyata,\"</em> tegas Nartam.</p>
<p>Warga mengapresiasi keterbukaan wakil rakyat NasDem yang rutin menggelar silaturahmi tanpa batas sekat birokrasi.</p>",
                'image' => 'images/news_1.jpg',
                'author_name' => 'Humas Fraksi NasDem',
                'published_at' => '2026-09-12',
                'status' => 'Published',
                'views_count' => 285,
            ],
            [
                'title' => 'Aksi Sosial NasDem Peduli Bagikan 1.500 Paket Sembako untuk Warga Kurang Mampu di Banyumas',
                'category' => 'NasDem Peduli',
                'excerpt' => 'Bakti sosial serentak digelar di wilayah Cilongok, Wangon, dan Ajibarang sebagai wujud nyata politik kehadiran dan kepedulian tanpa pamrih bagi masyarakat.',
                'content' => "<p><strong>CILONGOK</strong> – Mengusung semangat kepedulian sosial dan politik tanpa mahar, DPD Partai NasDem Kabupaten Banyumas menyalurkan sebanyak 1.500 paket sembako kebutuhan pokok bagi keluarga kurang mampu, lansia, dan yatim piatu di sejumlah kecamatan.</p>
<p>Bakti sosial bertajuk <strong>'NasDem Peduli: Berbagi Berkah untuk Rakyat'</strong> ini dipusatkan di Kecamatan Cilongok, kemudian didistribusikan secara bergiliran ke Wangon, Lumbir, dan Ajibarang melalui koordinasi pengurus DPC dan DPRt desa.</p>
<p>Sekretaris DPD Partai NasDem Banyumas, <strong>Yayat Nur Muslimin Saputra</strong>, menyatakan bahwa kegiatan sosial seperti ini telah menjadi kultur partai sejak didirikan.</p>
<p><em>\"Partai NasDem tidak hanya hadir saat menjelang pemilu, melainkan senantiasa berdampingan dengan rakyat dalam suka maupun duka. Gotong royong kemanusiaan inilah jati diri Gerakan Perubahan,\"</em> terangnya.</p>",
                'image' => 'images/baksos.jpg',
                'author_name' => 'Bappilu & Peduli NasDem',
                'published_at' => '2026-09-08',
                'status' => 'Published',
                'views_count' => 419,
            ],
            [
                'title' => 'Ketua DPD Edris Santoso: Generasi Muda dan Digitalisasi Menjadi Kunci Restorasi Banyumas',
                'category' => 'DPD NasDem Banyumas',
                'excerpt' => 'DPD Partai NasDem Banyumas terus menggenjot perekrutan pemilih pemula dan generasi milenial melalui program keanggotaan digital dan forum kreatif pemuda.',
                'content' => "<p><strong>PURWOKERTO</strong> – Komposisi demografi anggota Partai NasDem Kabupaten Banyumas yang kini didominasi generasi muda (Gen Z dan Milenial produktif mencapai lebih dari 75 persen) menjadi modal utama dalam transformasi politik daerah yang cerdas dan berintegritas.</p>
<p>Hal tersebut ditegaskan oleh Ketua DPD Partai NasDem Banyumas <strong>Edris Santoso, S.E.</strong> dalam workshop kepemimpinan pemuda yang berlangsung di Purwokerto.</p>
<p><em>\"Kaum muda Banyumas memiliki energi kreatif dan kecintaan besar pada kemajuan daerah. Partai NasDem memberikan panggung seluas-luasnya bagi anak muda untuk berpartisipasi aktif, mengawal kebijakan publik, dan melahirkan gagasan pembangunan yang berdampak langsung bagi kemajuan Banyumas,\"</em> pungkasnya.</p>",
                'image' => 'images/news_2.jpg',
                'author_name' => 'Media & Komunikasi Publik',
                'published_at' => '2026-09-02',
                'status' => 'Published',
                'views_count' => 512,
            ],
            [
                'title' => 'Konsolidasi Sayap Partai: Garda Pemuda dan Garnita NasDem Banyumas Perkuat Basis Perempuan',
                'category' => 'Sayap Partai',
                'excerpt' => 'Garnita Malahayati Kabupaten Banyumas siap mendampingi UMKM perempuan dan memastikan keterwakilan perempuan di atas 30 persen terus terjaga secara konsisten.',
                'content' => "<p><strong>SOKARAJA</strong> – Sayap organisasi perempuan Partai NasDem, Garda Wanita (Garnita) Malahayati bersama Garda Pemuda NasDem Banyumas menggelar konsolidasi kepengurusan guna mematangkan program pendampingan ekonomi keluarga dan pemberdayaan perempuan.</p>
<p>Ketua Bidang Perempuan dan Anak DPD NasDem Banyumas, Rinawati, menegaskan bahwa peran perempuan dalam kancah perpolitikan lokal Banyumas semakin strategis. Partai NasDem terbukti konsisten melampaui kuota keterwakilan perempuan 30% dalam kepengurusan struktural partai di seluruh Banyumas.</p>",
                'image' => 'images/news_3.jpg',
                'author_name' => 'Garnita Malahayati',
                'published_at' => '2026-08-28',
                'status' => 'Published',
                'views_count' => 198,
            ],
        ];

        foreach ($articles as $art) {
            Article::updateOrCreate(
                ['slug' => Str::slug($art['title'])],
                [
                    'title' => $art['title'],
                    'category' => $art['category'],
                    'excerpt' => $art['excerpt'],
                    'content' => $art['content'],
                    'image' => $art['image'],
                    'author_name' => $art['author_name'],
                    'published_at' => $art['published_at'],
                    'status' => $art['status'],
                    'views_count' => $art['views_count'],
                ]
            );
        }
    }
}
