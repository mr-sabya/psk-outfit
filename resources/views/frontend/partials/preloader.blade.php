@if(request()->is('/'))
<div id="preloader-wrapper">
    <div class="preloader-content">
        <div class="logo-container">
            <img src="{{ isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('assets/frontend/images/logo_2.png') }}" alt="Logo" class="preloader-logo" />
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
        justify-content: center;
        align-items: center;
        z-index: 9999999;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }

    .logo-container {
        width: 120px;
        animation: preloader-pulse 2s infinite ease-in-out;
    }

    .loader-progress-container {
        width: 120px;
        height: 2px;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
        margin-top: 10px;
    }

    .loader-progress-bar {
        position: absolute;
        width: 45%;
        height: 100%;
        background-color: #1a1a1a;
        animation: loading-bar-move 1.5s infinite ease-in-out;
    }

    @keyframes preloader-pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
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

    .loader-hidden {
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none;
    }
</style>

<script>
    function handlePreloader() {
        const preloader = document.getElementById('preloader-wrapper');
        if (!preloader) return;
        if (!sessionStorage.getItem('preloader_shown')) {
            sessionStorage.setItem('preloader_shown', 'true');
            setTimeout(() => {
                preloader.classList.add('loader-hidden');
            }, 1500);
        } else {
            preloader.style.display = 'none';
        }
    }
    window.addEventListener('load', handlePreloader);
    document.addEventListener('livewire:navigated', handlePreloader);
</script>
@endif