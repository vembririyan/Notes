<!DOCTYPE html>
<html lang="en">
<!-- This is the simple application Notes using Codeigniter v4.2.1 -->
<!-- And using Vanilla Js -->
<!-- Develop By Vembri Riyan Diansah, S.Tr.Kom -->
<!-- https:://github/vembririyan -->
<!-- https:://github/vembririyan/Notes -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    * {
        font-family: 'Open Sans', sans-serif;
    }
    </style>
    <script src="<?= base_url('js/vanilla.js') ?>"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="bg-gray-100">
    <header>
        <nav class="bg-teal-600 p-3 w-full fixed top-0">
            <h1 class="text-white font-bold text-lg inline-block"><i class="fa fa-note-sticky"></i> Notes</h1>
        </nav>
    </header>
    <section id="note_lists" class="m-3 mt-16">
        <content>
            <ul id="list_notes" class="block">
            </ul>
        </content>
    </section>

    <div id="overlay" class="bg-teal-900 opacity-50 w-full h-screen fixed top-0 left-0 right-0 mx-auto hidden">
    </div>
    <div id="modal_add_note"
        class="p-3 container rounded-lg bg-white fixed top-1/4 left-0 right-0 mx-auto block w-96 hidden">
        <button class="px-2 rounded-md float-right outline-none bg-teal-200 hover:bg-teal-300" onclick="hide_modal()"><i
                class="fa fa-xmark text-gray-500"></i></button>
        <h1 class="text-lg text-teal-900 mb-5"><i class="fa fa-note-sticky"></i> Add Note</h1>
        <form id="form_add_note">
            <input onkeyup="count_title(this.value,'count_add_title')"
                class="px-2 py-1 block text-sm w-full rounded-md focus:border-teal-400 focus:border outline-none bg-teal-100 text-teal-900"
                type="text" id="title" placeholder="Title">
            <span class="text-xs float-right text-gray-600"><span id="count_add_title">0</span>/50</span>
            <span id="error_title" class="text-xs text-red-600 ml-2 my-0"></span>
            <textarea onkeyup="count_content(this.value,'count_add_content')" rows="8" maxlength="500"
                class="px-2 py-1 mt-2 text-sm w-full rounded-md focus:border-teal-400 focus:border outline-none bg-teal-100 text-teal-900"
                type="text" id="content" placeholder="Contents"></textarea>
            <span class="text-xs float-right text-gray-600"><span id="count_add_content">0</span>/500</span>
            <span id="error_content" class="text-xs text-red-600 ml-2"></span>
            <button onclick="add_note('<?= csrf_hash() ?>')" type="button"
                class="px-2 py-1 mt-3 mx-auto block bg-teal-600 hover:bg-teal-700 rounded-lg text-white"><i
                    class="fa fa-save"></i>
                Save</button>
        </form>
    </div>

    <div id="modal_edit_note"
        class="p-3 container rounded-lg bg-white fixed top-1/4 left-0 right-0 mx-auto block w-96 hidden">
        <button class="px-2 rounded-md float-right outline-none bg-teal-200 hover:bg-teal-300" onclick="hide_modal()"><i
                class="fa fa-xmark text-gray-500"></i></button>
        <h1 class="text-lg text-teal-900 mb-5"><i class="fa fa-note-sticky"></i> Edit Note</h1>
        <div id="form_edit_note">
            <input type="hidden" id="edit_id" />
            <input on="count_title(this.value)" onkeyup="count_title(this.value,'count_edit_title')" maxlength="50"
                class="px-2 py-1 block text-sm w-full rounded-md focus:border-teal-400 focus:border outline-none bg-teal-100 text-teal-900"
                type="text" id="edit_title" placeholder="Title">
            <span class="text-xs float-right text-gray-600"><span id="count_edit_title">0</span>/50</span>
            <span id="error_edit_title" class="text-xs text-red-600 ml-2 my-0"></span>
            <textarea onkeyup="count_content(this.value,'count_edit_content')" rows="8" maxlength="500"
                class="px-2 py-1 mt-2 text-sm w-full rounded-md focus:border-teal-400 focus:border outline-none bg-teal-100 text-teal-900"
                type="text" id="edit_content" placeholder="Contents"></textarea>
            <span class="text-xs float-right text-gray-600"><span id="count_edit_content">0</span>/500</span>
            <span id="error_edit_content" class="text-xs text-red-600 ml-2"></span>
            <button onclick="edit_note('<?= csrf_hash() ?>')" type="button"
                class="px-2 py-1 mt-3 mx-auto block bg-teal-600 hover:bg-teal-700 rounded-lg text-white"><i
                    class="fa fa-save"></i>
                Save</button>
        </div>
    </div>

    <!-- Add Button -->
    <button class="fixed bottom-20 right-5 rounded-full bg-teal-600 hover:bg-teal-700 px-5 py-3.5"
        onclick="modal_add()"><i class="fa fa-plus text-white text-lg"></i></button>
    <!-- Copyrights -->
    <div class="bg-teal-600 py-3 fixed bottom-0 w-full">
        <p class="text-center text-white text-xs">&copy; Copyrights | Vembri Riyan Diansah</p>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', event => {
        get_notes()
    })


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
    async function get_notes() {
        try {
            let res = await fetch(<?= base_url('list_notes') ?>, {
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
                    <button onclick="modal_edit(` + notes.id + `,'` + notes.title + `','` + notes.content +
                        `')" class="bg-teal-100 active:bg-teal-200  rounded inline-block relative top-3 outline-none" onclick='confirm_delete(` +
                        notes.id +
                        `)'><i
                    class="fa fa-pencil text-xs text-teal-600 py-2 px-3"></i></button>
                    <button class="bg-teal-100 active:bg-teal-200 rounded inline-block  relative top-3 outline-none" onclick='confirm_delete(` +
                        notes.id + `)'><i
                    class="fa fa-trash text-xs text-red-600 py-2 px-3"></i></button>
                    </div>
                    <div class="bg-white rounded-lg">
                    <a onclick="detail_note('detail_note_` + notes.id + `')" class="no-underline inline-block w-11/12 bg-white p-3 rounded-lg active:bg-gray-300 cursor-pointer">
                        <i class="fa fa-note-sticky text-teal-700 text-lg"></i>
                        <h1 class="text-sm bold inline text-left">` + notes.title + `</h1>
                        <div class="block">
                            <p class="text-xs mb-2 inline"><i class="fa fa-calendar m-1 text-green-600"></i> ` + notes
                        .updated_at.split(" ")[0] + `
                            </p>
                            <p class="text-xs mb-2 inline"><i class="fa fa-clock m-1 text-yellow-500"></i> ` + notes
                        .updated_at.split(" ")[1].slice(0, 5) + `</p>
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

    async function add_note(csrf_hash) {
        let title = document.getElementById('title').value
        let content = document.getElementById('content').value

        let data = {
            "csrf_note": String(csrf_hash),
            "title": title,
            "content": content
        }
        try {
            let res = await fetch("<?= base_url('note') ?>", {
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
                    hide_modal()
                    get_notes()
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

    async function edit_note(csrf_hash) {
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
            let res = await fetch("<?= base_url('note') ?>/" + id, {
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

                    hide_modal()
                    get_notes()
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

    function confirm_delete(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this note!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Your note has been deleted!", {
                        icon: "success",
                    });
                    delete_note(id)
                } else {
                    swal("Delete Cancelled!");
                }
            });
    }

    async function delete_note(id) {
        let res = await fetch("<?= base_url('note') ?>/" + id, {
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
                get_notes()
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
        let count = character.length
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
        let count = character.length
        document.getElementById(idcount).textContent = count
    }
    </script>
</body>

</html>