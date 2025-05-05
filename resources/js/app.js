import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (window.location.pathname == '/produits') {
    document.getElementById("btnSupprimer").addEventListener("click", supProducts);
    document.getElementById("btnFiltre").addEventListener("click", filtreTexte);
    document.getElementById("btnEffacer").addEventListener("click", effacerFiltre);


    function supProducts(evt) {
        let divs = document.getElementById("formProduits").children[0].children;
        let ids = [];
        for (let i = 3; i < divs.length; i++) {
            if (divs[i].children[0].checked) {
                ids.push(divs[i].id)
            }
        }
        if (ids.length == 0) {
            let elem = document.getElementById("formProduits");

            if (elem.lastChild.id == "errorText") {
                return;
            }

            let para = document.createElement("p");
            let node = document.createTextNode("Veuillez selectionner un ou plusieurs articles.");

            para.setAttribute("id", "errorText");

            para.appendChild(node);
            elem.appendChild(para);

            elem.lastChild.classList.add("text-red-600");
            elem.lastChild.classList.add("w-full");
            elem.lastChild.classList.add("text-center");
        }
        callFetchDel(ids);
    }

    function triProduits(evt) {

        var container = document.getElementById("formProduits").children;
        var elements = container[0].childNodes;
        var value = document.getElementById("triProduit").value
        var sortMe = [];
        console.log(elements)
        for (var i = 0; i < elements.length; i++) {
            if (!elements[i].id) {
                console.log("asda");

                continue;
            }
            sortMe.push(elements[i]);
        }
        console.log(sortMe);
        if (value == "Nom") {
            sortMe.sort((a, b) => a.children[3].innerHTML.localeCompare(b.children[3].innerHTML));
        }
        else if (value == "Code") {
            sortMe.sort((a, b) => a.id.localeCompare(b.id));
        }
        else if (value == "Prix") {
            sortMe.sort(function (a, b) { return b.children[4].innerHTML.replace('$', '') - a.children[4].innerHTML.replace('$', '') });
        }
        for (var j = 0; j < sortMe.length; j++) {
            {
                container[0].append(sortMe[j]);
            }
        }
    }

    function effacerFiltre(evt) {
        document.getElementById("triProduit").value = "Code";
        triProduits(evt);
        document.getElementById("searchInput").value = "";
        let divs = document.getElementById("formProduits").children[0].children;
            let error = document.getElementById("mauvaiseRecherche");
            if (error != null) {
                error.classList.add("hidden");
            }
            for (let i = 3; i < divs.length; i++) {
                if (divs[i].classList.contains("hidden")) {
                    divs[i].classList.toggle("hidden");
                }
            }

    }

    function filtreTexte(evt) {
        console.log("ok");
        triProduits()
        var text = document.getElementById("searchInput")
        if (text.value == "") {
            let divs = document.getElementById("formProduits").children[0].children;
            let error = document.getElementById("mauvaiseRecherche");
            if (error != null) {
                error.classList.add("hidden");
            }
            for (let i = 3; i < divs.length; i++) {
                if (divs[i].classList.contains("hidden")) {
                    divs[i].classList.toggle("hidden");
                }
            }
            return;
        }
        var container = document.getElementById("formProduits").children;
        var elements = container[0].childNodes;
        var sortMe = [];
        for (var i = 0; i < elements.length; i++) {
            if (!elements[i].id) {
                continue;
            }
            sortMe.push(elements[i]);
        }
        if (text.value.match(/[0-9]*/) != '') {
            callFetchFiltre("filtreId/" + text.value);
        } else {
            callFetchFiltre("filtreName/" + text.value);
        }
        for (var j = 0; j < sortMe.length; j++) {
            {
                container[0].append(sortMe[j]);
            }
        }

    }
    async function callFetchFiltre($param) {
        fetch('api/produit/' + $param, {
            method: 'GET',
            headers: {
                'Accept': 'application/json; charset=utf-8',
                'Content-Type': 'application/json; charset=utf-8'
            }
        })
            .then(response => response.json())
            .then(response => {
                let divs = document.getElementById("formProduits").children[0].children;
                let ids = [];
                for (let j = 0; j < response.length; j++) {
                    ids.push(response[j].produit_id)
                }
                for (let i = 3; i < divs.length; i++) {
                    if (ids.includes(parseInt(divs[i].id))) {
                        if (divs[i].classList.contains("hidden")) {
                            divs[i].classList.toggle("hidden");
                        }
                    } else {
                        if (!divs[i].classList.contains("hidden")) {
                            divs[i].classList.toggle("hidden");
                        }
                    }
                }
                if (ids.length == 0) {
                    let error = document.getElementById("mauvaiseRecherche");

                    if (error == null) {
                        let para = document.createElement("p");
                        let node = document.createTextNode("Aucun article correspond a la recherche.");

                        para.setAttribute("id", "mauvaiseRecherche");

                        para.appendChild(node);
                        document.getElementById("formProduits").insertAdjacentElement("beforebegin", para);
                        para.classList.add("col-span-12", "text-center", "text-red-600", "font-semibold");
                    }else{
                        if(error.classList.contains("hidden")){
                            error.classList.toggle("hidden")
                        }
                    }
                }
            });
    }
    async function callFetchDel(ids) {
        fetch('api/produit/delete', {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json; charset=utf-8',
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify({ ids: ids })
        })
            .then(response => response.json())
            .then(response => {
                let divs = document.getElementById("formProduits").children[0].children;
                for (let i = 3; i < divs.length; i++) {
                    if (divs[i].children[0].checked) {
                        divs[i].classList.add("hidden");
                    }
                }
            });

    }
}
