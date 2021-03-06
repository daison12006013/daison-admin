<?php namespace Daison\AdminLaravel\App\Controllers;

use Daison\AdminLaravel\App\Models\Role;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends BaseController
{

  private function _getRole($id)
  {
    $role = Role::findOrFail($id);

    if (! $role) {
      throw new Exception('Role not found');
    }

    return $role;
  }

  public function showRoles()
  {
    $roles = Role::orderBy('name', 'ASC')->get();

    foreach ($roles as $role) {
      $role->users;
    }

    $recs = [];
    foreach ($roles as $role) {
      $recs[$role['id']]['name'] = $role['name'];
      $recs[$role['id']]['count'] = count($role['users']);
    }

    return View::make('admin-laravel::admin.roles.list')->withRecords($recs);
  }


  public function showAdd()
  {
    return View::make('admin-laravel::admin.roles.add');
  }


  public function saveAdd()
  {
    $role_name = Input::get('name');
    $redirect_to = Redirect::to(URL::previous());

    if (empty($role_name)) {
      return $redirect_to->withError(Config::get('admin-laravel::lang/lang.role_add_err_msg'));
    }

    if (count(explode(' ', $role_name)) > 1) {
      return $redirect_to->withError(Config::get('admin-laravel::lang/lang.role_add_space_err_msg'));
    }

    try {
      Role::where('name', '=', $role_name)->firstOrFail();
      return $redirect_to->withError(Config::get('admin-laravel::lang/lang.role_add_exists'));
    } catch (ModelNotFoundException $e) {
      # do nothing
    }

    $role = new Role;
    $role->name = $role_name;
    $role->save();

    return $redirect_to->withSuccess(Config::get('admin-laravel::lang/lang.role_add_info_msg'));
  }


  public function showEdit($id)
  {
    $role = $this->_getRole($id);

    return View::make('admin-laravel::admin.roles.edit')->withRole($role);
  }


  public function saveEdit($id)
  {
    $role = $this->_getRole($id);
    $role_name = Input::get('name');
    $redirect_to = Redirect::to(URL::previous());

    if (empty($role_name)) {
      return $redirect_to->withError(Config::get('admin-laravel::lang/lang.role_add_err_msg'));
    }

    if (count(explode(' ', $role_name)) > 1) {
      return $redirect_to->withError(Config::get('admin-laravel::lang/lang.role_add_space_err_msg'));
    }

    $role->name = $role_name;
    $role->save();

    return $redirect_to->withSuccess(Config::get('admin-laravel::lang/lang.role_edit_info_msg'));
  }

}
