document.addEventListener("DOMContentLoaded", function () {
    // --- Sticky Navbar ---
    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });

    // --- Mobile Menu Toggle ---
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    mobileMenuButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    // --- Animate on Scroll (Fade In Up) ---
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        },
        { threshold: 0.1 }
    );

    document.querySelectorAll(".fade-in-up").forEach((el) => {
        observer.observe(el);
    });

    // --- News Carousel ---
    const carouselInner = document.getElementById("carousel-inner");
    const prevBtn = document.getElementById("prev-btn");
    const nextBtn = document.getElementById("next-btn");
    let currentIndex = 0;
    let itemsPerView = 3;

    function updateItemsPerView() {
        if (window.innerWidth < 768) itemsPerView = 1;
        else if (window.innerWidth < 1024) itemsPerView = 2;
        else itemsPerView = 3;
    }
    updateItemsPerView();
    window.addEventListener("resize", updateItemsPerView);

    const totalItems = carouselInner.children.length;

    function updateCarousel() {
        const itemWidth =
            carouselInner.children[0].getBoundingClientRect().width;
        carouselInner.style.transform = `translateX(-${
            currentIndex * itemWidth
        }px)`;
    }

    nextBtn.addEventListener("click", () => {
        if (currentIndex < totalItems - itemsPerView) {
            currentIndex++;
            updateCarousel();
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    setInterval(() => {
        if (currentIndex < totalItems - itemsPerView) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }, 7000);

    // --- Count-up Animation ---
    function animateCountUp(el) {
        const target = +el.getAttribute("data-target");
        let count = 0;
        const duration = 2000; // 2 seconds

        const step = (timestamp) => {
            if (!start) start = timestamp;
            const progress = Math.min((timestamp - start) / duration, 1);
            el.innerText = Math.floor(progress * target).toLocaleString(
                "id-ID"
            );
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        let start;
        window.requestAnimationFrame(step);
    }

    const countUpObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    document
                        .querySelectorAll("[data-target]")
                        .forEach(animateCountUp);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.5 }
    );

    if (document.getElementById("data-penduduk")) {
        countUpObserver.observe(document.getElementById("data-penduduk"));
    }

    // --- Chart.js ---
    const chartObserver = new IntersectionObserver(
        (entries, observer) => {
            if (entries[0].isIntersecting) {
                // Gender Chart
                new Chart(document.getElementById("genderChart"), {
                    type: "pie",
                    data: {
                        labels: ["Laki-laki", "Perempuan"],
                        datasets: [
                            {
                                data: [4420, 4330],
                                backgroundColor: ["#3B82F6", "#EC4899"],
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { position: "bottom" } },
                    },
                });

                // Age Chart
                new Chart(document.getElementById("ageChart"), {
                    type: "bar",
                    data: {
                        labels: ["0-17", "18-55", ">55"],
                        datasets: [
                            {
                                label: "Jumlah Penduduk",
                                data: [2500, 5150, 1100],
                                backgroundColor: [
                                    "#10B981",
                                    "#F59E0B",
                                    "#6366F1",
                                ],
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } },
                    },
                });
                observer.unobserve(entries[0].target);
            }
        },
        { threshold: 0.5 }
    );

    if (document.getElementById("data-penduduk")) {
        chartObserver.observe(document.getElementById("data-penduduk"));
    }

    // --- Footer Year ---
    document.getElementById("year").textContent = new Date().getFullYear();

    // --- Gemini API Integration ---

    const callGeminiAPI = async (userPrompt, systemInstruction) => {
        const apiKey = "AIzaSyC3YaUmxG_eGFX2SRzk_-sV5ZI00jnUO8A"; // API Key will be provided by the environment
        const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=${apiKey}`;

        const payload = {
            contents: [{ parts: [{ text: userPrompt }] }],
            systemInstruction: {
                parts: [{ text: systemInstruction }],
            },
        };

        let response;
        let retries = 3;
        let delay = 1000;

        while (retries > 0) {
            try {
                response = await fetch(apiUrl, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });

                if (response.ok) {
                    const result = await response.json();
                    const candidate = result.candidates?.[0];
                    if (candidate && candidate.content?.parts?.[0]?.text) {
                        return candidate.content.parts[0].text;
                    } else {
                        console.error("No content in response:", result);
                        return "Maaf, saya tidak dapat memberikan jawaban saat ini.";
                    }
                } else if (response.status === 429) {
                    console.warn(
                        `API call throttled. Retrying in ${delay / 1000}s...`
                    );
                    await new Promise((res) => setTimeout(res, delay));
                    delay *= 2;
                    retries--;
                } else {
                    throw new Error(
                        `API call failed with status: ${response.status}`
                    );
                }
            } catch (error) {
                console.error("Error calling Gemini API:", error);
                retries--;
                if (retries <= 0) {
                    return "Maaf, terjadi kesalahan saat menghubungi asisten. Silakan coba lagi nanti.";
                }
                await new Promise((res) => setTimeout(res, delay));
                delay *= 2;
            }
        }
        return "Maaf, layanan asisten sedang tidak tersedia saat ini.";
    };

    // --- AI Chatbot Logic ---
    const chatModal = document.getElementById("chat-modal");
    const chatOpenBtn = document.getElementById("chat-open-btn");
    const chatCloseBtn = document.getElementById("chat-close-btn");
    const chatMessages = document.getElementById("chat-messages");
    const chatInput = document.getElementById("chat-input");
    const chatSendBtn = document.getElementById("chat-send-btn");

    const addMessageToChat = (sender, message, isLoading = false) => {
        const messageWrapper = document.createElement("div");
        messageWrapper.className = `flex ${
            sender === "user" ? "justify-end" : "justify-start"
        }`;

        const messageBubble = document.createElement("div");
        messageBubble.className = `max-w-xs md:max-w-sm rounded-2xl px-4 py-2.5 ${
            sender === "user"
                ? "bg-blue-600 text-white rounded-br-lg"
                : "bg-gray-200 text-gray-800 rounded-bl-lg"
        }`;

        if (isLoading) {
            messageBubble.innerHTML = `<div class="gemini-thinking-bubble"><div class="loader"></div><span>Mengetik...</span></div>`;
            messageBubble.id = "loading-bubble";
        } else {
            messageBubble.innerText = message;
        }

        messageWrapper.appendChild(messageBubble);
        chatMessages.appendChild(messageWrapper);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    addMessageToChat(
        "bot",
        "Halo! Ada yang bisa saya bantu terkait layanan di Kelurahan Tipulu?"
    );

    chatOpenBtn.addEventListener("click", () => {
        chatModal.classList.remove("hidden");
        setTimeout(() => {
            chatModal.classList.remove("opacity-0", "translate-y-8");
        }, 10);
    });

    chatCloseBtn.addEventListener("click", () => {
        chatModal.classList.add("opacity-0", "translate-y-8");
        setTimeout(() => {
            chatModal.classList.add("hidden");
        }, 300);
    });

    const handleChatSend = async () => {
        const userInput = chatInput.value.trim();
        if (!userInput) return;

        addMessageToChat("user", userInput);
        chatInput.value = "";
        chatSendBtn.disabled = true;
        addMessageToChat("bot", "", true);

        const systemInstruction =
            "Anda adalah asisten virtual Kelurahan Tipulu yang ramah, profesional, dan sangat membantu. Gunakan Bahasa Indonesia yang baik dan sopan. Jawab pertanyaan warga seputar layanan (misal: cara membuat KTP, surat domisili), jam operasional kantor (Senin-Kamis 08:00-16:00, Jumat 08:00-11:00 WITA), persyaratan dokumen, dan informasi umum tentang Kelurahan Tipulu di Kota Kendari. Jaga agar jawaban tetap singkat, jelas, dan akurat. Jika tidak tahu jawabannya, sarankan pengguna untuk menghubungi kantor kelurahan secara langsung di (0401) 312XXXX.";
        const response = await callGeminiAPI(userInput, systemInstruction);

        const loadingBubble = document.getElementById("loading-bubble");
        if (loadingBubble) loadingBubble.parentElement.remove();

        addMessageToChat("bot", response);
        chatSendBtn.disabled = false;
        chatInput.focus();
    };

    chatSendBtn.addEventListener("click", handleChatSend);
    chatInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            handleChatSend();
        }
    });

    // --- Complaint Assistant Logic ---
    const geminiAssistBtn = document.getElementById("gemini-assist-btn");
    const complaintDetails = document.getElementById("complaint-details");
    const geminiStatus = document.getElementById("gemini-status");

    geminiAssistBtn.addEventListener("click", async () => {
        const userText = complaintDetails.value.trim();
        if (!userText) {
            geminiStatus.innerText =
                "Mohon isi detail pengaduan terlebih dahulu.";
            return;
        }

        geminiAssistBtn.disabled = true;
        geminiStatus.innerHTML =
            '<div class="flex justify-center items-center gap-2"><div class="loader"></div><span>Memproses tulisan Anda...</span></div>';

        const systemInstruction =
            "Anda adalah asisten penulis yang ahli dalam komunikasi formal. Tugas Anda adalah mengubah draf pengaduan dari warga menjadi sebuah laporan yang lebih terstruktur, jelas, sopan, dan profesional dalam Bahasa Indonesia. Pertahankan inti dari masalah yang disampaikan pengguna. Jangan menambahkan informasi yang tidak ada dalam draf asli.";
        const prompt = `Berikut adalah draf pengaduan dari seorang warga. Tolong perbaiki menjadi laporan yang baik:\n\n"${userText}"`;

        const refinedText = await callGeminiAPI(prompt, systemInstruction);

        complaintDetails.value = refinedText;
        geminiStatus.innerText = "Teks pengaduan Anda berhasil disempurnakan!";
        geminiAssistBtn.disabled = false;

        setTimeout(() => {
            geminiStatus.innerText = "";
        }, 4000);
    });
    
});
