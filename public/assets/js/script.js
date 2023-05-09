document.addEventListener("DOMContentLoaded", function () {
  // Récupérer les éléments à glisser
  const tasks = document.querySelectorAll(".tache_complete");
  const sections = document.querySelectorAll(".bloc_taches");

  let draggedTask = null;
  let tacheId;
console.log(tasks);
  function dragStart() {
    draggedTask = this;
    tacheId = task.firstElementChild.lastElementChild.id;
  }

  // Ajouter un événement pour le glisser
  tasks.forEach(task => {
    task.addEventListener("dragstart", dragStart);
  });

  // Ajouter un événement pour cibler l'endroit où déposer l'élément
  sections.forEach((section) => {
    section.addEventListener("dragover", dragOver);
    section.addEventListener("drop", drop);
  });

  function dragOver(event) {
    event.preventDefault();
  }

  async function drop(event) {
    event.preventDefault();
    // Vérifier si l'élément cible est la section "En cours" ou "Terminés"
    const targetSection = this.id;

    if (targetSection === "doing" ) {
      // Déplacer l'élément vers la section cible
      this.querySelector(".bloc_tache_en_cours").appendChild(draggedTask);
      
      let formDone = new FormData();
      formDone.append("statut", targetSection);
      formDone.append("tacheId", tacheId);
      tacheId = null;

      let retourFetch = await fetch(
        "/drag",
        // '../traitement/traitementDrop.php',
        { method: "POST", body: formDone }
      );
      let reponse = await retourFetch.json();
    }else if(targetSection === "done") {
      // Déplacer l'élément vers la section "A faire"
      this.querySelector(".bloc_tache_faire").appendChild(draggedTask);
      let formDone = new FormData();
      formDone.append("statut", targetSection);
      formDone.append("tacheId", tacheId);
      tacheId = null;

      let retourFetch = await fetch(
        "/drag",
        // '../traitement/traitementDrop.php',
        { method: "POST", body: formDone }
      );
      let reponse = await retourFetch.json();
    }
  }
});
