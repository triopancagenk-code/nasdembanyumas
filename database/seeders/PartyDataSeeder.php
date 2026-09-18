<?php

namespace Database\Seeders;

use App\Models\Dpc;
use App\Models\DpdOfficer;
use App\Models\Dprt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PartyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users: Admin & Pengguna
        User::updateOrCreate(
            ['email' => 'admin@nasdem.id'],
            [
                'name' => 'Administrator DPD NasDem',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '0812-3456-7890',
                'kta_number' => 'ND-BMS-ADM-001',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pengguna@nasdem.id'],
            [
                'name' => 'Kader NasDem Banyumas',
                'password' => Hash::make('user123'),
                'role' => 'pengguna',
                'phone' => '0857-1122-3344',
                'kta_number' => 'ND-BMS-KDR-889',
            ]
        );

        // Admin Bapilu 2026
        User::updateOrCreate(
            ['email' => 'bapilu2026@nasdem.id'],
            [
                'name' => 'bapilu2026',
                'password' => Hash::make('bapilu2026'),
                'role' => 'admin',
                'phone' => '0812-2026-2026',
                'kta_number' => 'ND-BMS-BAPILU-2026',
            ]
        );

        // 2. DPD Officers (Susunan Pengurus DPD Partai NasDem Kabupaten Banyumas Periode 2026-2029)
        DpdOfficer::query()->delete();

        $dpdOfficers = [
            // Pimpinan (Ketua)
            ['category' => 'inti', 'title' => 'Ketua', 'name' => 'Edris Santoso, S.E.', 'photo' => '/images/ketua_dpd.jpg', 'phone' => '0813-2764-2853', 'sk_number' => null, 'sort_order' => 1, 'status' => 'Aktif'],

            // 24 Wakil Ketua Bidang
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pemenangan Pemilu', 'name' => 'Nurokhman', 'photo' => '/storage/uploads/officer_1789628970_w0bwnrju.jpg', 'phone' => '0811-2511-1471', 'sk_number' => null, 'sort_order' => 2, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Organisasi dan Keanggotaan', 'name' => 'Zaqki Aulia', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 3, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Kaderisasi dan Pendidikan Politik', 'name' => 'Toni', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 4, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Hubungan Legislatif', 'name' => 'Vembry Dwi Widiyanto', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 5, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Hubungan Eksekutif', 'name' => 'Suprayogi, S.IP', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 6, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Hubungan Sayap dan Badan', 'name' => 'Agam Soedijono, SH., M.Kn., C.P.L', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 7, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Penggalangan dan Penggerak Komunitas', 'name' => 'Andrianto', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 8, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pemilih Pemula dan Milenial', 'name' => 'Bagus Panuntun Hutama Putra', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 9, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Digital dan Siber', 'name' => 'Abdul Jahir', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 10, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Media dan Komunikasi Publik', 'name' => 'Sutrisno', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 11, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Ekonomi', 'name' => 'Ristam', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 12, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Usaha Mikro Kecil dan Menengah', 'name' => 'Imam Syaefudin', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 13, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Agama dan Masyarakat Adat', 'name' => 'Syaiful Mumin', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 14, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Tenaga Kerja', 'name' => 'Ani Pujianti, SM', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 15, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Kesehatan', 'name' => 'Setiyani', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 16, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Perempuan dan Anak', 'name' => 'Rinawati', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 17, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pendidikan dan Kebudayaan', 'name' => 'Ari Widyawati', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 18, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Hukum dan Hak Asasi Manusia', 'name' => 'Eko Mediantoro, SH', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 19, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pariwisata dan Industri Kreatif', 'name' => 'Triono Ari Pamungkas', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 20, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pertanian, Peternakan dan Kemandirian Desa', 'name' => 'Prahesa Gatot Hutama', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 21, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pemuda dan Olahraga', 'name' => 'Iwan Yulianto, ST', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 22, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Lingkungan Hidup', 'name' => 'Farkhan Putri Antony', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 23, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Migran', 'name' => 'Nur Fajar Sidik', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 24, 'status' => 'Aktif'],
            ['category' => 'bidang', 'title' => 'Wakil Ketua Bidang Pembangunan dan Infrastruktur', 'name' => 'Sunarto Rachmat Widiyanto', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 25, 'status' => 'Aktif'],

            // Kesekretariatan (Sekretaris & 4 Wakil Sekretaris)
            ['category' => 'inti', 'title' => 'Sekretaris', 'name' => 'Yayat Nur Muslimin Saputra', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 26, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Sekretaris Bidang Kebijakan Publik dan Isu Strategis', 'name' => 'Desi Nur Sekardinah', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 27, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Sekretaris Bidang Ideologi, Organisasi dan Kaderisasi', 'name' => 'Desi Dwi Pamukti Sari', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 28, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Sekretaris Bidang Pemenangan Pemilu', 'name' => 'Nully Melany', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 29, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Sekretaris Bidang Umum dan Administrasi', 'name' => 'Janathy Cherry', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 30, 'status' => 'Aktif'],

            // Kebendaharaan (Bendahara & 2 Wakil Bendahara)
            ['category' => 'inti', 'title' => 'Bendahara', 'name' => 'Nartam Andrea Nusa', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 31, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Bendahara Pengelolaan Dana dan Aset', 'name' => 'Siti Nurtoyibah', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 32, 'status' => 'Aktif'],
            ['category' => 'inti', 'title' => 'Wakil Bendahara Penggalangan Dana', 'name' => 'Eni Kusrini, S.Pd', 'photo' => null, 'phone' => null, 'sk_number' => null, 'sort_order' => 33, 'status' => 'Aktif'],
        ];

        foreach ($dpdOfficers as $officer) {
            DpdOfficer::create($officer);
        }

        // 3. 27 DPC Kecamatan di Kabupaten Banyumas & 331 Desa/Kelurahan
        $banyumasData = [
            'Ajibarang' => [
                'dapil' => 'Dapil 5', 'ketua' => 'Teguh Prabowo', 'sekretaris' => 'Hadi Santoso', 'bendahara' => 'Sri Rejeki',
                'desas' => ['Ajibarang Kulon', 'Ajibarang Wetan', 'Banjarsari', 'Ciberung', 'Darmakradenan', 'Jingkang', 'Kalibenda', 'Karangbawang', 'Kracak', 'Lesmana', 'Pancasan', 'Pandansari', 'Sawangan', 'Tipar Kidul']
            ],
            'Banyumas' => [
                'dapil' => 'Dapil 3', 'ketua' => 'Suryo Atmojo', 'sekretaris' => 'Budi Utomo', 'bendahara' => 'Endah Kusuma',
                'desas' => ['Binangun', 'Danaraja', 'Dawuhan', 'Kalisube', 'Karangrau', 'Kedunguter', 'Kejawar', 'Papringan', 'Pasinggangan', 'Pekunden', 'Sudagaran']
            ],
            'Baturraden' => [
                'dapil' => 'Dapil 2', 'ketua' => 'Wahyudi Santoso', 'sekretaris' => 'Arief Rahman', 'bendahara' => 'Yuliana Putri',
                'desas' => ['Karangcegak', 'Karangmangu', 'Karangtengah', 'Kebumen', 'Kemutug Kidul', 'Kemutug Lor', 'Ketenger', 'Kutasari', 'Pandak', 'Purwosari', 'Rempoah']
            ],
            'Cilongok' => [
                'dapil' => 'Dapil 6', 'ketua' => 'H. Mulyono', 'sekretaris' => 'Didik Supriyadi', 'bendahara' => 'Fitri Handayani',
                'desas' => ['Batuanten', 'Cikidang', 'Cilongok', 'Cipete', 'Gununglurah', 'Jatisaba', 'Kalisari', 'Karanglo', 'Karangtengah', 'Kasegeran', 'Langgongsari', 'Pageraji', 'Panembangan', 'Panusupan', 'Pejogol', 'Pernasidi', 'Rancamaya', 'Sambirata', 'Sokawera', 'Sudimara']
            ],
            'Gumelar' => [
                'dapil' => 'Dapil 5', 'ketua' => 'Danang Kusworo', 'sekretaris' => 'Slamet Riyadi', 'bendahara' => 'Wiwit Lestari',
                'desas' => ['Cihonje', 'Cilangkap', 'Gancang', 'Gumelar', 'Karangkobar', 'Kedungkujang', 'Samudra', 'Samudra Kulon', 'Tlaga']
            ],
            'Jatilawang' => [
                'dapil' => 'Dapil 4', 'ketua' => 'Sukirno Hadi', 'sekretaris' => 'Agus Priyono', 'bendahara' => 'Sulastri',
                'desas' => ['Bantar', 'Gentawangi', 'Gunungsari', 'Karanganyar', 'Karanglewas', 'Kedungwringin', 'Margasana', 'Pekuncen', 'Rawalo', 'Tinggarjaya', 'Tunjung']
            ],
            'Kalibagor' => [
                'dapil' => 'Dapil 3', 'ketua' => 'Edi Gunawan', 'sekretaris' => 'Rahmat Hidayat', 'bendahara' => 'Nurul Aini',
                'desas' => ['Kalibagor', 'Kalicupak Kidul', 'Kalicupak Lor', 'Kaliori', 'Kalisogra Wetan', 'Karangdadap', 'Pajerukan', 'Pekaja', 'Petir', 'Srowot', 'Suro', 'Wlahar Wetan']
            ],
            'Karanglewas' => [
                'dapil' => 'Dapil 6', 'ketua' => 'Purnomo Sidi', 'sekretaris' => 'Nanang Kosim', 'bendahara' => 'Dewi Sartika',
                'desas' => ['Babakan', 'Jipang', 'Karanggude Kulon', 'Karangkemiri', 'Karanglewas Kidul', 'Kediri', 'Pangebatan', 'Pasir Kulon', 'Pasir Lor', 'Pasir Muncang', 'Pasir Wetan', 'Singasari', 'Sunyalangu']
            ],
            'Kebasen' => [
                'dapil' => 'Dapil 4', 'ketua' => 'Bambang Sugito', 'sekretaris' => 'Baskoro', 'bendahara' => 'Ratih Kumala',
                'desas' => ['Adisana', 'Bangsa', 'Cindaga', 'Gambarsari', 'Kalisalak', 'Karangsari', 'Kebasen', 'Mandirancan', 'Randegan', 'Sawangan', 'Tumiyang']
            ],
            'Kedungbanteng' => [
                'dapil' => 'Dapil 6', 'ketua' => 'Hartono', 'sekretaris' => 'Eko Prasetyo', 'bendahara' => 'Indah Permata',
                'desas' => ['Baseh', 'Beji', 'Dawuhan Kulon', 'Dawuhan Wetan', 'Kalikesur', 'Kalisalak', 'Karangnangka', 'Karangsalam Kidul', 'Kedungbanteng', 'Keniten', 'Kutaliman', 'Melung', 'Windujaya']
            ],
            'Kembaran' => [
                'dapil' => 'Dapil 2', 'ketua' => 'Anas Mahfudz', 'sekretaris' => 'Hendra Setiawan', 'bendahara' => 'Nia Daniati',
                'desas' => ['Bantarwuni', 'Bojongsari', 'Dukuhwaluh', 'Karangsari', 'Karangsoka', 'Karanglewas', 'Kembaran', 'Kramat', 'Ledug', 'Linggasari', 'Pliken', 'Purbadana', 'Purwodadi', 'Sambeng Kulon', 'Sambeng Wetan', 'Tambaksari Kidul']
            ],
            'Kemranjen' => [
                'dapil' => 'Dapil 3', 'ketua' => 'Drs. Supardi', 'sekretaris' => 'Moh. Toha', 'bendahara' => 'Siti Khotimah',
                'desas' => ['Alasmalang', 'Grujugan', 'Karanggintung', 'Karangjati', 'Karangsalam', 'Kebarongan', 'Kecila', 'Kedungpring', 'Nusamangir', 'Pageralang', 'Petarangan', 'Sibalung', 'Sibrama', 'Sidamulya', 'Sirau']
            ],
            'Lumbir' => [
                'dapil' => 'Dapil 5', 'ketua' => 'Rustam Effendi', 'sekretaris' => 'Yono Maryono', 'bendahara' => 'Titin Maryati',
                'desas' => ['Besuki', 'Canduk', 'Cidora', 'Cingebul', 'Cirahab', 'Dermaji', 'Karanggayam', 'Kedunggede', 'Lumbir', 'Parungkamal']
            ],
            'Patikraja' => [
                'dapil' => 'Dapil 1', 'ketua' => 'Suradi', 'sekretaris' => 'Deni Kurniawan', 'bendahara' => 'Ika Rahmawati',
                'desas' => ['Karanganyar', 'Karangendep', 'Kedungrandu', 'Kedungwringin', 'Kedungwuluh Kidul', 'Kedungwuluh Lor', 'Notog', 'Patikraja', 'Pegalongan', 'Sawangan Wetan', 'Sidabowa', 'Sokawera Kidul', 'Wlahar Kulon']
            ],
            'Pekuncen' => [
                'dapil' => 'Dapil 5', 'ketua' => 'H. Mufid', 'sekretaris' => 'Kusworo', 'bendahara' => 'Eni Sulistyowati',
                'desas' => ['Banjaranyar', 'Candinegara', 'Cibangkong', 'Cikawung', 'Cikembulan', 'Glempang', 'Karangkemiri', 'Karangklesem', 'Krajan', 'Kranggan', 'Pasiraman Kidul', 'Pasiraman Lor', 'Pekuncen', 'Petahunan', 'Semedo', 'Tumiyang']
            ],
            'Purwojati' => [
                'dapil' => 'Dapil 6', 'ketua' => 'Kurniawan', 'sekretaris' => 'Joko Waluyo', 'bendahara' => 'Lestari',
                'desas' => ['Gerduren', 'Kaliputih', 'Kalitapen', 'Kaliwangi', 'Karangmangu', 'Karangtalun Kidul', 'Karangtalun Lor', 'Klapasawit', 'Purwojati']
            ],
            'Purwokerto Barat' => [
                'dapil' => 'Dapil 1', 'ketua' => 'Bayu Wicaksono, S.T.', 'sekretaris' => 'Rizki Pratama', 'bendahara' => 'Sari Indrayani',
                'desas' => ['Bantarsoka', 'Karanglewas Lor', 'Kedungwuluh', 'Kober', 'Pasir Kidul', 'Pasirmuncang', 'Rejasari']
            ],
            'Purwokerto Selatan' => [
                'dapil' => 'Dapil 1', 'ketua' => 'Rahmat Basuki, S.E.', 'sekretaris' => 'Yuda Perdana', 'bendahara' => 'Dian Anggraini',
                'desas' => ['Berkoh', 'Karangklesem', 'Karangpucung', 'Purwokerto Kidul', 'Purwokerto Kulon', 'Tanjung', 'Teluk']
            ],
            'Purwokerto Timur' => [
                'dapil' => 'Dapil 1', 'ketua' => 'Ir. Hendra Gunawan', 'sekretaris' => 'Bagus Susanto', 'bendahara' => 'Ratna Juwita',
                'desas' => ['Arcawinangun', 'Kranji', 'Mersi', 'Purwokerto Lor', 'Purwokerto Wetan', 'Sokanegara']
            ],
            'Purwokerto Utara' => [
                'dapil' => 'Dapil 1', 'ketua' => 'Dr. Bambang Sutrisno', 'sekretaris' => 'Dedi Iskandar', 'bendahara' => 'Citra Kirana',
                'desas' => ['Bancarkembar', 'Bobosan', 'Grendeng', 'Karangwangkal', 'Pabuaran', 'Purwanegara', 'Sumampir']
            ],
            'Rawalo' => [
                'dapil' => 'Dapil 4', 'ketua' => 'Subagyo', 'sekretaris' => 'Wawan Setiawan', 'bendahara' => 'Sri Wahyuni',
                'desas' => ['Banjarparakan', 'Losari', 'Menganti', 'Pesawahan', 'Rawalo', 'Sanggreman', 'Sidamulih', 'Tambaknegara', 'Tipar']
            ],
            'Sokaraja' => [
                'dapil' => 'Dapil 2', 'ketua' => 'H. Muhlasin', 'sekretaris' => 'Taufik Hidayat', 'bendahara' => 'Yuli Astuti',
                'desas' => ['Banjaranyar', 'Banjarsari Kidul', 'Jompo Kulon', 'Kalikidang', 'Karangduren', 'Karangkedawung', 'Karangnanas', 'Karangrau', 'Kedondong', 'Klahang', 'Lemberang', 'Pamijen', 'Sokaraja Kidul', 'Sokaraja Kulon', 'Sokaraja Lor', 'Sokaraja Tengah', 'Sokaraja Wetan', 'Wiradadi']
            ],
            'Somagede' => [
                'dapil' => 'Dapil 3', 'ketua' => 'Parsono', 'sekretaris' => 'Heru Purwanto', 'bendahara' => 'Maryani',
                'desas' => ['Kanding', 'Kemawi', 'Klinting', 'Piasa Kulon', 'Plana', 'Sokawera', 'Somagede', 'Tanggeran']
            ],
            'Sumbang' => [
                'dapil' => 'Dapil 2', 'ketua' => 'H. Sunaryo', 'sekretaris' => 'Aris Munandar', 'bendahara' => 'Tri Hastuti',
                'desas' => ['Banjarsari Kulon', 'Banjarsari Wetan', 'Banteran', 'Ciberem', 'Datar', 'Gandatapa', 'Karangcegak', 'Karanggintung', 'Karangturi', 'Kawungcarang', 'Kebanggan', 'Kedungmalang', 'Kotayasa', 'Limpakuwus', 'Silado', 'Sikapat', 'Sumbang', 'Susukan', 'Tambaksogra']
            ],
            'Sumpiuh' => [
                'dapil' => 'Dapil 3', 'ketua' => 'H. Suwarto', 'sekretaris' => 'Ibnu Hajar', 'bendahara' => 'Nunung Nurjanah',
                'desas' => ['Bogangin', 'Karanggedang', 'Kebokura', 'Kemiri', 'Ketinggeman', 'Kradenan', 'Kroya', 'Lebeng', 'Nusadadi', 'Pandak', 'Selandaka', 'Sumpiuh']
            ],
            'Tambak' => [
                'dapil' => 'Dapil 3', 'ketua' => 'Ahmad Mudasir', 'sekretaris' => 'Ferry Andrian', 'bendahara' => 'Siti Maemunah',
                'desas' => ['Buniayu', 'Gebangsari', 'Gumelar Kidul', 'Gumelar Lor', 'Kamulyan', 'Karangpetir', 'Karangpucung', 'Plangkapan', 'Prembun', 'Purwodadi', 'Watuagung']
            ],
            'Wangon' => [
                'dapil' => 'Dapil 4', 'ketua' => 'Drs. H. Mahrus', 'sekretaris' => 'Sudarno', 'bendahara' => 'Rukmini',
                'desas' => ['Banteran', 'Cikakak', 'Jambu', 'Jurangbahas', 'Klapagading', 'Klapagading Kulon', 'Pangadegan', 'Randegan', 'Rawaheng', 'Wangon', 'Windunegara', 'Wlahar']
            ],
        ];

        $kecamatanMetrics = [
            'Cilongok' => ['kader' => 2140, 'suara' => 6850, 'target' => 7500],
            'Kedungbanteng' => ['kader' => 1480, 'suara' => 4420, 'target' => 5000],
            'Karanglewas' => ['kader' => 1450, 'suara' => 3980, 'target' => 4500],
            'Purwojati' => ['kader' => 1120, 'suara' => 3150, 'target' => 3500],
            'Purwokerto Selatan' => ['kader' => 1260, 'suara' => 3250, 'target' => 3800],
            'Purwokerto Barat' => ['kader' => 1180, 'suara' => 2840, 'target' => 3400],
            'Patikraja' => ['kader' => 1390, 'suara' => 2760, 'target' => 3300],
            'Purwokerto Timur' => ['kader' => 1040, 'suara' => 2620, 'target' => 3200],
            'Purwokerto Utara' => ['kader' => 1150, 'suara' => 2480, 'target' => 3000],
            'Sokaraja' => ['kader' => 1950, 'suara' => 3120, 'target' => 3800],
            'Sumbang' => ['kader' => 2020, 'suara' => 2940, 'target' => 3600],
            'Kembaran' => ['kader' => 1640, 'suara' => 2450, 'target' => 3000],
            'Baturraden' => ['kader' => 1250, 'suara' => 2150, 'target' => 2600],
            'Ajibarang' => ['kader' => 1680, 'suara' => 3450, 'target' => 4000],
            'Pekuncen' => ['kader' => 1720, 'suara' => 2890, 'target' => 3500],
            'Lumbir' => ['kader' => 1050, 'suara' => 1860, 'target' => 2200],
            'Gumelar' => ['kader' => 980, 'suara' => 1640, 'target' => 2000],
            'Wangon' => ['kader' => 1420, 'suara' => 2950, 'target' => 3500],
            'Jatilawang' => ['kader' => 1280, 'suara' => 2320, 'target' => 2800],
            'Kebasen' => ['kader' => 1220, 'suara' => 2180, 'target' => 2600],
            'Rawalo' => ['kader' => 960, 'suara' => 1740, 'target' => 2200],
            'Kemranjen' => ['kader' => 1580, 'suara' => 2420, 'target' => 2900],
            'Sumpiuh' => ['kader' => 1360, 'suara' => 2380, 'target' => 2900],
            'Banyumas' => ['kader' => 1240, 'suara' => 1950, 'target' => 2400],
            'Kalibagor' => ['kader' => 1310, 'suara' => 1880, 'target' => 2300],
            'Tambak' => ['kader' => 1160, 'suara' => 1620, 'target' => 2000],
            'Somagede' => ['kader' => 890, 'suara' => 1340, 'target' => 1700],
        ];

        foreach ($banyumasData as $kecamatan => $info) {
            $totalRanting = count($info['desas']);
            $metric = $kecamatanMetrics[$kecamatan] ?? ['kader' => 1200, 'suara' => 2200, 'target' => 2600];

            $dpc = Dpc::updateOrCreate(
                ['kecamatan_name' => $kecamatan],
                [
                    'dapil' => $info['dapil'],
                    'office_address' => 'Jl. Raya ' . $kecamatan . ' No. ' . rand(12, 99) . ', Banyumas',
                    'ketua_name' => $info['ketua'],
                    'sekretaris_name' => $info['sekretaris'],
                    'bendahara_name' => $info['bendahara'],
                    'phone' => '0812-7788-' . rand(1000, 9999),
                    'sk_number' => null,
                    'status' => 'SK Definitif',
                    'total_ranting' => $totalRanting,
                    'total_kader' => $metric['kader'],
                    'total_suara' => $metric['suara'],
                    'target_suara' => $metric['target'],
                ]
            );

            $desaCount = count($info['desas']);
            $baseKader = intdiv($metric['kader'], max(1, $desaCount));
            $remKader = $metric['kader'] % max(1, $desaCount);

            foreach ($info['desas'] as $idx => $desa) {
                $isKel = (str_starts_with($kecamatan, 'Purwokerto') && in_array($desa, ['Bantarsoka', 'Karanglewas Lor', 'Kedungwuluh', 'Kober', 'Pasir Kidul', 'Pasirmuncang', 'Rejasari', 'Berkoh', 'Karangklesem', 'Karangpucung', 'Purwokerto Kidul', 'Purwokerto Kulon', 'Tanjung', 'Teluk', 'Arcawinangun', 'Kranji', 'Mersi', 'Purwokerto Lor', 'Purwokerto Wetan', 'Sokanegara', 'Bancarkembar', 'Bobosan', 'Grendeng', 'Karangwangkal', 'Pabuaran', 'Purwanegara', 'Sumampir']));
                $desaKader = $baseKader + ($idx < $remKader ? 1 : 0);

                Dprt::updateOrCreate(
                    [
                        'kecamatan_name' => $kecamatan,
                        'desa_name' => $desa,
                    ],
                    [
                        'dpc_id' => $dpc->id,
                        'type' => $isKel ? 'Kelurahan' : 'Desa',
                        'ketua_name' => 'Ketua ' . $desa . ' (' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3) . ')',
                        'phone' => '0858-' . rand(1000, 9999) . '-' . rand(100, 999),
                        'status' => 'Terbentuk SK',
                        'total_kader' => $desaKader,
                    ]
                );
            }
        }

        // 5. Berita & Kegiatan Partai
        $this->call(ArticleSeeder::class);
    }
}
