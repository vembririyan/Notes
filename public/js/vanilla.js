// This is the simple application Notes using Codeigniter v4.2.1
// And using Vanilla Js
// Develop By Vembri Riyan Diansah, S.Tr.Kom
// https:://github/vembririyan
// https:://github/vembririyan/Notes
function modal_add() {
    let overlay = document.getElementById('overlay');
    let modaladdnote = document.getElementById('modal_add_note');

    overlay.classList.add("show")
    overlay.classList.remove("hidden")

    modaladdnote.classList.add("show")
    modaladdnote.classList.remove("hidden")

}


function modal_edit(id, title, content) {
    let overlay = document.getElementById('overlay');
    let modaleditnote = document.getElementById('modal_edit_note');

    overlay.classList.add("show")
    overlay.classList.remove("hidden")

    modaleditnote.classList.add("show")
    modaleditnote.classList.remove("hidden")

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_content').value = content;
    count_title(title, 'count_edit_title')
    count_content(content, 'count_edit_content')
}

function hide_modal() {
    let overlay = document.getElementById('overlay');
    let modaladdnote = document.getElementById('modal_add_note');
    let modaleditnote = document.getElementById('modal_edit_note');
    overlay.classList.add("hidden")
    overlay.classList.remove("show")

    modaladdnote.classList.add("hidden")
    modaladdnote.classList.remove("show")


    modaleditnote.classList.add("hidden")
    modaleditnote.classList.remove("show")
}
async function get_notes(base_url) {
    try {
        let res = await fetch(base_url + '/list_notes', {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
        })
        let listnotes = ''
        res.json().then(data => {
            data.forEach(notes => {
                listnotes +=
                    `<li class="mb-2 drop-shadow-lg">
                    <div class="absolute right-2 mx-3">
                    <button onclick="modal_edit(` + notes.id + `,'` + notes.title + `',` + notes.content.replace(/<br ?\/?>/g, '\n') + `)" class="bg-teal-100 active:bg-teal-200  rounded inline-block relative top-3 outline-none" onclick='confirm_delete(` + notes.id + `)'><i
                    class="fa fa-pencil text-xs text-teal-600 py-2 px-3"></i></button>
                    <button class="bg-teal-100 active:bg-teal-200 rounded inline-block  relative top-3 outline-none" onclick="confirm_delete(` + notes.id + `,'` + base_url + `')"><i
                    class="fa fa-trash text-xs text-red-600 py-2 px-3"></i></button>
                    </div>
                    <div class="bg-white rounded-lg">
                    <a onclick="detail_note('detail_note_` + notes.id + `')" class="no-underline inline-block w-11/12 bg-white p-3 rounded-lg active:bg-gray-300 cursor-pointer">
                        <i class="fa fa-note-sticky text-teal-700 text-lg"></i>
                        <h1 class="text-sm bold inline text-left">` + notes.title + `</h1>
                        <div class="block">
                            <p class="text-xs mb-2 inline"><i class="fa fa-calendar m-1 text-green-600"></i> ` + notes.updated_at.split(" ")[0] + `
                            </p>
                            <p class="text-xs mb-2 inline"><i class="fa fa-clock m-1 text-yellow-500"></i> ` + notes.updated_at.split(" ")[1].slice(0, 5) + `</p>
                        </div>
                        
                        </a>
                        <div id="detail_note_` + notes.id + `" class="hidden detail_show rounded-bottom rounded-b-lg bg-teal-200 p-3 block">
                        <p class="text-sm m-3">` + notes.content + `</p>
                        </div>
                    </div>
                </li>`
            });
            if (listnotes != '') {
                document.getElementById('list_notes').innerHTML = listnotes
            } else {
                document.getElementById('list_notes').innerHTML = `<li id="list_notes" class="text-sm text-center rounded bg-gray-200 p-2"><i class="fa fa-note-sticky text-teal-700 mx-2"></i></i>You have no notes!
                </li>`
            }
        })
    } catch (error) {

    }
}

async function detail_note(detail_id) {
    let detail = document.getElementById(detail_id);
    let showDetailExist = detail.classList.contains('show');
    let detail_show = document.getElementsByClassName('detail_show');

    for (var i = 0; i < detail_show.length; i++) {
        detail_show[i].classList.remove('show');
        detail_show.item(i).classList.add('hidden');
    }
    if (showDetailExist) {
        detail.classList.add("hidden")
        detail.classList.remove("show")
    } else {
        detail.classList.add("show")
        detail.classList.remove("hidden")
    }
}

async function add_note(csrf_hash, base_url) {
    let title = document.getElementById('title').value
    let content = document.getElementById('content').value

    let data = {
        "csrf_note": String(csrf_hash),
        "title": title,
        "content": content
    }
    try {
        let res = await fetch(base_url + '/note', {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(data)
        });
        res.json().then(data => {
            if (data.validstatus) {
                swal({
                    title: "Saved",
                    text: "Your notes are saved!",
                    icon: "success",
                    timer: 2000,
                    buttons: false
                })
                get_notes(base_url)
                document.getElementById('title').value = ''
                document.getElementById('content').value = ''
                count_title('', 'count_add_title')
                count_content('', 'count_add_content')
                hide_modal()
            } else {
                document.getElementById('error_title').textContent = data.errors.title
                document.getElementById('error_content').textContent = data.errors.content
                swal("Failed", "Your notes are failed to save!", "error");
            }
        })
    } catch (error) {
        swal("Error", "Something went wrong!", "error");
    }
}

async function edit_note(csrf_hash, base_url) {
    let id = document.getElementById('edit_id').value
    let title = document.getElementById('edit_title').value
    let content = document.getElementById('edit_content').value

    let data = {
        "csrf_note": String(csrf_hash),
        "id": id,
        "title": title,
        "content": content
    }
    try {
        let res = await fetch(base_url + '/note/' + id, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(data)
        });
        res.json().then(data => {
            if (data.validstatus) {
                swal({
                    title: "Saved",
                    text: "Your changes are saved!",
                    icon: "success",
                    timer: 2000,
                    buttons: false
                })

                get_notes(base_url)
                hide_modal()
            } else {
                document.getElementById('error_edit_title').textContent = data.errors.title
                document.getElementById('error_edit_content').textContent = data.errors.content
                swal("Failed", "Your changes are failed to save!", "error");
            }
        })
    } catch (error) {
        swal("Error", "Something went wrong!", "error");
    }
}

function confirm_delete(id, base_url) {
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this note!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                delete_note(id, base_url)
            } else {
                swal("Delete Cancelled!");
            }
        });
}

async function delete_note(id, base_url) {
    let res = await fetch(base_url + '/note/' + id, {
        method: 'delete',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    res.json().then(data => {
        if (data.deletedstatus) {
            swal({
                title: "Deleted",
                text: "Your notes are deleted!",
                icon: "success",
                timer: 2000,
                buttons: false
            })
            get_notes(base_url)
        } else {
            swal("Deleted", "Your notes are failed to delete!", "error")
        }
    })
}


function count_title(character, idcount) {
    if (character.length >= 50) {
        swal({
            title: "Warning",
            text: "Character not more than 50",
            icon: "warning",
            timer: 2000,
            buttons: false
        })
    }
    let count = ''
    if (character != null) {
        count = character.length
    }
    document.getElementById(idcount).textContent = count
}

function count_content(character, idcount) {
    if (character.length > 500) {
        swal({
            title: "Warning",
            text: "Character not more than 500",
            icon: "warning",
            timer: 2000,
            buttons: false
        })
    }
    let count = ''
    if (character != null) {
        count = character.length
    }
    document.getElementById(idcount).textContent = count
}