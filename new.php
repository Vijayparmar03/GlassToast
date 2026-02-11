<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* Library Namespace Variables */
:root {
    --gt-success: #00ff88;
    --gt-error: #ff3366;
    --gt-info: #00d4ff;
    --gt-warning: #ffcc00;
    --gt-glass: rgba(255, 255, 255, 0.1);
    --gt-border: rgba(255, 255, 255, 0.2);
}

/* Container: Fixed position, doesn't interfere with body flow */
#glass-toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    display: flex;
    flex-direction: column;
    gap: 15px;
    perspective: 1200px;
    /* 3D Depth */
    pointer-events: none;
    /* Allows clicks to pass through empty space to the site */
}

/* Individual Toast */
.glass-toast {
    width: 350px;
    background: var(--gt-glass);
    backdrop-filter: blur(15px) saturate(160%);
    -webkit-backdrop-filter: blur(15px) saturate(160%);
    border: 1px solid var(--gt-border);
    border-radius: 20px;
    padding: 18px;
    color: #ffffff;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    position: relative;
    transform-style: preserve-3d;
    pointer-events: auto;
    /* Re-enable clicks for the toast itself */
    animation: gt-flyIn 0.7s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    transition: transform 0.3s ease, background 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.glass-toast:hover {
    transform: scale(1.02) translateZ(20px);
    background: rgba(255, 255, 255, 0.15);
}

.gt-content {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.gt-icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.gt-text {
    flex-grow: 1;
    margin-top: 2px;
}

.gt-title {
    font-weight: 700;
    font-size: 0.95rem;
    display: block;
    margin-bottom: 2px;
    color: #000000;
}

.gt-msg {
    font-size: 0.85rem;
    color: rgba(0, 0, 0, 0.75);
    line-height: 1.4;
}

.gt-close {
    cursor: pointer;
    opacity: 0.5;
    transition: 0.2s;
    padding: 2px;
    font-size: 14px;
    color:#000000;
}

.gt-close:hover {
    opacity: 1;
    transform: scale(1.2);
}

/* Progress Bar */
.gt-loader {
    position: absolute;
    bottom: 0;
    left: 10%;
    height: 3px;
    width: 80%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 8px;
}

.gt-fill {
    height: 100%;
    width: 100%;
    transform-origin: left;
}

/* Type Variations */
.gt-success .gt-icon-wrapper {
    background: var(--gt-success);
    color: #003d21;
}

.gt-success .gt-fill {
    background: var(--gt-success);
}

.gt-error .gt-icon-wrapper {
    background: var(--gt-error);
    color: #fff;
}

.gt-error .gt-fill {
    background: var(--gt-error);
}

.gt-info .gt-icon-wrapper {
    background: var(--gt-info);
    color: #002e38;
}

.gt-info .gt-fill {
    background: var(--gt-info);
}

.gt-warning .gt-icon-wrapper {
    background: var(--gt-warning);
    color: #3d3000;
}

.gt-warning .gt-fill {
    background: var(--gt-warning);
}

/* Interactive Buttons */
.gt-actions {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.gt-btn {
    padding: 5px 14px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 12px;
    transition: 0.2s;
    cursor: pointer;
}

.gt-btn-yes {
    background: var(--gt-success);
    color: #003d21;
}

.gt-btn-no {
    background: rgba(34, 30, 30, 0.87);
    color: white;
}

.gt-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

/* Animations */
@keyframes gt-flyIn {
    0% {
        opacity: 0;
        transform: translate3d(80px, 0, -200px) rotateY(25deg);
    }

    100% {
        opacity: 1;
        transform: translate3d(0, 0, 0) rotateY(0);
    }
}

@keyframes gt-flyOut {
    to {
        opacity: 0;
        transform: scale(0.8) translate3d(50px, 0, 0);
    }
}

.gt-exit {
    animation: gt-flyOut 0.4s ease forwards !important;
}

@keyframes gt-shrink {
    from {
        transform: scaleX(1);
    }

    to {
        transform: scaleX(0);
    }
}
</style>

<script>
const GlassToast = {
    container: null,

    _init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'glass-toast-container';
            document.body.appendChild(this.container);
        }
    },

    show(type, title, message, duration = 4000) {
        this._init();
        const toast = document.createElement('div');
        toast.className = `glass-toast gt-${type}`;

        const icons = {
            success: 'fa-check-double',
            error: 'fa-circle-exclamation',
            info: 'fa-circle-info',
            warning: 'fa-triangle-exclamation'
        };

        toast.innerHTML = `
                <div class="gt-content">
                    <div class="gt-icon-wrapper"><i class="fa-solid ${icons[type]}"></i></div>
                    <div class="gt-text">
                        <span class="gt-title">${title}</span>
                        <span class="gt-msg">${message}</span>
                    </div>
                    <div class="gt-close"><i class="fa-solid fa-xmark"></i></div>
                </div>
                <div class="gt-loader">
                    <div class="gt-fill" style="animation: gt-shrink ${duration}ms linear forwards"></div>
                </div>
            `;

        this.container.prepend(toast);

        const loader = toast.querySelector('.gt-fill');
        const closeBtn = toast.querySelector('.gt-close');

        // Timer logic with Pause-on-hover
        let startTime = Date.now();
        let remaining = duration;
        let timer;

        const startTimer = (ms) => {
            timer = setTimeout(() => this.remove(toast), ms);
        };

        closeBtn.onclick = () => this.remove(toast);

        toast.onmouseenter = () => {
            loader.style.animationPlayState = 'paused';
            clearTimeout(timer);
            remaining -= Date.now() - startTime;
        };

        toast.onmouseleave = () => {
            loader.style.animationPlayState = 'running';
            startTime = Date.now();
            startTimer(remaining);
        };

        startTimer(duration);
    },

    confirm(title, message, onYes) {
        this._init();
        const toast = document.createElement('div');
        toast.className = `glass-toast gt-info`;

        toast.innerHTML = `
                <div class="gt-content">
                    <div class="gt-icon-wrapper"><i class="fa-solid fa-circle-question"></i></div>
                    <div class="gt-text">
                        <span class="gt-title">${title}</span>
                        <span class="gt-msg">${message}</span>
                        <div class="gt-actions">
                            <button class="gt-btn gt-btn-yes">Confirm</button>
                            <button class="gt-btn gt-btn-no">Cancel</button>
                        </div>
                    </div>
                </div>
            `;

        this.container.prepend(toast);
        toast.querySelector('.gt-btn-yes').onclick = () => {
            onYes();
            this.remove(toast);
        };
        toast.querySelector('.gt-btn-no').onclick = () => this.remove(toast);
    },

    remove(el) {
        if (!el || el.classList.contains('gt-exit')) return;
        el.classList.add('gt-exit');
        el.addEventListener('animationend', () => el.remove());
    },

    success(t, m, d) {
        this.show('success', t, m, d);
    },
    error(t, m, d) {
        this.show('error', t, m, d);
    },
    info(t, m, d) {
        this.show('info', t, m, d);
    },
    warning(t, m, d) {
        this.show('warning', t, m, d);
    }
};
</script>