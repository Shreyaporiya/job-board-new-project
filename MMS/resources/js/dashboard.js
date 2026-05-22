// Counter
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.dataset.count;
        const speed = target / 200;

        const update = () => {
            const count = +counter.innerText;
            if (count < target) {
                counter.innerText = Math.ceil(count + speed);
                setTimeout(update, 10);
            } else {
                counter.innerText = target;
            }
        };
        update();
    });
});