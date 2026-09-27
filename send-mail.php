document.addEventListener("DOMContentLoaded", function () {


    /* ================= MOBILE MENU ================= */

    const menuToggle = document.getElementById("menuToggle");
    const navMenu = document.getElementById("navMenu");

    if (menuToggle && navMenu) {

        menuToggle.addEventListener("click", function () {

            const isOpen = navMenu.classList.toggle("open");

            menuToggle.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );

            menuToggle.setAttribute(
                "aria-label",
                isOpen ? "Close navigation" : "Open navigation"
            );

        });


        navMenu.querySelectorAll("a").forEach(function (link) {

            link.addEventListener("click", function () {

                navMenu.classList.remove("open");

                menuToggle.setAttribute(
                    "aria-expanded",
                    "false"
                );

                menuToggle.setAttribute(
                    "aria-label",
                    "Open navigation"
                );

            });

        });

    }


    /* ================= FAQ ACCORDION ================= */

    const faqQuestions =
        document.querySelectorAll(".faq-question");


    faqQuestions.forEach(function (question) {

        question.addEventListener("click", function () {

            const currentItem =
                question.closest(".faq-item");

            const currentAnswer =
                currentItem.querySelector(".faq-answer");

            const isCurrentlyOpen =
                currentItem.classList.contains("active");


            /*
             * Close every FAQ before opening the selected one.
             */

            document
                .querySelectorAll(".faq-item")
                .forEach(function (item) {

                    item.classList.remove("active");

                    const button =
                        item.querySelector(".faq-question");

                    const answer =
                        item.querySelector(".faq-answer");

                    button.setAttribute(
                        "aria-expanded",
                        "false"
                    );

                    answer.style.maxHeight = null;

                });


            /*
             * Open the selected FAQ.
             */

            if (!isCurrentlyOpen) {

                currentItem.classList.add("active");

                question.setAttribute(
                    "aria-expanded",
                    "true"
                );

                currentAnswer.style.maxHeight =
                    currentAnswer.scrollHeight + "px";

            }

        });

    });


    /* ================= COPYRIGHT YEAR ================= */

    const yearElement =
        document.getElementById("currentYear");

    if (yearElement) {
        yearElement.textContent =
            new Date().getFullYear();
    }


    /* ================= CONTACT FORM ================= */

    const contactForm =
        document.getElementById("contactForm");

    const formMessage =
        document.getElementById("formMessage");


    if (contactForm) {

        contactForm.addEventListener("submit", async function (event) {

            event.preventDefault();


            if (!contactForm.checkValidity()) {

                contactForm.reportValidity();

                return;

            }


            const submitButton =
                contactForm.querySelector(
                    'button[type="submit"]'
                );


            const originalButtonText =
                submitButton.innerHTML;


            submitButton.disabled = true;

            submitButton.innerHTML =
                "Sending...";


            formMessage.className =
                "form-message";

            formMessage.textContent = "";


            try {

                const formData =
                    new FormData(contactForm);


                const response =
                    await fetch(
                        "send-mail.php",
                        {
                            method: "POST",
                            body: formData
                        }
                    );


                const result =
                    await response.json();


                if (result.success) {

                    formMessage.className =
                        "form-message success";

                    formMessage.textContent =
                        result.message;

                    contactForm.reset();

                } else {

                    formMessage.className =
                        "form-message error";

                    formMessage.textContent =
                        result.message ||
                        "We could not send your enquiry.";

                }

            } catch (error) {

                formMessage.className =
                    "form-message error";

                formMessage.textContent =
                    "There was a problem sending your enquiry. Please email us directly at owinojerim269@gmail.com.";

            }


            submitButton.disabled = false;

            submitButton.innerHTML =
                originalButtonText;

        });

    }


    /* ================= COOKIE SYSTEM ================= */

    const cookieBanner =
        document.getElementById("cookieBanner");

    const cookieModal =
        document.getElementById("cookieModal");

    const acceptCookies =
        document.getElementById("acceptCookies");

    const rejectCookies =
        document.getElementById("rejectCookies");

    const manageCookies =
        document.getElementById("manageCookies");

    const closeCookieModal =
        document.getElementById("closeCookieModal");

    const saveCookiePreferences =
        document.getElementById(
            "saveCookiePreferences"
        );

    const preferenceCookies =
        document.getElementById(
            "preferenceCookies"
        );

    const cookieSettingsButton =
        document.getElementById(
            "cookieSettingsButton"
        );

    const footerCookieButton =
        document.getElementById(
            "footerCookieButton"
        );


    function getCookieConsent() {

        return localStorage.getItem(
            "softtech_cookie_consent"
        );

    }


    function showCookieBanner() {

        if (
            cookieBanner &&
            !getCookieConsent()
        ) {

            cookieBanner.style.display =
                "block";

        }

    }


    function hideCookieBanner() {

        if (cookieBanner) {

            cookieBanner.style.display =
                "none";

        }

    }


    function openCookieSettings() {

        if (!cookieModal) {
            return;
        }

        cookieModal.classList.add("show");

        cookieModal.setAttribute(
            "aria-hidden",
            "false"
        );


        const preference =
            localStorage.getItem(
                "softtech_preference_cookies"
            );


        if (preferenceCookies) {

            preferenceCookies.checked =
                preference === "accepted";

        }

    }


    function closeCookieSettings() {

        if (!cookieModal) {
            return;
        }

        cookieModal.classList.remove("show");

        cookieModal.setAttribute(
            "aria-hidden",
            "true"
        );

    }


    if (acceptCookies) {

        acceptCookies.addEventListener(
            "click",
            function () {

                localStorage.setItem(
                    "softtech_cookie_consent",
                    "accepted"
                );

                localStorage.setItem(
                    "softtech_preference_cookies",
                    "accepted"
                );

                hideCookieBanner();

            }
        );

    }


    if (rejectCookies) {

        rejectCookies.addEventListener(
            "click",
            function () {

                localStorage.setItem(
                    "softtech_cookie_consent",
                    "rejected"
                );

                localStorage.setItem(
                    "softtech_preference_cookies",
                    "rejected"
                );

                hideCookieBanner();

            }
        );

    }


    if (manageCookies) {

        manageCookies.addEventListener(
            "click",
            openCookieSettings
        );

    }


    if (cookieSettingsButton) {

        cookieSettingsButton.addEventListener(
            "click",
            openCookieSettings
        );

    }


    if (footerCookieButton) {

        footerCookieButton.addEventListener(
            "click",
            openCookieSettings
        );

    }


    if (closeCookieModal) {

        closeCookieModal.addEventListener(
            "click",
            closeCookieSettings
        );

    }


    if (saveCookiePreferences) {

        saveCookiePreferences.addEventListener(
            "click",
            function () {

                localStorage.setItem(
                    "softtech_cookie_consent",
                    "custom"
                );

                localStorage.setItem(
                    "softtech_preference_cookies",
                    preferenceCookies.checked
                        ? "accepted"
                        : "rejected"
                );

                hideCookieBanner();

                closeCookieSettings();

            }
        );

    }


    if (cookieModal) {

        cookieModal.addEventListener(
            "click",
            function (event) {

                if (
                    event.target === cookieModal
                ) {

                    closeCookieSettings();

                }

            }
        );

    }


    showCookieBanner();

});
