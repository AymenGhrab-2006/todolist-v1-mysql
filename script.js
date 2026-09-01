add = document.getElementById("add");
modi = document.getElementById("modi");
function opentask() {
  add.showModal();
}
function openmodi(task) {
  modi.showModal();
  document.getElementById("idm").value=task[0];
  document.getElementById("titlem").value=task[1];
  document.getElementById("descm").value=task[2];
}
document.addEventListener("click", function (e) {
  if (e.target === add) {
    add.close();
  }
});
document.addEventListener("click", function (e) {
  if (e.target === modi) {
    modi.close();
  }
});
function verif() {
  const title = document.getElementById("title").value.trim();
  const desc = document.getElementById("desc").value.trim();
  if (title.length > 30) {
    alert("maximum title length is 30");
    return false;
  }
  if (desc.length > 255) {
    alert("maximum description length is 255");
    return false;
  }
  return true;
}
