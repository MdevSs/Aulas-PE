let switchButton = document.querySelector('#switch-button');
let sectionImages = document.querySelector('.section-images');
let section1 = document.querySelector('.section-1');

switchButton.addEventListener("click", (e) =>{
    sectionImages.style.display = "none";
    section1.style.display = 'flex';
})