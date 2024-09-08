const $back = document.querySelector('img.back')

function VoltarIndex(){
    window.location.href = '../Index.htm'
}

$back.addEventListener('click', function(){
    VoltarIndex()
})