console.log("FAQ carregando...");

import FaqService from "../../_common/scripts/services/FaqService.js";

const faqService = new FaqService();

async function fetchFAQS() {

    try {

        console.log("FAQ carregando...");

        const faqs = await faqService.list();

        console.log(faqs);

        const listFaqs = document.querySelector("#list-faqs");

        faqs.data.forEach(faq => {

            const faqItem = document.createElement("li");

            faqItem.className = "faq-item";

            faqItem.innerHTML = `
                <button
                    class="faq-question"
                    type="button"
                    aria-expanded="false"
                >
                    <span>${faq.question}</span>

                    <span class="faq-icon">+</span>
                </button>

                <p class="faq-answer">
                    ${faq.answer}
                </p>
            `;

            listFaqs.appendChild(faqItem);

            const button = faqItem.querySelector(".faq-question");

            button.addEventListener("click", () => {

                const isOpen = faqItem.classList.contains("active");

                document.querySelectorAll(".faq-item").forEach(item => {

                    item.classList.remove("active");

                    const otherButton =
                        item.querySelector(".faq-question");

                    if (otherButton) {
                        otherButton.setAttribute(
                            "aria-expanded",
                            "false"
                        );
                    }

                });

                if (!isOpen) {

                    faqItem.classList.add("active");

                    button.setAttribute(
                        "aria-expanded",
                        "true"
                    );

                }

            });

        });

    } catch (error) {

        console.error("Erro ao carregar as FAQs:", error);

    }

}

fetchFAQS();