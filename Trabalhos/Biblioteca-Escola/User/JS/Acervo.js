function fnAvalia(oImagem, e){
    console.log(e)
    console.log(oImagem)

    let nPor = e.offsetX/e.target.offsetWidth
    let nPontos = 0

    nPor = nPor.toFixed(1)*100

    if(nPor < 20) {
        nPor = 20
        nPontos = 1
    }
    else if(nPor < 40) {
        nPor = 40
        nPontos = 2
    }
    else if(nPor < 60) {
        nPor = 60
        nPontos = 3
    }
    else if(nPor < 80) {
        nPor = 80
        nPontos = 4
    }
    else if(nPor < 100) {
        nPor = 100
        nPontos = 5
    }

    oImagem.style.background = "linear-gradient(to right, #FFF000 "+ nPor +"%, transparent "+ nPor +"%)"
    
    oForm = new FormData()
    oForm.append("nObra", oImagem.dataset.nValor)
    oForm.append("nNota", nPontos)


    fetch('avaliar.php', {'method': 'POST', 'header': {'Content-Type': 'application/json'}, 'body': oForm})
        .then(oResposta=>oResposta.json())
        .then(oRes=>console.log(JSON.parse(oRes)))
        .catch(oError=>console.log(oError))
}