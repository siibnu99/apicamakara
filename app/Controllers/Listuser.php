<?php

namespace App\Controllers;


use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

use \Myth\Auth\Models\UserModel;

class Listuser extends BaseController
{
    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $usermodel = new UserModel();
        $data = [
            'title' => 'listuser',
            'users' => $usermodel->findAll(),
        ];
        return view('listuser/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'listuser',
            'validation' => \Config\Services::validation(),

        ];
        return view('listuser/add', $data);
    }
    public function attemptCreate()
    {

        $users = model('UserModel');

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = [
            'username'      => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'pass_confirm'     => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', service('validation')->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $user->activate();

        // Ensure default group gets assigned if set
        $users = $users->withGroupId($this->request->getVar('group'));
        if (!$users->save($user)) {
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $users->errors());
        }
        $this->session->setFlashdata('message', 'User ' . $this->request->getVar('username') . ' Berhasil dibuat');
        return redirect()->to(base_url('admincamakara/listuser'));
    }
    public function changePassword($id)
    {
        $usermodel = new UserModel();
        $data = [
            'title' => 'listuser',
            'validation' => \Config\Services::validation(),
            'user' => $usermodel->find($id),
            'id' => $id
        ];
        return view('listuser/changepassword', $data);
    }
    public function changePasswordAttempt($id)
    {
        $usermodel = new UserModel();
        $user = $usermodel->find($id);
        $rules = [
            'password'         => 'required|min_length[8]',
            'pass_confirm'     => 'required|matches[password]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', service('validation')->getErrors());
        }
        $user->password = $this->request->getVar('password');
        $usermodel->save($user);
        $this->session->setFlashdata('message', 'User ' . $this->request->getVar('username') . ' Berhasil mengubah password');
        return redirect()->to(base_url('admincamakara/listuser'));
    }
    public function edit($id)
    {
        $usermodel = new UserModel();
        $groupmodel = $this->db->table('auth_groups_users');
        $group = $groupmodel->where('user_id', $id)->get()->getResult();
        $data = [
            'title' => 'listuser',
            'validation' => \Config\Services::validation(),
            'user' => $usermodel->find($id),
            'id' => $id,
            'group' => $group[0]->group_id
        ];
        return view('listuser/edit', $data);
    }
    public function attemptedit($id)
    {
        $usermodel = new UserModel();
        $user = $usermodel->find($id);
        $user->email == $this->request->getVar('email') ? $ruleEmail = 'required|valid_email' : $ruleEmail = 'required|valid_email|is_unique[users.email]';
        $user->username == $this->request->getVar('username') ? $ruleUsername = 'required|alpha_numeric_space|min_length[3]' : $ruleUsername = 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]';
        $rules = [
            'username'      => $ruleUsername,
            'email'            => $ruleEmail,
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', service('validation')->getErrors());
        }
        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'id' => $id
        ];
        $usermodel->save($data);
        $groupmodel = $this->db->table('auth_groups_users');
        $group = $groupmodel->set('group_id', $this->request->getVar('group'))->where('user_id', $id)->update();
        $this->session->setFlashdata('message', 'User ' . $this->request->getVar('username') . ' Berhasil diedit');
        return redirect()->to(base_url('admincamakara/listuser'));
    }
    public function delete($id)
    {
        $usermodel = new UserModel();
        $usermodel->delete($id);
        $this->session->setFlashdata('message', 'User ' . $this->request->getVar('username') . ' Berhasil dihapus');
        return redirect()->to(base_url('admincamakara/listuser'));
    }
}
