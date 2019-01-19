function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  if (selectedIds.length != 0) {
    // document.getElementById(selectedIds[0]).style.backgroundColor = "";
    // selectedIds.pop();
    // showAll(tr);
    if (filteredRows.length != 0) {
      deleteNoneRows(tr);
      for (i = 0; i < filteredRows.length; i++) {
        td = filteredRows[i].getElementsByTagName("h2")[0];
        if (td) {
          if(td.innerText.length==0){
            var v=filteredRows[i].getElementsByClassName("fold")[0];
            td=v.getElementsByTagName("p")[0];
          }
          if (td.innerText.toUpperCase().indexOf(filter) > -1) {
            filteredRows[i].style.display = "";
          } else {
            filteredRows[i].style.display = "none";
          }
        }
      }
    }
  }
  else {
    deleteNoneRows(tr);
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("h2")[0];
      if (td) {
        if(td.innerText.length==0){
          var v=tr[i].getElementsByClassName("fold")[0];
          td=v.getElementsByTagName("p")[0];
        }
        if (td.innerText.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function displayFunction() {
  var acc = document.getElementsByClassName("view");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
      /* Toggle between adding and removing the "active" class,
      to highlight the button that controls the panel */
      this.classList.toggle("active");

      /* Toggle between hiding and showing the active panel */
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        this.getElementsByClassName("fa fa-fw fa-chevron-up")[0].className = "fa fa-fw fa-chevron-down";
        panel.style.display = "none";
      } else {
        this.getElementsByClassName("fa fa-fw fa-chevron-down")[0].className = "fa fa-fw fa-chevron-up";
        panel.style.display = "block";
      }
    });
  }
}

function deleteNoneRows(tr) {
  for (var i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.indexOf("projects found!") > -1) {
        table.deleteRow(i);
      }
    }
  }
}

function showAll(tr) {
  for (var i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    tr[i].style.display = "";
  }
}

var selectedIds = [];
var filteredRows = [];

function checkId(id) {
  return selectedIds.includes(id);
}

function filter(id) {
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  filteredRows = [];
  deleteNoneRows(tr);
  if (checkId(id)) {
    selectedIds.pop();
    document.getElementById(id).style.backgroundColor = "";
    showAll(tr);
  } else {
    if (selectedIds.length != 0) {
      document.getElementById(selectedIds[0]).style.backgroundColor = "";
      selectedIds.pop();
    }
    selectedIds.push(id);
    var isActive = false;
    var noneSelected = true;
    if (!isActive) {
      document.getElementById(id).style.backgroundColor = "grey";
      isActive = false;
    }
    if (id == "Undo") {
      showAll(tr);
    } else {
      for (var i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          if (td.innerHTML.toUpperCase().search(id.toUpperCase()) != -1) {
            filteredRows.push(tr[i]);
            tr[i].style.display = "";
            noneSelected = false;
          } else {
            tr[i].style.display = "none";
          }
        }
      }
      if (noneSelected) {
        var row = table.insertRow(1);
        var c1 = row.insertCell(0);
        var c2 = row.insertCell(1);
        c1.innerHTML = "No " + id + " projects found!";
        // alert("Nothing in this category!");
      }
    }
  }
}
displayFunction();
