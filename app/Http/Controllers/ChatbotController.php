<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Penilaian;
use App\Models\Unit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Daftar 114 Nama Surah Al-Qur'an untuk pencarian instan
     */
    protected static $surahList = [
        1 => 'Al-Fatihah', 2 => 'Al-Baqarah', 3 => 'Ali \'Imran', 4 => 'An-Nisa\'', 5 => 'Al-Ma\'idah',
        6 => 'Al-An\'am', 7 => 'Al-A\'raf', 8 => 'Al-Anfal', 9 => 'At-Taubah', 10 => 'Yunus',
        11 => 'Hud', 12 => 'Yusuf', 13 => 'Ar-Ra\'d', 14 => 'Ibrahim', 15 => 'Al-Hijr',
        16 => 'An-Nahl', 17 => 'Al-Isra\'', 18 => 'Al-Kahfi', 19 => 'Maryam', 20 => 'Ta-Ha',
        21 => 'Al-Anbiya\'', 22 => 'Al-Hajj', 23 => 'Al-Mu\'minun', 24 => 'An-Nur', 25 => 'Al-Furqan',
        26 => 'Asy-Syu\'ara\'', 27 => 'An-Naml', 28 => 'Al-Qasas', 29 => 'Al-\'Ankabut', 30 => 'Ar-Rum',
        31 => 'Luqman', 32 => 'As-Sajdah', 33 => 'Al-Ahzab', 34 => 'Saba\'', 35 => 'Fatir',
        36 => 'Ya-Sin', 37 => 'As-Saffat', 38 => 'Sad', 39 => 'Az-Zumar', 40 => 'Ghafir',
        41 => 'Fussilat', 42 => 'Asy-Syura', 43 => 'Az-Zukhruf', 44 => 'Ad-Dukhan', 45 => 'Al-Jasiyah',
        46 => 'Al-Ahqaf', 47 => 'Muhammad', 48 => 'Al-Fath', 49 => 'Al-Hujurat', 50 => 'Qaf',
        51 => 'Az-Zariyat', 52 => 'At-Tur', 53 => 'An-Najm', 54 => 'Al-Qamar', 55 => 'Ar-Rahman',
        56 => 'Al-Waqi\'ah', 57 => 'Al-Hadid', 58 => 'Al-Mujadilah', 59 => 'Al-Hasyr', 60 => 'Al-Mumtahanah',
        61 => 'As-Saff', 62 => 'Al-Jumu\'ah', 63 => 'Al-Munafiqun', 64 => 'At-Taghabun', 65 => 'At-Talaq',
        66 => 'At-Tahrim', 67 => 'Al-Mulk', 68 => 'Al-Qalam', 69 => 'Al-Haqqah', 70 => 'Al-Ma\'arij',
        71 => 'Nuh', 72 => 'Al-Jinn', 73 => 'Al-Muzzammil', 74 => 'Al-Muddassir', 75 => 'Al-Qiyamah',
        76 => 'Al-Insan', 77 => 'Al-Mursalat', 78 => 'An-Naba\'', 79 => 'An-Nazi\'at', 80 => '\'Abasa',
        81 => 'At-Takwir', 82 => 'Al-Infitar', 83 => 'Al-Mutaffifin', 84 => 'Al-Insyiqaq', 85 => 'Al-Buruj',
        86 => 'At-Tariq', 87 => 'Al-A\'la', 88 => 'Al-Ghasyiyah', 89 => 'Al-Fajr', 90 => 'Al-Balad',
        91 => 'Asy-Syams', 92 => 'Al-Lail', 93 => 'Ad-Duha', 94 => 'Asy-Syarh', 95 => 'At-Tin',
        96 => 'Al-\'Alaq', 97 => 'Al-Qadr', 98 => 'Al-Bayyinah', 99 => 'Az-Zalzalah', 100 => 'Al-\'Adiyat',
        101 => 'Al-Qari\'ah', 102 => 'At-Takasur', 103 => 'Al-\'Asr', 104 => 'Al-Humazah', 105 => 'Al-Fil',
        106 => 'Quraisy', 107 => 'Al-Ma\'un', 108 => 'Al-Kausar', 109 => 'Al-Kafirun', 110 => 'An-Nasr',
        111 => 'Al-Lahab', 112 => 'Al-Ikhlas', 113 => 'Al-Falaq', 114 => 'An-Nas'
    ];

    /**
     * Endpoint utama untuk menjawab pertanyaan chatbot
     */
    public function ask(Request $request)
    {
        $message = trim($request->input('message', ''));

        if (empty($message)) {
            return response()->json([
                'status' => 'error',
                'reply'  => 'Silakan ketik pertanyaan yang ingin Anda tanyakan. 😊',
            ]);
        }

        // 1. Cek integrasi Generative AI (Gemini / OpenAI) jika API key tersedia di .env
        $aiReply = $this->tryGenerativeAI($message);
        if ($aiReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'generative_ai',
                'reply'  => $aiReply,
            ]);
        }

        // 2. Percakapan Santai, Sapaan & Pertanyaan Interaktif (Small Talk & Chatbot Self-Awareness)
        $talkReply = $this->handleConversationalAndSmallTalk($message);
        if ($talkReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'conversational',
                'reply'  => $talkReply,
            ]);
        }

        // 3. Panduan Fitur Sistem Munaqasyah & FAQ
        $guideReply = $this->handleSystemFaqAndGuides($message);
        if ($guideReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'system_guide',
                'reply'  => $guideReply,
            ]);
        }

        // 4. Pencarian Data Santri Individual Real-Time (Nama, NISN, No Peserta, Cek Nilai)
        $santriReply = $this->handleIndividualSantriSearch($message);
        if ($santriReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'santri_db',
                'reply'  => $santriReply,
            ]);
        }

        // 5. Cek Kueri Agregasi Database Santri & Yayasan
        $dbReply = $this->handleDatabaseQueries($message);
        if ($dbReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'database',
                'reply'  => $dbReply,
            ]);
        }

        // 6. Cek Pencarian Al-Qur'an Interaktif (Surah, Ayat, Murottal)
        $quranReply = $this->handleQuranQueries($message);
        if ($quranReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'quran_api',
                'reply'  => $quranReply,
            ]);
        }

        // 7. Cek Jadwal Sholat & Doa-Doa Harian
        $prayerReply = $this->handlePrayerAndWorship($message);
        if ($prayerReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'prayer_worship',
                'reply'  => $prayerReply,
            ]);
        }

        // 8. Cek pertanyaan Matematika, Konversi Satuan & Perhitungan
        $mathReply = $this->handleMathAndConversions($message);
        if ($mathReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'calculator',
                'reply'  => $mathReply,
            ]);
        }

        // 9. Cek Pengetahuan Khusus Sistem Ar-Raudhah, Tajwid & Keislaman
        $systemReply = $this->handleSystemAndIslamicKnowledge($message);
        if ($systemReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'knowledge_base',
                'reply'  => $systemReply,
            ]);
        }

        // 10. Cek Pencarian Pengetahuan Umum (Wikipedia Bahasa Indonesia - khusus kueri ensiklopedia)
        $wikiReply = $this->searchWikipediaKnowledge($message);
        if ($wikiReply) {
            return response()->json([
                'status' => 'success',
                'source' => 'wikipedia',
                'reply'  => $wikiReply,
            ]);
        }

        // 11. Respon Percakapan Cerdas / Fallback Kontekstual Dinamis
        $fallbackReply = $this->getConversationalFallback($message);
        return response()->json([
            'status' => 'success',
            'source' => 'conversational',
            'reply'  => $fallbackReply,
        ]);
    }

    /**
     * Integrasi Google Gemini API atau OpenAI API jika dikonfigurasi
     */
    protected function tryGenerativeAI(string $message): ?string
    {
        $geminiKey = env('GEMINI_API_KEY');
        $openaiKey = env('OPENAI_API_KEY');

        $systemInstruction = "Kamu adalah Asisten Layanan Informasi Yayasan Cahaya Amanah Ar-Raudhah (TPQ dan RTQ) di Banjarbaru, Kalimantan Selatan. "
            . "Sistem Penilaian dan Database Sekolah ini dikelola resmi untuk standardisasi penilaian santri TPQ dan RTQ. "
            . "Tugasmu adalah menjawab pertanyaan pengguna seputar sistem ini, santri, agama Islam, pengetahuan umum, sains, matematika, teknologi, dan topik lainnya, "
            . "dengan ramah, santun, akurat, informatif, dan mudah dipahami dalam Bahasa Indonesia. "
            . "Jika pertanyaan terkait sistem ini, berikan panduan yang jelas dan terstruktur. "
            . "Jangan pernah menolak menjawab pertanyaan yang wajar dan etis.";

        if ($geminiKey) {
            $text = $this->callGeminiCurl($geminiKey, $message, $systemInstruction);
            if ($text) {
                return $this->formatMarkdownToHtml($text);
            }
        }

        if ($openaiKey) {
            try {
                $response = Http::timeout(15)->withToken($openaiKey)->post('https://api.openai.com/v1/chat/completions', [
                    'model'    => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemInstruction],
                        ['role' => 'user',   'content' => $message]
                    ],
                    'max_tokens'  => 800,
                    'temperature' => 0.7,
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $text = $json['choices'][0]['message']['content'] ?? null;
                    if ($text) {
                        return $this->formatMarkdownToHtml($text);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("OpenAI API Error: " . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Memanggil Gemini API menggunakan native cURL (lebih stabil dari Http facade Laravel)
     * Menggunakan parameter system_instruction untuk memisahkan instruksi sistem dari pesan user
     */
    protected function callGeminiCurl(string $apiKey, string $message, string $systemInstruction): ?string
    {
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

        $payload = json_encode([
            'system_instruction' => [
                'parts' => [['text' => $systemInstruction]]
            ],
            'contents' => [
                [
                    'role'  => 'user',
                    'parts' => [['text' => $message]]
                ]
            ],
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 1024,
                'topP'            => 0.95,
            ]
        ]);

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);

        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            Log::warning("Gemini cURL Error: " . $curlErr);
            return null;
        }

        if ($httpCode !== 200) {
            Log::warning("Gemini HTTP {$httpCode}: " . substr($result, 0, 300));
            return null;
        }

        $json = json_decode($result, true);
        return $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }

    /**
     * @deprecated Tidak digunakan lagi, digantikan callGeminiCurl
     */
    private function _legacyGeminiHttpFacade(string $geminiKey, string $message, string $systemPrompt): ?string
    {
        try {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $geminiKey;
            $response = Http::withoutVerifying()
                ->withOptions(['curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4]])
                ->timeout(8)
                ->post($endpoint, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => "Instruksi Sistem: {$systemPrompt}\n\nPertanyaan Pengguna: {$message}"]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]);

            if ($response->successful()) {
                $json = $response->json();
                return $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }
        } catch (\Throwable $e) {
            Log::warning("Gemini HTTP Facade Error: " . $e->getMessage());
        }
        return null;
    }

    /**
     * Menangani Percakapan Santai, Sapaan & Pertanyaan Interaktif

     */
    protected function handleConversationalAndSmallTalk(string $message): ?string
    {
        $q = strtolower(trim($message));

        // 1. Respon terhadap keluhan bot "ga nyambung" / "jawabannya itu terus"
        if (preg_match('/(ga nyambung|gak nyambung|tidak nyambung|ngulang terus|itu terus|kok gitu|jawabanmu aneh|jawabanmu sama|kenapa jawabannya|kaku amat|bot aneh|jawabannya kok|kok aneh)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center gap-2'>
                        <span class='text-base'>🙏</span>
                        <p class='font-bold'>Mohon maaf jika tadi jawaban saya terasa kaku atau kurang tepat!</p>
                    </div>
                    <p class='text-slate-700 leading-relaxed'>
                        Saya sekarang sudah diperbarui agar jauh lebih luwes, nyambung, dan memahami pertanyaan Anda dengan baik! Silakan coba tanyakan:
                    </p>
                    <ul class='space-y-1.5 text-slate-700 pl-1'>
                        <li>🔹 <strong>Cari data santri:</strong> Cukup ketik nama santri, misalnya: <em>\"Ahmad\"</em> atau <em>\"Syauqi\"</em>.</li>
                        <li>🔹 <strong>Panduan sistem:</strong> Ketik <em>\"cara input nilai\"</em>, <em>\"cara tambah biodata\"</em>, atau <em>\"cara cetak surat\"</em>.</li>
                        <li>🔹 <strong>Wawasan Islam &amp; Al-Qur'an:</strong> Ketik <em>\"surat al fatihah\"</em>, <em>\"jadwal sholat\"</em>, atau <em>\"hukum tajwid\"</em>.</li>
                        <li>🔹 <strong>Hitungan:</strong> Ketik <em>\"25% dari 500000\"</em> atau <em>\"akar 144\"</em>.</li>
                    </ul>
                    <p class='text-[10px] text-slate-400'>Silakan ketik pertanyaan Anda sekarang, saya siap menjawab! 😊</p>
                </div>
            ";
        }

        // 2. Pertanyaan identitas "kamu siapa?", "siapa namamu?", "kamu apa?"
        if (preg_match('/(kamu siapa|siapa kamu|siapa namamu|namamu siapa|nama kamu siapa|tentang kamu|profil kamu|identitas kamu|kamu apa)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-3 rounded-2xl bg-[#081026] border border-blue-900/50 text-white flex items-center gap-3'>
                        <div class='w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xl shrink-0'>
                            <i class='fa-solid fa-headset text-amber-300'></i>
                        </div>
                        <div>
                            <h4 class='font-black text-sm text-white'>Asisten Layanan Informasi Ar-Raudhah</h4>
                            <p class='text-[10px] text-blue-200'>Yayasan Cahaya Amanah Banjarbaru</p>
                        </div>
                    </div>
                    <p class='text-slate-700 leading-relaxed'>
                        Saya adalah asisten informasi resmi Yayasan Cahaya Amanah Ar-Raudhah untuk membantu panitia database sekolah, penguji, dan wali santri.
                    </p>
                    <div class='p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 space-y-1'>
                        <p class='font-bold text-slate-900'>Kemampuan Utama Saya:</p>
                        <ul class='list-disc list-inside space-y-0.5 pl-1 text-[11px]'>
                            <li>Mencari biodata &amp; hasil ujian santri secara real-time dari database</li>
                            <li>Menampilkan Al-Qur'an 114 surah beserta audio murottal</li>
                            <li>Memberikan panduan teknis penggunaan seluruh fitur aplikasi</li>
                            <li>Menampilkan jadwal sholat Banjarbaru, doa harian &amp; hukum tajwid</li>
                        </ul>
                    </div>
                </div>
            ";
        }

        // 3. Apakah kamu robot / AI / manusia?
        if (preg_match('/(kamu robot|kamu manusia|apakah kamu robot|apakah kamu manusia|kamu bot|kamu ai|apakah kamu bot|apakah kamu nyata)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs text-slate-700 leading-relaxed'>
                    <p class='font-bold text-slate-900 text-sm'>Saya adalah Program Kecerdasan Buatan (AI Chatbot) 🤖✨</p>
                    <p>
                        Saya dirancang khusus untuk mempermudah Anda dalam mengelola penilaian munaqasyah santri TPQ &amp; RTQ Ar-Raudhah, mencari data santri di database, menyajikan referensi Al-Qur'an, dan menjawab pertanyaan seputar sistem ini.
                    </p>
                    <p class='text-slate-500 text-[11px]'>
                        Meskipun saya bot cerdas, saya selalu siap mendampingi Anda layaknya rekan kerja yang ramah! 😊
                    </p>
                </div>
            ";
        }

        // 4. "Kamu bisa apa?" / "Bisa bantu apa?"
        if (preg_match('/(kamu bisa apa|bisa apa aja|fitur kamu|apa saja yang bisa|bisa bantu apa|kamu bisa bantu apa|kemampuan kamu|bisa ngapain)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>✨ Berikut Kemampuan yang Bisa Saya Bantu:</p>
                    <div class='grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-700'>
                        <div class='p-2 rounded-xl bg-blue-50 border border-blue-200'>
                            <p class='font-bold text-blue-950'>🔍 Cari Data Santri</p>
                            <p class='text-[11px] text-slate-600 mt-0.5'>Ketik nama santri atau no peserta untuk melihat nilai 9 mata uji dan kelulusan.</p>
                        </div>
                        <div class='p-2 rounded-xl bg-emerald-50 border border-emerald-200'>
                            <p class='font-bold text-emerald-950'>📖 Al-Qur'an &amp; Murottal</p>
                            <p class='text-[11px] text-slate-600 mt-0.5'>Ketik <em>\"surat al mulk\"</em> atau <em>\"ayat kursi\"</em> untuk bacaan Arab, arti &amp; audio.</p>
                        </div>
                        <div class='p-2 rounded-xl bg-amber-50 border border-amber-200'>
                            <p class='font-bold text-amber-950'>🕌 Jadwal Sholat &amp; Doa</p>
                            <p class='text-[11px] text-slate-600 mt-0.5'>Ketik <em>\"jadwal sholat\"</em> atau <em>\"doa orang tua\"</em> untuk waktu sholat Banjarbaru.</p>
                        </div>
                        <div class='p-2 rounded-xl bg-slate-50 border border-slate-200'>
                            <p class='font-bold text-slate-800'>⚙️ Panduan Sistem</p>
                            <p class='text-[11px] text-slate-600 mt-0.5'>Tanyakan <em>\"cara cetak surat\"</em>, <em>\"cara input nilai\"</em>, atau <em>\"cara export excel\"</em>.</p>
                        </div>
                    </div>
                </div>
            ";
        }

        // 5. "Apa kabar?" / "Lagi apa?"
        if (preg_match('/(apa kabar|bagaimana kabar|kabarmu|gimana kabar|lagi apa|sedang apa|lagi ngapain)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Alhamdulillah, saya luar biasa baik dan selalu bersemangat! 🌟</p>
                    <p>
                        Saat ini saya sedang siaga memproses data munaqasyah dan siap menjawab segala pertanyaan Anda seputar santri, nilai, maupun fitur sistem ini.
                    </p>
                    <p class='text-[11px] text-slate-500'>Bagaimana dengan Anda? Semoga senantiasa diberikan kesehatan dan kelancaran dalam mendidik generasi Qur'ani! Ada yang bisa saya bantu?</p>
                </div>
            ";
        }

        // 6. Sapaan singkat: "halo", "hai", "p", "assalamualaikum", dll.
        if (preg_match('/^(assalamu|assalamualaikum|halo|hai|hey|hei|p|ping|tes|test|pagi|siang|sore|malam)$/i', $q) ||
            preg_match('/^(selamat pagi|selamat siang|selamat sore|selamat malam)$/i', $q)) {
            $greeting = str_contains($q, 'assalam') 
                ? "Wa'alaikumussalam Warahmatullahi Wabarakatuh! 🕌✨"
                : "Halo! Selamat datang di SIMUNAQASYAH Ar-Raudhah 👋";

            return "
                <div class='space-y-1.5 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>{$greeting}</p>
                    <p>
                        Senang sekali bisa menyapa Anda! Saya adalah <strong>Asisten Cerdas Virtual Ar-Raudhah</strong> yang siap membantu kebutuhan informasi Anda.
                    </p>
                    <p class='text-[11px] text-slate-600'>
                        Ada yang ingin Anda tanyakan atau cari hari ini? Coba tanyakan nama santri, surah Al-Qur'an, atau panduan sistem! 😊
                    </p>
                </div>
            ";
        }

        // 7. Ucapan terima kasih / pujian
        if (preg_match('/(terima kasih|makasih|syukron|jazakallah|thank you|thanks|keren|mantap|bagus|hebat|top|makasi)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Sama-sama! Afwan / Wa Iyyakum... 😊🤲</p>
                    <p>
                        Senang sekali bisa membantu Anda. Sukses selalu untuk seluruh kegiatan munaqasyah santri di Yayasan Cahaya Amanah Ar-Raudhah! Jangan ragu bertanya lagi kapan pun ya. ✨
                    </p>
                </div>
            ";
        }

        // 8. Konfirmasi singkat: "ok", "oke", "siap", dll.
        if (preg_match('/^(ok|oke|okee|siap|baik|sip|y|ya|yes|bisa|mengerti|paham)$/i', $q)) {
            return "
                <div class='text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Siap, luar biasa! 👍</p>
                    <p class='mt-1 text-[11px]'>Silakan ketik pertanyaan lain kapan saja jika Anda membutuhkan bantuan seputar santri atau munaqasyah.</p>
                </div>
            ";
        }

        return null;
    }

    /**
     * Menangani Panduan Fitur Sistem & FAQ Munaqasyah Ar-Raudhah
     */
    protected function handleSystemFaqAndGuides(string $message): ?string
    {
        $q = strtolower(trim($message));

        // 1. Panduan Tambah / Input Biodata Santri
        if (preg_match('/(cara.*(tambah|daftar|input).*(santri|siswa|biodata)|tambah santri|daftar santri)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>📝 Panduan Menambah Biodata Santri Baru:</p>
                    <ol class='list-decimal list-inside space-y-1 text-slate-700 pl-1'>
                        <li>Buka menu <strong>\"Biodata Santri\" &rarr; \"Tambah Biodata\"</strong> pada sidebar sebelah kiri.</li>
                        <li>Isi identitas santri: Nama lengkap, Jenjang (TPQ / RTQ), No. Peserta, dan NISN.</li>
                        <li>Unggah pas foto resmi santri (foto akan otomatis terpasang pada sertifikat kelulusan).</li>
                        <li>Pilih tombol <strong>\"Simpan Biodata\"</strong> atau <strong>\"Simpan &amp; Lanjut Isi Nilai\"</strong>.</li>
                    </ol>
                    <div class='pt-1'>
                        <a href='/santri/create' class='inline-block px-3 py-1.5 bg-red-600 text-white rounded-lg font-bold text-[11px] hover:bg-red-500 transition'>
                            + Buka Form Tambah Santri Sekarang &rarr;
                        </a>
                    </div>
                </div>
            ";
        }

        // 2. Panduan Input / Mengisi Nilai Munaqasyah 9 Mata Uji
        if (preg_match('/(cara.*(isi|input|nilai|skor).*(munaqasyah|ujian|santri)|cara menilai|form nilai|isi nilai)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>📊 Panduan Mengisi Nilai Munaqasyah:</p>
                    <ol class='list-decimal list-inside space-y-1 text-slate-700 pl-1'>
                        <li>Pilih tab jenjang pada sidebar: <strong>\"TPQ Ar-Raudhah\"</strong> atau <strong>\"RTQ Ar-Raudhah\"</strong>.</li>
                        <li>Pada baris santri yang ingin dinilai, klik tombol edit/pensil berwarna biru.</li>
                        <li>Masukkan nilai angka (skala 0 - 100) untuk masing-masing <strong>9 mata uji</strong>.</li>
                        <li>Total nilai, rata-rata, dan predikat kelulusan (Mumtaz, Jayyid, dll.) akan terkalkulasi otomatis!</li>
                        <li>Klik tombol <strong>\"Simpan Perubahan Nilai\"</strong> di bagian bawah form.</li>
                    </ol>
                    <div class='pt-1'>
                        <a href='/database-sekolah' class='inline-block px-3 py-1.5 bg-blue-950 text-white rounded-lg font-bold text-[11px] hover:bg-slate-900 transition'>
                            Buka Lembar Penilaian &rarr;
                        </a>
                    </div>
                </div>
            ";
        }

        // 3. Panduan Cetak Surat Kelulusan & Cetak Massal
        if (preg_match('/(cara.*(cetak|print).*(surat|kelulusan|sertifikat|piagam|ijazah)|cetak massal|cetak surat)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>🖨️ Panduan Mencetak Surat Keterangan Kelulusan:</p>
                    <ul class='space-y-1.5 text-slate-700 pl-1'>
                        <li>🔹 <strong>Cetak Satuan:</strong> Pada tabel penilaian, klik tombol cetak / printer berwarna hijau di samping nama santri. Lembar sertifikat resmi lengkap dengan foto, QR Code, dan stempel yayasan akan langsung terbuka siap cetak.</li>
                        <li>🔹 <strong>Cetak Massal:</strong> Buka menu cetak massal pada halaman penilaian untuk mencetak seluruh santri yang berstatus LULUS sekaligus dalam format multi-halaman siap cetak ke printer.</li>
                    </ul>
                    <p class='text-[10px] text-slate-500'>Tips: Gunakan kertas ukuran A4 dengan orientasi Portrait dan hilangkan opsi 'Header &amp; Footer' di dialog printer browser.</p>
                </div>
            ";
        }

        // 4. Panduan Kirim Hasil ke WhatsApp Wali Santri
        if (preg_match('/(cara.*(kirim|share|kirimkan).*(wa|whatsapp|wali)|whatsapp wali|kirim wa)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>📲 Panduan Kirim Hasil Ujian ke WhatsApp Wali Santri:</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Sistem telah dilengkapi fitur <strong>Direct WhatsApp Share</strong>:
                    </p>
                    <ol class='list-decimal list-inside space-y-1 text-slate-700 pl-1'>
                        <li>Masuk ke halaman <strong>Penilaian TPQ</strong> atau <strong>RTQ</strong>.</li>
                        <li>Cari nama santri yang ingin dibagikan hasilnya.</li>
                        <li>Klik ikon tombol berwarna hijau berlogo <strong>WhatsApp</strong> (<i class='fa-brands fa-whatsapp text-emerald-600'></i>).</li>
                        <li>WhatsApp akan terbuka otomatis dengan format pesan ucapan selamat, rekap nilai rata-rata, predikat, dan tautan online untuk melihat surat resmi.</li>
                    </ol>
                </div>
            ";
        }

        // 5. Apa fungsi QR Code di Surat Kelulusan?
        if (preg_match('/(fungsi.*qr code|apa itu qr code|verifikasi dokumen|cek keaslian|qr code)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>🔲 Fitur QR Code Verifikasi Keaslian Dokumen:</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Setiap Surat Keterangan Kelulusan yang diterbitkan oleh sistem ini memiliki <strong>QR Code verifikasi unik</strong> di pojok kanan bawah.
                    </p>
                    <div class='p-2 rounded-xl bg-blue-50 border border-blue-200 text-slate-800 space-y-1'>
                        <p class='font-bold text-blue-950'>Keunggulan:</p>
                        <ul class='list-disc list-inside space-y-0.5 text-[11px]'>
                            <li>Mencegah pemalsuan piagam atau manipulasi nilai kelulusan.</li>
                            <li>Wali santri atau madrasah lanjutan cukup memindai QR Code dengan kamera ponsel untuk memvalidasi keabsahan surat secara real-time.</li>
                        </ul>
                    </div>
                </div>
            ";
        }

        // 6. Panduan Export Excel & Spreadsheet
        if (preg_match('/(cara.*(export|download|unduh).*(excel|spreadsheet|csv)|ekspor)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>📊 Panduan Ekspor Data Penilaian:</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Tersedia dua format ekspor resmi pada navbar dan sidebar:
                    </p>
                    <ul class='space-y-1 text-slate-700 pl-1'>
                        <li>🟢 <strong>Export Excel (.xls):</strong> Mengunduh dokumen Excel dengan format tabel beraksen kuning resmi siap print atau arsip yayasan.</li>
                        <li>🔵 <strong>Export Spreadsheet (.csv):</strong> Mengunduh data CSV terstruktur yang kompatibel langsung untuk dibuka di Microsoft Excel maupun Google Sheets.</li>
                    </ul>
                </div>
            ";
        }

        // 7. Lupa Password / Akun Terkunci / Gagal Login
        if (preg_match('/(lupa password|gagal login|akun terkunci|login terkunci|tidak bisa login|kenapa diblokir)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>🔒 Bantuan Akses &amp; Keamanan Akun:</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Sistem dilengkapi proteksi anti brute-force: akun akan <strong>dikunci sementara selama 15 menit</strong> jika terjadi 5 kali percobaan login gagal berturut-turut.
                    </p>
                    <div class='p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 space-y-1'>
                        <p class='font-bold text-slate-900'>Solusi:</p>
                        <ul class='list-disc list-inside space-y-0.5 text-[11px]'>
                            <li>Tunggu hitung mundur di halaman login hingga waktu selesai.</li>
                            <li>Pastikan username dan password diisi dengan benar tanpa spasi berlebih.</li>
                            <li>Hubungi Administrator untuk mereset kata sandi melalui menu Kelola Pengguna.</li>
                        </ul>
                    </div>
                </div>
            ";
        }

        // 8. Apa itu Munaqasyah?
        if (preg_match('/(apa itu munaqasyah|arti munaqasyah|pengertian munaqasyah|munaqasyah adalah|tujuan munaqasyah)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>📖 Pengertian Munaqasyah Al-Qur'an:</p>
                    <p class='text-slate-700 leading-relaxed'>
                        <strong>Munaqasyah</strong> adalah proses ujian komprehensif akhir bagi santri TPQ (Taman Pendidikan Qur'an) dan RTQ (Rumah Tahfidz Qur'an) untuk menguji kelayakan, kefasihan membaca, hafalan, serta penguasaan dasar-dasar ilmu agama Islam sebelum dinyatakan lulus dan diwisuda.
                    </p>
                    <div class='p-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-950 text-[11px]'>
                        <strong>Tujuan:</strong> Memastikan standarisasi kualitas bacaan santri sesuai kaidah tajwid, fashohah, dan mencetak generasi yang berakhlakul karimah.
                    </div>
                </div>
            ";
        }

        // 9. Kriteria Kelulusan & Predikat Nilai
        if (preg_match('/(kriteria kelulusan|syarat lulus|predikat|mumtaz|jayyid|nilai minimal|standar kelulusan)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900 text-sm'>🏆 Standar Kategori &amp; Predikat Nilai Munaqasyah:</p>
                    <div class='space-y-1 font-mono text-[11px]'>
                        <div class='p-1.5 rounded-lg bg-emerald-100 text-emerald-900 flex justify-between font-bold'>
                            <span>🌟 90.0 - 100.0</span> <span>MUMTAZ (Istimewa)</span>
                        </div>
                        <div class='p-1.5 rounded-lg bg-blue-100 text-blue-900 flex justify-between font-bold'>
                            <span>✨ 80.0 - 89.9</span> <span>JAYYID JIDDAN (Amat Baik)</span>
                        </div>
                        <div class='p-1.5 rounded-lg bg-sky-100 text-sky-900 flex justify-between font-bold'>
                            <span>👍 70.0 - 79.9</span> <span>JAYYID (Baik)</span>
                        </div>
                        <div class='p-1.5 rounded-lg bg-amber-100 text-amber-900 flex justify-between font-bold'>
                            <span>⚠️ 60.0 - 69.9</span> <span>MAQBUL (Cukup)</span>
                        </div>
                        <div class='p-1.5 rounded-lg bg-rose-100 text-rose-900 flex justify-between font-bold'>
                            <span>❌ &lt; 60.0</span> <span>RASIB (Tidak Lulus)</span>
                        </div>
                    </div>
                    <p class='text-[10px] text-slate-500'>Santri dinyatakan LULUS jika memperoleh nilai rata-rata minimal 60.0 (Maqbul).</p>
                </div>
            ";
        }

        return null;
    }

    /**
     * Pencarian Data Santri Individual Real-Time
     * Contoh: "cari santri Ahmad", "nilai santri Muhammad", "apakah fatimah lulus?", "cek peserta 001", atau ketik langsung nama santri "Ahmad"
     */
    protected function handleIndividualSantriSearch(string $message): ?string
    {
        $q = strtolower($message);

        // Abaikan jika pertanyaan tentang total atau umum
        if (preg_match('/(berapa|jumlah|total|semua|daftar|kriteria|syarat|apa saja)/i', $q) && !preg_match('/(cari|cek|nilai|profil|tentang)/i', $q)) {
            return null;
        }

        $searchName = null;

        // Ekstraksi pola nama santri
        if (preg_match('/(?:cari|cek|lihat|tampilkan|status|nilai|profil)\s+(?:santri|siswa|peserta|data)?\s*(?:nama)?\s*[:\s]*([a-zA-Z0-9\s\.\'\-]{3,40})/i', $message, $m)) {
            $searchName = trim($m[1]);
        } elseif (preg_match('/(?:apakah|gimana|bagaimana)\s+([a-zA-Z\s\.\'\-]{3,30})\s+(?:lulus|nilainya|skornya)/i', $message, $m)) {
            $searchName = trim($m[1]);
        } elseif (preg_match('/^santri\s+([a-zA-Z0-9\s\.\'\-]{3,30})$/i', $message, $m)) {
            $searchName = trim($m[1]);
        }

        // Hapus kata sambung yang mungkin terbawa
        if ($searchName) {
            $searchName = trim(preg_replace('/\b(lulus|tidak lulus|munaqasyah|ujian|tpq|rtq|tahun ini|hari ini)\b/i', '', $searchName));
        }

        // Jika tidak ada kata awalan khusus, tetapi input 1-3 kata cocok dengan data santri di database
        if (!$searchName && preg_match('/^[a-zA-Z0-9\s\.\'\-]{3,35}$/', trim($message))) {
            $candidate = trim($message);
            // Cek apakah ada santri yang cocok di database
            $exists = Santri::where('nama', 'like', "%{$candidate}%")
                ->orWhere('no_peserta', $candidate)
                ->orWhere('nisn', $candidate)
                ->exists();
            if ($exists) {
                $searchName = $candidate;
            }
        }

        if (!$searchName || mb_strlen($searchName) < 2) {
            return null;
        }

        // Cari di database
        $results = Santri::with(['penilaian', 'unit'])
            ->where(function ($query) use ($searchName) {
                $query->where('nama', 'like', "%{$searchName}%")
                      ->orWhere('no_peserta', $searchName)
                      ->orWhere('nisn', $searchName);
            })
            ->take(5)
            ->get();

        if ($results->isEmpty()) {
            return null;
        }

        // Jika hanya 1 santri ditemukan, tampilkan kartu detail lengkap
        if ($results->count() === 1) {
            $s = $results->first();
            return $this->renderSantriCard($s);
        }

        // Jika ditemukan lebih dari 1 santri
        $list = "";
        foreach ($results as $s) {
            $pen = $s->penilaian;
            $statusBadge = $s->status_kelulusan === 'LULUS'
                ? "<span class='px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]'>LULUS</span>"
                : ($s->status_kelulusan === 'TIDAK LULUS'
                    ? "<span class='px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 font-bold text-[10px]'>TIDAK LULUS</span>"
                    : "<span class='px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-bold text-[10px]'>PENDING</span>");

            $rata = $pen && $pen->rata_rata ? number_format($pen->rata_rata, 1) : '-';

            $list .= "
                <div class='p-2 rounded-xl bg-white border border-slate-200 flex items-center justify-between gap-2 hover:border-red-400 transition'>
                    <div class='min-w-0'>
                        <div class='flex items-center gap-1.5'>
                            <span class='font-bold text-slate-900 text-xs truncate'>{$s->nama}</span>
                            <span class='text-[10px] text-slate-500 font-mono'>#{$s->no_peserta}</span>
                        </div>
                        <p class='text-[10px] text-slate-500 truncate'>{$s->jenis} • {$s->nama_unit} | Nilai: <strong>{$rata}</strong></p>
                    </div>
                    <div class='shrink-0 flex items-center gap-1.5'>
                        {$statusBadge}
                        <button type='button' onclick=\"askQuestion('cek santri {$s->nama}')\" class='px-2 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-900 font-bold text-[10px] transition'>
                            Detail
                        </button>
                    </div>
                </div>
            ";
        }

        return "
            <div class='space-y-2 text-xs'>
                <p class='font-bold text-slate-900'>🔍 Ditemukan {$results->count()} santri dengan kata kunci <em>\"{$searchName}\"</em>:</p>
                <div class='space-y-1.5'>
                    {$list}
                </div>
                <p class='text-[10px] text-slate-500'>Klik tombol <strong>Detail</strong> pada santri yang Anda maksud untuk melihat nilai lengkap.</p>
            </div>
        ";
    }

    /**
     * Render Kartu Interaktif Santri untuk Chatbot
     */
    protected function renderSantriCard(Santri $s): string
    {
        $pen = $s->penilaian;
        $fotoUrl = $s->foto_url;
        $gender = $s->jenis_kelamin === 'L' ? 'Laki-laki 👦' : ($s->jenis_kelamin === 'P' ? 'Perempuan 👧' : '-');
        $wali = $s->nama_wali ?: '-';

        $statusColor = $s->status_kelulusan === 'LULUS' ? 'text-emerald-700 bg-emerald-50 border-emerald-300' : ($s->status_kelulusan === 'TIDAK LULUS' ? 'text-rose-700 bg-rose-50 border-rose-300' : 'text-amber-700 bg-amber-50 border-amber-300');

        $scoresHtml = "";
        if ($pen) {
            $rata = number_format($pen->rata_rata ?? 0, 2);
            $total = number_format($pen->total_nilai ?? 0, 1);
            $predikat = $pen->predikat ?: 'Mumtaz';

            $scoresHtml = "
                <div class='mt-2 pt-2 border-t border-slate-200'>
                    <div class='flex items-center justify-between mb-1.5 text-xs'>
                        <span class='font-bold text-slate-800'>📊 Rangkuman Nilai Munaqasyah:</span>
                        <span class='font-black text-blue-900'>{$rata} ({$predikat})</span>
                    </div>
                    <div class='grid grid-cols-3 gap-1.5 text-[10px] text-slate-600'>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Fashohah: <strong>{$pen->fashohah}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Tajwid: <strong>{$pen->tajwid}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Gharib: <strong>{$pen->gharib}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Lagu: <strong>{$pen->suara_lagu}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Ayat: <strong>{$pen->ayat_pilihan}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Surah: <strong>{$pen->surah_pendek}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Doa: <strong>{$pen->doa_harian}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Shalat: <strong>{$pen->bacaan_shalat}</strong></div>
                        <div class='p-1 rounded bg-slate-50 border border-slate-200 text-center'>Tertulis: <strong>{$pen->ujian_tertulis}</strong></div>
                    </div>
                    <div class='mt-2 flex items-center justify-between text-[11px] font-semibold text-slate-500'>
                        <span>Total Nilai: <strong class='text-slate-900'>{$total}</strong></span>
                        <a href='/database-sekolah/{$s->id}/kelulusan' target='_blank' class='text-red-600 hover:text-red-700 font-bold flex items-center gap-1 hover:underline'>
                            <i class='fa-solid fa-print'></i> Surat Kelulusan
                        </a>
                    </div>
                </div>
            ";
        } else {
            $scoresHtml = "
                <div class='mt-2 p-2 rounded-xl bg-amber-50 border border-amber-200 text-[11px] text-amber-800 flex items-center justify-between'>
                    <span>⚠️ Santri ini belum memiliki penilaian munaqasyah.</span>
                    <a href='/database-sekolah/{$s->id}/edit' class='px-2 py-1 rounded bg-amber-600 text-white font-bold hover:bg-amber-700 transition'>Input Nilai</a>
                </div>
            ";
        }

        return "
            <div class='space-y-2 text-xs'>
                <div class='p-3 rounded-2xl bg-[#081026] border border-slate-800 text-white flex items-center gap-3 shadow-sm'>
                    <img src='{$fotoUrl}' alt='{$s->nama}' class='w-12 h-14 object-cover rounded-xl border border-white/30 shrink-0'>
                    <div class='min-w-0 flex-1'>
                        <div class='flex items-center gap-1.5'>
                            <h4 class='font-black text-sm text-white truncate'>{$s->nama}</h4>
                            <span class='px-1.5 py-0.5 rounded text-[9px] font-bold bg-white/20 text-white'>{$s->jenis}</span>
                        </div>
                        <p class='text-[10px] text-blue-200 font-mono'>No. Peserta: {$s->no_peserta} | NISN: " . ($s->nisn ?: '-') . "</p>
                        <p class='text-[10px] text-slate-300 truncate'>Unit: {$s->nama_unit} | Wali: {$wali}</p>
                    </div>
                </div>
                <div class='flex items-center justify-between px-1 text-[11px]'>
                    <span>Gender: <strong>{$gender}</strong></span>
                    <span class='px-2 py-0.5 rounded-full border font-black text-[10px] {$statusColor}'>
                        STATUS: {$s->status_kelulusan}
                    </span>
                </div>
                {$scoresHtml}
            </div>
        ";
    }

    /**
     * Menangani pertanyaan seputar kueri agregasi database santri
     */
    protected function handleDatabaseQueries(string $message): ?string
    {
        $q = strtolower($message);

        // 1. Santri yang belum dinilai
        if (preg_match('/(belum dinilai|belum ada nilai|belum dinilai siapa|santri belum dinilai)/i', $q)) {
            $unrated = Santri::doesntHave('penilaian')->take(8)->get();
            $totalUnrated = Santri::doesntHave('penilaian')->count();

            if ($totalUnrated === 0) {
                return "
                    <div class='space-y-1.5 text-xs text-slate-700'>
                        <p class='font-bold text-slate-900'>🎉 Seluruh Santri Sudah Dinilai!</p>
                        <p>Hebat! Seluruh data santri yang terdaftar di sistem Yayasan Cahaya Amanah Ar-Raudhah telah memiliki penilaian munaqasyah lengkap.</p>
                    </div>
                ";
            }

            $list = "";
            foreach ($unrated as $u) {
                $list .= "<li><strong>{$u->nama}</strong> ({$u->jenis} - {$u->nama_unit}) · No: {$u->no_peserta}</li>";
            }

            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📋 Santri yang Belum Memiliki Penilaian ({$totalUnrated} Santri):</p>
                    <ul class='space-y-1 text-slate-700 list-disc pl-4'>
                        {$list}
                    </ul>
                    " . ($totalUnrated > 8 ? "<p class='text-[10px] text-slate-500'>Dan " . ($totalUnrated - 8) . " santri lainnya...</p>" : "") . "
                    <div class='pt-1'>
                        <a href='/santri' class='text-xs font-bold text-red-600 hover:underline'>Buka Halaman Biodata Siswa &rarr;</a>
                    </div>
                </div>
            ";
        }

        // 2. Santri yang tidak lulus
        if (preg_match('/(tidak lulus|gagal|rasib|belum lulus|yang tidak lulus)/i', $q) && preg_match('/(siapa|santri|berapa|daftar)/i', $q)) {
            $failed = Santri::where('status_kelulusan', 'TIDAK LULUS')->take(8)->get();
            $totalFailed = Santri::where('status_kelulusan', 'TIDAK LULUS')->count();

            if ($totalFailed === 0) {
                return "
                    <div class='space-y-1.5 text-xs text-slate-700'>
                        <p class='font-bold text-slate-900'>Alhamdulillah, Tidak Ada Santri yang Berstatus Tidak Lulus! ✨</p>
                        <p>Seluruh santri yang telah dinilai berhasil memenuhi standar kelulusan Yayasan Cahaya Amanah Ar-Raudhah.</p>
                    </div>
                ";
            }

            $list = "";
            foreach ($failed as $f) {
                $rata = $f->penilaian ? number_format($f->penilaian->rata_rata, 1) : '-';
                $list .= "<li><strong>{$f->nama}</strong> ({$f->jenis}) · Rata-rata: {$rata}</li>";
            }

            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>⚠️ Santri Berstatus Belum Lulus ({$totalFailed} Santri):</p>
                    <ul class='space-y-1 text-slate-700 list-disc pl-4'>
                        {$list}
                    </ul>
                    <p class='text-[10px] text-slate-500'>Santri di atas disarankan untuk mengikuti bimbingan atau ujian perbaikan munaqasyah.</p>
                </div>
            ";
        }

        // 3. Unit apa saja yang ada
        if (preg_match('/(unit apa saja|daftar unit|nama unit|lembaga apa saja|ada unit apa)/i', $q)) {
            $units = Unit::all();
            $totalUnit = $units->count();

            $list = "";
            foreach ($units as $u) {
                $count = Santri::where('nama_unit', $u->nama_unit)->count();
                $list .= "<li>🏢 <strong>{$u->nama_unit}</strong> ({$u->jenis}) · <strong>{$count}</strong> Santri</li>";
            }

            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>🏛️ Daftar Unit / Lembaga Terdaftar ({$totalUnit} Unit):</p>
                    <ul class='space-y-1.5 text-slate-700 pl-1'>
                        {$list}
                    </ul>
                    <p class='text-[10px] text-slate-500'>Data terhubung langsung dengan sistem penilaian dan sertifikat kelulusan.</p>
                </div>
            ";
        }

        // 4. Pertanyaan jumlah/total santri
        if (preg_match('/(berapa|total|jumlah|banyaknya).*?(santri|peserta|siswa)/i', $q) ||
            preg_match('/(santri|peserta).*?(berapa|jumlah)/i', $q)) {
            
            $totalSemua = Santri::count();
            $totalTPQ   = Santri::where('jenis', 'TPQ')->count();
            $totalRTQ   = Santri::where('jenis', 'RTQ')->count();
            $totalLaki  = Santri::where('jenis_kelamin', 'L')->count();
            $totalPerem = Santri::where('jenis_kelamin', 'P')->count();
            $totalLulus = Santri::where('status_kelulusan', 'LULUS')->count();
            $sudahNilai = Santri::has('penilaian')->count();

            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📊 Data Statistik Santri Real-Time:</p>
                    <div class='grid grid-cols-2 gap-2'>
                        <div class='p-2 rounded-xl bg-blue-50 border border-blue-200'>
                            <span class='text-slate-500 text-[10px] block'>Total Santri</span>
                            <span class='text-sm font-black text-blue-900'>{$totalSemua} Santri</span>
                        </div>
                        <div class='p-2 rounded-xl bg-emerald-50 border border-emerald-200'>
                            <span class='text-slate-500 text-[10px] block'>Dinyatakan Lulus</span>
                            <span class='text-sm font-black text-emerald-800'>{$totalLulus} Santri</span>
                        </div>
                        <div class='p-2 rounded-xl bg-slate-50 border border-slate-200'>
                            <span class='text-slate-500 text-[10px] block'>TPQ &amp; RTQ</span>
                            <span class='text-xs font-bold text-slate-800'>TPQ: {$totalTPQ} | RTQ: {$totalRTQ}</span>
                        </div>
                        <div class='p-2 rounded-xl bg-amber-50 border border-amber-200'>
                            <span class='text-slate-500 text-[10px] block'>Santri L / P</span>
                            <span class='text-xs font-bold text-amber-900'>👦 {$totalLaki} | 👧 {$totalPerem}</span>
                        </div>
                    </div>
                    <p class='text-[10px] text-slate-500 pt-0.5'>💡 Sudah Dinilai: <strong>{$sudahNilai}</strong> dari {$totalSemua} santri.</p>
                </div>
            ";
        }

        // 5. Pertanyaan santri terbaik / nilai tertinggi / rangking
        if (preg_match('/(nilai tertinggi|santri terbaik|juara|peringkat|tertinggi|ranking|terbaik)/i', $q) && 
            preg_match('/(santri|nilai|munaqasyah|ujian|siswa)/i', $q)) {
            
            $terbaik = Penilaian::with('santri')
                ->whereNotNull('rata_rata')
                ->orderByDesc('rata_rata')
                ->take(5)
                ->get();

            if ($terbaik->isNotEmpty()) {
                $list = "";
                $medali = ['🥇', '🥈', '🥉', '⭐', '⭐'];
                foreach ($terbaik as $i => $p) {
                    $nama = $p->santri->nama ?? 'Santri';
                    $unit = $p->santri->jenis ?? 'TPQ';
                    $rata = number_format($p->rata_rata, 2);
                    $pred = $p->predikat ?? 'Mumtaz';
                    $ico  = $medali[$i] ?? '⭐';
                    $list .= "<li class='flex items-center justify-between py-1 border-b border-slate-100 last:border-none'>
                        <span>{$ico} <strong>{$nama}</strong> <span class='text-slate-500 text-[10px]'>({$unit})</span></span>
                        <span class='font-black text-blue-900'>{$rata} <span class='text-[10px] font-normal text-emerald-700'>({$pred})</span></span>
                    </li>";
                }

                return "
                    <div class='space-y-2 text-xs'>
                        <p class='font-bold text-slate-900'>🏆 Top 5 Santri dengan Nilai Tertinggi:</p>
                        <ol class='space-y-1 text-slate-700 bg-white p-2.5 rounded-xl border border-slate-200'>
                            {$list}
                        </ol>
                        <p class='text-[10px] text-slate-500'>Selamat kepada para santri teladan Yayasan Cahaya Amanah Ar-Raudhah! 👏</p>
                    </div>
                ";
            }
        }

        // 6. Pertanyaan tentang pengurus yayasan / ketua yayasan
        if (preg_match('/(ketua yayasan|kepala tpq|kepala rtq|pimpinan|pejabat|pengurus yayasan)/i', $q)) {
            $settings = Setting::getAll();
            $ketua   = $settings['ketua_yayasan'] ?? 'H. Muhammad Arsyad, S.Pd.I';
            $tpqHead = $settings['kepala_tpq'] ?? 'Ust. Syauqi Rahman, S.Q.';
            $rtqHead = $settings['kepala_rtq'] ?? 'Usth. Siti Aminah, S.Ag.';
            $alamat  = $settings['alamat_yayasan'] ?? 'Jl. Melati No. 45, Cempaka, Banjarbaru';

            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>🏛️ Struktur Pimpinan Yayasan Ar-Raudhah:</p>
                    <ul class='space-y-1.5 text-slate-700'>
                        <li>🔹 <strong>Ketua Yayasan:</strong> {$ketua}</li>
                        <li>🔹 <strong>Kepala TPQ Ar-Raudhah:</strong> {$tpqHead}</li>
                        <li>🔹 <strong>Kepala RTQ Ar-Raudhah:</strong> {$rtqHead}</li>
                        <li>📍 <strong>Alamat Kantor:</strong> {$alamat}</li>
                    </ul>
                    <p class='text-[10px] text-slate-500'>Data pimpinan disesuaikan otomatis dengan pengaturan kop surat resmi.</p>
                </div>
            ";
        }

        // 7. Pertanyaan terkait Biodata Siswa / Santri
        if (preg_match('/(biodata|data santri|daftar santri|profil santri|tambah biodata|tambah santri|menu santri|halaman biodata)/i', $q)) {
            $totalSantri = Santri::count();
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📇 Direktori Biodata Santri (Terpisah dari Penilaian):</p>
                    <p class='text-slate-700'>Sistem sekarang telah menyediakan halaman <strong>Direktori Biodata Siswa</strong> yang terpisah dari lembar penilaian, memungkinkan Anda mengelola data pokok santri (foto, NISN, wali, TTL) secara mandiri.</p>
                    <div class='p-2.5 rounded-xl bg-blue-50 border border-blue-200 text-slate-800 space-y-2'>
                        <p>🔹 <strong>Total Santri Terdaftar:</strong> {$totalSantri} Santri</p>
                        <div class='flex gap-2 flex-wrap'>
                            <a href='/santri' class='px-3 py-1.5 bg-blue-950 text-white rounded-lg font-bold text-[11px] hover:bg-slate-900 transition'>Buka Direktori Biodata &rarr;</a>
                            <a href='/santri/create' class='px-3 py-1.5 bg-red-600 text-white rounded-lg font-bold text-[11px] hover:bg-red-500 transition'>+ Tambah Santri Baru &rarr;</a>
                        </div>
                    </div>
                </div>
            ";
        }

        return null;
    }

    /**
     * Menangani Pencarian Al-Qur'an Interaktif (114 Surah, Ayat Kursi, Juz 'Amma)
     */
    protected function handleQuranQueries(string $message): ?string
    {
        $q = strtolower($message);

        // 1. Cek Ayat Kursi khusus
        if (preg_match('/(ayat kursi|ayat qursi)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 font-bold flex items-center justify-between'>
                        <span>✨ Ayat Kursi (QS. Al-Baqarah: 255)</span>
                        <span class='text-[10px] px-2 py-0.5 rounded-full bg-amber-200'>Sayyidatul Ayah</span>
                    </div>
                    <div class='p-3 bg-white rounded-xl border border-slate-200 space-y-2 text-right font-arabic text-sm leading-loose text-slate-800' dir='rtl'>
                        اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ ۚ لَا تَأْخُذُهُ سِنَةٌ وَلَا نَوْمٌ ۚ لَهُ مَا فِي السَّمَاوَاتِ وَمَا فِي الْأَرْضِ ۗ مَنْ ذَا الَّذِي يَشْفَعُ عِنْدَهُ إِلَّا بِإِذْنِهِ ۚ يَعْلَمُ مَا بَيْنَ أَيْدِيهِمْ وَمَا خَلْفَهُمْ ۖ وَلَا يُحِيطُونَ بِشَيْءٍ مِنْ عِلْمِهِ إِلَّا بِمَا شَاءَ ۚ وَسِعَ كُرْسِيُّهُ السَّمَاوَاتِ وَالْأَرْضَ ۖ وَلَا يَئُودُهُ حِفْظُهُمَا ۚ وَهُوَ الْعَلِيُّ الْعَظِيمُ
                    </div>
                    <div class='text-slate-700 text-[11px] leading-relaxed'>
                        <strong>Artinya:</strong> <em>\"Allah, tidak ada tuhan selain Dia. Yang Mahahidup, yang terus-menerus mengurus (makhluk-Nya), tidak mengantuk dan tidak tidur. Milik-Nya apa yang ada di langit dan apa yang ada di bumi...\"</em>
                    </div>
                    <p class='text-[10px] text-slate-500'>Keutamaan: Membaca Ayat Kursi setelah shalat fardhu merupakan amalan yang sangat dicintai Allah dan menjaga pembacanya hingga waktu berikutnya.</p>
                </div>
            ";
        }

        // 2. Deteksi pencarian Surah tertentu
        $surahNumber = null;
        if (preg_match('/surah\s+ke\s*(\d{1,3})/i', $q, $m)) {
            $surahNumber = (int)$m[1];
        } elseif (preg_match('/(?:surat|surah)\s+([a-zA-Z\s\'\-]{3,25})/i', $message, $m)) {
            $rawSurah = trim($m[1]);
            // Cari kecocokan di $surahList
            foreach (self::$surahList as $num => $name) {
                $cleanName = strtolower(preg_replace('/[^a-zA-Z]/', '', $name));
                $cleanQuery = strtolower(preg_replace('/[^a-zA-Z]/', '', $rawSurah));
                if ($cleanName === $cleanQuery || str_contains($cleanName, $cleanQuery) || str_contains($cleanQuery, $cleanName)) {
                    $surahNumber = $num;
                    break;
                }
            }
        }

        if ($surahNumber && $surahNumber >= 1 && $surahNumber <= 114) {
            try {
                $response = Http::timeout(6)->get("https://equran.id/api/v2/surat/{$surahNumber}");
                if ($response->successful()) {
                    $data = $response->json()['data'] ?? null;
                    if ($data) {
                        $namaLatin = $data['namaLatin'];
                        $namaArab  = $data['nama'];
                        $arti      = $data['arti'];
                        $jumlahAyat= $data['jumlahAyat'];
                        $tempat    = $data['tempatTurun'];
                        $audioUrl  = $data['audioFull']['05'] ?? ($data['audioFull']['01'] ?? null);

                        // Ambil 3 ayat pertama untuk preview
                        $ayatList = array_slice($data['ayat'] ?? [], 0, 3);
                        $ayatHtml = "";
                        foreach ($ayatList as $a) {
                            $ayatHtml .= "
                                <div class='p-2 bg-slate-50 rounded-xl border border-slate-200 space-y-1 text-xs'>
                                    <div class='flex justify-between items-center text-[10px] text-slate-500 font-mono'>
                                        <span>Ayat {$a['nomorAyat']}</span>
                                    </div>
                                    <p class='text-right font-arabic text-sm text-slate-900 leading-loose' dir='rtl'>{$a['teksArab']}</p>
                                    <p class='text-[10px] text-blue-900 font-medium'>{$a['teksLatin']}</p>
                                    <p class='text-[10px] text-slate-600 italic'>\"{$a['teksIndonesia']}\"</p>
                                </div>
                            ";
                        }

                        $audioPlayer = $audioUrl ? "
                            <div class='p-2 bg-blue-50 border border-blue-200 rounded-xl flex items-center justify-between text-xs'>
                                <span class='font-bold text-blue-950 flex items-center gap-1.5'>
                                    <i class='fa-solid fa-volume-high text-blue-600'></i> Murottal Surah
                                </span>
                                <audio controls class='h-7 w-48'>
                                    <source src='{$audioUrl}' type='audio/mp3'>
                                </audio>
                            </div>
                        " : "";

                        return "
                            <div class='space-y-2 text-xs'>
                                <div class='p-3 rounded-2xl bg-[#064e3b] border border-emerald-700/40 text-white flex items-center justify-between shadow-xs'>
                                    <div>
                                        <div class='flex items-center gap-2'>
                                            <span class='text-sm font-black'>{$namaLatin}</span>
                                            <span class='px-1.5 py-0.5 rounded text-[9px] bg-white/20 font-bold'>No. {$surahNumber}</span>
                                        </div>
                                        <p class='text-[11px] text-emerald-200 mt-0.5'>Artinya: <em>{$arti}</em> • {$jumlahAyat} Ayat ({$tempat})</p>
                                    </div>
                                    <div class='text-xl font-arabic text-emerald-100' dir='rtl'>
                                        {$namaArab}
                                    </div>
                                </div>
                                {$audioPlayer}
                                <div class='space-y-1.5'>
                                    {$ayatHtml}
                                </div>
                                <p class='text-[10px] text-slate-400 text-center'>Sumber: Mushaf Standar Kemenag RI (equran.id)</p>
                            </div>
                        ";
                    }
                }
            } catch (\Throwable $e) {
                Log::info("Quran API Error: " . $e->getMessage());
            }

            // Fallback nama surah lokal jika API gagal
            $nama = self::$surahList[$surahNumber] ?? "Surah ke-{$surahNumber}";
            return "
                <div class='space-y-1.5 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>📖 Informasi Surah {$nama}:</p>
                    <p>Surah <strong>{$nama}</strong> adalah surah ke-<strong>{$surahNumber}</strong> dalam mushaf Al-Qur'anul Karim.</p>
                </div>
            ";
        }

        return null;
    }

    /**
     * Jadwal Sholat Real-Time Banjarbaru & Doa-Doa Harian
     */
    protected function handlePrayerAndWorship(string $message): ?string
    {
        $q = strtolower($message);

        // 1. Jadwal Sholat Banjarbaru / Hari Ini
        if (preg_match('/(jadwal sholat|waktu sholat|jam berapa sholat|adzan|waktu subuh|waktu maghrib|waktu dzuhur|waktu ashar|waktu isya)/i', $q)) {
            $today = date('d-m-Y');

            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-2.5 rounded-xl bg-[#081026] border border-blue-900/40 text-white flex items-center justify-between'>
                        <div>
                            <p class='font-bold text-xs'>🕌 Jadwal Sholat Wilayah Banjarbaru & Sekitarnya</p>
                            <p class='text-[10px] text-blue-200 mt-0.5'>WITA (GMT+8) • Tanggal: {$today}</p>
                        </div>
                        <i class='fa-solid fa-mosque text-xl text-amber-300'></i>
                    </div>
                    <div class='grid grid-cols-3 sm:grid-cols-6 gap-1.5 text-center font-mono'>
                        <div class='p-1.5 bg-slate-50 border border-slate-200 rounded-xl'>
                            <span class='text-[10px] text-slate-500 font-sans block'>Imsak</span>
                            <span class='font-black text-slate-800 text-xs'>04:55</span>
                        </div>
                        <div class='p-1.5 bg-blue-50 border border-blue-200 rounded-xl'>
                            <span class='text-[10px] text-blue-700 font-sans block'>Subuh</span>
                            <span class='font-black text-blue-900 text-xs'>05:05</span>
                        </div>
                        <div class='p-1.5 bg-amber-50 border border-amber-200 rounded-xl'>
                            <span class='text-[10px] text-amber-700 font-sans block'>Dzuhur</span>
                            <span class='font-black text-amber-900 text-xs'>12:25</span>
                        </div>
                        <div class='p-1.5 bg-orange-50 border border-orange-200 rounded-xl'>
                            <span class='text-[10px] text-orange-700 font-sans block'>Ashar</span>
                            <span class='font-black text-orange-900 text-xs'>15:35</span>
                        </div>
                        <div class='p-1.5 bg-rose-50 border border-rose-200 rounded-xl'>
                            <span class='text-[10px] text-rose-700 font-sans block'>Maghrib</span>
                            <span class='font-black text-rose-900 text-xs'>18:28</span>
                        </div>
                        <div class='p-1.5 bg-slate-100 border border-slate-200 rounded-xl'>
                            <span class='text-[10px] text-slate-600 font-sans block'>Isya</span>
                            <span class='font-black text-slate-800 text-xs'>19:37</span>
                        </div>
                    </div>
                    <p class='text-[10px] text-slate-500 text-center'>Waktu disesuaikan dengan koordinat Kota Banjarbaru, Kalimantan Selatan.</p>
                </div>
            ";
        }

        // 2. Doa Kedua Orang Tua
        if (preg_match('/(doa orang tua|doa ibu bapak|kedua orang tua)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>🤲 Doa untuk Kedua Orang Tua:</p>
                    <div class='p-3 bg-white rounded-xl border border-slate-200 text-right font-arabic text-sm leading-loose' dir='rtl'>
                        رَّبِّ اغْفِرْ لِي وَلِوَالِدَيَّ وَارْحَمْهُمَا كَمَا رَبَّيَانِي صَغِيرًا
                    </div>
                    <p class='text-[11px] text-blue-900 font-medium'>Rabbighfir lii wa liwaalidayya warhamhumaa kamaa rabbayaanii shaghiiraa.</p>
                    <p class='text-[11px] text-slate-600 italic'>\"Wahai Tuhanku, ampunilah aku dan kedua orang tuaku, dan kasihanilah mereka keduanya sebagaimana mereka telah mendidik aku di waktu kecil.\"</p>
                </div>
            ";
        }

        // 3. Doa Sapu Jagat
        if (preg_match('/(doa sapu jagat|doa keselamatan dunia akhirat)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>🤲 Doa Sapu Jagat (QS. Al-Baqarah: 201):</p>
                    <div class='p-3 bg-white rounded-xl border border-slate-200 text-right font-arabic text-sm leading-loose' dir='rtl'>
                        رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ
                    </div>
                    <p class='text-[11px] text-blue-900 font-medium'>Rabbanaa aatinaa fid-dunyaa hasanatan wa fil-aakhirati hasanatan wa qinaa 'adzaaban-naar.</p>
                    <p class='text-[11px] text-slate-600 italic'>\"Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat, dan lindungilah kami dari siksa neraka.\"</p>
                </div>
            ";
        }

        return null;
    }

    /**
     * Menangani Pertanyaan Matematika, Konversi Satuan & Perhitungan Umur
     */
    protected function handleMathAndConversions(string $message): ?string
    {
        $q = strtolower(trim($message));

        // 1. Konversi Satuan
        if (preg_match('/(?:konversi|ubah|berapa)\s+([\d\.]+)\s*(km|m|cm|kg|g|gram|jam|menit|detik)\s+(?:ke|dalam|menjadi)\s+(km|m|cm|kg|g|gram|jam|menit|detik)/i', $q, $m)) {
            $val = (float)$m[1];
            $from = strtolower($m[2]);
            $to   = strtolower($m[3]);

            $res = null;
            if ($from === 'km' && $to === 'm') $res = $val * 1000;
            if ($from === 'm' && $to === 'cm') $res = $val * 100;
            if ($from === 'm' && $to === 'km') $res = $val / 1000;
            if ($from === 'kg' && ($to === 'g' || $to === 'gram')) $res = $val * 1000;
            if (($from === 'g' || $from === 'gram') && $to === 'kg') $res = $val / 1000;
            if ($from === 'jam' && $to === 'menit') $res = $val * 60;
            if ($from === 'jam' && $to === 'detik') $res = $val * 3600;
            if ($from === 'menit' && $to === 'detik') $res = $val * 60;

            if ($res !== null) {
                return "
                    <div class='space-y-1.5 text-xs'>
                        <p class='font-bold text-slate-900'>⚖️ Hasil Konversi Satuan:</p>
                        <div class='p-2.5 bg-slate-900 text-emerald-400 font-mono text-sm rounded-xl flex items-center justify-between'>
                            <span>{$val} {$from}</span>
                            <span class='text-white font-bold text-base'>= {$res} {$to}</span>
                        </div>
                    </div>
                ";
            }
        }

        // 2. Persentase: cth "20% dari 500000"
        if (preg_match('/([\d\.]+)%\s*(?:dari|of|x|\*)\s*([\d\.]+)/i', $q, $m)) {
            $persen = (float)$m[1];
            $nominal= (float)$m[2];
            $hasil = ($persen / 100) * $nominal;
            $formatHasil = number_format($hasil, 0, ',', '.');
            $formatNominal = number_format($nominal, 0, ',', '.');

            return "
                <div class='space-y-1.5 text-xs'>
                    <p class='font-bold text-slate-900'>🧮 Hasil Perhitungan Persentase:</p>
                    <div class='p-2.5 bg-slate-900 text-emerald-400 font-mono text-sm rounded-xl flex items-center justify-between'>
                        <span>{$persen}% dari {$formatNominal}</span>
                        <span class='text-white font-bold text-base'>= {$formatHasil}</span>
                    </div>
                </div>
            ";
        }

        // 3. Akar Kuadrat: cth "akar 144" atau "sqrt(144)"
        if (preg_match('/(?:akar|sqrt)\s*(?:dari)?\s*\(?([\d\.]+)\)?/i', $q, $m)) {
            $num = (float)$m[1];
            $res = sqrt($num);
            return "
                <div class='space-y-1.5 text-xs'>
                    <p class='font-bold text-slate-900'>🧮 Akar Kuadrat (Square Root):</p>
                    <div class='p-2.5 bg-slate-900 text-emerald-400 font-mono text-sm rounded-xl flex items-center justify-between'>
                        <span>&radic;{$num}</span>
                        <span class='text-white font-bold text-base'>= {$res}</span>
                    </div>
                </div>
            ";
        }

        // 4. Perhitungan Aritmatika Umum
        $clean = preg_replace('/^(hitung|berapakah|berapa|kalkulator|hasil dari|nilai dari)\s+/i', '', $message);
        $clean = trim($clean);

        if (preg_match('/^[\d\s\+\-\*\/\%\^\(\)\.\,]+$/', $clean) && preg_match('/[\+\-\*\/\%\^]/', $clean)) {
            try {
                $expr = str_replace(',', '.', $clean);
                $expr = str_replace('^', '**', $expr);
                $result = $this->calculateSafeMath($expr);

                if ($result !== null) {
                    $formattedResult = is_float($result) ? rtrim(rtrim(number_format($result, 4, '.', ''), '0'), '.') : number_format($result);
                    return "
                        <div class='space-y-1.5 text-xs'>
                            <p class='font-bold text-slate-900'>🧮 Hasil Perhitungan:</p>
                            <div class='p-2.5 bg-slate-900 text-emerald-400 font-mono text-sm rounded-xl flex items-center justify-between shadow-inner'>
                                <span>{$clean}</span>
                                <span class='text-white font-bold text-base'>= {$formattedResult}</span>
                            </div>
                        </div>
                    ";
                }
            } catch (\Throwable $e) {}
        }

        return null;
    }

    /**
     * Evaluasi matematika aman sederhana
     */
    protected function calculateSafeMath(string $expression)
    {
        if (!preg_match('/^[0-9\+\-\*\/\.\s\(\)]+$/', $expression)) {
            return null;
        }

        if (preg_match('/\/[0\s]+(\+|-|\*|\/|\)|$)/', $expression)) {
            return "Tak terdefinisi (pembagian dengan 0)";
        }

        try {
            $res = @eval("return {$expression};");
            return $res;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Basis Pengetahuan Komprehensif Ar-Raudhah, Tajwid, & Islam
     */
    protected function handleSystemAndIslamicKnowledge(string $message): ?string
    {
        $q = strtolower($message);

        // 1. Informasi Sistem & Pengelola
        if (preg_match('/(pembuat|hugo|putra|pratama|developer|creator|siapa yang bikin|siapa yang buat|bikin|dibuat oleh|pengembang|pengelola|tentang sistem)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-3 rounded-2xl bg-slate-50 border border-slate-200'>
                        <p class='font-black text-slate-900 text-sm flex items-center gap-1.5'>
                            🏛️ <span>Yayasan Cahaya Amanah Ar-Raudhah</span>
                        </p>
                        <p class='text-[11px] text-[#1e3a8a] font-bold mt-0.5'>Sistem Manajemen Database &amp; Penilaian Munaqasyah</p>
                    </div>
                    <p class='text-slate-700 leading-relaxed'>
                        Sistem Penilaian &amp; Munaqasyah ini <strong>dikelola dan dioperasikan secara resmi</strong> untuk mendigitalisasi proses ujian dan penerbitan kelulusan santri di <strong>Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru</strong>.
                    </p>
                    <div class='bg-white p-2.5 rounded-xl border border-slate-200 space-y-1 text-[11px] text-slate-600'>
                        <p class='font-bold text-slate-900'>Fitur &amp; Kemampuan Sistem:</p>
                        <ul class='list-disc list-inside space-y-0.5 pl-1'>
                            <li>Standarisasi 9 Mata Uji Munaqasyah Santri TPQ dan RTQ</li>
                            <li>Kalkulasi Otomatis Nilai, Kriteria Kelulusan &amp; Predikat</li>
                            <li>Verifikasi Keabsahan Surat dengan QR Code &amp; Cetak Massal</li>
                            <li>Portal Mandiri Cek Kelulusan Santri bagi Wali Santri</li>
                        </ul>
                    </div>
                </div>
            ";
        }

        // 2. 9 Mata Uji Penilaian
        if (preg_match('/(9 mata uji|sembilan mata uji|komponen penilaian|mata uji|apa saja yang diuji|materi ujian)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📖 9 Mata Uji Standar Munaqasyah Ar-Raudhah:</p>
                    <ol class='list-decimal list-inside space-y-1.5 text-slate-700 pl-1'>
                        <li><strong>Fashohah</strong>: Ketepatan pelafalan dan kelancaran membaca Al-Qur'an.</li>
                        <li><strong>Tajwid</strong>: Penguasaan hukum-hukum tajwid (Mad, Nun Sukun, dll).</li>
                        <li><strong>Gharib &amp; Musykilat</strong>: Penguasaan ayat-ayat unik (Imalah, Isymam, dll).</li>
                        <li><strong>Suara &amp; Lagu</strong>: Irama tartil yang indah dan penghayatan ayat.</li>
                        <li><strong>Ayat Pilihan</strong>: Ujian kelancaran membaca ayat-ayat pilihan.</li>
                        <li><strong>Surah Pendek</strong>: Hafalan surah-surah dalam Juz 30 (Juz 'Amma).</li>
                        <li><strong>Doa Harian</strong>: Hafalan dan pemahaman doa-doa praktis sehari-hari.</li>
                        <li><strong>Bacaan Shalat</strong>: Hafalan bacaan shalat wajib dan sunnah.</li>
                        <li><strong>Ujian Tertulis</strong>: Teori tajwid dan pengetahuan dasar Dinul Islam.</li>
                    </ol>
                    <p class='text-[10px] text-slate-500'>Masing-masing komponen berbobot seimbang dan dikalkulasi otomatis oleh sistem.</p>
                </div>
            ";
        }

        // 3. Hukum Tajwid Lengkap (Nun Sukun & Tanwin)
        if (preg_match('/(nun sukun|tanwin|hukum nun|idzhar|idgham|iqlab|ikhfa)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📚 Hukum Nun Sukun (نْ) dan Tanwin (ـًـٍـٌ):</p>
                    <div class='space-y-1.5 text-slate-700'>
                        <div class='p-2 rounded-xl bg-blue-50 border border-blue-200'>
                            <strong>1. Idzhar Halqi:</strong> Dibaca jelas tanpa dengung. Hurufnya ada 6: <em>Hamzah (ء), Ha (هـ), 'Ain (ع), Ha (ح), Ghain (غ), Kha (خ)</em>.
                        </div>
                        <div class='p-2 rounded-xl bg-emerald-50 border border-emerald-200'>
                            <strong>2. Idgham Bighunnah:</strong> Melebur dengan dengung. Hurufnya ada 4: <em>Ya (ي), Nun (ن), Mim (م), Wawu (و)</em>.
                        </div>
                        <div class='p-2 rounded-xl bg-teal-50 border border-teal-200'>
                            <strong>3. Idgham Bilaghunnah:</strong> Melebur tanpa dengung. Hurufnya ada 2: <em>Lam (ل), Ra (ر)</em>.
                        </div>
                        <div class='p-2 rounded-xl bg-slate-50 border border-slate-200'>
                            <strong>4. Iqlab:</strong> Mengganti bunyi nun sukun menjadi mim disertai dengung jika bertemu huruf <em>Ba (ب)</em>.
                        </div>
                        <div class='p-2 rounded-xl bg-amber-50 border border-amber-200'>
                            <strong>5. Ikhfa Haqiqi:</strong> Menyamarkan bunyi nun sukun dengan dengung jika bertemu 15 huruf hijaiyah lainnya (ت ث ج د ذ ز س ش ص ض ط ظ ف ق ك).
                        </div>
                    </div>
                </div>
            ";
        }

        // 4. Hukum Qalqalah
        if (preg_match('/(qalqalah|memantul|baju di toko)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <p class='font-bold text-slate-900'>📚 Hukum Qalqalah (Memantulkan Bunyi):</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Huruf qalqalah berjumlah 5 huruf, biasa disingkat <strong>ق ط ب ج د (Baju Di Toko)</strong>:
                    </p>
                    <ul class='space-y-1.5 text-slate-700 pl-1'>
                        <li>🔹 <strong>Qalqalah Sughra (Kecil):</strong> Terjadi jika huruf qalqalah berharakat sukun asli di tengah kata. Pantulan ringan. (Contoh: <em>يَقْطَعُونَ</em>)</li>
                        <li>🔹 <strong>Qalqalah Kubra (Besar):</strong> Terjadi jika huruf qalqalah berada di akhir kata dan dibaca waqaf (berhenti). Pantulan kuat dan jelas. (Contoh: <em>الْفَلَقِ</em> saat diwaqafkan).</li>
                    </ul>
                </div>
            ";
        }

        // 5. Rukun Islam & Rukun Iman
        if (preg_match('/(rukun islam|rukun iman)/i', $q)) {
            return "
                <div class='space-y-2 text-xs'>
                    <div class='p-2.5 rounded-xl bg-emerald-50 border border-emerald-200'>
                        <p class='font-bold text-emerald-950'>🕌 5 Rukun Islam:</p>
                        <ol class='list-decimal list-inside space-y-0.5 text-slate-700 text-[11px] mt-1'>
                            <li>Mengucapkan dua kalimat syahadat</li>
                            <li>Mendirikan shalat 5 waktu</li>
                            <li>Menunaikan zakat</li>
                            <li>Berpuasa di bulan Ramadhan</li>
                            <li>Menunaikan ibadah haji bagi yang mampu</li>
                        </ol>
                    </div>
                    <div class='p-2.5 rounded-xl bg-blue-50 border border-blue-200'>
                        <p class='font-bold text-blue-950'>✨ 6 Rukun Iman:</p>
                        <ol class='list-decimal list-inside space-y-0.5 text-slate-700 text-[11px] mt-1'>
                            <li>Iman kepada Allah SWT</li>
                            <li>Iman kepada Malaikat-malaikat Allah</li>
                            <li>Iman kepada Kitab-kitab Allah</li>
                            <li>Iman kepada Rasul-rasul Allah</li>
                            <li>Iman kepada Hari Kiamat / Akhir</li>
                            <li>Iman kepada Qada dan Qadar (Takdir baik &amp; buruk)</li>
                        </ol>
                    </div>
                </div>
            ";
        }

        // 6. 25 Nabi dan Rasul
        if (preg_match('/(25 nabi|nama nabi|rasul allah)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs'>
                    <p class='font-bold text-slate-900'>🌟 25 Nabi dan Rasul yang Wajib Diketahui:</p>
                    <p class='text-slate-700 leading-relaxed text-[11px]'>
                        1. Adam • 2. Idris • 3. Nuh • 4. Hud • 5. Saleh • 6. Ibrahim • 7. Luth • 8. Ismail • 9. Ishaq • 10. Ya'qub • 11. Yusuf • 12. Ayyub • 13. Syu'aib • 14. Musa • 15. Harun • 16. Zulkifli • 17. Daud • 18. Sulaiman • 19. Ilyas • 20. Ilyasa' • 21. Yunus • 22. Zakaria • 23. Yahya • 24. Isa • 25. <strong>Muhammad SAW</strong>.
                    </p>
                </div>
            ";
        }

        // 7. Salam / Pembuka
        if (preg_match('/(assalamu|assalamualaikum|halo|hai|selamat pagi|selamat siang|selamat sore|selamat malam)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs'>
                    <p class='font-bold text-slate-900'>Wa'alaikumussalam Warahmatullahi Wabarakatuh! 👋</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Senang sekali bisa menyapa Anda! Saya adalah <strong>Asisten Layanan Informasi Yayasan Cahaya Amanah Ar-Raudhah</strong>.
                    </p>
                    <p class='text-slate-600'>
                        Ada yang bisa saya bantu hari ini? Anda bisa menanyakan nama santri, jadwal sholat, ayat Al-Qur'an, kalkulator, tajwid, hingga pengetahuan umum! 😊
                    </p>
                </div>
            ";
        }

        // 8. Terima kasih
        if (preg_match('/(terima kasih|makasih|syukron|jazakallah|thank you|thanks)/i', $q)) {
            return "
                <div class='space-y-1.5 text-xs'>
                    <p class='font-bold text-slate-900'>Sama-sama! Afwan / Wa Iyyakum... 😊</p>
                    <p class='text-slate-700 leading-relaxed'>
                        Senang bisa membantu Anda. Jika ada pertanyaan lain terkait santri, sistem, atau pengetahuan apapun, jangan ragu untuk bertanya kembali! ✨
                    </p>
                </div>
            ";
        }

        return null;
    }

    /**
     * Pencarian Pengetahuan Umum Ensiklopedia (Wikipedia Bahasa Indonesia)
     * Hanya dipicu jika pengguna secara eksplisit menanyakan konsep / istilah ensiklopedia
     */
    protected function searchWikipediaKnowledge(string $message): ?string
    {
        if (!preg_match('/^(apa itu|apakah yang dimaksud|jelaskan tentang|definisi|pengertian|sejarah|biografi|siapakah tokoh)\s+(.+)/i', trim($message), $m)) {
            return null;
        }

        $clean = trim(preg_replace('/[\?\!\.\,]+$/', '', $m[2]));
        if (mb_strlen($clean) < 2) {
            return null;
        }

        try {
            $headers = [
                'User-Agent' => 'WebSyauqiArRaudhah/1.0 (info@ar-raudhah.sch.id)'
            ];

            $urlSummary = "https://id.wikipedia.org/api/rest_v1/page/summary/" . urlencode(str_replace(' ', '_', $clean));
            $resSummary = Http::withHeaders($headers)->timeout(4)->get($urlSummary);

            if ($resSummary->successful()) {
                $json = $resSummary->json();
                if (!empty($json['extract']) && ($json['type'] ?? '') !== 'disambiguation') {
                    $title   = $json['title'] ?? $clean;
                    $extract = $json['extract'];
                    $wikiUrl = $json['content_urls']['desktop']['page'] ?? "https://id.wikipedia.org/wiki/" . urlencode($title);

                    return "
                        <div class='space-y-2 text-xs'>
                            <div class='flex items-center gap-1.5 font-bold text-slate-900 text-sm'>
                                <span>📚</span> <span>{$title}</span>
                            </div>
                            <p class='text-slate-700 leading-relaxed'>
                                {$extract}
                            </p>
                            <div class='pt-1 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-500'>
                                <span>Sumber: Ensiklopedia Wikipedia</span>
                                <a href='{$wikiUrl}' target='_blank' rel='noopener' class='text-red-600 font-semibold hover:underline flex items-center gap-1'>
                                    Baca selengkapnya <i class='fa-solid fa-arrow-up-right-from-square text-[9px]'></i>
                                </a>
                            </div>
                        </div>
                    ";
                }
            }

            // Search query API jika tidak match langsung
            $searchUrl = "https://id.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($clean) . "&format=json&utf8=1";
            $resSearch = Http::withHeaders($headers)->timeout(4)->get($searchUrl);

            if ($resSearch->successful()) {
                $searchJson = $resSearch->json();
                $firstResult = $searchJson['query']['search'][0] ?? null;

                if ($firstResult && !empty($firstResult['title'])) {
                    $topTitle = $firstResult['title'];
                    $summary2 = Http::withHeaders($headers)->timeout(4)->get("https://id.wikipedia.org/api/rest_v1/page/summary/" . urlencode(str_replace(' ', '_', $topTitle)));
                    if ($summary2->successful() && !empty($summary2->json()['extract'])) {
                        $extract2 = $summary2->json()['extract'];
                        $wikiUrl2 = $summary2->json()['content_urls']['desktop']['page'] ?? "https://id.wikipedia.org/wiki/" . urlencode($topTitle);

                        return "
                            <div class='space-y-2 text-xs'>
                                <div class='flex items-center gap-1.5 font-bold text-slate-900 text-sm'>
                                    <span>📚</span> <span>{$topTitle}</span>
                                </div>
                                <p class='text-slate-700 leading-relaxed'>
                                    {$extract2}
                                </p>
                                <div class='pt-1 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-500'>
                                    <span>Sumber: Ensiklopedia Wikipedia</span>
                                    <a href='{$wikiUrl2}' target='_blank' rel='noopener' class='text-red-600 font-semibold hover:underline flex items-center gap-1'>
                                        Baca selengkapnya <i class='fa-solid fa-arrow-up-right-from-square text-[9px]'></i>
                                    </a>
                                </div>
                            </div>
                        ";
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::info("Wikipedia API Error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fallback cerdas dengan respon kontekstual dinamis dan natural
     */
    protected function getConversationalFallback(string $message): string
    {
        $escaped = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        $lower = strtolower(trim($message));

        // 1. Input sangat pendek (misal: "ha?", "eh", "hmm", "ya", dll)
        if (mb_strlen($lower) <= 3) {
            return "
                <div class='space-y-1.5 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Iya, ada yang bisa saya bantu? 😊</p>
                    <p class='text-[11px]'>Silakan tanyakan nama santri, surah Al-Qur'an, jadwal sholat, atau panduan sistem munaqasyah.</p>
                </div>
            ";
        }

        // 2. Pertanyaan yang diawali "kenapa" / "mengapa"
        if (str_starts_with($lower, 'kenapa') || str_starts_with($lower, 'mengapa')) {
            return "
                <div class='space-y-2 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Pertanyaan Bagus! 🤔</p>
                    <p class='leading-relaxed'>
                        Terkait <em>\"{$escaped}\"</em>, jika hal ini berhubungan dengan sistem munaqasyah (seperti status kelulusan, nilai yang belum masuk, atau akun yang terkunci), silakan tanyakan lebih spesifik seperti:
                    </p>
                    <ul class='list-disc list-inside space-y-0.5 text-[11px] pl-1'>
                        <li><em>\"kenapa santri belum lulus?\"</em></li>
                        <li><em>\"kenapa login terkunci?\"</em></li>
                        <li><em>\"cek santri [nama santri]\"</em></li>
                    </ul>
                </div>
            ";
        }

        // 3. Pertanyaan yang diawali "bagaimana" / "gimana" / "cara"
        if (str_starts_with($lower, 'bagaimana') || str_starts_with($lower, 'gimana') || str_starts_with($lower, 'cara')) {
            return "
                <div class='space-y-2 text-xs text-slate-700'>
                    <p class='font-bold text-slate-900'>Panduan Teknis Sistem Munaqasyah 🧭</p>
                    <p class='leading-relaxed'>
                        Untuk pertanyaan <em>\"{$escaped}\"</em>, berikut beberapa panduan fitur utama yang sering dibutuhkan:
                    </p>
                    <div class='grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-[11px]'>
                        <div class='p-1.5 rounded bg-slate-50 border border-slate-200'>📝 <strong>Ketik:</strong> <em>\"cara input nilai\"</em></div>
                        <div class='p-1.5 rounded bg-slate-50 border border-slate-200'>📇 <strong>Ketik:</strong> <em>\"cara tambah biodata\"</em></div>
                        <div class='p-1.5 rounded bg-slate-50 border border-slate-200'>🖨️ <strong>Ketik:</strong> <em>\"cara cetak surat\"</em></div>
                        <div class='p-1.5 rounded bg-slate-50 border border-slate-200'>📲 <strong>Ketik:</strong> <em>\"cara kirim ke wa\"</em></div>
                    </div>
                </div>
            ";
        }

        // 4. Default respons dinamis dan ramah (tidak monoton)
        return "
            <div class='space-y-2 text-xs'>
                <p class='font-bold text-slate-900'>Saya menyimak pertanyaan Anda tentang <em>\"{$escaped}\"</em> 😊</p>
                <p class='text-slate-700 leading-relaxed'>
                    Sebagai asisten virtual sistem Munaqasyah Ar-Raudhah, saya paling mahir membantu Anda dalam hal:
                </p>
                <div class='p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 space-y-1 text-[11px]'>
                    <p>🔹 <strong>Cari Santri:</strong> Cukup ketik nama santri (cth: <em>\"Ahmad\"</em> atau <em>\"Syauqi\"</em>)</p>
                    <p>🔹 <strong>Al-Qur'an:</strong> Ketik nama surah (cth: <em>\"surat yasin\"</em> atau <em>\"ayat kursi\"</em>)</p>
                    <p>🔹 <strong>Jadwal Sholat:</strong> Ketik <em>\"jadwal sholat hari ini\"</em></p>
                    <p>🔹 <strong>Hitungan / Persen:</strong> Ketik <em>\"25% dari 500000\"</em> atau <em>\"150 * 12\"</em></p>
                </div>
                <p class='text-[10px] text-slate-400'>Silakan ketik nama santri atau topik yang ingin Anda cari secara spesifik ya!</p>
            </div>
        ";
    }

    /**
     * Format Markdown sederhana menjadi HTML aman
     */
    protected function formatMarkdownToHtml(string $text): string
    {
        $paragraphs = explode("\n\n", trim($text));
        $htmlParts = [];

        foreach ($paragraphs as $para) {
            $para = trim($para);
            if (empty($para)) continue;

            if (str_starts_with($para, '- ') || str_starts_with($para, '* ')) {
                $lines = explode("\n", $para);
                $listHtml = "<ul class='list-disc list-inside space-y-1 text-slate-700 pl-1'>";
                foreach ($lines as $line) {
                    $line = preg_replace('/^[\-\*]\s+/', '', trim($line));
                    if (!empty($line)) {
                        $listHtml .= "<li>" . $this->inlineMarkdown($line) . "</li>";
                    }
                }
                $listHtml .= "</ul>";
                $htmlParts[] = $listHtml;
            } else {
                $htmlParts[] = "<p class='text-slate-700 leading-relaxed'>" . $this->inlineMarkdown($para) . "</p>";
            }
        }

        return "<div class='space-y-2 text-xs'>" . implode("", $htmlParts) . "</div>";
    }

    /**
     * Format markdown inline: bold, italic, code
     */
    protected function inlineMarkdown(string $str): string
    {
        $str = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $str);
        $str = preg_replace('/(?<!\*)\*(?!\*)(.*?)(?<!\*)\*(?!\*)/', '<em>$1</em>', $str);
        $str = preg_replace('/\`(.*?)\`/', '<code class="px-1 py-0.5 rounded bg-slate-100 text-red-600 font-mono text-[11px]">$1</code>', $str);

        return $str;
    }
}
