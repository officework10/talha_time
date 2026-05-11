document.addEventListener("DOMContentLoaded", function () {
    const openModalButtons = document.querySelectorAll(".open-modal");
    const closeModalButton = document.querySelector(".close-modal");
    const searchModal = document.getElementById("searchModal");
    const searchInput = document.getElementById("searchInput");
    // Open modal
    openModalButtons.forEach((button) => {
        button.addEventListener("click", function () {
            searchModal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
            setTimeout(() => {
                searchInput?.focus();
            }, 200);
        });
    });
    // Close modal + trigger Livewire reset
    function closeModal() {
        if (searchModal) {
            searchModal.classList.add("hidden");
            document.body.style.overflow = "";
        }
        if (window.Livewire) {
            Livewire.dispatch("closeSearchModal");
        }
    }
    if (closeModalButton) {
        closeModalButton.addEventListener("click", closeModal);
    }
    // Close on outside click
    if (searchModal) {
        searchModal.addEventListener("click", function (e) {
            if (e.target === searchModal) {
                closeModal();
            }
        });
    }
    // Close on ESC
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && searchModal && !searchModal.classList.contains("hidden")) {
            closeModal();
        }
    });
});
// show_calculator
function show_calculator(button) {
    const value = button.value;
    if (value === "scientific") {
        $("#scientific_calculator").hide();
        $("#simple_calculator").show();
        $("#left_calulator").show();
    } else if (value === "simple") {
        $("#scientific_calculator").show();
        $("#simple_calculator").hide();
        $("#left_calulator").hide();
    }
}
// downloadPDF
async function downloadPDF() {
    const resultElementDiv = document.querySelector(".result");
    if (!resultElementDiv) return alert("No result to export.");

    const HTMLWidthDiv = resultElementDiv.offsetWidth;
    const HTMLHeightDiv = resultElementDiv.offsetHeight;

    const TopLeftMarginDiv = 10;
    const PDFWidthDiv = HTMLWidthDiv + TopLeftMarginDiv * 2;
    const PDFHeightDiv = PDFWidthDiv * 1.5 + TopLeftMarginDiv * 2;

    const canvasImageWidthDiv = HTMLWidthDiv;
    const canvasImageHeight = HTMLHeightDiv;

    const totalPDFPages = Math.ceil(HTMLHeightDiv / PDFHeightDiv);

    const canvas = await html2canvas(resultElementDiv, {
        allowTaint: true,
        useCORS: true,
        scale: 2,
        backgroundColor: "#ffffff",
    });

    const imgData = canvas.toDataURL("image/jpeg", 1.0);

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF("p", "pt", [PDFWidthDiv, PDFHeightDiv]);

    pdf.addImage(
        imgData,
        "JPG",
        TopLeftMarginDiv,
        TopLeftMarginDiv,
        canvasImageWidthDiv,
        canvasImageHeight
    );

    for (let i = 1; i < totalPDFPages; i++) {
        pdf.addPage([PDFWidthDiv, PDFHeightDiv]);
        pdf.addImage(
            imgData,
            "JPG",
            TopLeftMarginDiv,
            -(PDFHeightDiv * i) + TopLeftMarginDiv * 4,
            canvasImageWidthDiv,
            canvasImageHeight
        );
    }

    pdf.save("result.pdf");
}
function copyResult() {
    const result = document.querySelector(".result");
    if (result) {
        navigator.clipboard
            .writeText(result.innerText)
            .then(() => showToast("✅ Result copied!", "bg-green-600"))
            .catch(() => showToast("❌ Failed to copy", "bg-red-600"));
    }
}
function printResult() {
    const resultElement = document.querySelector(".result");
    if (!resultElement) {
        showToast("❌ No result section found", "bg-red-600");
        return;
    }

    // Create a hidden iframe
    const iframe = document.createElement("iframe");
    iframe.style.position = "fixed";
    iframe.style.right = "0";
    iframe.style.bottom = "0";
    iframe.style.width = "0";
    iframe.style.height = "0";
    iframe.style.border = "0";
    document.body.appendChild(iframe);

    const doc = iframe.contentWindow.document;

    // Clone styles
    const stylesheets = Array.from(
        document.querySelectorAll('link[rel="stylesheet"]')
    )
        .map((link) => `<link rel="stylesheet" href="${link.href}">`)
        .join("");

    doc.open();
    doc.write(`
            <html>
            <head>
                <title>Print Result</title>
                ${stylesheets}
                <style>
                    body {
                        font-family: 'Segoe UI', sans-serif;
                        padding: 20px;
                        background: #fff;
                        color: #000;
                    }
                </style>
            </head>
            <body>
                ${resultElement.innerHTML}
            </body>
            </html>
        `);
    doc.close();

    iframe.onload = function () {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();

        // Remove iframe after printing
        setTimeout(() => {
            document.body.removeChild(iframe);
            showToast("🖨️ Print completed", "bg-green-600");
        }, 1000);
    };
}

function showToast(message, bgColor = "bg-black") {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.className = `fixed top-5 right-5 z-50 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300 text-sm ${bgColor}`;
    toast.style.opacity = 1;

    setTimeout(() => {
        toast.style.opacity = 0;
    }, 3000);
}
// calculator modal feedback
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("default-modalfeed");
    const openBtn = document.querySelector(".open-feedback-btn"); // class for the trigger button
    if (modal && openBtn) {
        const closeBtn = modal.querySelector(
            '[data-modal-hide="default-modalfeed"]'
        );
        // Show modal
        openBtn.addEventListener("click", () => {
            modal.classList.remove("hidden");
        });
        // Hide modal
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });
        }
        // Hide modal when clicking outside content
        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    }
});

const button = document.getElementById("scrollToTopBtn");
const SCROLL_THRESHOLD = 300; // Scroll position in pixels
const FIXED_TOP = "top-[15px]"; // Top position when fixed
const FIXED_RIGHT = "right-[15px]"; // Right position when fixed
const MOBILE_BREAKPOINT = 768; // Mobile screen max width in pixels

window.addEventListener("scroll", () => {
    // Only apply fixed positioning on larger screens
    if (button && window.innerWidth > MOBILE_BREAKPOINT) {
        if (window.scrollY > SCROLL_THRESHOLD) {
            button.classList.add(
                "fixed",
                FIXED_TOP,
                FIXED_RIGHT,
                "bottom-auto"
            );
            button.classList.remove("relative");
        } else {
            button.classList.remove(
                "fixed",
                FIXED_TOP,
                FIXED_RIGHT,
                "bottom-auto"
            );
            button.classList.add("relative");
        }
    } else if (button) {
        // Ensure mobile screens always have default styles
        button.classList.remove("fixed", FIXED_TOP, FIXED_RIGHT, "bottom-auto");
        button.classList.add("relative");
    }
});

// Scroll top to bottom
document.addEventListener("DOMContentLoaded", () => {
    const scrollToTopmove = document.getElementById("scrollToTopmove");
    if (scrollToTopmove) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 600) {
                scrollToTopmove.style.display = "block";
            } else {
                scrollToTopmove.style.display = "none";
            }
        });
        scrollToTopmove.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }
});

// Custom Sidebar Toggle Fix
document.addEventListener("DOMContentLoaded", function () {
    const drawer = document.getElementById("drawer-navigation");
    const toggleBtns = document.querySelectorAll('[data-drawer-toggle="drawer-navigation"]');
    const closeBtns = document.querySelectorAll('[data-drawer-hide="drawer-navigation"]');

    if (drawer) {
        toggleBtns.forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                drawer.classList.remove("-translate-x-full");

                // Add backdrop
                if (!document.querySelector('.drawer-backdrop')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'drawer-backdrop fixed inset-0 z-[99998] bg-gray-900/50 dark:bg-gray-900/80 transition-opacity';
                    document.body.appendChild(backdrop);

                    backdrop.addEventListener('click', () => {
                        drawer.classList.add("-translate-x-full");
                        backdrop.remove();
                    });
                }
            });
        });

        closeBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                drawer.classList.add("-translate-x-full");
                document.querySelector('.drawer-backdrop')?.remove();
            });
        });
    }
});
