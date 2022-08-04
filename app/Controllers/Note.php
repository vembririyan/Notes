<?php
// This is the simple application Notes using Codeigniter v4.2.1
// And using Vanilla Js
// Develop By Vembri Riyan Diansah, S.Tr.Kom
// https:://github/vembririyan
// https:://github/vembririyan/Notes
namespace App\Controllers;

use App\Models\NoteModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\RESTful\ResourceController;

class Note extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return view('app');
    }
    public function list_notes()
    {
        $notemodel = new NoteModel();
        $res = $notemodel->findAll();
        echo json_encode($res);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        if ($this->request->isAJAX()) {
            $notemodel = new NoteModel();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => [
                    'rules' => 'required|max_length[50]',
                    'errors' => [
                        'required' => 'Title is required!',
                        'max_length' => 'Character not more than 50'
                    ]
                ],
                'content' => [
                    'rules' => 'required|max_length[500]',
                    'errors' => [
                        'required' => 'Content is required!',
                        'max_length' => 'Character not more than 500'
                    ]
                ]
            ]);

            $valid = $validation->withRequest($this->request)->run();
            if (!$valid) {
                $validstatus = [
                    'validation' => false,
                    'errors' => $validation->getErrors(),
                ];
                echo json_encode($validstatus);
            } else if ($valid) {
                $validstatus = [
                    'validation' => true,
                    'errors' => ''
                ];
                $res = $notemodel->add($this->request->getVar()->title, nl2br($this->request->getVar()->content));
                $data = [
                    'validstatus' => $validstatus,
                    'create_status' => $res
                ];
                echo json_encode($data);
            }
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => [
                    'rules' => 'required|max_length[50]',
                    'errors' => [
                        'required' => 'Title is required!',
                        'max_length' => 'Character not more than 50'
                    ]
                ],
                'content' => [
                    'rules' => 'required|max_length[500]',
                    'errors' => [
                        'required' => 'Content is required!',
                        'max_length' => 'Character not more than 500'
                    ]
                ]
            ]);
            $valid = $validation->withRequest($this->request)->run();
            if (!$valid) {
                $validstatus = [
                    'validation' => false,
                    'errors' => $validation->getErrors(),
                ];
                echo json_encode($validstatus);
            } else if ($valid) {
                $validstatus = [
                    'validation' => true,
                    'errors' => ''
                ];
                $notemodel = new NoteModel();
                $data = [
                    'title' => $this->request->getVar()->title,
                    'content' => nl2br($this->request->getVar()->content)
                ];
                $notemodel->update($this->request->getVar()->id, $data);
                if ($notemodel->db->affectedRows() >= 0) {
                    $data = [
                        'validstatus' => $validstatus,
                        'updatedstatus' => true
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'validstatus' => $validstatus,
                        'updatedstatus' => false
                    ];
                    echo json_encode($data);
                }
            }
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $notemodel = new NoteModel();
        $notemodel->delete($id);
        if ($notemodel->db->affectedRows() > 0) {
            $deletedstatus = ['deletedstatus' => true];
        } else {
            $deletedstatus = ['deletedstatus' => false];
        }
        echo json_encode($deletedstatus);
    }
}