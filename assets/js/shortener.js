document.addEventListener("DOMContentLoaded", function () {

    // COPY SHORT URL
    const copyBtn = document.querySelector('[data-copy]');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            const output = document.getElementById('shortUrlOutput');
            if (!output) return;

            output.select();
            output.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(output.value).then(() => {
                copyBtn.textContent = 'Copied!';
                setTimeout(() => {
                    copyBtn.textContent = 'Copy';
                }, 1500);
            });
        });
    }

    // CLEAR SHORTENER
    const clearBtn = document.querySelector('[data-clear]');
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            const input = document.getElementById('longUrlInput');
            if (input) {
                input.value = '';
            }
            window.location.href = window.location.pathname;
        });
    }

});
