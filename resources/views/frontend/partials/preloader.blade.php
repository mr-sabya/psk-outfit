<div id="preloader-wrapper">
    <div class="preloader-content">
        <!-- You can replace this with your logo or a CSS spinner -->
        <div class="spinner"></div>
        <p>Loading...</p>
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
        /* Page background color */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        /* Stay on top of everything */
        transition: opacity 0.5s ease, visibility 0.5s;
    }

    /* Simple Spinner Animation */
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #000000ff;
        /* Your Brand Color */
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Class to hide the loader */
    .loader-hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>

<script>
    document.addEventListener('livewire:navigated', function() {
        const preloader = document.getElementById('preloader-wrapper');

        // Check if the loader has already been shown in this browser session
        if (!sessionStorage.getItem('home_loader_shown')) {

            // Wait for the entire page (images, scripts) to finish loading
            window.addEventListener('load', function() {
                setTimeout(() => {
                    preloader.classList.add('loader-hidden');
                    // Set the flag so it doesn't show again
                    sessionStorage.setItem('home_loader_shown', 'true');
                }, 2000); // 800ms delay to ensure it looks smooth
            });

        } else {
            // If already shown, hide it immediately without animation
            preloader.style.display = 'none';
        }
    });
</script>