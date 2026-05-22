import './bootstrap';


window.addEventListener('scroll', () => {
    const nav = document.querySelector('.glass-navbar');
    if (window.scrollY > 50) {
        nav.style.background = 'rgba(255,255,255,0.95)';
    } else {
        nav.style.background = 'rgba(255,255,255,0.75)';
    }
});



document.addEventListener('DOMContentLoaded', () => {

    // AOS
    AOS.init({ once:true, duration:1000 });

    // Counter Animation
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.dataset.target;
        let count = 0;

        const update = () => {
            if (count < target) {
                count += Math.ceil(target / 100);
                counter.innerText = count;
                setTimeout(update, 20);
            } else {
                counter.innerText = target + '+';
            }
        };
        update();
    });

});
