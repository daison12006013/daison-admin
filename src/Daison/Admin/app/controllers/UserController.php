<?php namespace Daison\Admin\App\Controllers;

use Daison\Admin\App\Models\PasswordRules as Rules;
use Daison\Admin\App\Models\User;
use Daison\Admin\App\Models\Role;
use Daison\Admin\App\Models\UserHasRole;

class UserController extends BaseController
{
  public function showChangePassword()
  {
    return \View::make('admin::admin.settings.change_password');
  }

  public function updatedPassword()
  {
    $old_password = \Input::get('old_password');
    $new_password = \Input::get('new_password');

    $rules = new Rules($new_password);

    try {
      if ($old_password != \Input::get('re_old_password')) {
        throw new \Exception(\Config::get('admin::lang/lang.password_old_pass_and_re'));
      }

      if (! \Hash::check($old_password, \Auth::user()->password)) {
        throw new \Exception(\Config::get('admin::lang/lang.password_db_not_match'));
      }

      $this->_checkPasswordRules($new_password);

      $user = User::find(\Auth::user()->id);
      $user->password = \Hash::make($new_password);
      $user->save();

      return \Redirect
                ::to(\Config::get('admin::routes.admin_changepass.url'))
                ->withSuccess(\Config::get('admin::lang/lang.password_success'));

    } catch (\Exception $e) {
      return \Redirect::to(\Config::get('admin::routes.admin_changepass.url'))->withError($e->getMessage())->withInput();
    }

    return;
  }

  public function showLists()
  {
    $users = \User::orderBy('last_name','ASC')->paginate(15);

    return \View::make('admin::admin.users.list')->withUsers($users);
  }

  public function showEdit($x)
  {
    $user = \User::find($x);

    if (! $user) {
      throw new \Exception('User not found');
    }

    return \View::make('admin::admin.users.edit')->withUser($user);
  }

  public function saveEdit($id)
  {
    $post = \Input::all();

    $user = User::find($id);

    if (! $user) {
      throw new \Exception('User not found');
    }

    $user->updateInformation($post);
    $user->save();

    return \View::make('admin::admin.users.edit')->withUser($user)->withSuccessMessage(\Config::get('admin::lang/lang.user_changed_info_msg'));
  }

  public function showAdd()
  {
    return \View::make('admin::admin.users.add');
  }

  public function saveAdd()
  {
    $post = \Input::all();

    $redirect_to = \Redirect::to(\Config::get('admin::routes.admin_user_add.url'));

    // Try to check the password rules
    try {
      $this->_checkPasswordRules($post['password']);
    } catch(\Exception $e) {
      return $redirect_to->withError($e->getMessage())->withInput();
    }


    // Now, add the user
    try {
      $user = new User;
      $user->create($post);
      $user->password = Hash::make($post['password']);
      $user->save();
    } catch(\Exception $e) {
      $msg = \Config::get('admin::lang/lang.user_add_err_msg');
      return $redirect_to->withInput()->withError($msg);
    }
  

    $msg = \Config::get('admin::lang/lang.user_add_info_msg');
    return $redirect_to->withSuccess($msg);
  }


  private function _checkPasswordRules($password)
  {
    $rules = new Rules($password);

    $min = \Config::get('admin::general.password_settings.min');
    $has_number = \Config::get('admin::general.password_settings.has_number');
    $has_special_char = \Config::get('admin::general.password_settings.has_special_char');
    $has_upper_and_lower = \Config::get('admin::general.password_settings.has_upper_and_lower');

    $min_m = \Config::get('admin::lang/lang.password_min_err');
    $has_number_m = \Config::get('admin::lang/lang.password_has_number_err');
    $has_special_char_m = \Config::get('admin::lang/lang.password_has_special_err');
    $has_upper_and_lower_m = \Config::get('admin::lang/lang.password_up_low_err');

    try {
      $result = $rules
        ->setMinimumLength($min, $min_m)
        ->setRequireAtleastOneNumber($has_number, $has_number_m)
        ->setRequireAtleastOneSpecialCharacter($has_special_char, $has_special_char_m)
        ->setRequireUpperAndLower($has_upper_and_lower, $has_upper_and_lower_m)
        ->check();

    } catch (\Exception $e) {
      throw $e;
    }

    return true;
  }


  public function showRoles($user_id)
  {
    $user = User::find($user_id);

    if (! $user) {
      throw new Exception('User not found');
    }

    $user_roles = $user->roles;
    $available_roles = Role::orderBy('name', 'ASC')->get();

    return \View::make('admin::admin.users.role')->withAvailableRoles($available_roles)->withUserRoles($user_roles);
  }

  public function saveRoles()
  {
    
  }

  public function deleteRole($user_id, $role_id)
  {
    $user_has_role = UserHasRole::where('user_id', '=', $user_id)->where('role_id', '=', $role_id);

    $user_has_role->delete();

    return \Redirect::to(\URL::previous());
  }
  
}