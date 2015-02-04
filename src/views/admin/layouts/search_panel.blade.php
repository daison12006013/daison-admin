<form class="form-vertical" method="GET">
  <legend>Search Panel</legend>
  <?php
  foreach ($forms as $form) {
    $pre_text = '';

    $name = str_replace('[', '.', $form['name']);
    $name = str_replace(']', '', $name);

    switch ($form['type']) {
      case 'email':
        $pre_text = Form::email($form['name'], Input::get($name), $form['html']);
        break;
      
      case 'text':
        $pre_text = Form::text($form['name'], Input::get($name), $form['html']);
        break;
      
      case 'select':
        $pre_text = Form::select($form['name'], $form['options'], Input::get($name), $form['html']);
        break;
    }
    ?>
    <div class="form-group">
      <label>{{$form['label']}}</label>
      {{$pre_text}}
    </div>
    <?php
  }
?>
<div class="pull-right">
  <button type="submit" class="btn btn-primary">Search <span class="fa fa-search fa-fw"></span></button>
</div>
<div class="clearfix"></div>
</form>