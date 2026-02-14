<div id="preloader-wrapper">
    <div class="preloader-content">
        <div class="logo-container">
            <img
                src="{{ isset($settings['logo']) && $settings['logo'] 
                    ? asset('storage/' . $settings['logo']) 
                    : asset('assets/frontend/images/logo_2.png') 
                }}"
                alt="Logo"
                class="preloader-logo" />
        </div>
        <div class="loader-progress-container">
            <div class="loader-progress-bar"></div>
        </div>
    </div>
</div>

<style>
    #preloader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ffffff;
        display: flex;
        /* Ensure it starts visible */
        justify-content: center;
        align-items: center;
        z-index: 9999999;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.6s cubic-bezier(0.77, 0, 0.175, 1),
            visibility 0.6s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .preloader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
    }

    .logo-container {
        width: 120px;
        animation: preloader-pulse 2s infinite ease-in-out;
    }

    .preloader-logo {
        width: 100%;
        height: auto;
    }

    .loader-progress-container {
        width: 120px;
        height: 2px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .loader-progress-bar {
        position: absolute;
        width: 45%;
        height: 100%;
        background-color: #1a1a1a;
        /* Replace with your Brand Color */
        border-radius: 10px;
        animation: loading-bar-move 1.5s infinite ease-in-out;
    }

    @keyframes preloader-pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.04);
            opacity: 0.8;
        }
    }

    @keyframes loading-bar-move {
        0% {
            left: -45%;
        }

        100% {
            left: 100%;
        }
    }

    /* Exit state */
    .loader-hidden {
        opacity: 0 !important;
        visibility: hidden !important;
    }
</style>

<script>
    // This function handles the disappearance
    function hidePreloader() {
        const preloader = document.getElementById('preloader-wrapper');
        if (preloader) {
            // Short delay so it feels smooth
            setTimeout(() => {
                preloader.classList.add('loader-hidden');
            }, 1000);
        }
    }

    // 1. Run on initial page load
    window.addEventListener('load', hidePreloader);

    // 2. Run after Livewire navigates to a new page
    document.addEventListener('livewire:navigated', () => {
        // Ensure it's hidden on SPA navigation 
        // because the element might persist in the DOM
        hidePreloader();
    });

    // 3. Optional: Hide if things take too long (Safety fallback)
    setTimeout(hidePreloader, 5000);
</script>