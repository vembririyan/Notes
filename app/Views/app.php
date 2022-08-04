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
    <link rel="icon" href="favicon.ico" />
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
            <button onclick="add_note('<?= csrf_hash() ?>','<?= base_url() ?>')" type="button"
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
            <textarea style="white-space: pre-wrap;" onkeyup="count_content(this.value,'count_edit_content')" rows="8"
                maxlength="500"
                class="px-2 py-1 mt-2 text-sm w-full rounded-md focus:border-teal-400 focus:border outline-none bg-teal-100 text-teal-900"
                type="text" id="edit_content" placeholder="Contents">
            </textarea>
            <span class="text-xs float-right text-gray-600"><span id="count_edit_content">0</span>/500</span>
            <span id="error_edit_content" class="text-xs text-red-600 ml-2"></span>
            <button onclick="edit_note('<?= csrf_hash() ?>','<?= base_url() ?>')" type="button"
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
        get_notes('<?= base_url() ?>')
    })
    </script>
</body>

</html>