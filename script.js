
render();
function render(){
    setTimeout(() => {

        fetch('http://localhost:8000/mapel/select.php')
        .then(r => r.json())
        .then(d => { 
            if (d.status == 200){

                let dataTable = document.getElementById("userTable");
                let element = '';

                if (d.data.length == 0){
                    element = `
                        <tr>
                            <td colspan="5" class="text-center">No users found</td>
                        </tr>
                    `
                }

                d.data.map((item, key) =>{


                    element += `
                        <tr key="${key}">
                            <td>${key + 1}</td>
                            <td>${item.name}</td>
                            <td>${item.deskripsi}</td>
                            <td>${item.guru}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMapel-${item.id}">
                                Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteMapel-${item.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Mapel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to delete this?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <button onclick="del(${item.id})" type="button" class="btn btn-primary">Yes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>                
                    `
                });

                dataTable.innerHTML = element;
            }
            else {
                console.error(d.message);
            }
        })
        .catch(e => {
            console.error(e); 
        });

    },100);
}

function add(){
    let name = document.getElementById('Namee').value;
    let deskripsi = document.getElementById("Deskripsi").value;
    let guru = document.getElementById("Guru").value;
    let modal = document.getElementById("exampleModal");

    if (name == "" || deskripsi == "" || guru == ""){

    }
    else {
        let data = {
            name: name,
            deskripsi: deskripsi,
            guru: guru
        };
        console.log(data);
    
        fetch("http://localhost:8000/mapel/insert.php", { method: "POST", headers: {'Content-Type' : 'application/json'}, body: JSON.stringify(data)}).then(r => r.json()).then(r => { render(); document.getElementById('Namee').value = ""; document.getElementById("Deskripsi").value = ""; document.getElementById("Guru").value = ""; modal.setAttribute("style", "display: none"); document.getElementsByClassName('modal-backdrop')[0].remove();});        
    }

    

}


function del(id){
    fetch(`http://localhost:8000/mapel/delete.php?id=${id}`, { method: 'DELETE', headers: { "Access-Control-Allow-Origin": "*", "Access-Control-Allow-Method": "*", "Access-Control-Allow-Headers": "*"}}).then(r => r.json()).then(r => { render(); document.getElementsByClassName('modal-backdrop')[0].remove();});
}
