    let oDadosAjax;

    let tabelas = document.querySelectorAll('.toogle-button');

    let ativado = document.querySelector('.toogleOn');

    function fnReqURL(value){
        let txtURL;
        value.classList.forEach(classes =>{
            switch(classes)
            {
                case 'tables':
                    txtURL = `nTipo=1&txtTabela=${value.dataset.tipo}&nFuncao=null`;    
                break;
                case 'relatorio':
                    txtURL = `nTipo=2&$txtTabela=null&nFuncao=${value.dataset.tipo}&txtParametro=${value.value}`;
                break;
            }
        })
        
        return txtURL;     
    }

    function MostraDados(dados){
        let oConteudo = document.querySelector('.content-itens table');

        oConteudo.innerHTML = '<thead></thead>'
                            +'<tbody></tbody>';
                            
        let oTabelaCabeca = oConteudo.children[0];
        let oTabelaCorpo = oConteudo.children[1];

        let indices = Object.keys(dados[0]);
        console.log(indices);
        indices.forEach(valor =>{
            let tColuna = document.createElement('th');
            tColuna.textContent = valor.toUpperCase();    
            oTabelaCabeca.append(tColuna);
        })
        indices = null;
        dados.forEach((valor, indice)=>{
            let oLinha = document.createElement('tr');
            
            for(index in valor)
            {
                console.log(valor[index]);
                let oValores = document.createElement('td');
                oValores.textContent = valor[index];
                oLinha.append(oValores);
            }
            console.log(oLinha);
            oTabelaCorpo.append(oLinha);
        });
        console.log(oTabelaCorpo);


    }

    function fnAjax(value){
        console.log(`API/api-json.php?${fnReqURL(value)}`);
        fetch(`API/api-json.php?${fnReqURL(value)}`)
            .then(response => response.json())
            .then(data =>{
                oDadosAjax = data;
                console.log(oDadosAjax);
                MostraDados(oDadosAjax);
            }).catch(error => console.error('Erro:'+ error));
    }

    tabelas.forEach(element => {
        element.addEventListener('click', (e)=>{
            ativado = document.querySelector('.toogleOn');
            if(ativado.classList.contains('toogleOn')){
                ativado.classList.remove('toogleOn')
                ativado.style.color = "#eeeeff";
            }
            element.classList.add('toogleOn');
            element.style.color = "#00CC00";
            fnAjax(e.target);
    })
    });

    const buttonOpen = document.querySelector('.openButton');

    buttonOpen.addEventListener('click', (e)=>{
        let sideBarContents = document.querySelectorAll('.tables, .reports');
        let sideBar = document.querySelector('.side-bar');
        if(!sideBar.classList.contains('close')){
            buttonOpen.style.transform = 'translate(0px)';
            buttonOpen.children[0].style.transform = 'rotate(0deg)';
            sideBar.classList.toggle('close');
            sideBar.children[1].classList.toggle('invisible');
            sideBar.children[2].classList.toggle('invisible');
        }
        else{

            buttonOpen.style.transform = 'translate(20vw)';
            buttonOpen.children[0].style.transform = 'rotate(180deg)';
            sideBar.classList.toggle('close');
            sideBar.children[1].classList.toggle('invisible');
            sideBar.children[2].classList.toggle('invisible');
        }
        
    })

    document.querySelectorAll('.reports .search form').forEach(element =>{
        element.addEventListener('submit', (e)=>{
            e.preventDefault();
            console.log(e.target);
            console.log(e.target.children[0]);
            e.target.children[0].classList.add('relatorio');
            fnAjax(e.target.children[0]);
            // fnAjax(e.target);
        })
    })


