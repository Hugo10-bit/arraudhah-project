<!-- ===== FLOATING FAQ CHATBOT WIDGET ===== -->
<!-- Yayasan Cahaya Amanah Ar-Raudhah -->
<div id="faq-chatbot-widget" class="fixed bottom-5 right-5 z-50 font-sans select-none no-print">

    <!-- Chat Trigger Button -->
    <button id="chatbot-toggle-btn"
            onclick="toggleChatbot()"
            class="group relative flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#1e3a8a] hover:bg-[#16285a] text-white shadow-xl hover:scale-105 active:scale-95 transition-all duration-300 focus:outline-none ring-4 ring-[#1e3a8a]/20 cursor-pointer"
            aria-label="Buka FAQ Chatbot">
        <!-- Notification Badge -->
        <span class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="relative inline-flex rounded-full h-4 w-4 bg-amber-500 text-[9px] font-bold text-white items-center justify-center shadow-xs">1</span>
        </span>

        <!-- Icons -->
        <i class="fa-solid fa-comments text-2xl transition-transform duration-300 group-hover:rotate-6" id="chat-icon-open"></i>
        <i class="fa-solid fa-xmark text-2xl hidden" id="chat-icon-close"></i>

        <!-- Floating Tooltip Label (Desktop) -->
        <div class="hidden lg:flex absolute right-20 bg-slate-900/90 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Tanya Asisten Ar-Raudhah</span>
        </div>
    </button>

    <!-- Chatbot Window Panel -->
    <div id="chatbot-window"
         class="hidden fixed sm:absolute bottom-20 right-0 left-4 sm:left-auto w-auto sm:w-96 max-w-[92vw] h-[580px] max-h-[84vh] bg-white rounded-3xl shadow-2xl border border-slate-200/90 flex-col overflow-hidden transition-all duration-300 transform origin-bottom-right z-50">

        <!-- Chat Header -->
        <div class="bg-[#081026] p-4 text-white flex items-center justify-between border-b border-[#16285a] shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-amber-300 text-lg shadow-inner">
                    <i class="fa-solid fa-headset"></i>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-[#081026]"></span>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold tracking-tight leading-tight flex items-center gap-1.5">
                        Asisten Ar-Raudhah
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-blue-700 font-bold uppercase tracking-wider">Layanan Resmi</span>
                    </h3>
                    <p class="text-[10px] text-slate-300 font-medium leading-tight mt-0.5">
                        Yayasan Cahaya Amanah Ar-Raudhah
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button onclick="resetChat()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center text-xs transition" title="Mulai Ulang Percakapan">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button onclick="toggleChatbot()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center text-xs transition" title="Tutup Chat">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Institutional Mini Bar -->
        <div class="bg-slate-950 px-3.5 py-1.5 text-[11px] text-slate-400 flex items-center justify-between border-b border-slate-800">
            <span class="flex items-center gap-1.5 text-[10px] text-slate-400">
                <i class="fa-solid fa-mosque text-emerald-400 text-[10px]"></i> Layanan Informasi Resmi Ar-Raudhah
            </span>
            <span class="text-[9px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full font-bold flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online
            </span>
        </div>

        <!-- Chat Messages Container -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs sm:text-sm select-text">

            <!-- Bot Welcome Bubble -->
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-xl bg-[#1e3a8a] text-white flex items-center justify-center text-xs shrink-0 mt-1 shadow-xs">
                    <i class="fa-solid fa-headset text-amber-300"></i>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-xs p-3.5 text-slate-800 shadow-xs max-w-[88%] space-y-2 leading-relaxed">
                    <p class="font-bold text-slate-900 text-xs">
                        Assalamu'alaikum! 👋
                    </p>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        Saya Asisten Layanan Informasi <strong>Yayasan Cahaya Amanah Ar-Raudhah</strong> siap membantu Anda mencari data santri, nilai ujian, membaca Al-Qur'an 114 surah, jadwal sholat, perhitungan nilai, dan hukum tajwid.
                    </p>
                </div>
            </div>

            <!-- Suggestion Chips Container -->
            <div id="chat-suggestions" class="space-y-1.5 pt-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Pertanyaan Cepat:</p>
                <div class="flex flex-wrap gap-1.5">
                    <button type="button" onclick="askQuestion('Apa saja informasi tentang sistem ini?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        ℹ️ Informasi Sistem
                    </button>
                    <button type="button" onclick="askQuestion('Berapa jumlah santri saat ini?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        📊 Total Santri
                    </button>
                    <button type="button" onclick="askQuestion('Siapa santri dengan nilai tertinggi?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-amber-600 hover:text-amber-800 hover:bg-amber-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        🏆 Santri Terbaik
                    </button>
                    <button type="button" onclick="askQuestion('Surat Al-Fatihah')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        📖 Surah Al-Fatihah
                    </button>
                    <button type="button" onclick="askQuestion('Ayat Kursi')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-amber-600 hover:text-amber-800 hover:bg-amber-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        ✨ Ayat Kursi
                    </button>
                    <button type="button" onclick="askQuestion('Jadwal sholat hari ini')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        🕌 Jadwal Sholat
                    </button>
                    <button type="button" onclick="askQuestion('Apa saja 9 mata uji penilaian?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        📖 9 Mata Uji
                    </button>
                    <button type="button" onclick="askQuestion('Hitung 25% dari 500000')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        🧮 25% dari 500rb
                    </button>
                </div>
            </div>

            <!-- Typing indicator (hidden by default) -->
            <div id="typing-indicator" class="hidden flex items-center gap-2 text-slate-400 text-xs px-2 py-1">
                <div class="w-6 h-6 rounded-lg bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 shrink-0">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div class="flex gap-1.5 items-center bg-white border border-slate-200 px-3 py-2 rounded-2xl shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.2s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.4s;"></span>
                    <span class="text-[10px] text-slate-400 ml-1 font-medium">Asisten sedang berpikir...</span>
                </div>
            </div>

        </div>

        <!-- Voice Status Banner (when listening) -->
        <div id="voice-status-banner" class="hidden bg-blue-600 text-white px-3 py-1.5 text-[11px] flex items-center justify-between animate-pulse">
            <span class="flex items-center gap-1.5 font-bold">
                <i class="fa-solid fa-microphone"></i> Mendengarkan suara Anda... Silakan berbicara
            </span>
            <button type="button" onclick="stopVoiceRecognition()" class="text-white hover:text-blue-200">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Chat Input Form -->
        <div class="p-3 bg-white border-t border-slate-200/90 shrink-0">
            <form id="chatbot-form" onsubmit="handleChatSubmit(event)" class="flex items-center gap-1.5">
                <input type="text"
                       id="chatbot-input"
                       placeholder="Tanya apa saja (santri, nilai, quran, sholat, hitung)..."
                       autocomplete="off"
                       class="flex-1 px-3.5 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
                
                <!-- Voice Input Button (Mic) -->
                <button type="button"
                        id="voice-input-btn"
                        onclick="toggleVoiceInput()"
                        class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-blue-600 flex items-center justify-center transition cursor-pointer shrink-0 border border-slate-200"
                        title="Bicara dengan Suara (Voice Input)">
                    <i class="fa-solid fa-microphone text-xs" id="voice-mic-icon"></i>
                </button>

                <!-- Send Button -->
                <button type="submit"
                        id="chatbot-send-btn"
                        class="w-10 h-10 rounded-2xl bg-[#1e3a8a] hover:bg-[#16285a] text-white flex items-center justify-center shadow-md hover:scale-105 active:scale-95 transition cursor-pointer shrink-0"
                        title="Kirim Pesan">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
            <div class="text-center mt-1.5 flex items-center justify-between px-1">
                <span class="text-[9px] text-slate-400">
                    <strong class="text-slate-600">Yayasan Cahaya Amanah Ar-Raudhah</strong>
                </span>
                <span class="text-[9px] text-slate-400">
                    Bisa tanya nama santri, surah, &amp; sholat
                </span>
            </div>
        </div>

    </div>
</div>

<script>
    const CHATBOT_ENDPOINT = "{{ route('chatbot.ask') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    // Speech Recognition & Speech Synthesis Setup
    let speechRecognition = null;
    let isRecognizing = false;

    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
        speechRecognition = new SpeechRec();
        speechRecognition.lang = 'id-ID';
        speechRecognition.interimResults = false;
        speechRecognition.maxAlternatives = 1;

        speechRecognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            document.getElementById('chatbot-input').value = transcript;
            stopVoiceRecognition();
            askQuestion(transcript);
        };

        speechRecognition.onerror = function(event) {
            console.warn('Speech recognition error:', event.error);
            stopVoiceRecognition();
        };

        speechRecognition.onend = function() {
            stopVoiceRecognition();
        };
    }

    function toggleVoiceInput() {
        if (!speechRecognition) {
            alert('Browser Anda belum mendukung input suara. Silakan gunakan Google Chrome, Microsoft Edge, atau Safari terbaru.');
            return;
        }

        if (isRecognizing) {
            stopVoiceRecognition();
        } else {
            startVoiceRecognition();
        }
    }

    function startVoiceRecognition() {
        if (!speechRecognition) return;
        try {
            speechRecognition.start();
            isRecognizing = true;
            document.getElementById('voice-status-banner').classList.remove('hidden');
            const btn = document.getElementById('voice-input-btn');
            btn.classList.add('bg-blue-600', 'text-white', 'animate-pulse');
            btn.classList.remove('bg-slate-100', 'text-slate-600');
        } catch (e) {
            console.warn(e);
        }
    }

    function stopVoiceRecognition() {
        if (!speechRecognition) return;
        try {
            speechRecognition.stop();
        } catch (e) {}
        isRecognizing = false;
        document.getElementById('voice-status-banner').classList.add('hidden');
        const btn = document.getElementById('voice-input-btn');
        btn.classList.remove('bg-blue-600', 'text-white', 'animate-pulse');
        btn.classList.add('bg-slate-100', 'text-slate-600');
    }

    // Text to Speech (Baca Suara Jawaban)
    function speakText(btn) {
        if (!('speechSynthesis' in window)) {
            alert('Browser Anda belum mendukung pembacaan suara (Text-to-Speech).');
            return;
        }

        window.speechSynthesis.cancel(); // Hentikan suara sebelumnya jika ada

        const container = btn.closest('.bot-bubble-content');
        if (!container) return;

        // Ambil teks bersih
        const clone = container.cloneNode(true);
        // Hapus audio player & tombol aksi dari pembacaan
        clone.querySelectorAll('audio, button, .no-read').forEach(el => el.remove());
        let textToRead = clone.innerText || clone.textContent;
        textToRead = textToRead.replace(/[^\w\s\.\,\?\!\-]/gi, ' ').trim();

        if (!textToRead) return;

        const utterance = new SpeechSynthesisUtterance(textToRead);
        utterance.lang = 'id-ID';
        utterance.rate = 1.0;
        utterance.pitch = 1.0;

        btn.innerHTML = '<i class="fa-solid fa-volume-high text-blue-600 animate-pulse"></i>';
        utterance.onend = function() {
            btn.innerHTML = '<i class="fa-solid fa-volume-low"></i>';
        };
        utterance.onerror = function() {
            btn.innerHTML = '<i class="fa-solid fa-volume-low"></i>';
        };

        window.speechSynthesis.speak(utterance);
    }

    // Salin Teks Jawaban
    function copyChatText(btn) {
        const container = btn.closest('.bot-bubble-content');
        if (!container) return;

        const clone = container.cloneNode(true);
        clone.querySelectorAll('audio, button, .no-read').forEach(el => el.remove());
        const text = clone.innerText || clone.textContent;

        navigator.clipboard.writeText(text.trim()).then(() => {
            const oldHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i>';
            setTimeout(() => btn.innerHTML = oldHtml, 1500);
        });
    }

    // FAQ Knowledge Base (Local Offline Fallback)
    const FAQ_KNOWLEDGE = [
        {
            keywords: ['sistem', 'aplikasi', 'yayasan', 'ar-raudhah', 'informasi', 'tentang', 'pengelola', 'pengembang'],
            answer: `
                <div class="space-y-2">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-black text-slate-900 text-xs sm:text-sm flex items-center gap-1.5">
                            🏛️ <span>Sistem Manajemen Database &amp; Penilaian Munaqasyah</span>
                        </p>
                        <p class="text-[11px] text-blue-700 font-semibold mt-0.5">Yayasan Cahaya Amanah Ar-Raudhah</p>
                    </div>
                    <p class="text-slate-700 leading-relaxed text-xs">
                        Sistem ini dikelola secara resmi untuk digitalisasi proses penilaian, munaqasyah, dan penerbitan kelulusan santri di <strong>Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru</strong>.
                    </p>
                    <div class="text-[11px] text-slate-600 space-y-1">
                        <p>✨ <strong>Fitur Utama:</strong></p>
                        <ul class="list-disc list-inside space-y-0.5 text-slate-500 pl-1">
                            <li>Kalkulasi Otomatis 9 Mata Uji Standar Munaqasyah</li>
                            <li>Cetak Surat Kelulusan Resmi &amp; Cek Kelulusan Mandiri</li>
                            <li>Chatbot AI Interaktif &amp; Al-Qur'an Digital</li>
                        </ul>
                    </div>
                </div>
            `
        },
        {
            keywords: ['9', 'mata uji', 'indikator', 'komponen', 'aspek', 'ujian', 'fashohah', 'tajwid', 'gharib'],
            answer: `
                <div class="space-y-1.5">
                    <p class="font-bold text-slate-900">📖 9 Mata Uji Standar Database Sekolah:</p>
                    <ol class="list-decimal list-inside space-y-1 text-slate-700 pl-1 text-xs">
                        <li><strong>Fashohah</strong>: Kelancaran membaca Al-Qur'an</li>
                        <li><strong>Tajwid</strong>: Ketepatan hukum tajwid</li>
                        <li><strong>Gharib &amp; Musykilat</strong>: Ayat-ayat asing &amp; khusus</li>
                        <li><strong>Suara &amp; Lagu</strong>: Irama tartil santri</li>
                        <li><strong>Ayat Pilihan</strong>: Ujian tilawah acak</li>
                        <li><strong>Surah Pendek</strong>: Hafalan Juz 'Amma (Juz 30)</li>
                        <li><strong>Doa Harian</strong>: Doa-doa harian praktis</li>
                        <li><strong>Bacaan Shalat</strong>: Doa &amp; gerakan sholat</li>
                        <li><strong>Ujian Tertulis</strong>: Dinul Islam &amp; tajwid teori</li>
                    </ol>
                    <p class="text-[11px] text-slate-500 pt-1">Seluruh nilai dihitung otomatis secara akurat oleh sistem.</p>
                </div>
            `
        },
        {
            keywords: ['syarat', 'kelulusan', 'lulus', 'tidak lulus', 'nilai minimum', 'standar', 'kkm', 'predikat'],
            answer: `
                <div class="space-y-1.5">
                    <p class="font-bold text-slate-900">🎓 Standar Kelulusan Santri:</p>
                    <p class="text-slate-700 leading-relaxed text-xs">
                        Santri dinyatakan <strong>LULUS</strong> jika memenuhi seluruh kriteria kelayakan pada 9 mata uji dengan predikat:
                    </p>
                    <ul class="space-y-1 text-slate-700 pl-1 text-[11px]">
                        <li>🌟 <strong>Mumtaz (Istimewa)</strong>: Rata-rata 90 – 100</li>
                        <li>👍 <strong>Jayyid Jiddan (Sangat Baik)</strong>: Rata-rata 80 – 89</li>
                        <li>👌 <strong>Jayyid (Baik)</strong>: Rata-rata 70 – 79</li>
                        <li>📑 <strong>Maqbul (Cukup)</strong>: Rata-rata 60 – 69</li>
                        <li>⚠️ <strong>Rasib (Perbaikan)</strong>: Rata-rata &lt; 60</li>
                    </ul>
                </div>
            `
        },
        {
            keywords: ['cetak', 'surat', 'kelulusan', 'sertifikat', 'ijazah', 'rapor', 'print', 'pdf'],
            answer: `
                <div class="space-y-1.5 text-xs">
                    <p class="font-bold text-slate-900">🖨️ Cara Cetak Surat Kelulusan:</p>
                    <ol class="list-decimal list-inside space-y-1 text-slate-700 pl-1">
                        <li>Buka menu <strong>TPQ</strong> atau <strong>RTQ</strong> di sidebar dashboard.</li>
                        <li>Cari nama santri, klik tombol <strong>"Surat Kelulusan"</strong>.</li>
                        <li>Halaman surat kelulusan berkop resmi Yayasan akan terbuka.</li>
                        <li>Klik tombol <strong>"Cetak Surat"</strong> di pojok kanan atas (langsung print atau simpan PDF).</li>
                    </ol>
                </div>
            `
        }
    ];

    // Toggle Chat Window
    function toggleChatbot() {
        const win = document.getElementById('chatbot-window');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');

        if (win.classList.contains('hidden')) {
            win.classList.remove('hidden');
            win.classList.add('flex');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            setTimeout(() => document.getElementById('chatbot-input').focus(), 150);
            scrollChatBottom();
        } else {
            win.classList.add('hidden');
            win.classList.remove('flex');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
            stopVoiceRecognition();
        }
    }

    // Scroll to bottom
    function scrollChatBottom() {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    }

    // Handle Form Submit
    function handleChatSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('chatbot-input');
        const text = input.value.trim();
        if (!text) return;

        askQuestion(text);
        input.value = '';
    }

    // Ask Question function (Asynchronous with Backend & Fallback)
    async function askQuestion(query) {
        const messages = document.getElementById('chat-messages');
        const typing = document.getElementById('typing-indicator');

        // Add user bubble
        const userHtml = `
            <div class="flex items-start justify-end gap-2.5">
                <div class="bg-[#1e3a8a] text-white rounded-2xl rounded-tr-xs p-3 shadow-xs max-w-[85%] font-medium leading-relaxed text-xs sm:text-sm">
                    ${escapeHtml(query)}
                </div>
            </div>
        `;
        messages.insertAdjacentHTML('beforeend', userHtml);
        scrollChatBottom();

        // Show typing indicator
        typing.classList.remove('hidden');
        scrollChatBottom();

        let botAnswer = '';
        let sourceBadge = '';

        try {
            // Panggil API Backend Chatbot
            const response = await fetch(CHATBOT_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'ngrok-skip-browser-warning': '1'
                },
                body: JSON.stringify({ message: query })
            });

            if (response.ok) {
                const data = await response.json();
                botAnswer = data.reply;
                
                // Beri label badge sumber
                if (data.source === 'santri_db') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-bold ml-1.5"><i class="fa-solid fa-id-card mr-1"></i>Profil Santri</span>';
                } else if (data.source === 'quran_api') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold ml-1.5"><i class="fa-solid fa-book-quran mr-1"></i>Al-Qur\'anul Karim</span>';
                } else if (data.source === 'prayer_worship') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-bold ml-1.5"><i class="fa-solid fa-mosque mr-1"></i>Jadwal Sholat &amp; Doa</span>';
                } else if (data.source === 'database') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-bold ml-1.5"><i class="fa-solid fa-database mr-1"></i>Data Realtime</span>';
                } else if (data.source === 'calculator') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold ml-1.5"><i class="fa-solid fa-calculator mr-1"></i>Kalkulator</span>';
                } else if (data.source === 'wikipedia') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-800 font-bold ml-1.5"><i class="fa-solid fa-book mr-1"></i>Ensiklopedia</span>';
                } else if (data.source === 'generative_ai') {
                    sourceBadge = '<span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-800 font-bold ml-1.5"><i class="fa-solid fa-circle-info mr-1"></i>Layanan Resmi</span>';
                }
            } else {
                botAnswer = findOfflineAnswer(query);
            }
        } catch (err) {
            console.warn('Chatbot API fetch error, fallback to offline KB:', err);
            botAnswer = findOfflineAnswer(query);
        } finally {
            typing.classList.add('hidden');

            const botHtml = `
                <div class="flex items-start gap-2.5">
                    <div class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs shrink-0 mt-1 shadow-xs">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-xs p-3.5 text-slate-800 shadow-xs max-w-[88%] space-y-2 leading-relaxed text-xs sm:text-sm bot-bubble-content relative group">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-1.5 mb-1 no-read">
                            <div>${sourceBadge}</div>
                            <div class="flex items-center gap-1 opacity-80 hover:opacity-100 transition">
                                <button type="button" onclick="speakText(this)" class="p-1 rounded hover:bg-slate-100 text-slate-500 hover:text-slate-900" title="Dengarkan Suara (Text-to-Speech)">
                                    <i class="fa-solid fa-volume-low text-[11px]"></i>
                                </button>
                                <button type="button" onclick="copyChatText(this)" class="p-1 rounded hover:bg-slate-100 text-slate-500 hover:text-slate-900" title="Salin Pesan">
                                    <i class="fa-regular fa-copy text-[11px]"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            ${botAnswer}
                        </div>
                    </div>
                </div>
            `;
            messages.insertAdjacentHTML('beforeend', botHtml);
            scrollChatBottom();
        }
    }

    // Offline Matcher Fallback
    function findOfflineAnswer(query) {
        const q = query.toLowerCase();

        for (const item of FAQ_KNOWLEDGE) {
            for (const key of item.keywords) {
                if (q.includes(key)) {
                    return item.answer;
                }
            }
        }

        return `
            <div class="space-y-2 text-xs">
                <p class="font-bold text-slate-800">Terima kasih atas pertanyaannya! 😊</p>
                <p class="text-slate-600 leading-relaxed">
                    Saya dapat membantu Anda menjawab segala pertanyaan terkait:
                </p>
                <ul class="list-disc list-inside space-y-1 text-slate-600 text-[11px] pl-1">
                    <li><strong>Cari Data Santri</strong> (contoh: <em>"cari santri Ahmad"</em>)</li>
                    <li><strong>Al-Qur'an 114 Surah</strong> (contoh: <em>"surah al fatihah"</em>, <em>"ayat kursi"</em>)</li>
                    <li><strong>Jadwal Sholat &amp; Doa Harian</strong></li>
                    <li><strong>Informasi Sistem</strong> (Fitur &amp; Penggunaan)</li>
                    <li><strong>9 Mata Uji Database Sekolah &amp; Syarat Kelulusan</strong></li>
                </ul>
            </div>
        `;
    }

    // Reset Chat
    function resetChat() {
        const messages = document.getElementById('chat-messages');
        messages.innerHTML = `
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs shrink-0 mt-1 shadow-xs">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-xs p-3.5 text-slate-800 shadow-xs max-w-[85%] space-y-2 leading-relaxed text-xs sm:text-sm">
                    <p class="font-bold text-slate-900">
                        Percakapan telah dimulai ulang. 👋
                    </p>
                    <p class="text-slate-600 leading-relaxed">
                        Saya adalah Asisten Virtual Resmi <strong>Yayasan Cahaya Amanah Ar-Raudhah</strong>.
                    </p>
                    <p class="text-slate-600">
                        Silakan tanyakan apa saja yang ingin Anda ketahui seputar santri, munaqasyah, atau Al-Qur'an!
                    </p>
                </div>
            </div>

            <div id="chat-suggestions" class="space-y-1.5 pt-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Pertanyaan Cepat:</p>
                <div class="flex flex-wrap gap-1.5">
                    <button type="button" onclick="askQuestion('Apa saja informasi tentang sistem ini?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        ℹ️ Informasi Sistem
                    </button>
                    <button type="button" onclick="askQuestion('Berapa jumlah santri saat ini?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        📊 Total Santri
                    </button>
                    <button type="button" onclick="askQuestion('Siapa santri dengan nilai tertinggi?')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-amber-600 hover:text-amber-800 hover:bg-amber-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        🏆 Santri Terbaik
                    </button>
                    <button type="button" onclick="askQuestion('Surat Al-Fatihah')" class="suggestion-chip px-2.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#1e3a8a] hover:text-[#1e3a8a] hover:bg-blue-50/60 text-slate-700 text-[11px] font-semibold transition text-left shadow-2xs">
                        📖 Surah Al-Fatihah
                    </button>
                </div>
            </div>

            <div id="typing-indicator" class="hidden flex items-center gap-2 text-slate-400 text-xs px-2 py-1">
                <div class="w-6 h-6 rounded-lg bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 shrink-0">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div class="flex gap-1.5 items-center bg-white border border-slate-200 px-3 py-2 rounded-2xl shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.2s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.4s;"></span>
                    <span class="text-[10px] text-slate-400 ml-1 font-medium">Asisten sedang berpikir...</span>
                </div>
            </div>
        `;
    }

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
</script>
