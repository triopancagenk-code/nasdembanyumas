@extends('layouts.app')

@section('title', 'Visi & Misi – Partai NasDem Banyumas')

@section('content')

{{-- Header Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 120px 20px 60px; text-align: center; border-bottom: 3px solid #ffb700; position: relative;">
    <div style="max-width: 900px; margin: 0 auto;">
        <span style="display: inline-block; background: rgba(255, 183, 0, 0.15); color: #ffb700; font-size: 12px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; padding: 6px 16px; border-radius: 20px; margin-bottom: 16px; border: 1px solid rgba(255, 183, 0, 0.4);">
            GERAKAN PERUBAHAN
        </span>
        <h1 style="font-size: 40px; font-weight: 900; color: #ffffff; margin: 0 0 16px 0; line-height: 1.2;">
            Visi &amp; Misi <span style="color: #ffb700;">Partai NasDem</span>
        </h1>
        <p style="font-size: 16px; color: #cbd5e1; max-width: 700px; margin: 0 auto; line-height: 1.6;">
            Landasan perjuangan moral, politik, dan kebangsaan Partai NasDem untuk mewujudkan Indonesia yang adil, makmur, berdaulat, dan bermartabat di mata dunia.
        </p>
    </div>
</div>

<div style="max-width: 1100px; margin: 60px auto; padding: 0 20px;">

    <!-- VISI BOX -->
    <div style="background: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border-left: 6px solid #ffb700; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="background: #001333; color: #ffb700; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 900;">
                ★
            </div>
            <h2 style="font-size: 26px; font-weight: 900; color: #001333; margin: 0;">
                Visi Partai NasDem
            </h2>
        </div>
        <p style="font-size: 18px; line-height: 1.8; color: #334155; font-weight: 600; margin: 0;">
            "Indonesia yang merdeka sebagai negara bangsa, berdaulat secara ekonomi, bermartabat dalam budaya, serta berkeadilan sosial bagi seluruh rakyat Indonesia melalui Gerakan Perubahan Restorasi Indonesia."
        </p>
    </div>

    <!-- MISI BOX -->
    <div style="background: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border-left: 6px solid #001333; margin-bottom: 50px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
            <div style="background: #ffb700; color: #001333; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 900;">
                ✦
            </div>
            <h2 style="font-size: 26px; font-weight: 900; color: #001333; margin: 0;">
                Misi Partai NasDem
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px;">
                <div style="font-size: 28px; font-weight: 900; color: #ffb700; margin-bottom: 8px;">01</div>
                <h3 style="font-size: 17px; font-weight: 800; color: #001333; margin: 0 0 8px 0;">Membangun Politik Demokratis Berkeadaban</h3>
                <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 0;">
                    Menciptakan iklim politik nasional yang bersih tanpa mahar, berintegritas, menjunjung etika luhur, dan berpihak nyata kepada rakyat.
                </p>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px;">
                <div style="font-size: 28px; font-weight: 900; color: #ffb700; margin-bottom: 8px;">02</div>
                <h3 style="font-size: 17px; font-weight: 800; color: #001333; margin: 0 0 8px 0;">Menciptakan Kemandirian Ekonomi Bangsa</h3>
                <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 0;">
                    Mendorong pertumbuhan ekonomi yang berkeadilan, memperkuat UMKM, melindungi petani dan buruh, serta mengoptimalkan kedaulatan sumber daya alam.
                </p>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px;">
                <div style="font-size: 28px; font-weight: 900; color: #ffb700; margin-bottom: 8px;">03</div>
                <h3 style="font-size: 17px; font-weight: 800; color: #001333; margin: 0 0 8px 0;">Menjaga Ketahanan Kebudayaan Gotong Royong</h3>
                <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 0;">
                    Memperkokoh persatuan dalam keberagaman, menjaga kearifan lokal Nusantara, dan menumbuhkan karakter bangsa yang berdaya saing global.
                </p>
            </div>
        </div>
    </div>

    <!-- TIGA PILAR RESTORASI -->
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-size: 28px; font-weight: 900; color: #001333; margin: 0 0 10px 0;">
            Tiga Pilar Restorasi Indonesia
        </h2>
        <p style="font-size: 15px; color: #64748b; max-width: 600px; margin: 0 auto;">
            Komitmen teguh Partai NasDem di tingkat pusat hingga DPD Kabupaten Banyumas
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 60px;">
        <div style="background: #001333; color: #ffffff; border-radius: 16px; padding: 32px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 100px; font-weight: 900; color: rgba(255,255,255,0.05); line-height: 1;">1</div>
            <h3 style="font-size: 20px; font-weight: 800; color: #ffb700; margin: 0 0 12px 0;">1. Politik Tanpa Mahar</h3>
            <p style="font-size: 14px; color: #cbd5e1; line-height: 1.6; margin: 0;">
                Partai NasDem konsisten menolak segala bentuk mahar politik dalam penjaringan calon legislatif maupun calon kepala daerah demi mencetak pemimpin yang murni berjuang untuk kemaslahatan rakyat.
            </p>
        </div>

        <div style="background: #001333; color: #ffffff; border-radius: 16px; padding: 32px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 100px; font-weight: 900; color: rgba(255,255,255,0.05); line-height: 1;">2</div>
            <h3 style="font-size: 20px; font-weight: 800; color: #ffb700; margin: 0 0 12px 0;">2. Keadilan &amp; Kesetaraan Sosial</h3>
            <p style="font-size: 14px; color: #cbd5e1; line-height: 1.6; margin: 0;">
                Setiap warga negara memiliki hak yang setara dalam hukum, akses pendidikan bermutu, pelayanan kesehatan prima, dan lapangan kerja yang layak di perkotaan maupun pelosok desa.
            </p>
        </div>

        <div style="background: #001333; color: #ffffff; border-radius: 16px; padding: 32px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 100px; font-weight: 900; color: rgba(255,255,255,0.05); line-height: 1;">3</div>
            <h3 style="font-size: 20px; font-weight: 800; color: #ffb700; margin: 0 0 12px 0;">3. Restorasi Kebangsaan</h3>
            <p style="font-size: 14px; color: #cbd5e1; line-height: 1.6; margin: 0;">
                Mengembalikan haluan kehidupan berbangsa dan bernegara pada tujuan luhur Proklamasi 1945 dan Pancasila, menempatkan kedaulatan rakyat di atas kepentingan pribadi maupun golongan.
            </p>
        </div>
    </div>

</div>

@endsection
