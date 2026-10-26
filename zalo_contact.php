<style>
    /* Zalo Contact Button */
    .zalo-contact-widget {
        position: fixed;
        bottom: 100px;
        right: 20px;
        z-index: 9999;
    }

    .zalo-contact-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0068FF 0%, #0095FF 100%);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 104, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .zalo-contact-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 104, 255, 0.6);
    }

    .zalo-icon {
        width: 35px;
        height: 35px;
        fill: white;
    }

    /* Zalo tooltip */
    .zalo-tooltip {
        position: absolute;
        right: 70px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 500;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        font-family: Arial, sans-serif;
    }

    .zalo-contact-btn:hover .zalo-tooltip {
        opacity: 1;
    }

    .zalo-tooltip::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 6px solid rgba(0, 0, 0, 0.85);
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
    }

    /* Notification badge */
    .zalo-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: #ff3b30;
        border-radius: 50%;
        border: 2px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        animation: pulse 2s infinite;
    }

    /* Animation cho Zalo button */
    @keyframes zaloRing {
        0%, 100% {
            transform: scale(1);
        }
        25% {
            transform: scale(1.1) rotate(-5deg);
        }
        50% {
            transform: scale(1.1) rotate(5deg);
        }
        75% {
            transform: scale(1.1) rotate(-5deg);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }

    .zalo-contact-btn.ringing {
        animation: zaloRing 0.8s ease-in-out;
    }

    /* Ripple effect */
    .zalo-ripple {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(0, 104, 255, 0.4);
        animation: ripple 2s infinite;
    }

    @keyframes ripple {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .zalo-contact-widget {
            bottom: 90px;
            right: 20px;
        }

        .zalo-tooltip {
            display: none;
        }
    }

    /* Animation when page loads */
    @keyframes bounceIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .zalo-contact-widget {
        animation: bounceIn 0.6s ease-out 0.5s both;
    }
</style>

<!-- Zalo Contact Widget -->
<div class="zalo-contact-widget">
    <a href="https://zalo.me/0364200565" target="_blank" class="zalo-contact-btn" id="zaloBtn">
        <div class="zalo-ripple"></div>
        <span class="zalo-tooltip">Chat với chúng tôi qua Zalo</span>
        <span class="zalo-badge">!</span>
        <svg class="zalo-icon" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 4C12.954 4 4 12.954 4 24c0 5.64 2.346 10.734 6.12 14.364L8.286 43.8l5.82-1.584C17.34 43.38 20.58 44 24 44c11.046 0 20-8.954 20-20S35.046 4 24 4z" fill="#fff"/>
            <path d="M24 7c9.374 0 17 7.626 17 17s-7.626 17-17 17c-3.066 0-5.94-.816-8.424-2.238l-5.994 1.632 1.746-5.4C8.904 32.58 7 28.506 7 24c0-9.374 7.626-17 17-17z" fill="#0068FF"/>
            <path d="M20.52 28.5c-.45 0-.9-.18-1.23-.51l-3.3-3.3c-.69-.69-.69-1.8 0-2.49.69-.69 1.8-.69 2.49 0l2.04 2.04 5.46-5.46c.69-.69 1.8-.69 2.49 0 .69.69.69 1.8 0 2.49l-6.72 6.72c-.33.33-.78.51-1.23.51z" fill="#fff"/>
        </svg>
    </a>
</div>

<script>
    // Zalo button animation
    const zaloBtn = document.getElementById('zaloBtn');
    
    // Ring animation every 8 seconds
    setInterval(() => {
        zaloBtn.classList.add('ringing');
        setTimeout(() => {
            zaloBtn.classList.remove('ringing');
        }, 800);
    }, 8000);

    // Remove badge on click
    zaloBtn.addEventListener('click', function() {
        const badge = this.querySelector('.zalo-badge');
        if (badge) {
            badge.style.display = 'none';
        }
    });

    // Show badge again after 30 seconds
    setTimeout(() => {
        const badge = zaloBtn.querySelector('.zalo-badge');
        if (badge) {
            badge.style.display = 'flex';
        }
    }, 30000);
</script>