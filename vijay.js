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
