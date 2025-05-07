document.getElementById("searchEmploye")?.addEventListener("click", searchEmploye);
document.getElementById("name")?.addEventListener("focusout", validerName);
document.getElementById("email")?.addEventListener("focusout", validerEmail);
document.getElementById("password")?.addEventListener("focusout", validerPassword);
document.getElementById("password_confirmation")?.addEventListener("focusout", validerPasswordConfirmation);
document.getElementById("email")?.addEventListener("focusin", enleverErreurEmail);

let buttonDelete = document.getElementsByClassName("supprimerEmploye");
for(const element of buttonDelete){
    element?.addEventListener("click", verifDelete);
}

let pasEncorePassé = true;

function verifDelete(evt){
    let confirmation = confirm("Êtes-vous certains de vouloir supprimer ce compte d'employé ?");

    if(confirmation == false){
        evt.preventDefault();
    }
}

function searchEmploye(evt){
    evt.preventDefault();

    console.log(document.getElementById("searchEmployee").value);

    const userSearch = document.getElementById("searchEmployee").value;

    searchEmployee(userSearch);
}

function enleverErreurEmail(evt){
    let p = document.getElementById("emailErreur");
    if(p != null){
        if(pasEncorePassé == true){
            p.innerHTML = "";
            p.classList.remove("text-sm");
            p.classList.remove("text-red-600");
            p.classList.remove("space-y-1");
            p.classList.remove("mt-2");

            pasEncorePassé = false;
        }
    }
}

function validerEmail(evt){
    console.log(evt.target.id);
    let p;
    let after;
    let email = document.getElementById("email").value;

    if(!/^([a-zA-Z0-9_.]+)([@])([a-z]+)([.])([a-z]+)$/.test(email)){
        if(document.getElementById("emailErreur") == null){
            p = document.createElement("ul");
        }
        else{
            p = document.getElementById("emailErreur");
        }

        p.innerHTML = "L\'email entré n'est pas dans un format valide.";

        p.id = "emailErreur";

        p.classList.add("text-sm");
        p.classList.add("text-red-600");
        p.classList.add("space-y-1");
        p.classList.add("mt-2");

        after = document.getElementById("email");
        after.insertAdjacentElement("afterend", p);
    }
    else{
        if(document.getElementById("emailErreur") != null){
            p = document.getElementById("emailErreur");

            p.innerHTML = "";
            p.classList.remove("text-sm");
            p.classList.remove("text-red-600");
            p.classList.remove("space-y-1");
            p.classList.remove("mt-2");
        }
    }
}

function validerName(evt){
    console.log(evt.target.id);
    let p;
    let after;
    let name = document.getElementById("name").value;

    if(!/^([a-zA-Z-]+) ([a-zA-Z-]+)$/.test(name)){
        if(document.getElementById("nameErreur") == null){
            p = document.createElement("ul");
        }
        else{
            p = document.getElementById("nameErreur");
        }

        p.innerHTML = "Le nom entré n\'est pas dans le bon format. Exemple: Jean Charles.";

        p.id = "nameErreur";

        p.classList.add("text-sm");
        p.classList.add("text-red-600");
        p.classList.add("space-y-1");
        p.classList.add("mt-2");

        after = document.getElementById("name");
        after.insertAdjacentElement("afterend", p);
    }
    else{
        if(document.getElementById("nameErreur") != null){
            p = document.getElementById("nameErreur");

            p.innerHTML = "";
            p.classList.remove("text-sm");
            p.classList.remove("text-red-600");
            p.classList.remove("space-y-1");
            p.classList.remove("mt-2");
        }
    }
}

function validerPassword(evt){
    console.log(evt.target.id);
    let p;
    let after;
    let password = document.getElementById("password").value;

    if(!/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;"'<>,.?'\/'-]).{8,}/.test(password)){
        if(document.getElementById("passwordErreur") == null){
            p = document.createElement("ul");
        }
        else{
            p = document.getElementById("passwordErreur");
        }

        p.innerHTML = "Le mot de passe entré n'est pas dans un format valide. Vous devez avoir une lettre minuscule et majuscule, un chiffre et un symbole.";

        p.id = "passwordErreur";

        p.classList.add("text-sm");
        p.classList.add("text-red-600");
        p.classList.add("space-y-1");
        p.classList.add("mt-2");

        after = document.getElementById("password");
        after.insertAdjacentElement("afterend", p);
    }
    else{
        if(document.getElementById("passwordErreur") != null){
            p = document.getElementById("passwordErreur");

            p.innerHTML = "";
            p.classList.remove("text-sm");
            p.classList.remove("text-red-600");
            p.classList.remove("space-y-1");
            p.classList.remove("mt-2");
        }
    }
}

function validerPasswordConfirmation(evt){
    console.log(evt.target.id);
    let p;
    let after;
    let passwordC = document.getElementById("password_confirmation").value;

    if(!/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+={}\[\]:;"'<>,.?'\/'-]).{8,}/.test(passwordC)){
        if(document.getElementById("passwordCErreur") == null){
            p = document.createElement("ul");
        }
        else{
            p = document.getElementById("passworCErreur");
        }

        p.innerHTML = "La confirmation du mot de passe entré n'est pas dans un format valide.";

        p.id = "passwordCErreur";

        p.classList.add("text-sm");
        p.classList.add("text-red-600");
        p.classList.add("space-y-1");
        p.classList.add("mt-2");

        after = document.getElementById("password_confirmation");
        after.insertAdjacentElement("afterend", p);
    }
    else{
        if(document.getElementById("passwordCErreur") != null){
            p = document.getElementById("passwordCErreur");

            p.innerHTML = "";
            p.classList.remove("text-sm");
            p.classList.remove("text-red-600");
            p.classList.remove("space-y-1");
            p.classList.remove("mt-2");
        }
    }
}

async function searchEmployee(motCle){
    const options = {
        method: 'GET', //ou autres méthodes vue dans les API.
        headers: {
                'Accept': 'application/json; charset=utf-8',
                'Content-Type': 'application/json; charset=utf-8'
                },
    };

    let response = await fetch('http://localhost:8000/api/searchEmploye?objet=employe&mots_cles=' + motCle, options)
    /* La méthode json() ci-dessous (au lieu de text()) est nécessaire puisque
    le serveur répondra au format JSON tel que défini dans le champ "headers"
    ci-haut. */

    .then(response => response.json())
    .then(response => {
        if(response.ÉCHEC){
            console.log("échec");

            let resultSearch = document.getElementById("zoneInfo");
            resultSearch.classList.remove("hidden");

            let entete = document.getElementById("enTete");
            entete.classList.add("hidden");

            let listEmploye = document.getElementById("listEmploye");
            listEmploye.classList.add("hidden");

            resultSearch.innerHTML = "<h2 class='pl-2 py-1 text-white font-semibold col-span-12 grid place-content-center text-xl'>Aucun employé trouvé.</h2>"
        }
        else{
            console.log("réussi");
            let listEmploye = document.getElementById("listEmploye");
            listEmploye.classList.remove("hidden");
            listEmploye.innerHTML = "";

            let resultSearch = document.getElementById("zoneInfo");
            resultSearch.classList.add("hidden");

            let entete = document.getElementById("enTete");
            entete.classList.remove("hidden");

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            response.forEach(affichage => {
                listEmploye.innerHTML += "<div id=" + affichage['id'] + " class='grid grid-cols-subgrid col-span-12 gap-2'><p class='pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5'>" + affichage['name'] + "</p><p class='pl-2 py-1 text-white font-semibold bg-blue-300 col-span-5'>" + affichage['email'] + "</p><form method='get' action='http://localhost:8000/profile'><button type='submit' name='id_user' value=" + affichage['id'] + " class='w-5 mx-2'><img src='./images/edit-icon.png' alt='Modifier un employé' /></button></form><form method='post' action='http://localhost:8000/listeEmployee'><input type='hidden' name='_token' value=" + csrfToken + "><button type='submit' name='id_user' value=" + affichage['id'] + " class='w-5 supprimerEmploye'><img type='image' src='./images/delete-icon.png' alt='Supprimer un employé' /></button></form></div>";
            });

            let buttonDelete = document.getElementsByClassName("supprimerEmploye");
            for(const element of buttonDelete){
                element?.addEventListener("click", verifDelete);
            }
        }
    });
}
