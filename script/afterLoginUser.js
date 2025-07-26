//search area start
let crossBtn = document.getElementById('cross');
let searchArea = document.getElementById('search-area');

crossBtn.addEventListener('click', ()=>{
    searchArea.style.display = 'none';
});

function viewSearchArea(){
    searchArea.style.display = 'block';
    searchArea.style.animation = 'scale 1s 1';
}

//search area end

// speakes takl start
const speakers = [
    { name: "-Shakespeare", talk: "All the world’s a stage, and all the men and women merely players." },
    { name: "-John F. Kennedy (1961)", talk: "Ask not what your country can do for you – ask what you can do for your country." },
    { name: "-Nelson Mandela", talk: "We dedicate this day to all the heroes and heroines in this country and the rest of the world who sacrificed in many ways and surrendered their lives so that we could be free." },
    { name: "-Bill Geats", talk: "Humanity's greatest advances are not in its discoveries, but in how those discoveries are applied to reduce inequity." }, 
    { name: "-Bill Geats", talk: "If you are born poor it's not your mistake, but if you die poor it's your mistake." }
];

let currentSpeakerIndex = 0;

function updateSpeaker() {
    const speakerNameElement = document.getElementById('speaker-name');
    const speakerTalkElement = document.getElementById('speaker-talk');

    const currentSpeaker = speakers[currentSpeakerIndex];
    speakerNameElement.textContent = currentSpeaker.name;
    speakerTalkElement.textContent = currentSpeaker.talk;

    currentSpeakerIndex = (currentSpeakerIndex + 1) % speakers.length;
}

setInterval(updateSpeaker, 5000);

//speckers talk area end


//image slider hero area start
const slider = document.getElementById('slider');
    const slides = document.querySelector('.slides');

    function nextSlide() {
        const firstSlide = slides.firstElementChild;
        slides.style.transition = "transform 0.5s ease-in-out";
        slides.style.transform = `translateX(-${firstSlide.offsetWidth}px)`;

        setTimeout(() => {
            slides.appendChild(firstSlide);
            slides.style.transition = 'none';
            slides.style.transform = 'translateX(0)';
        }, 1000);
    }

    setInterval(nextSlide, 5000);

//loader
window.addEventListener('load', function () {
    document.getElementById('preloader').style.display = 'none';
});