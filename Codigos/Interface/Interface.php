<html>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        div {
            border: 1px solid #909090;
        }

        section {
            text-align: right;
        }

        main {
            height: 200px;
        }


    </style>

    <body>
        <div>
            <section>
                <input id="txtPesquisa">
            </section>

            <main id="pnlConteudo"></main>
            
            <footer>
                <button onClick="txtPag.value--; retornaDados();">&lt;</button>

                <input id="txtPag" value="1">
                
                <button onClick="txtPag.value++; retornaDados();">&gt;</button>
            </footer>
        </div>
    </body>

    <script>
        function retornaDados() {
            var oForm = new FormData();
            
            oForm.append("txtPag", txtPag.value);
            oForm.append("txtPesquisa", txtPesquisa.value);

            fetch('Servico.php', {method: 'POST', body: oForm})
                .then(oResp => oResp.text())
                .then(oDados => pnlConteudo.innerHTML = oDados)
                .catch(oErro => console.log(oErro))
        }

        window.onload = retornaDados;
    </script>
</html>