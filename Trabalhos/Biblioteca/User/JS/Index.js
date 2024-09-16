const item = document.querySelectorAll('div.item')

function mudarPagina(value){
    switch(value){
        case '1':
            window.location.href = 'HTML/Acervo.htm'
            break
        case '2':
            window.location.href = 'HTML/Emprestimo.htm'
            break
    }
}

item.forEach(function(div){
    div.addEventListener('click', function(){
        mudarPagina(div.getAttribute('value'))
    })
})